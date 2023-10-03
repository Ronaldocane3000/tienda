<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $notifications = Notification::where('is_seen', false)->get();
        $notificationsCount = $notifications->count();
        $perPage = 2; // Número de categorías por página
        $search = $request->input('search');

        // Consulta de búsqueda
        $query = Product::query();

        if (!empty($search)) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('selling_price', 'like', "%$search%");
        }

        $products = $query->paginate($perPage);

        if ($request->ajax()) {
            return view('admin.product.search', compact('products','notifications','notificationsCount'))->render();
        }

        return view('admin.product.index', compact('products', 'search','notifications','notificationsCount'));
    }

    public function search(Request $request)
    {
        $perPage = 2;
        $search = $request->input('search');

        $query = Product::query();

        if (!empty($search)) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('selling_price', 'like', "%$search%");
        }

        $products = $query->paginate($perPage);

        return view('admin.product.search', compact('products'))->render();
    }


    public function add()
    {
        $notifications = Notification::where('is_seen', false)->get();
        $notificationsCount = $notifications->count();
        $category = Category::all();
        return view('admin.product.add', compact('category','notifications','notificationsCount'));
    }


    public function insert(Request $request)
    {

        $product = new Product();

        if ($request->hasFile('image')) {


            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('assets/uploads/product', $filename);
            $product->image = $filename;
        }
        $product->cate_id = $request->input('cate_id');
        $product->name = $request->input('name');
        $product->slug = $request->input('slug');
        $product->small_description = $request->input('small_description');
        $product->description = $request->input('description');
        $product->original_price = $request->input('original_price');
        $product->selling_price = $request->input('selling_price');
        $product->tax = $request->input('tax');
        $product->qty = $request->input('qty');
        $product->status = $request->input('status') == TRUE ? '1' : '0';
        $product->trending = $request->input('trending') == TRUE ? '1' : '0';
        $product->meta_title = $request->input('meta_title');
        $product->meta_keywords = $request->input('meta_keywords');
        $product->meta_description = $request->input('meta_description');
        $product->save();

        return redirect('products')->with('status', 'Product Added Successfully');
    }

    public function edit($id)
    {
        $product = Product::find($id);

        return view('admin.product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {

        $product = Product::find($id);
        if ($request->hasFile('image')) {
            $path = public_path('assets/uploads/product/' . $product->image);

            if (file_exists($path)) {
                unlink($path);
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('assets/uploads/product', $filename);
            $product->image = $filename;
        }

        $product->name = $request->input('name');
        $product->slug = $request->input('slug');
        $product->small_description = $request->input('small_description');
        $product->description = $request->input('description');
        $product->original_price = $request->input('original_price');
        $product->selling_price = $request->input('selling_price');
        $product->tax = $request->input('tax');
        $product->qty = $request->input('qty');
        $product->status = $request->input('status') == TRUE ? '1' : '0';
        $product->trending = $request->input('trending') == TRUE ? '1' : '0';
        $product->meta_title = $request->input('meta_title');
        $product->meta_description = $request->input('meta_description');
        $product->meta_keywords = $request->input('meta_keywords');
        $product->update();

        return redirect('products')->with('status', "Product Update Successfully");
    }

    public function destroy($id)
    {

        $product = Product::find($id);
        if ($product->image) {
            $path = 'assets/uploads/product/' . $product->image;
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $product->delete();
        return redirect('categories')->with('status', 'Product Deleted Successfully');
    }
}
