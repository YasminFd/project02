<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\File;
use App\Models\menu_item;
use App\Models\category;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use App\Http\Requests\MealStoreRequest;

class AdminMealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function getCategory(){
        $categories = DB::table('categories')
            ->select('*')
            ->get();
        return $categories;
        
    }
    public function index()
    {
        //
        $categories=$this->getCategory();
        return view('admin.edits.addMeal', ['data' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = $this->getCategory();
        return view('admin.edits.addMeal', ['data' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MealStoreRequest $req)
    {
        //
        $path = 'images\menu'; // the path to the directory you want to store the file in
        $file = $req->image->getClientOriginalName();
        $req->image->move(public_path($path),$file); // get the original file name
        
        // store the file in the public/images directory
                
                $item=new menu_item();
                $item->name=$req->name;
                $item->price=$req->price;
                $item->description=$req->description;
                $item->category_id=$req->category_id;
                $item->image="/images/menu/".$req->image->getClientOriginalName();
                $item->save();
                return redirect('/admin-menu');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $meal = menu_item::findOrFail($id);
        $categories=$this->getCategory();
        return view('admin.edits.editMeal',['data1'=>$meal,'data'=>$categories]);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, string $id)
    {
        //
        $meal=menu_item::find($id);
        if($req->hasFile('image'))
        {
            $path= public_path($meal->image);
            if(File::exists($path)){
                File::delete($path);
            }
            $path = 'images\menu'; // the path to the directory you want to store the file in
            $file = $req->image->getClientOriginalName();
            $req->image->move(public_path($path),$file);
            $meal->image="/images/menu/".$req->image->getClientOriginalName();
        }
        $meal->name=$req->name;
        $meal->price=$req->price;
        $meal->description=$req->description;
        $meal->category_id=$req->category_id;
        $meal->save();
        return redirect('/admin-menu');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $meal = menu_item::findOrFail($id);
        $path= public_path($meal->image);
        if(File::exists($path)){
            File::delete($path);
        }
        $meal->delete();
        return redirect('/admin-menu')->with('success', 'Meal deleted successfully');
    }
}
