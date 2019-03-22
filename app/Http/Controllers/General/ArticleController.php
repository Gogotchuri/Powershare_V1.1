<?php

namespace App\Http\Controllers\General;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Resources\Articles as ArticleResource;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index(){
        //Should add is published to model
        // and filter and sort by date
        return ArticleResource::collection(Article::all());
    }
    public function show($id){
        $article = Article::where("id", $id)->first();
        if($article == null)
            return response()->json(["errors" => ["Article with id ".$id." not found"]], 404);
        return new ArticleResource($article);
    }
}
