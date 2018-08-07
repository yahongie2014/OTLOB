<?php

use App\Currency;
use Illuminate\Database\Seeder;

class CurrencyTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::create(array
        (
            'id' => 1,
            'currency_name' => 'جنيه مصرى',
            'currency_name_en' => 'Egyptian Pound',
            'currency_code' => 'EGP',
            'lang' => 'en'
        ));
        Currency::create(array
        (
            'id' => 2,
            'currency_name' => 'ريال',
            'currency_name_en' => 'Riyal',
            'currency_code' => 'SAR',
            'lang' => 'en'
        ));
        Currency::create(array
        (
            'id' => 2,
            'currency_name' => 'ريال',
            'currency_name_en' => 'US Dollar',
            'currency_code' => '$',
            'lang' => 'en'
        ));



    }
}
