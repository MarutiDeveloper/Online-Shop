<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $city = array(
            array('code' => 'VGA', 'name' => 'Vijayawada'),
            array('code' => 'TIR', 'name' => 'Tirupati'),                                                   //array('code' => 'MP', 'name' => 'Madhya Pradesh'),
            array('code' => 'VSKP', 'name' => 'Visakhapatnam'),
            array('city_code' => 'ITN', 'city_name' => 'Itanagar'),
            array('city_code' => 'PAS', 'city_name' => 'Pasighat'),
            array('city_code' => 'GUW', 'city_name' => 'Guwahati'),
            array('city_code' => 'DBR', 'city_name' => 'Dibrugarh'),
            array('city_code' => 'SIL', 'city_name' => 'Silchar'),
            array('city_code' => 'PAT', 'city_name' => 'Patna'),
            array('city_code' => 'GYA', 'city_name' => 'Gaya'),
            array('city_code' => 'BGP', 'city_name' => 'Bhagalpur'),
            array('city_code' => 'RPR', 'city_name' => 'Raipur'),
            array('city_code' => 'BIL', 'city_name' => 'Bilaspur'),
            array('city_code' => 'PNJ', 'city_name' => 'Panaji'),
            array('city_code' => 'MAP', 'city_name' => 'Mapusa'),
            array('city_code' => 'AMD', 'city_name' => 'Ahmedabad'),
            array('city_code' => 'SUR', 'city_name' => 'Surat'),
            array('city_code' => 'VAD', 'city_name' => 'Vadodara'),
            array('city_code' => 'GUR', 'city_name' => 'Gurugram'),
            array('city_code' => 'FBD', 'city_name' => 'Faridabad'),
            array('city_code' => 'ROH', 'city_name' => 'Rohtak'),
            array('city_code' => 'SML', 'city_name' => 'Shimla'),
            array('city_code' => 'DH', 'city_name' => 'Dharamshala'),
            array('city_code' => 'SXR', 'city_name' => 'Srinagar'),
            array('city_code' => 'JMU', 'city_name' => 'Jammu'),
            array('city_code' => 'RNC', 'city_name' => 'Ranchi'),
            array('city_code' => 'DHN', 'city_name' => 'Dhanbad'),
            array('city_code' => 'BLR', 'city_name' => 'Bengaluru'),
            array('city_code' => 'MYS', 'city_name' => 'Mysuru'),
            array('city_code' => 'TVM', 'city_name' => 'Thiruvananthapuram'),
            array('city_code' => 'KOC', 'city_name' => 'Kochi'),
            array('city_code' => 'BPL', 'city_name' => 'Bhopal'),
            array('city_code' => 'IND', 'city_name' => 'Indore'),
            array('city_code' => 'MUM', 'city_name' => 'Mumbai'),
            array('city_code' => 'PUN', 'city_name' => 'Pune'),
            array('city_code' => 'NGP', 'city_name' => 'Nagpur'),
            array('city_code' => 'IMP', 'city_name' => 'Imphal'),
            array('city_code' => 'SHG', 'city_name' => 'Shillong'),
            array('city_code' => 'AIZ', 'city_name' => 'Aizawl'),
            array('city_code' => 'KOH', 'city_name' => 'Kohima'),
            array('city_code' => 'BHU', 'city_name' => 'Bhubaneswar'),
            array('city_code' => 'CTC', 'city_name' => 'Cuttack'),
            array('city_code' => 'LDH', 'city_name' => 'Ludhiana'),
            array('city_code' => 'ASR', 'city_name' => 'Amritsar'),
            array('city_code' => 'JAL', 'city_name' => 'Jalandhar'),
            array('city_code' => 'JPR', 'city_name' => 'Jaipur'),
            array('city_code' => 'JOD', 'city_name' => 'Jodhpur'),
            array('city_code' => 'UDA', 'city_name' => 'Udaipur'),
            array('city_code' => 'GNG', 'city_name' => 'Gangtok'),
            array('city_code' => 'CHE', 'city_name' => 'Chennai'),
            array('city_code' => 'MDU', 'city_name' => 'Madurai'),
            array('city_code' => 'COI', 'city_name' => 'Coimbatore'),
            array('city_code' => 'HYD', 'city_name' => 'Hyderabad'),
            array('city_code' => 'WGL', 'city_name' => 'Warangal'),
            array('city_code' => 'AGT', 'city_name' => 'Agartala'),
            array('city_code' => 'LKO', 'city_name' => 'Lucknow'),
            array('city_code' => 'KNP', 'city_name' => 'Kanpur'),
            array('city_code' => 'VAR', 'city_name' => 'Varanasi'),
            array('city_code' => 'DDN', 'city_name' => 'Dehradun'),
            array('city_code' => 'HAR', 'city_name' => 'Haridwar'),
            array('city_code' => 'CCU', 'city_name' => 'Kolkata'),
            array('city_code' => 'DGP', 'city_name' => 'Durgapur'),
            array('city_code' => 'SILG', 'city_name' => 'Siliguri'),
            array('city_code' => 'PTB', 'city_name' => 'Port Blair'),
            array('city_code' => 'CHD', 'city_name' => 'Chandigarh'),
            array('city_code' => 'SVD', 'city_name' => 'Silvassa'),
            array('city_code' => 'DAM', 'city_name' => 'Daman'),
            array('city_code' => 'DIU', 'city_name' => 'Diu'),
            array('city_code' => 'KVR', 'city_name' => 'Kavaratti'),
            array('city_code' => 'DEL', 'city_name' => 'Delhi'),
            array('city_code' => 'PUD', 'city_name' => 'Puducherry')

        );
        DB::table('city')->insert($city);
    }
}
