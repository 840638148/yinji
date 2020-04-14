<?php
namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\Designer;
use Illuminate\Http\Request;
use Session;
class NotFoundController extends Controller
{

    public function index(Request $request){
        $uri = $request->path();
		$arr = explode('/', $uri);
		if (!isset($arr[1])) {
            return view('errors.404');
        }

		switch (strtolower($arr[0])) {
			case 'article':
				$obj = Article::where('static_url', $arr[1])->first();
                $controller = new ArticleController();
				break;
			case 'designer':
                $obj = Designer::where('static_url', $arr[1])->first();
                $controller = new DesignerController();
				break;	
		}
		if (isset($obj) && isset($controller)) {
            return $controller->detail($request, $obj->id);
        } else {
		    return view('errors.404');
        }
    }
}