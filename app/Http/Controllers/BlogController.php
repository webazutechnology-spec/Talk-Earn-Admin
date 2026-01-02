<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;



class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function categories()
    {
        $data = BlogCategory::withTrashed()->latest()->get();
        return view('admin.blog.category.list', compact('data'));
    }

    public function categoryAdd()
    {
        return view('admin.blog.category.add');
    }

    public function categoryStore(Request $request)
    {
        $request->merge(['slug' => Str::slug($request->name)]);

        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'required|string|unique:blog_categories,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $category = new BlogCategory();
        $category->name = $request->name;
        $category->slug = $request->slug;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'blog_category_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/blog/category'), $fileName);
            $category->image = $fileName;
        }

        $check = $category->save();

        if($check) {
            return redirect()->route('blog-categories')->with('success', 'Category created successfully.');
        } else {
            return redirect()->route('blog-categories')->with('error', 'Category Not created.');
        }
    }

    public function categoryEdit($id)
    {
        $data = BlogCategory::findOrFail($id);
        return view('admin.blog.category.edit', compact('data'));
    }

    public function categoryUpdate(Request $request, $id)
    {
        $request->merge(['slug' => Str::slug($request->name)]);

        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'required|string|unique:blog_categories,slug,'.$id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $category = BlogCategory::findOrFail($id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        
        if ($request->hasFile('image')) {
                
            if ($category->image && file_exists(public_path('images/blog/category/'.$category->image))) {
                unlink(public_path('images/blog/category/'.$category->image));
            }

            $file = $request->file('image');
            $fileName = 'blog_category_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/blog/category'), $fileName);
            $category->image = $fileName;
        }

        $check = $category->save();

        if($check) {
            return redirect()->route('blog-categories')->with('success', 'Category updated successfully.');
        } else {
            return redirect()->route('blog-categories')->with('error', 'Category not updated.');
        }
    }

    public function categoryDelete($id)
    {
        $data = BlogCategory::withTrashed()->findOrFail($id);
        
        if ($data->trashed()) {
            $data->restore();
            $message = 'City restored successfully!';
        } else {
            $data->delete();
            $message = 'City deleted successfully!';
        }

        return redirect()->route('blog-categories')->with('success', $message);
    }

    public function blogs(Request $request)
    {
        $category = BlogCategory::withTrashed()->latest()->get();
        
        if(empty($request->category_id)) {
            $request->merge(['category_id' => $category[0]->id??'0']);
        }
// ->where('category_id', $request->category_id)
        $data = Blog::with('category')->withTrashed()->latest()->get();
        return view('admin.blog.list', compact('data','category'));
    }

    public function blogAdd()
    {
        $category = BlogCategory::get();
        return view('admin.blog.add', compact('category'));
    }

    public function blogStore(Request $request)
    {
        $request->merge(['slug' => Str::slug($request->title)]);

        $validated = $request->validate([
            'category_id' => 'required|integer|exists:blog_categories,id',
            'status' => 'required|in:Pending,Publish,Schedule,Unpublish',
            'publish_datetime' => 'required|date', //|after_or_equal:today
            'title' => 'required|string|min:5|max:255',
            'slug' => 'required|string|unique:blogs,slug|min:3|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $blog = new Blog();
        $blog->category_id = $request->category_id;
        $blog->status = $request->status;
        $blog->publish_datetime = $request->publish_datetime;
        $blog->title = $request->title;
        $blog->slug = $request->slug;
        $blog->content = $request->content;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'blog_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/blog'), $fileName);
            $blog->image = $fileName;
        }

        $check = $blog->save();

        if($check) {
            return redirect()->route('blogs')->with('success', 'Blog created successfully.');
        } else {
            return redirect()->route('blogs')->with('error', 'Blog not created.');
        }
    }

    public function blogEdit($id)
    {
        $category = BlogCategory::get();
        $data = Blog::withTrashed()->findOrFail($id);
        return view('admin.blog.edit', compact('data', 'category'));
    }

    public function blogUpdate(Request $request, $id)
    {
        $request->merge(['slug' => Str::slug($request->title)]);
        
        $request->validate([
            'category_id' => 'required|integer|exists:blog_categories,id',
            'status' => 'required|in:Pending,Publish,Schedule,Unpublish',
            'publish_datetime' => 'required|date', //|after_or_equal:today
            'title' => 'required|string|min:5|max:255',
            'slug' => 'required|string|min:3|max:255|unique:blogs,slug,'.$id,
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $blog = Blog::withTrashed()->findOrFail($id);
        $blog->category_id = $request->category_id;
        $blog->status = $request->status;
        $blog->publish_datetime = $request->publish_datetime;
        $blog->title = $request->title;
        $blog->slug = $request->slug;
        $blog->content = $request->content;

        if ($request->hasFile('image')) {
                
            if ($blog->image && file_exists(public_path('images/blog/'.$blog->image))) {
                unlink(public_path('images/blog/'.$blog->image));
            }

            $file = $request->file('image');
            $fileName = 'blog_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/blog'), $fileName);
            $blog->image = $fileName;
        }

        $check = $blog->save();

        if($check) {
            return redirect()->route('blogs')->with('success', 'Blog updated successfully.');
        } else {
            return redirect()->route('blogs')->with('error', 'Blog not updated.');
        }
    }

    public function blogDelete($id)
    {
        $data = Blog::withTrashed()->findOrFail($id);
        
        if ($data->trashed()) {
            $data->restore();
            $message = 'Blog restored successfully!';
        } else {
            $data->delete();
            $message = 'Blog deleted successfully!';
        }

        return redirect()->route('blogs')->with('success', $message);
    }

}
