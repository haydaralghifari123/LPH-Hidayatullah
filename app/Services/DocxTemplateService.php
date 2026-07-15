<?php

namespace App\Services;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use RuntimeException;
use ZipArchive;

/**
 * Generate .docx (and optionally .pdf) from Word templates that use <<PLACEHOLDER>> syntax.
 *
 * Word often splits placeholders across multiple <w:r> runs due to spell-check
 * and revision tracking, so we first merge runs inside each paragraph before
 * doing string replacement.
 */
class DocxTemplateService
{
    private const XML_ENTRIES = [
        'word/document.xml',
        'word/header1.xml', 'word/header2.xml', 'word/header3.xml',
        'word/footer1.xml', 'word/footer2.xml', 'word/footer3.xml',
    ];

    public function generate(string $templatePath, array $values, string $outputPath): void
    {
        if (! is_file($templatePath)) {
            throw new RuntimeException("Template not found: {$templatePath}");
        }

        $outDir = dirname($outputPath);
        if (! is_dir($outDir)) {
            mkdir($outDir, 0755, true);
        }

        if (! copy($templatePath, $outputPath)) {
            throw new RuntimeException("Failed to copy template to {$outputPath}");
        }

        $zip = new ZipArchive();
        if ($zip->open($outputPath) !== true) {
            throw new RuntimeException("Cannot open output docx: {$outputPath}");
        }

        try {
            foreach (self::XML_ENTRIES as $entry) {
                $xml = $zip->getFromName($entry);
                if ($xml === false) {
                    continue;
                }
                $xml = $this->mergeSplitPlaceholders($xml);
                $xml = $this->replacePlaceholders($xml, $values);
                $zip->addFromString($entry, $xml);
            }
        } finally {
            $zip->close();
        }
    }

    /**
     * Fill template and convert to PDF. Returns absolute path to the generated PDF.
     * Prefers LibreOffice/MS Word (exact template fidelity); falls back to dompdf.
     */
    public function generatePdf(string $templatePath, array $values, string $outputPath): string
    {
        $docxTmp = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'lph_docx_' . bin2hex(random_bytes(6)) . '.docx';
        $this->generate($templatePath, $values, $docxTmp);

        $outDir = dirname($outputPath);
        if (! is_dir($outDir)) {
            mkdir($outDir, 0755, true);
        }

        try {
            // Try LibreOffice / MS Word first for exact template fidelity
            $converter = new PdfConverter();
            $available = $converter->detect();

            if ($available['libreoffice'] || $available['msword']) {
                $converter->convert($docxTmp, $outputPath);
            } else {
                // Fallback: dompdf via PHPWord (strips images/headers/complex tables)
                Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
                Settings::setPdfRendererPath(base_path('vendor/dompdf/dompdf'));
                $phpWord = IOFactory::load($docxTmp);
                $writer = IOFactory::createWriter($phpWord, 'PDF');
                $writer->save($outputPath);
            }
        } finally {
            @unlink($docxTmp);
        }

        return $outputPath;
    }

    private function mergeSplitPlaceholders(string $xml): string
    {
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = true;
        $dom->formatOutput = false;

        libxml_use_internal_errors(true);
        if (! $dom->loadXML($xml)) {
            libxml_clear_errors();
            return $xml;
        }

        $xpath = new \DOMXPath($dom);
        $xpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');

        $paragraphs = $xpath->query('//w:p');
        foreach ($paragraphs as $p) {
            $textNodes = $xpath->query('.//w:t', $p);
            if ($textNodes->length <= 1) {
                continue;
            }

            $combined = '';
            foreach ($textNodes as $t) {
                $combined .= $t->textContent;
            }

            if (! preg_match('/<<[^<>]+>>/', $combined)) {
                continue;
            }

            $first = $textNodes->item(0);
            while ($first->firstChild) {
                $first->removeChild($first->firstChild);
            }
            $first->appendChild($dom->createTextNode($combined));
            $first->setAttributeNS('http://www.w3.org/XML/1998/namespace', 'xml:space', 'preserve');

            for ($i = $textNodes->length - 1; $i >= 1; $i--) {
                $t = $textNodes->item($i);
                $t->parentNode->removeChild($t);
            }
        }

        return $dom->saveXML();
    }

    private function replacePlaceholders(string $xml, array $values): string
    {
        foreach ($values as $key => $value) {
            $replacement = htmlspecialchars((string) ($value ?? ''), ENT_XML1 | ENT_QUOTES, 'UTF-8');
            $xml = str_replace('&lt;&lt;' . $key . '&gt;&gt;', $replacement, $xml);
            $xml = str_replace('<<' . $key . '>>', $replacement, $xml);
        }
        return $xml;
    }
}
