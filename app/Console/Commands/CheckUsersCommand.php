<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CheckUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check available users in database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Available Users in Database:');
        $this->info('============================');
        
        try {
            $users = User::all();
            
            if ($users->count() > 0) {
                $this->table(['ID', 'Name', 'Email', 'Role'], $users->map(function($user) {
                    return [
                        $user->id_user,
                        $user->name,
                        $user->email,
                        $user->role
                    ];
                })->toArray());
                
                $this->info('Available id_user values: ' . $users->pluck('id_user')->implode(', '));
            } else {
                $this->warn('No users found in database.');
            }
            
            $this->info('');
            $this->info('Available Customers in Database:');
            $this->info('=================================');
            
            $customers = \App\Models\Customer::all();
            
            if ($customers->count() > 0) {
                $this->table(['ID', 'Name', 'Address', 'Phone'], $customers->map(function($customer) {
                    return [
                        $customer->id_customer,
                        $customer->nama,
                        $customer->alamat,
                        $customer->no_hp
                    ];
                })->toArray());
                
                $this->info('Available id_customer values: ' . $customers->pluck('id_customer')->implode(', '));
            } else {
                $this->warn('No customers found in database.');
            }
            
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
