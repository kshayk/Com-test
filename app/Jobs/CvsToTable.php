<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Contact;

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
        //this will get all the data, row by row from the CSV file
        $file = fopen($this->file_path, 'r');
        $contact = [];
        while( ! feof($file)) {
            $csv_row = fgetcsv($file);
            if(is_bool($csv_row)) {
                continue;
            }
            $contact[] = $csv_row;
        }

        //no need for the first row that includes the names of the columns
        unset($contact[0]);

        //saving each row in the database
        //in our case it will always be one row but it still supports multiple rows
        foreach($contact as $contact_row) {
            $new_contact = new Contact();
            $new_contact->name = $contact_row[0];
            $new_contact->email = $contact_row[1];
            $new_contact->subject = $contact_row[2];
            $new_contact->content = $contact_row[3];

            $new_contact->save();
        }
    }
}
