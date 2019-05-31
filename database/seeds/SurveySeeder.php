<?php

use App\Models\Survey;
use Illuminate\Database\Seeder;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $surveys = [
            [
                "name" => "Survey one",
                "json_body" => "[{\"id\":\"bb674687-8737-96bf-5538-658aa6fee786\",\"question\":null,\"type\":\"BOOLEAN\",\"multiSelect\":false,\"characterLimited\":false,\"hasMinMax\":false,\"allowDecimals\":false,\"sequence\":null,\"minValue\":1,\"maxValue\":8,\"labels\":[],\"dateFormat\":\"MM/DD/YYYY\",\"timeFormat\":\"12\",\"intervals\":2,\"textLimit\":1024,\"units\":null,\"options\":[{\"body\":\"Yes\",\"sequence\":1},{\"body\":\"No\",\"sequence\":2}],\"body\":\"First Survey question1\"}]"
            ],
            [
                "name" => "Survey two",
                "json_body" => "[{\"id\":\"2b48ce74-88a1-2de9-2bf9-16fc94d2bfdf\",\"type\":\"NUMBER\",\"characterLimited\":false,\"hasMinMax\":true,\"allowDecimals\":false,\"minValue\":1,\"maxValue\":\"15\",\"textLimit\":1024,\"units\":\"days\",\"options\":[{\"body\":null,\"sequence\":1},{\"body\":null,\"sequence\":2}],\"body\":\"How many days?\",\"hasUnits\":true},{\"id\":\"a35be5b0-d67d-5895-f118-8bbfd3689d22\",\"type\":\"MULTI_CHOICE\",\"characterLimited\":false,\"hasMinMax\":false,\"allowDecimals\":false,\"minValue\":1,\"maxValue\":8,\"textLimit\":1024,\"units\":null,\"options\":[{\"body\":\"first option!\",\"sequence\":1},{\"body\":\"second one\",\"sequence\":2}],\"body\":\"Second question!\"},{\"id\":\"d6730c57-6e19-d575-f1aa-486995ebc94e\",\"type\":\"SINGLE_CHOICE\",\"characterLimited\":false,\"hasMinMax\":false,\"allowDecimals\":false,\"minValue\":1,\"maxValue\":8,\"textLimit\":1024,\"units\":null,\"options\":[{\"body\":\"red\",\"sequence\":1},{\"body\":\"BLUE\",\"sequence\":2}],\"body\":\"you can only choose one, be wise\"},{\"id\":\"06b7bad5-1882-997f-ceba-dbe9bc4881d5\",\"type\":\"TEXT\",\"characterLimited\":true,\"hasMinMax\":false,\"allowDecimals\":false,\"minValue\":1,\"maxValue\":8,\"textLimit\":1024,\"units\":null,\"options\":[{\"body\":null,\"sequence\":1},{\"body\":null,\"sequence\":2}],\"body\":\"Here you are supposed to enter text, but be limited!\"}]"
            ],
            [
                "name" => "Survey three",
                "json_body" => ""
            ],
            [
                "name" => "Survey four",
                "json_body" => ""
            ],
            [
                "name" => "Survey five",
                "json_body" => ""
            ],
        ];
        foreach ($surveys as $survey){
            Survey::create($survey);
        }

    }
}
