<?php

namespace App\Exports;

use App\Models\FilledSurvey;
use App\Models\Survey;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FilledSurveyExport implements FromQuery, WithHeadings, WithMapping
{
    private $survey_id;
    private $survey;

    public function __construct(int $survey_id)
    {
        $this->survey_id = $survey_id;
        $this->survey = Survey::find($survey_id);
    }

    /**
     * @return Builder
     */
    public function query()
    {
        return FilledSurvey::query()->where("survey_id", $this->survey_id);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $res = ["გამოკითხვის ID", "გამოკითხვის სახელი", "მომხმარებლის ID", "შეკითხვები:"];
        $questions = json_decode($this->survey->json_body);
        $i = 1;
        foreach($questions as $q){
            $res[] = $i.")".$q->body;
            $i++;
        }

        return $res;
    }

    /**
     * @param $filled
     * @return array
     */
    public function map($filled): array
    {
        $data = json_decode($filled->survey_data);
        $res = [$this->survey->id, $this->survey->name, $filled->user_id, ""];
        foreach($data as $d){
            if($d->type != 'MULTI_CHOICE')
                $res[] = $d->answer;
            else {
                $cell_val = "";
                foreach ($d->options as $opt) {
                    if (isset($opt->answer) && $opt->answer) {
                        if($cell_val != "")
                            $cell_val = $cell_val.", ";
                        $cell_val = $cell_val . $opt->body;
                    }
                }
                $cell_val = $cell_val.";";
                $res[] = $cell_val;
            }
        }

        return $res;
    }
}
