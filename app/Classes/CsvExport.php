<?php

namespace App\Classes;

// Export csv file by Marek Ciepiela 23/07/2023
// Class that will handle csv files
// - export csv file database

class CsvExport
{
    public function __construct(
        public $model,
        public ?string $csv_file_name = null,
        public ?string $csv_file_path = null,
        private ?array $keys = [],
    ) {
        $this->setup();
    }

    public function setup()
    {
        if ($this->csv_file_name == null) {
            throw new \Exception('Csv file name is not set.');
        }
        if ($this->csv_file_path == null) {
            throw new \Exception('Csv file name is not set.');
        }
    }

    public function setExcludedKeys($keys)
    {
        $this->keys = $keys;
    }

    public function export()
    {
        $model = $this->model::all();

        //Get all keys of model
        $model_keys = array_keys($model[0]->getAttributes());

        //Get all keys of model but not ones in array
        $keys = array_diff($model_keys, $this->keys);

        $stream = fopen($this->csv_file_path.$this->csv_file_name, 'w');

        // Add header
        $this->addArayLine($keys, $stream);

        foreach ($model as $m) {
            // If there are excluded keys then remove them
            if (count($this->keys) > 0) {
                $temp = $m->getAttributes();
                $temp = array_diff_key($temp, array_flip($this->keys));
                $this->addArayLine($temp, $stream);
            } else {
                $this->addArayLine($m->getAttributes(), $stream);
            }
        }

        fclose($stream);
    }

    public function addArayLine(array $array, $stream)
    {
        fputcsv($stream, $array,
            ",",
            "\"",
            "\\",
            "\n");
    }

    public function set_csv_file_name($name)
    {
        $this->csv_file_name = $name;
    }

    public function set_csv_file_path($path)
    {
        $this->csv_file_path = $path;
    }
}
