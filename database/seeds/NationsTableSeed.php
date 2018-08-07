<?php

use App\Nations;
use Illuminate\Database\Seeder;

class NationsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nations::create(array
        (
            'id' => 1,
            'name' => 'السعودية',
            'name_en' => 'KSA',
            'code' => '+966',
            'currency_code' => 'SAR',
            'currency_name' => 'ريال سعودي',
            'currency_name_en' => 'SAR',
            'flag' => 'uploads/contries/5a60ea29661db.png',
            'status' => '1'
        ));
        Nations::create(array
        (
            'id' => 2,
            'name' => 'مصر',
            'name_en' => 'EG',
            'code' => '+20',
            'currency_code' => 'EGP',
            'currency_name' => 'جنية مصري',
            'currency_name_en' => 'EGP',
            'flag' => 'uploads/contries/5a60ea533ae39.png',
            'status' => '1'
        ));

        Nations::create(array
        (
            'id' => 3,
            'name' => 'الامارات',
            'name_en' => 'UAE',
            'code' => '+971',
            'currency_code' => 'AED',
            'currency_name' => 'درهم اماراتي',
            'currency_name_en' => 'AED',
            'flag' => 'uploads/contries/5a60ea85b78a3.png',
            'status' => '1'
        ));



    }
}
