<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertiser extends Model
{
    public function surveys(){
        return $this->hasMany(Survey::class);
    }

    public function getFilledSurveysAttribute(){
        $surveys = $this->surveys();
        $IDs = array(0);
        foreach ($surveys as $surv){
            $IDs[] = $surv->id;
        }
        $filled = FilledSurvey::all()->whereIn("survey_id", $IDs);
        return $filled;
    }

}
