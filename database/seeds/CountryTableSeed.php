<?php

use App\Country;
use Illuminate\Database\Seeder;

class CountryTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create(array
        (
            'id' => 1,
            'country' => 'cairo',
            'lang' => 'en',
            'area_id' => '3'
        ));
        Country::create(array
        (
            'id' => 2,
            'country' => 'Alex',
            'lang' => 'en',
            'area_id' => '3'
        ));
        Country::create(array
        (
            'id' => 3,
            'country' => 'cairo',
            'lang' => 'en',
            'area_id' => '3'
        ));
        Country::create(array
        (
            'id' => 4,
            'country' => 'Giza',
            'lang' => 'en',
            'area_id' => '3'
        ));
        Country::create(array
        (
            'id' => 5,
            'country' => 'Ryiad',
            'lang' => 'en',
            'area_id' => '2'
        ));
        Country::create(array
        (
            'id' => 6,
            'country' => 'Gada',
            'lang' => 'en',
            'area_id' => '2'
        ));
        Country::create(array
        (
            'id' => 7,
            'country' => 'El-Taaef',
            'lang' => 'en',
            'area_id' => '2'
        ));
        Country::create(array
        (
            'id' => 8,
            'country' => 'الرياض',
            'lang' => 'ar',
            'area_id' => '2'
        ));
        Country::create(array
        (
            'id' => 9,
            'country' => 'جده',
            'lang' => 'ar',
            'area_id' => '2'
        ));
        Country::create(array
        (
            'id' => 10,
            'country' => 'الطائف',
            'lang' => 'ar',
            'area_id' => '2'
        ));
        Country::create(array
        (
            'id' => 11,
            'country' => 'القاهره',
            'lang' => 'ar',
            'area_id' => '3'
        ));
        Country::create(array
        (
            'id' => 12,
            'country' => 'الجيزه',
            'lang' => 'ar',
            'area_id' => '3'
        ));
        Country::create(array
        (
            'id' => 13,
            'country' => 'الاسكندريه',
            'lang' => 'ar',
            'area_id' => '3'
        ));
        
    }
}
