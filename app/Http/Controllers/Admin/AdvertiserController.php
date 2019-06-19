<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Collection\Admin\SurveysResource;
use App\Models\Advertiser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdvertiserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        //TODO Create resource for advertisers
        $advertisers = Advertiser::all();
        return self::responseData($advertisers, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    //TODO validator
    public function store(Request $request)
    {
        $advertiser = new Advertiser();
        $advertiser->name = $request["name"];
        $advertiser->email = $request["email"];
        $advertiser->phone_number = $request["phone_number"];
        $advertiser->save();
        return self::responseData($advertiser, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $advertiser = Advertiser::where("id", $id)->first();
        if($advertiser == null)
            return self::responseErrors("Advertiser not found!", 404);
        return self::responseData($advertiser, 200);
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
        $advertiser = Advertiser::where("id", $id)->first();
        if($advertiser == null)
            return self::responseErrors("Advertiser not found!", 404);
        $name = $request["name"];
        $email = $request["email"];
        $phone_number = $request["phone_number"];
        if($name != null)
            $advertiser->name = $name;
        if($email != null)
            $advertiser->email = $email;
        if($phone_number != null)
            $advertiser->phone_number = $phone_number;
        return self::responseData($advertiser, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $advertiser = Advertiser::where("id", $id)->first();
        if($advertiser == null)
            return self::responseErrors("Advertiser not found!", 404);
        $advertiser->delete();
        return self::responseData("Successfully deleted advertiser!", 200);

    }

    public function filledSurveys($id){
        $advertiser = Advertiser::where("id", $id)->first();
        if($advertiser == null)
            return self::responseErrors("Advertiser not found!", 404);
        $surveys = $advertiser->filled_surveys;
        return self::responseData(SurveysResource::collection($surveys));
    }
}
