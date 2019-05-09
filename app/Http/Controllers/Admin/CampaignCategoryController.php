<?php

namespace App\Http\Controllers\Admin;

use App\Models\References\CampaignCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CampaignCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware("admin");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return self::responseData(CampaignCategory::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ["name" => ["unique:CampaignCategories", "min:3", "max:20"]]);
        if($validator->fails())
            return self::responseErrors($validator->errors(), 422);
        $category = new CampaignCategory();
        $category->name = $request["name"];
        $category->save();
        return self::responseData($category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $category =  CampaignCategory::where("id", $id)->first();
        if($category == null)
            return self::responseErrors("Category not found!", 404);

        return self::responseData($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), ["name" => ["unique:CampaignCategories", "min:3", "max:20"]]);
        if($validator->fails())
            return self::responseErrors($validator->errors(), 422);
        $category =  CampaignCategory::where("id", $id)->first();
        if($category == null)
            return self::responseErrors("Category not found!", 404);
        $category->name = $request["name"];
        $category->save();
        return self::responseData($category, 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $category = CampaignCategory::where("id", $id)->first();
        if($category == null)
            return self::responseErrors("Category not found!", 404);
        $category->delete();
        return self::responseData("Category deleted!", 201);
    }
}
