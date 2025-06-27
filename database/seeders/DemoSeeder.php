<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\FormService;
use App\Models\DetailService;
use App\Models\UnitService;
use App\Models\StatusGaransi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
                'id_user' => $teknisi1->id_user,
            ],
            [
                'status' => 'proses',
                'id_customer' => 2,
                'id_user' => $teknisi1->id_user,
            ],
            [
                'status' => 'selesai',
                'id_customer' => 3,
                'id_user' => $teknisi2->id_user,
            ],
            [
                'status' => 'diterima',
                'id_customer' => 4,
                'id_user' => $teknisi2->id_user,
            ],
            [
                'status' => 'proses',
                'id_customer' => 5,
                'id_user' => $teknisi1->id_user,
            ],
            [
                'status' => 'selesai',
                'id_customer' => 1,
                'id_user' => $teknisi2->id_user,
            ],
            [
                'status' => 'diterima',
                'id_customer' => 2,
                'id_user' => $teknisi1->id_user,
            ],
        ];

        foreach ($formServices as $serviceData) {
            FormService::create($serviceData);
        }

        // Create detail services
        $detailServices = [
            [
                'no_form' => 1,
                'tgl_masuk' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'tgl_selesai' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'estimasi' => '3 hari',
                'biaya' => 150000,
            ],
            [
                'no_form' => 2,
                'tgl_masuk' => Carbon::now()->subDays(1)->format('Y-m-d'),
                'tgl_selesai' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'estimasi' => '3 hari',
                'biaya' => 200000,
            ],
            [
                'no_form' => 3,
                'tgl_masuk' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'tgl_selesai' => Carbon::now()->subDays(1)->format('Y-m-d'),
                'estimasi' => '4 hari',
                'biaya' => 300000,
            ],
            [
                'no_form' => 4,
                'tgl_masuk' => Carbon::now()->format('Y-m-d'),
                'tgl_selesai' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'estimasi' => '3 hari',
                'biaya' => 175000,
            ],
            [
                'no_form' => 5,
                'tgl_masuk' => Carbon::now()->subDays(1)->format('Y-m-d'),
                'tgl_selesai' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'estimasi' => '2 hari',
                'biaya' => 125000,
            ],
            [
                'no_form' => 6,
                'tgl_masuk' => Carbon::now()->subDays(7)->format('Y-m-d'),
                'tgl_selesai' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'estimasi' => '5 hari',
                'biaya' => 250000,
            ],
            [
                'no_form' => 7,
                'tgl_masuk' => Carbon::now()->format('Y-m-d'),
                'tgl_selesai' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'estimasi' => '2 hari',
                'biaya' => 100000,
            ],
        ];

        foreach ($detailServices as $detailData) {
            DetailService::create($detailData);
        }

        // Create unit services
        $unitServices = [
            [
                'no_form' => 1,
                'tipe_unit' => 'Laptop ASUS',
                'serial_number' => 'ASU123456789',
                'kerusakan' => 'Mati total, tidak bisa nyala',
                'kelengkapan' => 'Charger, tas laptop, mouse wireless',
            ],
            [
                'no_form' => 1,
                'tipe_unit' => 'Mouse Wireless',
                'serial_number' => 'MW001',
                'kerusakan' => 'Tidak terdeteksi',
                'kelengkapan' => 'USB receiver',
            ],
            [
                'no_form' => 2,
                'tipe_unit' => 'PC Desktop',
                'serial_number' => 'PC987654321',
                'kerusakan' => 'Blue screen, restart terus',
                'kelengkapan' => 'Keyboard, mouse, kabel power, monitor',
            ],
            [
                'no_form' => 3,
                'tipe_unit' => 'Smartphone Samsung',
                'serial_number' => 'SAM111222333',
                'kerusakan' => 'Layar pecah, touchscreen tidak responsif',
                'kelengkapan' => 'Charger, earphone, case',
            ],
            [
                'no_form' => 4,
                'tipe_unit' => 'Printer Canon',
                'serial_number' => 'CN555666777',
                'kerusakan' => 'Paper jam, hasil print bergaris',
                'kelengkapan' => 'Kabel USB, cartridge',
            ],
            [
                'no_form' => 5,
                'tipe_unit' => 'Laptop Lenovo',
                'serial_number' => 'LNV888999000',
                'kerusakan' => 'Keyboard beberapa tombol tidak berfungsi',
                'kelengkapan' => 'Charger, tas laptop',
            ],
            [
                'no_form' => 6,
                'tipe_unit' => 'Tablet iPad',
                'serial_number' => 'IPD444555666',
                'kerusakan' => 'Baterai drop, tidak bisa cas',
                'kelengkapan' => 'Charger, case, stylus',
            ],
            [
                'no_form' => 7,
                'tipe_unit' => 'Router WiFi',
                'serial_number' => 'RT777888999',
                'kerusakan' => 'Sinyal lemah, sering disconnect',
                'kelengkapan' => 'Adaptor, kabel ethernet',
            ],
        ];

        foreach ($unitServices as $unitData) {
            UnitService::create($unitData);
        }

        // Create status garansi
        $statusGaransiData = [
            [
                'no_form' => 1,
                'garansi' => '12',
                'tgl_beli' => Carbon::now()->subMonths(6)->format('Y-m-d'),
                'no_nota' => 'NT001ASU2024',
            ],
            [
                'no_form' => 2,
                'garansi' => '24',
                'tgl_beli' => Carbon::now()->subMonths(8)->format('Y-m-d'),
                'no_nota' => 'NT002PC2024',
            ],
            [
                'no_form' => 3,
                'garansi' => '12',
                'tgl_beli' => Carbon::now()->subMonths(10)->format('Y-m-d'),
                'no_nota' => 'NT003SAM2024',
            ],
            [
                'no_form' => 4,
                'garansi' => '6',
                'tgl_beli' => Carbon::now()->subMonths(3)->format('Y-m-d'),
                'no_nota' => 'NT004CN2024',
            ],
            [
                'no_form' => 5,
                'garansi' => '18',
                'tgl_beli' => Carbon::now()->subMonths(4)->format('Y-m-d'),
                'no_nota' => 'NT005LNV2024',
            ],
            [
                'no_form' => 6,
                'garansi' => '12',
                'tgl_beli' => Carbon::now()->subMonths(14)->format('Y-m-d'),
                'no_nota' => 'NT006IPD2023',
            ],
            [
                'no_form' => 7,
                'garansi' => '24',
                'tgl_beli' => Carbon::now()->subMonths(2)->format('Y-m-d'),
                'no_nota' => 'NT007RT2024',
            ],
        ];

        foreach ($statusGaransiData as $garansiData) {
            StatusGaransi::create($garansiData);
        }

        $this->command->info('Demo data created successfully!');
        $this->command->info('Users created:');
        $this->command->info('- Admin: admin@servisku.com / password');
        $this->command->info('- Teknisi 1: teknisi1@servisku.com / password');
        $this->command->info('- Teknisi 2: teknisi2@servisku.com / password');
        $this->command->info('- 5 customers created');
        $this->command->info('- 7 form services created');
        $this->command->info('- 7 detail services created');
        $this->command->info('- 8 unit services created');
        $this->command->info('- 7 status garansi created');
    }
}
