<?php


namespace App\Http\Controllers;

use App\Category;
use Auth;
use DB;
use Illuminate\Http\Request;


class CategoryController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    // function __construct()
    // {
    //      $this->middleware('permission:role-list');
    //      $this->middleware('permission:role-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }



    //index category
    public function index()
    {
        // $categories = Category::select('name')->get();
        // return $categories;
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

    //     $request->validate([
    //         'name' => 'required|unique:categories',

    //     ],
    //     [
    //         'name.unique' => 'カテゴリ名は一意である必要があります。'
    //     ]
    // );

        $category = new Category();
        $category->name = $request->input('name');
        $category->order_number = $request->input('order_number');
        $category->color_name = $request->input('color_name');
        $category->color_code = $request->input('color_code');
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
        // $request->validate([
        //     'name' => 'required',

        // ]);
        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->order_number = $request->input('order_number');
        $category->color_name = $request->input('color_name');
        $category->color_code = $request->input('color_code');
        $category->user_id = 1;
        $category->recordstatus = 1;
        $category -> save();
        return response()->json('The Facility successfully updated');
    }

    public function destroy($id)
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
        
     
        // return response()->json(array('categories'=>$categories,'msg'=>'The Category successfully deleted'));
      


    }
    public function create()

    {
        return view('categories.create');
    }

    public function search(Request $request) {
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

    // public function store(Request $request)
    // {
    //     $user = Auth::user()->id;
    //     request()->validate([
    //         'name' => 'required',
    //     ]);

    //     $categories = new Category;
    //     $categories->name = $request->name;
    //     $categories->user_id = $user;
    //     $categories->recordstatus = 1;
    //     $categories->save();
    //     // Category::create($request->all());


    //     return redirect()->route('categories.index')->with('success','Product created successfully.');

    // }



    // public function show($id)

    // {
    //     $categories = Category::where('id',$id)->get();
    //     return view('categories.show',compact('categories'));

    // }



    // public function edit($id)

    // {
    //     $categories = Category::where('id',$id)->get();
    //     return view('categories.edit',compact('categories'));

    // }

        // $user = Auth::user()->id;
        // request()->validate([
        //     'name' => 'required',
        // ]);
        //     $form_data = array(
        //         'user_id'         =>   $user,
        //         'name'            =>   $request->name,
        //         'recordstatus'    =>   1,
        //     );
        // Category::whereId($id)->update($form_data);

        //$product->update($request->all());


    // public function update(Request $request,$id)

    // {


    //     $user = Auth::user()->id;
    //     request()->validate([
    //         'name' => 'required',
    //     ]);
    //         $form_data = array(
    //             'user_id'         =>   $user,
    //             'name'            =>   $request->name,
    //             'recordstatus'    =>   1,
    //         );
    //     Category::whereId($id)->update($form_data);

    //     //$product->update($request->all());


    //     return redirect()->route('categories.index')

    //                     ->with('success','Product updated successfully');

    // }



    // public function destroy($id)

    // {
    //     $data = Category::findOrFail($id);
    //     $data->delete();
    //     return redirect()->route('categories.index')

    //                     ->with('success','categories deleted successfully');

    // }
}
