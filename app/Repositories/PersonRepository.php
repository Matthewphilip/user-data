<?php

namespace App\Repositories;

use App\Models\Person;

class PersonRepository
{
    public function create(array $data): Person
    {
        return Person::create($data);
    }
}
