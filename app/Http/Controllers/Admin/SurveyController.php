<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Collection\Admin\SurveysResource;
use App\Models\Survey;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class SurveyController extends Controller
{
    /**
     * Display a listing of the surveys.
     * Parameters in request:
     * @param $request ["name", "pagination", "advertiser_id"]
     * @return Response
     */
    private const DEFAULT_PAGINATION = 10;
    public function index(Request $request)
    {
        $query = Survey::where("id", ">", "-1")->orderBy("order", "asc");
        $name = $request["name"];
        $pagination = $request["pagination"];
        $advertisers_id = $request["advertiser_id"];
        if($advertisers_id !== null)
            $query->where("advertisers_id", $advertisers_id);

        if($name !== null)
            $query->where("name", "like", "%" . $name . "%");

        //Default pagination if not provided
        if($pagination === null)
            $surveys = $query->paginate(self::DEFAULT_PAGINATION);
        else if(is_numeric($pagination) && $pagination <= 0) {
            $surveys = $query->get();
            return self::responseData(SurveysResource::collection($surveys));
        }
        else
            $surveys = $query->paginate($pagination);

        return SurveysResource::collection($surveys);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $survey = new Survey();
        $survey->name = $request["name"];
        $survey->json_body = $request["json_body"];
        if($request["advertisers_id"] != null)
            $survey->advertisers_id = $request["advertisers_id"];
        if($request["order"] !== null)
            $survey->order = $request["order"];
        $survey->save();
        return self::responseData(new SurveysResource($survey), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $survey = Survey::all()->firstWhere("id", $id);
        if($survey == null)
            return self::responseErrors("Survey not found!", 404);
        return self::responseData(new SurveysResource($survey), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $survey = Survey::all()->firstWhere("id", $id);
        if($survey == null)
            return self::responseErrors("Survey not found!", 404);
        $name = $request["name"];
        $json_body = $request["json_body"];
        $advertisers_id = $request["advertisers_id"];
        $order = $request["order"];
        if($name != null)
            $survey->name = $name;
        if($json_body != null)
            $survey->json_body = $json_body;
        if($advertisers_id != null)
            $survey->advertisers_id = $advertisers_id;
        if($order != null)
            $survey->order = $order;
        $survey->save();
        return self::responseData(new SurveysResource($survey), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $survey = Survey::all()->firstWhere("id", $id);
        if($survey == null)
            return self::responseErrors("Survey not found!", 404);
        $survey->delete();
        return self::responseData("Deleted successfully", 200);
    }
}
