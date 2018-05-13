<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CvsToTable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $file_path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file_random_string)
    {
        $this->file_path = "/var/www/tmp/csv_{$file_random_string}.csv";
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file = fopen($this->file_path, 'r');
        $contact = [];
        while( ! feof($file)) {
            $csv_row = fgetcsv($file);
            if(is_bool($csv_row)) {
                continue;
            }
            $contact[] = $csv_row;
        }

        unset($contact[0]);


    }
}
