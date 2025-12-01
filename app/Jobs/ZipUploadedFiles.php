<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ZipUploadedFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $folder;
    protected string $zipFileName;

    /**
     * Create a new job instance.
     */
    public function __construct(string $folder = 'uploads', ?string $zipFileName = null)
    {
        $this->folder = $folder;
        $this->zipFileName = $zipFileName ?? 'pdfs_' . now()->format('Ymd_His') . '.zip';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $zipDir = storage_path('app/zipped');
        $processedFile = storage_path('app/processed_files.json');

        if (!file_exists($zipDir)) {
            mkdir($zipDir, 0755, true);
        }

        if (!file_exists($processedFile)) {
            file_put_contents($processedFile, json_encode([], JSON_PRETTY_PRINT));
        }

        $processed = json_decode(file_get_contents($processedFile), true);
        if (!is_array($processed)) {
            $processed = [];
        }

        $pdfFiles = collect(Storage::files($this->folder))
        ->filter(fn($path) => strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'pdf');

        $newFiles = [];

        foreach ($pdfFiles as $path) {
            $absolutePath = Storage::path($path);

            if (!file_exists($absolutePath)) {
                continue;
            }

            $hash = md5_file($absolutePath);

            // Skip already processed files
            if (!in_array($hash, $processed)) {
                $newFiles[] = ['path' => $path, 'hash' => $hash];
            }
        }

          if (empty($newFiles)) {
            info("No new PDF files found in folder '{$this->folder}'.");
            return;
        }

        $zipPath = "{$zipDir}/{$this->zipFileName}";
        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            foreach ($newFiles as $file) {
                $zip->addFile(Storage::path($file['path']), basename($file['path']));
                $processed[] = $file['hash']; // Mark as processed
            }
            $zip->close();
        }

                file_put_contents($processedFile, json_encode($processed, JSON_PRETTY_PRINT));

        info("Zipped " . count($newFiles) . " new PDFs from '{$this->folder}' into '{$this->zipFileName}'.");

    }
}
