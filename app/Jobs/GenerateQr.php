<?php

namespace App\Jobs;

use App\Models\Registration;
use App\Services\QrService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\File;

class GenerateQr implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Registration $registration)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $registration = $this->registration;
        
        $qr = app(QrService::class)->generate(data: $registration->unique_code);

        $folder = 'app/public/qr_codes';
        $filename = $registration->unique_code . '.png';
        $fullPath = storage_path("{$folder}/{$filename}");

        File::ensureDirectoryExists(storage_path($folder));
        $qr->saveToFile($fullPath);
    }
}
