<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\TrainigSession;
use App\Models\Training;
use App\Models\TrainingCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrainingController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function categories()
    {
        $data = TrainingCategories::withTrashed()->latest()->get();
        return view('admin.training.categories.list', compact('data'));
    }

    public function categoryAdd()
    {
        return view('admin.training.categories.add');
    }

    public function categoryStore(Request $request)
    {
        $request->merge(['slug' => Str::slug($request->name)]);

        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'required|string|unique:training_categories,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $category = new TrainingCategories();
        $category->name = $request->name;
        $category->slug = $request->slug;
          
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'training_category_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/training/category'), $fileName);
            $category->image = $fileName;
        }

        $check = $category->save();

        if($check) {
            return redirect()->route('training-categories')->with('success', 'Category created successfully.');
        } else {
            return redirect()->route('training-categories')->with('error', 'Category Not created.');
        }
    }

    public function categoryEdit($id)
    {
        $data = TrainingCategories::findOrFail($id);
        return view('admin.training.categories.edit', compact('data'));
    }

    public function categoryUpdate(Request $request, $id)
    {
        $request->merge(['slug' => Str::slug($request->name)]);

        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'required|string|unique:training_categories,slug,'.$id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $category = TrainingCategories::findOrFail($id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        
        if ($request->hasFile('image')) {
                
            if ($category->image && file_exists(public_path('images/training/category/'.$category->image))) {
                unlink(public_path('images/training/category/'.$category->image));
            }

            $file = $request->file('image');
            $fileName = 'training_category_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/training/category'), $fileName);
            $category->image = $fileName;
        }

        $check = $category->save();

        if($check) {
            return redirect()->route('training-categories')->with('success', 'Category updated successfully.');
        } else {
            return redirect()->route('training-categories')->with('error', 'Category not updated.');
        }
    }

    public function categoryDelete($id)
    {
        $data = TrainingCategories::withTrashed()->findOrFail($id);
        
        if ($data->trashed()) {
            $data->restore();
            $message = ' Category restored successfully!';
        } else {
            $data->delete();
            $message = ' Category deleted successfully!';
        }

        return redirect()->route('training-categories')->with('success', $message);
    }

    public function training(Request $request)
    {
        $category = TrainingCategories::withTrashed()->latest()->get();
        
        if(empty($request->category_id)) {
            $request->merge(['category_id' => $category[0]->id??'0']);
        }
        $data = TrainigSession::with('category')->withTrashed()->latest()->get();
        return view('admin.training.list', compact('data','category'));
    }

    public function trainingAdd()
    {
        $category = TrainingCategories::get();
        return view('admin.training.add', compact('category'));
    }

    public function trainingStore(Request $request)
    {

        $validated = $request->validate([
            'category_id' => 'required|integer|exists:training_categories,id',
            'title' => 'required|string|min:5|max:255',
             'video' => 'required|url',
            'content' => 'required|string',
        ]);

        $training = new TrainigSession();
        $training->category_id = $request->category_id;
        $training->title = $request->title;
        $training->url = $request->video;
        $training->description = $request->content;
 

        $check = $training->save();

        if($check) {
            return redirect()->route('trainings')->with('success', 'Session created successfully.');
        } else {
            return redirect()->route('trainings')->with('error', 'Session not created.');
        }
    }

    public function trainingEdit($id)
    {
        $category = TrainingCategories::get();
        $data = TrainigSession::withTrashed()->findOrFail($id);
        return view('admin.training.edit', compact('data', 'category'));
    }

    public function trainingUpdate(Request $request, $id)
    {
        
        $request->validate([
            'category_id' => 'required|integer|exists:training_categories,id',
            'title' => 'required|string|min:5|max:255',
             'video' => 'nullable|url',
            'content' => 'nullable|string',
             
        ]);

        $training = TrainigSession::withTrashed()->findOrFail($id);
        $training->category_id = $request->category_id;
        $training->title = $request->title;
        $training->url = $request->video;
        $training->description = $request->content;


        $check = $training->save();

        if($check) {
            return redirect()->route('trainings')->with('success', 'Session updated successfully.');
        } else {
            return redirect()->route('trainings')->with('error', 'Session not updated.');
        }
    }

    public function trainingDelete($id)
    {
        $data = TrainigSession::withTrashed()->findOrFail($id);
        
        if ($data->trashed()) {
            $data->restore();
            $message = 'Session restored successfully!';
        } else {
            $data->delete();
            $message = 'Session deleted successfully!';
        }

        return redirect()->route('trainings')->with('success', $message);
    }
    public function trainingView($id)
    {
        $data = TrainigSession::withTrashed()->findOrFail($id);
        return view('admin.training.details', compact('data'));
    }
}
