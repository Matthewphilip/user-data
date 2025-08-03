<?php

namespace App\Services;

use App\Repositories\PersonRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class ClientService
{
    protected $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function saveClients(array $clients): Collection
    {
        $savedClients = collect();

        foreach ($clients as $clientData) {
            try {
                $savedClients->push(
                    $this->personRepository->create($clientData)
                );
            } catch (\Exception $e) {
                Log::error('Error saving client: ' . $e->getMessage(), ['client' => $clientData]);
            }
        }

        return $savedClients;
    }

    public function saveIndividual(array $client): \App\Models\Person
    {
        return $this->personRepository->create($client);
    }
}
