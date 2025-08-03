<?php
namespace App\Services;

use Illuminate\Support\Facades\Log;

class CsvService
{
    public function processCSV($file)
    {
        Log::info('Received file:', ['name' => $file->getClientOriginalName()]);

        $data = array_map('str_getcsv', file($file->getPathname()));
        $people = [];

        foreach ($data as $row) {
            foreach ($row as $name) {
                $personData = $this->splitName($name);
                Log::info('personData:', ['personData' => $personData]);

                if (!empty($personData)) {
                    foreach ($personData as $person) {
                        $people[] = $person;
                    }
                }
            }
        }

        return $people;
    }

    private function splitName($name)
    {
        $titles = ['Mr', 'Mrs', 'Miss', 'Ms', 'Dr', 'Prof', 'Mister'];
        $parts = explode(' ', $name);
        Log::info('parts:', ['parts' =>  $parts]);

        if (!in_array($parts[0], $titles)) {
            return [];
        }

        $parts = array_filter($parts, function ($part) {
            return strtolower($part) !== 'and' && $part !== '&';
        });

        $people = [];
        $person = [];

        foreach ($parts as $part) {
            if (in_array($part, $titles)) {
                if (!empty($person)) {
                    if(count($parts) === 3 || count($parts) === 4){
                        $person['last_name'] = end($parts);
                    } 
                    $people[] = $person;
                }
                $person = ['title' => $part, 'first_name' => null, 'initial' => null, 'last_name' => null];
            } else {
                if (strlen($part) === 1 || (strlen($part) === 2 && $part[1] === '.')) {
                    $person['initial'] = str_replace('.', '', $part);
                } else {
                    if ($person['first_name'] === null && $person['initial'] === null && $part !== end($parts)) {
                        $person['first_name'] = $part;
                    } elseif ($person['last_name'] === null) {
                        $person['last_name'] = $part;
                    } 
                }
            }
        }

        if (!empty($person)) {
            $people[] = $person;
        }

        return $people;
    }
}
