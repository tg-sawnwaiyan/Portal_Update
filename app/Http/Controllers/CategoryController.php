<?php


namespace App\Http\Controllers;

use App\Category;
use Auth;
use DB;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    
    //index category
    public function index()
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
    public function add(Request $request)
    {
        $category = new Category();
        $category->name = $request->input('name');
        $category->order_number = $request->input('order_number');
        $category->user_id = 1;
        $category->recordstatus = 1;
        $category ->save();
        return $category;
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function update($id, Request $request)
    {
       
        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->order_number = $request->input('order_number');
        $category->user_id = 1;
        $category->recordstatus = 1;
        $category -> save();
        return response()->json('The Facility successfully updated');
    }

    public function delete($id)
    {
        $category = Category::find($id);
        $post = "SELECT * from posts where category_id =" .$id;
        $pid = DB::select($post);
        if(count($pid) != 0)
        {
            return response()->json(['error' => 'There are News that related this category So you can not delete this!'], 404);
        }
        else{
            $category->delete();
            $categories = Category::orderBy('id','DESC')->paginate(20);
            return response()->json($categories);
        }      
         
    }

    public function search(Request $request) 
    {
        $request = $request->all();
        if(isset($request['search_word'])) {
            $search_word = $request['search_word'];
        }else{
            $search_word = null;
        }
        $search_categories = Category::query()
                            ->where('name', 'LIKE', "%{$search_word}%")
                            ->orderBy('id','DESC')
                            ->paginate(20);
        return response()->json($search_categories);
    }
}
