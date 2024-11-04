<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = array(
            array('code' => 'AP', 'name' => 'Andhra Pradesh'),
            array('code' => 'AR', 'name' => 'Arunachal Pradesh'),
            array('code' => 'AS', 'name' => 'Assam'),
            array('code' => 'BR', 'name' => 'Bihar'),
            array('code' => 'CT', 'name' => 'Chhattisgarh'),
            array('code' => 'GA', 'name' => 'Goa'),
            array('code' => 'GJ', 'name' => 'Gujarat'),
            array('code' => 'HR', 'name' => 'Haryana'),
            array('code' => 'HP', 'name' => 'Himachal Pradesh'),
            array('code' => 'JK', 'name' => 'Jammu and Kashmir'),
            array('code' => 'JH', 'name' => 'Jharkhand'),
            array('code' => 'KA', 'name' => 'Karnataka'),
            array('code' => 'KL', 'name' => 'Kerala'),
            array('code' => 'MP', 'name' => 'Madhya Pradesh'),
            array('code' => 'MH', 'name' => 'Maharashtra'),
            array('code' => 'MN', 'name' => 'Manipur'),
            array('code' => 'ML', 'name' => 'Meghalaya'),
            array('code' => 'MZ', 'name' => 'Mizoram'),
            array('code' => 'NL', 'name' => 'Nagaland'),
            array('code' => 'OR', 'name' => 'Odisha'),
            array('code' => 'PB', 'name' => 'Punjab'),
            array('code' => 'RJ', 'name' => 'Rajasthan'),
            array('code' => 'SK', 'name' => 'Sikkim'),
            array('code' => 'TN', 'name' => 'Tamil Nadu'),
            array('code' => 'TG', 'name' => 'Telangana'),
            array('code' => 'TR', 'name' => 'Tripura'),
            array('code' => 'UP', 'name' => 'Uttar Pradesh'),
            array('code' => 'UT', 'name' => 'Uttarakhand'),
            array('code' => 'WB', 'name' => 'West Bengal'),
            array('code' => 'AN', 'name' => 'Andaman and Nicobar Islands'),
            array('code' => 'CH', 'name' => 'Chandigarh'),
            array('code' => 'DN', 'name' => 'Dadra and Nagar Haveli'),
            array('code' => 'DD', 'name' => 'Daman and Diu'),
            array('code' => 'LD', 'name' => 'Lakshadweep'),
            array('code' => 'DL', 'name' => 'Delhi'),
            array('code' => 'PY', 'name' => 'Puducherry')
        );

        DB::table('states')->insert($states);
    }
}
