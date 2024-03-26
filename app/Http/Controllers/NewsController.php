<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use jcobhams\NewsApi\NewsApi;

class NewsController extends Controller
{

    public function index(Request $request){


        $category = $request->category??'tecnología';
        $current_page = $request->page??1;
        $number_for_page = 10;

        $response = Http::get('https://newsapi.org/v2/everything?q='.$category.'&language=es&apiKey='.getenv("NEWSAPI_KEY"));
        $news_data = $response->json()['articles'];

        $pages = round(count($news_data)/$number_for_page);

        $start = ($number_for_page * $current_page) - $number_for_page;

        return view('news_index', [
            "category"=>$category,
            "news_data" => array_slice($news_data,$start,$number_for_page),
            "current_page" => $current_page,
            "pages" => $pages,
        ]);
    }

}
