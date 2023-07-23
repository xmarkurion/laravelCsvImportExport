<?php

namespace App\Classes;

// Import csv file by Marek Ciepiela 23/07/2023
// Class that will handle csv files
// - import csv file database

class CsvImport
{
    private array $parsed_csv = [];

    public function __construct(
        public $file
    ) {
        $this->process();
    }

    private function process()
    {
        // go through each line of the csv file and add it to the database
        $file = fopen($this->file, 'r');

        // Read CSV headers
        $keys = fgetcsv($file);

        // Parse csv rows into array
        while (($line = fgetcsv($file)) !== false) {
            $this->parsed_csv[] = array_combine($keys, $line);
        }

        // Close opened CSV file
        fclose($file);
    }

    public function import(): array
    {
        return $this->parsed_csv;
    }


}
