<?php

namespace Database\Seeders;

use App\Models\Ngo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class NgoSeeder extends Seeder
{
    public function run()
    {
        $ngoRole = Role::firstOrCreate(['name' => 'ngo']);

        $ngos = [
            [
                'name' => 'ASA',
                'registration_id' => 'NGO-ASA-1978',
                'phone' => '01755000001',
                'email' => 'contact@asa.org.bd',
                // 'website' => 'asa.org.bd',
                'focus_area' => 'Financial Inclusion',
                //'status' => 'active'
            ],
            [
                'name' => 'BRAC',
                'registration_id' => 'NGO-BRAC-1972',
                'phone' => '01755000002',
                'email' => 'info@brac.net',
                // 'website' => 'brac.net',
                'focus_area' => 'Multi-Sector',
                //'status' => 'active'
            ],
            [
                'name' => 'Friendship',
                'registration_id' => 'NGO-FRND-2002',
                'phone' => '01755000003',
                'email' => 'info@friendship.ngo',
                // 'website' => 'friendship.ngo',
                'focus_area' => 'Healthcare',
                //'status' => 'active'
            ],
            [
                'name' => 'Shelter',
                'registration_id' => 'NGO-SHLTR-1983',
                'phone' => '01755000004',
                'email' => 'info@shelter.org.bd',
                // 'website' => 'shelter.org.bd',
                'focus_area' => 'Education',
                //'status' => 'active'
            ],
            [
                'name' => 'SKUS',
                'registration_id' => 'NGO-SKUS-1985',
                'phone' => '01755000005',
                'email' => 'info@skus-bd.org',
                // 'website' => 'skus-bd.org',
                'focus_area' => 'Community Development',
                //'status' => 'active'
            ]
        ];

        foreach ($ngos as $ngoData) {
            $user = User::create([
                'name' => $ngoData['name'] . ' Admin',
                'email' => $ngoData['email'],
                'password' => Hash::make('password'),
            ])->assignRole($ngoRole);

            Ngo::create([
                'user_id' => $user->id,
                'name' => $ngoData['name'],
                'registration_id' => $ngoData['registration_id'],
                'phone_number' => $ngoData['phone'],
                'email' => $ngoData['email'],
                // 'website' => $ngoData['website'],
                'location' => 'Dhaka',
                'focus_area' => $ngoData['focus_area'],
                //'status' => $ngoData['status'],
                // 'established_year' => substr($ngoData['registration_id'], -4),
            ]);
        }

        Log::info('Created ' . count($ngos) . ' NGOs with admin users');
    }
}