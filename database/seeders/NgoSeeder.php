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
                'website' => 'asa.org.bd',
                'focus_area' => 'Financial Inclusion',
                'status' => 'approved',
                'logo' => 'logos/asa.png',
                'description' => 'ASA is a microfinance institution and NGO in Bangladesh that provides financial services to low-income populations, particularly women, to promote self-employment and poverty alleviation. Founded in 1978, it has become one of the largest MFIs in the world.'
            ],
            [
                'name' => 'BRAC',
                'registration_id' => 'NGO-BRAC-1972',
                'phone' => '01755000002',
                'email' => 'info@brac.net',
                'website' => 'brac.net',
                'focus_area' => 'Multi-Sector',
                'status' => 'approved',
                'logo' => 'logos/brac.png',
                'description' => 'BRAC is the largest non-governmental development organization in the world, established in 1972. It works across multiple sectors including education, healthcare, microfinance, and social enterprise development to empower people and communities in poverty.'
            ],
            [
                'name' => 'Friendship',
                'registration_id' => 'NGO-FRND-2002',
                'phone' => '01755000003',
                'email' => 'info@friendship.ngo',
                'website' => 'friendship.ngo',
                'focus_area' => 'Healthcare',
                'status' => 'approved',
                'logo' => 'logos/friendship.png',
                'description' => 'Friendship NGO focuses on providing healthcare services to remote and hard-to-reach communities in Bangladesh, particularly in riverine and coastal areas. Founded in 2002, it operates floating hospitals and community clinics to serve marginalized populations.'
            ],
            [
                'name' => 'Shelter',
                'registration_id' => 'NGO-SHLTR-1983',
                'phone' => '01755000004',
                'email' => 'info@shelter.org.bd',
                'website' => 'shelter.org.bd',
                'focus_area' => 'Education',
                'status' => 'approved',
                'logo' => 'logos/shelter.png',
                'description' => 'Shelter is an NGO dedicated to improving access to quality education for underprivileged children in Bangladesh. Since 1983, it has established schools, provided scholarships, and developed innovative education programs for disadvantaged communities.'
            ],
            [
                'name' => 'SKUS',
                'registration_id' => 'NGO-SKUS-1985',
                'phone' => '01755000005',
                'email' => 'info@skus-bd.org',
                'website' => 'skus-bd.org',
                'focus_area' => 'Community Development',
                'status' => 'approved',
                'logo' => 'logos/skus.png',
                'description' => 'SKUS (Sushilan Kallyan Sangstha) is a community development organization working since 1985 to empower rural communities in Bangladesh through programs in agriculture, women\'s empowerment, disaster preparedness, and sustainable livelihoods.'
            ]
        ];

        foreach ($ngos as $ngoData) {
            $user = User::create([
                'name' => $ngoData['name'] . ' NGO',
                'email' => $ngoData['email'],
                'password' => Hash::make('password'),
            ])->assignRole($ngoRole);

            Ngo::create([
                'user_id' => $user->id,
                'name' => $ngoData['name'],
                'description' => $ngoData['description'],
                'registration_id' => $ngoData['registration_id'],
                'phone_number' => $ngoData['phone'],
                'email' => $ngoData['email'],
                'website' => $ngoData['website'],
                'location' => 'Dhaka',
                'focus_area' => $ngoData['focus_area'],
                'logo' => $ngoData['logo'],
                'status' => $ngoData['status'],
                'established_year' => substr($ngoData['registration_id'], -4),
            ]);
        }

        Log::info('Created ' . count($ngos) . ' NGOs with admin users');
    }
}