<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
        public function __construct()
    {
        $this->middleware('auth');
    }

    public function categories()
    {
        $data = ProductCategory::withTrashed()->latest()->get();
        return view('admin.product.category.list', compact('data'));
    }

    public function categoryAdd()
    {
        return view('admin.product.category.add');
    }

    public function categoryStore(Request $request)
    {
        $request->merge(['slug' => Str::slug($request->name)]);

        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'required|string|unique:categories,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $category = new ProductCategory();
        $category->name = $request->name;
        $category->slug = $request->slug;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'product_category_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/product/category'), $fileName);
            $category->image = $fileName;
        }

        $check = $category->save();

        if($check) {
            return redirect()->route('product-categories')->with('success', 'Category created successfully.');
        } else {
            return redirect()->route('product-categories')->with('error', 'Category Not created.');
        }
    }

    public function categoryEdit($id)
    {
        $data = ProductCategory::findOrFail($id);
        return view('admin.product.category.edit', compact('data'));
    }

    public function categoryUpdate(Request $request, $id)
    {
        $request->merge(['slug' => Str::slug($request->name)]);

        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'required|string|unique:categories,slug,'.$id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $category = ProductCategory::findOrFail($id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        
        if ($request->hasFile('image')) {
                
            if ($category->image && file_exists(public_path('images/product/category/'.$category->image))) {
                unlink(public_path('images/product/category/'.$category->image));
            }

            $file = $request->file('image');
            $fileName = 'product_category_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/product/category'), $fileName);
            $category->image = $fileName;
        }

        $check = $category->save();

        if($check) {
            return redirect()->route('product-categories')->with('success', 'Category updated successfully.');
        } else {
            return redirect()->route('product-categories')->with('error', 'Category not updated.');
        }
    }

    public function categoryDelete($id)
    {
        $data = ProductCategory::withTrashed()->findOrFail($id);
        
        if ($data->trashed()) {
            $data->restore();
            $message = 'Product restored successfully!';
        } else {
            $data->delete();
            $message = 'Product deleted successfully!';
        }

        return redirect()->route('product-categories')->with('success', $message);
    }

    public function products(Request $request)
    {
        $category = ProductCategory::withTrashed()->latest()->get();
        
        if(empty($request->category_id)) {
            $request->merge(['category_id' => $category[0]->id??'0']);
        }
// ->where('category_id', $request->category_id)
        $data = Product::with('category')->withTrashed()->latest()->get();
        return view('admin.product.list', compact('data','category'));
    }

    public function productAdd()
    {
        $category = ProductCategory::get();
        $brand = Brand::get();
        return view('admin.product.add', compact('category', 'brand'));
    }

    public function productStore(Request $request)
    {
        $request->merge(['slug' => Str::slug($request->name)]);

        $validated = $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'brand_id' => 'required|integer|exists:brands,id',
            'slug' => 'required|string|unique:products,slug|min:3|max:255',
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'sku' => 'required|string|max:100',
            'capacity' => 'required|string|max:100',
            'voltage' => 'required|string|max:100',
            'type' => 'required|string|max:100',
            'price' => 'required|numeric',
            'disc_price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
             'content' => 'required|string',
        ]);

        $product = new Product();
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->sku = $request->sku;
        $product->capacity = $request->capacity;
        $product->voltage = $request->voltage;
        $product->type = $request->type;
        $product->price = $request->price;
        $product->disc_price = $request->disc_price;
        $product->stock_quantity = $request->stock_quantity;
        $product->specifications = $request->content;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'product_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/product'), $fileName);
            $product->image = $fileName;
        }

        $check = $product->save();

        if($check) {
            return redirect()->route('products')->with('success', 'Product created successfully.');
        } else {
            return redirect()->route('products')->with('error', 'Product not created.');
        }
    }

    public function productEdit($id)
    {
        $category = ProductCategory::get();
        $data = Product::withTrashed()->findOrFail($id);
        $brand = Brand::get();
        return view('admin.product.edit', compact('data', 'category', 'brand'));
    }

    public function productUpdate(Request $request, $id)
    {
        $request->merge(['slug' => Str::slug($request->name)]);
        
        $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'brand_id' => 'required|integer|exists:brands,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100',
            'capacity' => 'required|string|max:100',
            'voltage' => 'required|string|max:100',
            'type' => 'required|string|max:100',
            'price' => 'required|numeric',
            'disc_price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'slug' => 'required|string|min:3|max:255|unique:products,slug,'.$id,
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $product = Product::withTrashed()->findOrFail($id);
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->capacity = $request->capacity;
        $product->voltage = $request->voltage;
        $product->type = $request->type;
        $product->price = $request->price;
        $product->disc_price = $request->disc_price;
        $product->stock_quantity = $request->stock_quantity;
        $product->slug = $request->slug;
        $product->specifications = $request->content;

        if ($request->hasFile('image')) {
                
            if ($product->image && file_exists(public_path('images/product/'.$product->image))) {
                unlink(public_path('images/product/'.$product->image));
            }

            $file = $request->file('image');
            $fileName = 'product_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/product'), $fileName);
            $product->image = $fileName;
        }

        $check = $product->save();

        if($check) {
            return redirect()->route('products')->with('success', 'Product updated successfully.');
        } else {
            return redirect()->route('products')->with('error', 'Product not updated.');
        }
    }

    public function productDelete($id)
    {
        $data = Product::withTrashed()->findOrFail($id);
        
        if ($data->trashed()) {
            $data->restore();
            $message = 'Product restored successfully!';
        } else {
            $data->delete();
            $message = 'Product deleted successfully!';
        }

        return redirect()->route('products')->with('success', $message);
    }

    
    public function brands()
    {
        $data = Brand::withTrashed()->latest()->get();
        return view('admin.product.brand.list', compact('data'));
    }

    public function brandAdd()
    {
        return view('admin.product.brand.add');
    }

    public function brandStore(Request $request)
    {
        $request->merge(['slug' => Str::slug($request->name)]);

        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'required|string|unique:brands,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = $request->slug;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'brand_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/brand'), $fileName);
            $brand->image = $fileName;
        }

        $check = $brand->save();

        if($check) {
            return redirect()->route('brands')->with('success', 'Brand created successfully.');
        } else {
            return redirect()->route('brands')->with('error', 'Brand Not created.');
        }
    }

    public function brandEdit($id)
    {
        $data = Brand::findOrFail($id);
        return view('admin.product.brand.edit', compact('data'));
    }

    public function brandUpdate(Request $request, $id)
    {
        $request->merge(['slug' => Str::slug($request->name)]);

        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'required|string|unique:brands,slug,'.$id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        
        if ($request->hasFile('image')) {
                
            if ($brand->image && file_exists(public_path('images/brand/'.$brand->image))) {
                unlink(public_path('images/brand/'.$brand->image));
            }

            $file = $request->file('image');
            $fileName = 'brand_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/brand'), $fileName);
            $brand->image = $fileName;
        }

        $check = $brand->save();

        if($check) {
            return redirect()->route('brands')->with('success', 'Brand updated successfully.');
        } else {
            return redirect()->route('brands')->with('error', 'Brand not updated.');
        }
    }

    public function brandDelete($id)
    {
        $data = Brand::withTrashed()->findOrFail($id);
        
        if ($data->trashed()) {
            $data->restore();
            $message = 'Brand restored successfully!';
        } else {
            $data->delete();
            $message = 'Brand deleted successfully!';
        }

        return redirect()->route('brands')->with('success', $message);
    }


}
