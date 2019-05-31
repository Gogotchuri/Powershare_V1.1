<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    private const DEFAULT_PAGINATION = 10;

    public function index(Request $request){
        $query = Article::where("id", ">", -1)->orderBy("updated_at", "asc");

        $name = $request["name"];
        $pagination = $request["pagination"];

        if($name !== null)
            $query->where("name", "like", "%" . $name . "%");

        //Default pagination if not provided
        if($pagination === null)
            $articles = $query->paginate(self::DEFAULT_PAGINATION);

        else if(is_numeric($pagination) && $pagination <= 0) {
            $articles = $query->get();

            return self::responseData(ArticlesResource::collection($articles));
        }else
            $articles = $query->paginate($pagination);

        return ArticlesResource::collection($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
