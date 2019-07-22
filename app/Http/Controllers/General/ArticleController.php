<?php

namespace App\Http\Controllers\General;

use App\Exports\FilledSurvey;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Resources\Collection\ArticlesResource;
use App\Http\Resources\Entity\ArticleResource;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

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


    public function show($id){
        $article = Article::where("id", $id)->first();
        if($article == null)
            return self::responseErrors("Article with id ".$id." not found", 404);
        return self::responseData(new ArticlesResource($article));
    }

    public function exportSurveys(){
        $id = 1;
        return Excel::download(new FilledSurvey($id), "filled.xlsx");
    }
}
