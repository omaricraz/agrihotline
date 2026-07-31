<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@agrihotline.so'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $manager = User::updateOrCreate(
            ['email' => 'manager@agrihotline.so'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('password'),
                'role' => 'manager',
            ]
        );

        User::updateOrCreate(
            ['email' => 'callcenter@agrihotline.so'],
            [
                'name' => 'Call Center',
                'password' => Hash::make('password'),
                'role' => 'call_center',
            ]
        );

        if (Complaint::count() === 0) {
            $samples = [
                ['Omar Hassan', '0634131130', 'Borama', 'Awdal', 'Plant Protection', 'urgent'],
                ['Hassan Omar', '0634131130', 'Borama', 'Awdal', 'Animal Health', 'normal'],
                ['Sayid Farhan', '063434343', 'Borama', 'Awdal', 'Plant Protection', 'urgent'],
                ['Ahmed Hassan Mohamed', '0611234567', 'Hargeisa', 'Maroodi-jeex', 'Plant Protection', 'urgent'],
                ['Sahra Abdullahi Farah', '0612345678', 'Las Anod', 'Sool', 'Land and Water Management', 'normal'],
                ['Mohamed Jama Ali', '0613456789', 'Berbera', 'Saaxil', 'Plant Protection', 'normal'],
                ['Fatima Ibrahim Yusuf', '0614567890', 'Erigavo', 'Sanaag', 'Plant Protection', 'urgent'],
                ['Abdi Osman Hersi', '0615678901', 'Burco', 'Togdheer', 'Plant Protection', 'low'],
                ['Khadija Ali Samatar', '0616789012', 'Odweyne', 'Awdal', 'Production and Food Security', 'urgent'],
                ['Hassan Abdirahman Nuur', '0617890123', 'Burco', 'Togdheer', 'Plant Protection', 'normal'],
                ['Amina Mohamed Isse', '0618901234', 'Berbera', 'Saaxil', 'Marketing and Value Chain', 'normal'],
                ['Yusuf Ahmed Abdi', '0619012345', 'Ainabo', 'Saaxil', 'Plant Protection', 'normal'],
            ];

            foreach ($samples as $i => $row) {
                Complaint::create([
                    'complainant_name' => $row[0],
                    'phone' => $row[1],
                    'location' => $row[2],
                    'region' => $row[3],
                    'department' => $row[4],
                    'description' => 'Sample complaint for demonstration purposes.',
                    'priority' => $row[5],
                    'status' => 'new',
                    'created_by' => $i % 2 === 0 ? $admin->id : $manager->id,
                ]);
            }
        }
    }
}
