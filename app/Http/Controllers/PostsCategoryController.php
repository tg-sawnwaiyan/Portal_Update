<?php


namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Auth;
use DB;
use Illuminate\Http\Request;


class PostsCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('order_number','desc')->paginate(20); 
        return response()->json($categories);
    }

    public function getCategory()
    {
        $categories = Category::orderBy('order_number','desc')->paginate(20); 
        return response()->json($categories);
    }

    public function list()
    {
        $category_list = Category::select('id','name')->get()->toArray();
        $pr_category_list = Category::select('id','name')->where('id','!=',26)->get()->toArray();
        return response()->json(array("categories"=>$category_list,"prcategories"=>$pr_category_list));
    }

    //add category
    public function addCategory(Request $request)
    {
        $category = new Category();
        $category->name = $request->input('name');
        $order_number = (int)$request->input('order_number');
        $category->order_number = $order_number ? $order_number : 0;
        // $category->color_name = $request->input('color_name');
        // $category->color_code = $request->input('color_code');
        $category->user_id = 1;
        $category->recordstatus = 1;
        $category->save();
        return $category;
    }

    public function editCategory($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function updateCategory($id, Request $request)
    {
        $category = Category::find($id);
        $category->name = $request->input('name');
        $order_number = (int)$request->input('order_number');
        $category->order_number = $order_number ? $order_number : 0;
        // $category->color_name = $request->input('color_name');
        // $category->color_code = $request->input('color_code');
        $category->user_id = 1;
        $category->recordstatus = 1;
        $category->save();
        return response()->json($category);
    }

    public function destroyCategory($id)
    {
        $category = Category::find($id);
        $news_count = Post::where('category_id', $id)->count();

        if($news_count != 0)
        {
            return response()->json(['error' => 'There are News that related this category So you can not delete this!'], 404);
        }
        else{
           $category->delete();
           $categories = Category::orderBy('order_number','DESC')->paginate(20);
           return response()->json($categories);
        }

    }

    //return create vue template
    public function create()
    {
        return view('categories.create');
    }
    
    //category search and pagination
    public function search(Request $request) {
        $request = $request->all();
        if(isset($request['search_word'])) {
            $search_word = $request['search_word'];
        }else{
            $search_word = null;
        }

        $search_categories = Category::where('name', 'LIKE', "%{$search_word}%")
                            ->orderBy('order_number','DESC')
                            ->paginate(20);
        return response()->json($search_categories);
    }
}
