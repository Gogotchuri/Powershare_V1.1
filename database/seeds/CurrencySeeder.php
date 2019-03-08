<?php

use Illuminate\Database\Seeder;
use App\Models\References\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($id = 1; $id <= Currency::numCategories(); $id++) { 
            $currency = new Currency();
            $currency->id = $id;
            $currency->abbr = Currency::nameFromId($id);
            $currency->name = Currency::fullNameFromId($id);
            $currency->save();
        }
    }
}
