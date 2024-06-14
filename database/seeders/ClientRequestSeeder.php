<?php

namespace Database\Seeders;

use App\Models\ClientRequest;
use App\Models\ClientRequestStatus;
use Illuminate\Database\Seeder;

class ClientRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientRequestStatusesData = [
            ['name' => 'New', 'color' => 'blue'],
            ['name' => 'In Progress', 'color' => 'yellow'],
            ['name' => 'Completed', 'color' => 'green'],
        ];

        $clientRequestStatuses = [];
        foreach ($clientRequestStatusesData as $clientRequestStatus) {
            $clientRequestStatuses[] = ClientRequestStatus::create($clientRequestStatus);
        }

        ClientRequest::factory(10)->create([
            'client_request_status_id' => $clientRequestStatuses[array_rand($clientRequestStatuses)]->id
        ]);
    }
}
