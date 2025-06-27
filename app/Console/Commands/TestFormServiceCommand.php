<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FormService;
use App\Models\User;
use App\Models\Customer;

class TestFormServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:form-service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test form service creation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Form Service Creation');
        $this->info('=============================');
        
        try {
            // Test data
            $data = [
                'status' => 'diterima',
                'id_customer' => 1,
                'id_user' => 2,
            ];
            
            $this->info('Data to create:');
            $this->table(['Field', 'Value'], [
                ['status', $data['status']],
                ['id_customer', $data['id_customer']],
                ['id_user', $data['id_user']]
            ]);
            
            // Check if customer exists
            $customer = Customer::find(1);
            $this->info('Customer exists: ' . ($customer ? 'Yes - ' . $customer->nama : 'No'));
            
            // Check if user exists  
            $user = User::where('id_user', 2)->first();
            $this->info('User exists: ' . ($user ? 'Yes - ' . $user->name . ' (' . $user->role . ')' : 'No'));
            
            $this->info('');
            $this->info('Trying to create form service...');
            
            $formService = FormService::create($data);
            
            $this->info('✅ Success! Form service created with no_form: ' . $formService->no_form);
            
            // Load relationships
            $formService->load(['customer', 'user']);
            
            $this->info('Customer: ' . $formService->customer->nama);
            $this->info('User: ' . $formService->user->name);
            
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            $this->error('File: ' . $e->getFile() . ':' . $e->getLine());
        }
    }
}
