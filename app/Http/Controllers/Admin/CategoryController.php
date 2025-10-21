<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    //category  list page
    public function list(){
        $data = Category::orderBy('created_at' , 'desc')->paginate(5);
        return view('admin.category.list' , compact('data'));
    }

    //category create page
    public function createPage(){
        return view('admin.category.create');
    }

   //category data
   public function create(Request $request){
        //dd($request->all());

        //to check validate
        $validator = $request->validate([
            'category' => 'required|unique:categories,name', //not db field
        ],[
            'category.required' => 'Category field is required...',
            'category.unique' => 'This category has already been taken.Please Choose another one!!!'
        ]);

        //to create data
        Category::create([
            'name' => $request->category,
        ]);

        //after creating data 
        Alert::success('Insert Success', 'Category has been inserted successfully...');
        return back();
        //return to_route('categoryList');
    } 

    //delete category
    public function delete($id){
        Category::where('id',$id)->delete();

        Alert::success('Delete Success', 'Category has been deleted successfully...');
        return back();
    }

    //edit category
    public function edit($id){
        $data = Category::where('id',$id)->first();
        //dd($data->toArray());
        return view('admin.category.edit',compact('data'));
    }

    //update category
    public function update(Request $request){
        $validator = $request->validate([
            'category' => 'required|unique:Categories,name,'.$request->categoryId
        ]);

        Category::where('id',$request->categoryId)->update([
            'name' => $request->category
        ]);

        Alert::success('Update Success', 'Category has been updated successfully...'); 
        return to_route('categoryList');
    }

}
