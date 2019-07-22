<?php

namespace App\Exports;

use App\Models\Survey;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FilledSurvey implements FromQuery, WithHeadings, WithMapping
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
        return \App\Models\FilledSurvey::query()->where("survey_id", $this->survey_id);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ["survey_id", "survey_name", "user_id", "data"];
    }

    /**
     * @param $filled
     * @return array
     */
    public function map($filled): array
    {
        return [
            $filled->survey_id,
            $this->survey->name,
            $filled->user_id,
            $filled->survey_data
        ];
    }
}
