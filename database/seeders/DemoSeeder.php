<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\FormService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@servisku.com',
            'phone' => '08111111111',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create teknisi users
        $teknisi1 = User::create([
            'name' => 'Teknisi Satu',
            'email' => 'teknisi1@servisku.com',
            'phone' => '08222222222',
            'role' => 'teknisi',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $teknisi2 = User::create([
            'name' => 'Teknisi Dua',
            'email' => 'teknisi2@servisku.com',
            'phone' => '08333333333',
            'role' => 'teknisi',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create customers
        $customers = [
            [
                'nama' => 'John Doe',
                'no_telp' => '08123456789',
                'alamat' => 'Jl. Sudirman No. 123, Jakarta Selatan',
            ],
            [
                'nama' => 'Jane Smith',
                'no_telp' => '08234567890',
                'alamat' => 'Jl. Thamrin No. 456, Jakarta Pusat',
            ],
            [
                'nama' => 'Bob Wilson',
                'no_telp' => '08345678901',
                'alamat' => 'Jl. Kuningan No. 789, Jakarta Selatan',
            ],
            [
                'nama' => 'Alice Brown',
                'no_telp' => '08456789012',
                'alamat' => 'Jl. Senayan No. 321, Jakarta Pusat',
            ],
            [
                'nama' => 'Charlie Davis',
                'no_telp' => '08567890123',
                'alamat' => 'Jl. Menteng No. 654, Jakarta Pusat',
            ],
        ];

        foreach ($customers as $customerData) {
            Customer::create($customerData);
        }

        // Create form services
        $formServices = [
            [
                'status' => 'diterima',
                'id_customer' => 1,
                'id_user' => $teknisi1->id,
            ],
            [
                'status' => 'proses',
                'id_customer' => 2,
                'id_user' => $teknisi1->id,
            ],
            [
                'status' => 'selesai',
                'id_customer' => 3,
                'id_user' => $teknisi2->id,
            ],
            [
                'status' => 'diterima',
                'id_customer' => 4,
                'id_user' => $teknisi2->id,
            ],
            [
                'status' => 'proses',
                'id_customer' => 5,
                'id_user' => $teknisi1->id,
            ],
            [
                'status' => 'selesai',
                'id_customer' => 1,
                'id_user' => $teknisi2->id,
            ],
            [
                'status' => 'diterima',
                'id_customer' => 2,
                'id_user' => $teknisi1->id,
            ],
        ];

        foreach ($formServices as $serviceData) {
            FormService::create($serviceData);
        }

        $this->command->info('Demo data created successfully!');
        $this->command->info('Users created:');
        $this->command->info('- Admin: admin@servisku.com / password');
        $this->command->info('- Teknisi 1: teknisi1@servisku.com / password');
        $this->command->info('- Teknisi 2: teknisi2@servisku.com / password');
        $this->command->info('- 5 customers created');
        $this->command->info('- 7 form services created');
    }
}
