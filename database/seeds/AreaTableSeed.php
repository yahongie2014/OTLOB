<?php

use App\Area;
use Illuminate\Database\Seeder;

class AreaTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create(array
        ('id' => 1, 'name' => 'Kuwait', 'lang' => 'en', 'ico' => 'https://amazingpict.com/wp-content/uploads/2014/06/Kuwait-Flag-HD-Images.jpg','currency_id' => '1'));
        Area::create(array
        ('id' => 2, 'name' => 'Suadia', 'lang' => 'en', 'ico' => 'https://images2.alphacoders.com/577/thumb-350-577998.png','currency_id' => '2'));
        Area::create(array
        ('id' => 3, 'name' => 'Egypt', 'lang' => 'en', 'ico' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fe/Flag_of_Egypt.svg/220px-Flag_of_Egypt.svg.png','currency_id' => '3'));
        Area::create(array
        ('id' => 4, 'name' => 'الكويت', 'lang' => 'ar', 'ico' => 'https://amazingpict.com/wp-content/uploads/2014/06/Kuwait-Flag-HD-Images.jpg','currency_id' => '1'));
        Area::create(array
        ('id' => 5, 'name' => 'السعوديه', 'lang' => 'ar', 'ico' => 'https://images2.alphacoders.com/577/thumb-350-577998.png','currency_id' => '2'));
        Area::create(array
        ('id' => 6, 'name' => 'مصر', 'lang' => 'ar', 'ico' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fe/Flag_of_Egypt.svg/220px-Flag_of_Egypt.svg.png','currency_id' => '3'));


    }
}
