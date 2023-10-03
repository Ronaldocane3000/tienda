<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index(Request $request)
    {

        $notifications = Notification::where('is_seen', false)->get();
        $notificationsCount = $notifications->count();
        $perPage = 2; // Número de categorías por página
        $search = $request->input('search');
    
        // Consulta de búsqueda
        $query = Category::query();
    
        if (!empty($search)) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
        }
    
        $categories = $query->paginate($perPage);
    
        if ($request->ajax()) {
            return view('admin.category.search', compact('categories','notifications','notificationsCount'))->render();
        }
    
        return view('admin.category.index', compact('categories', 'search','notifications','notificationsCount'));
    }
    
    public function search(Request $request)
    {
        $perPage = 2;
        $search = $request->input('search');
    
        $query = Category::query();
    
        if (!empty($search)) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
        }
    
        $categories = $query->paginate($perPage);
    
        return view('admin.category.search', compact('categories'))->render();
    }
    



    public function add() {
        $notifications = Notification::where('is_seen', false)->get();
        $notificationsCount = $notifications->count();
        return view('admin.category.add', compact('notifications','notificationsCount'));
    }

    public function insert(Request $request) {
        $category = new Category();

        if($request->hasFile('image')){

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/category',$filename);
            $category->image = $filename;

            $category->name = $request->input('name');
            $category->slug = $request->input('slug');
            $category->description = $request->input('description');
            $category->status = $request->input('status') == TRUE ? '1':'0';
            $category->popular = $request->input('popular') == TRUE ? '1':'0';
            $category->meta_title = $request->input('meta_title');
            $category->meta_descrip = $request->input('meta_description');
            $category->meta_keywords = $request->input('meta_keywords');
            $category->save();
            return redirect('dashboard')->with('status','Category Added Successfully');

        }
    }

    public function edit($id){
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));

    }

    public function update(Request $request, $id){
        $category = Category::find($id);
        if($request->hasFile('image')){
            $path = public_path('assets/uploads/category/'.$category->image);

            if(file_exists($path)){
                unlink($path);
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/category',$filename);
            $category->image = $filename;


        }

        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->description = $request->input('description');
        $category->status = $request->input('status') == TRUE ? '1':'0';
        $category->popular = $request->input('popular') == TRUE ? '1':'0';
        $category->meta_title = $request->input('meta_title');
        $category->meta_descrip = $request->input('meta_description');
        $category->meta_keywords = $request->input('meta_keywords');
        $category->update();

        return redirect('dashboard')->with('status',"Category Update Successfully");

    }

    public function destroy($id){

        $category = Category::find($id);
        if($category->image){
            $path = 'assets/uploads/category/'.$category->image;
            if(file_exists($path)){
                unlink($path);
            }
        }
        $category->delete();
        return redirect('categories')->with('status','Category Deleted Successfully');
    }

    
    
    

    
}
