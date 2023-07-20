<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('123456');
        $adminRecords = [
            ['id' => 1, 'name' => 'Admin', 'type' => 'admin', 'mobile' => 980000000, 'email' => 'admin1@admin.com', 'password' => $password, 'image'=> '', 'status' => 1], 
            ['id' => 2, 'name' => 'Admin', 'type' => 'admin', 'mobile' => 980000000, 'email' => 'admin2@admin.com', 'password' => $password, 'image'=> '', 'status' => 1], 
            ['id' => 3, 'name' => 'Admin', 'type' => 'admin', 'mobile' => 980000000, 'email' => 'admin3@admin.com', 'password' => $password, 'image'=> '', 'status' => 1], 
            ['id' => 4, 'name' => 'Admin', 'type' => 'admin', 'mobile' => 980000000, 'email' => 'admin4@admin.com', 'password' => $password, 'image'=> '', 'status' => 1], 
            ['id' => 5, 'name' => 'Admin', 'type' => 'admin', 'mobile' => 980000000, 'email' => 'admin5git @admin.com', 'password' => $password, 'image'=> '', 'status' => 1],
            
        ]; 
        Admin::insert($adminRecords); 
    }
}
