<?php

namespace App\Services;

use RuntimeException;

/**
 * Convert .docx → .pdf using whichever office suite is available:
 *   1. LibreOffice (soffice --headless) — best cross-platform, exact template fidelity
 *   2. Microsoft Word via PowerShell COM — Windows only, exact template fidelity
 *   3. dompdf (via PHPWord) — fallback; strips images/headers/complex tables
 */
class PdfConverter
{
    public function convert(string $docxPath, string $pdfPath): string
    {
        $outDir = dirname($pdfPath);
        if (! is_dir($outDir)) {
            mkdir($outDir, 0755, true);
        }

        if ($soffice = $this->findLibreOffice()) {
            $this->convertWithLibreOffice($soffice, $docxPath, $pdfPath);
            return 'libreoffice';
        }

        if (PHP_OS_FAMILY === 'Windows' && $this->findWord()) {
            $this->convertWithWord($docxPath, $pdfPath);
            return 'msword';
        }

        throw new RuntimeException('Tidak ada office suite untuk konversi PDF persis template. Install LibreOffice atau gunakan endpoint format=docx.');
    }

    public function detect(): array
    {
        return [
            'libreoffice' => $this->findLibreOffice(),
            'msword' => PHP_OS_FAMILY === 'Windows' ? $this->findWord() : null,
        ];
    }

    private function findLibreOffice(): ?string
    {
        $candidates = [
            'C:\Program Files\LibreOffice\program\soffice.exe',
            'C:\Program Files (x86)\LibreOffice\program\soffice.exe',
            '/usr/bin/soffice',
            '/usr/bin/libreoffice',
            '/usr/local/bin/soffice',
            '/opt/libreoffice/program/soffice',
        ];
        foreach ($candidates as $c) {
            if (is_file($c)) {
                return $c;
            }
        }
        // Try PATH
        $which = PHP_OS_FAMILY === 'Windows' ? 'where soffice 2>NUL' : 'which soffice 2>/dev/null';
        $out = @shell_exec($which);
        if ($out && ($line = strtok(trim($out), "\n")) && is_file($line)) {
            return $line;
        }
        return null;
    }

    private function findWord(): ?string
    {
        $candidates = [
            'C:\Program Files\Microsoft Office\root\Office16\WINWORD.EXE',
            'C:\Program Files (x86)\Microsoft Office\root\Office16\WINWORD.EXE',
            'C:\Program Files\Microsoft Office\Office16\WINWORD.EXE',
            'C:\Program Files (x86)\Microsoft Office\Office16\WINWORD.EXE',
            'C:\Program Files\Microsoft Office\Office15\WINWORD.EXE',
            'C:\Program Files (x86)\Microsoft Office\Office15\WINWORD.EXE',
        ];
        foreach ($candidates as $c) {
            if (is_file($c)) {
                return $c;
            }
        }
        return null;
    }

    private function convertWithLibreOffice(string $soffice, string $docx, string $pdf): void
    {
        $outDir = dirname($pdf);
        $profileDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'lo_profile_' . bin2hex(random_bytes(4));
        $cmd = sprintf(
            '%s --headless -env:UserInstallation=file:///%s --convert-to pdf --outdir %s %s',
            escapeshellarg($soffice),
            str_replace('\\', '/', $profileDir),
            escapeshellarg($outDir),
            escapeshellarg($docx)
        );

        $descriptors = [1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
        $proc = proc_open($cmd, $descriptors, $pipes);
        if (! is_resource($proc)) {
            throw new RuntimeException('Gagal menjalankan LibreOffice.');
        }
        stream_get_contents($pipes[1]);
        $err = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $exit = proc_close($proc);

        // LibreOffice menamai output berdasarkan input basename
        $generated = $outDir . DIRECTORY_SEPARATOR . pathinfo($docx, PATHINFO_FILENAME) . '.pdf';
        if (! is_file($generated)) {
            throw new RuntimeException("LibreOffice gagal (exit={$exit}): {$err}");
        }
        if ($generated !== $pdf) {
            rename($generated, $pdf);
        }
    }

    private function convertWithWord(string $docx, string $pdf): void
    {
        $docxWin = str_replace('/', '\\', $docx);
        $pdfWin = str_replace('/', '\\', $pdf);

        $psScript = <<<PS
\$ErrorActionPreference = 'Stop'
\$word = New-Object -ComObject Word.Application
\$word.Visible = \$false
\$word.DisplayAlerts = 0
try {
    \$doc = \$word.Documents.Open('{$docxWin}', \$false, \$true)
    \$doc.SaveAs([ref] '{$pdfWin}', [ref] 17)
    \$doc.Close(\$false)
    Write-Output 'OK'
} finally {
    \$word.Quit()
    [System.Runtime.Interopservices.Marshal]::ReleaseComObject(\$word) | Out-Null
}
PS;

        $tmpPs = tempnam(sys_get_temp_dir(), 'ps_') . '.ps1';
        file_put_contents($tmpPs, $psScript);
        $cmd = sprintf('powershell -NoProfile -ExecutionPolicy Bypass -File %s 2>&1', escapeshellarg($tmpPs));
        $output = shell_exec($cmd);
        @unlink($tmpPs);

        if (! is_file($pdf)) {
            throw new RuntimeException('MS Word conversion gagal: ' . trim((string) $output));
        }
    }
}
