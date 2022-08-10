<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    protected $rules =[
        'name' => ['required', 'string', 'between:2,255'],
        'parent_id' => ['nullable', 'int', 'exists:categories,id'],
        'description' => ['nullable', 'string'],
        'art_file' => ['nullable', 'image'],
    ];
    
    // Custamiz on the message the exists in resourse->lang->validation.php
    protected $message = [
        'image' => 'The art File shoulde be image type.',
        'name.required' => 'The :attribute filed is mandatory.',
    ];
    // Actions
    public function index($slug, $id = 0)
    {
        //$categories = DB::table('categories')->get();
        $categories = Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name',
            ])
            ->paginate();

        // $flashMessage = session('success', false);
        // $flashMessage = session()->get('success', false);
        // $flashMessage = Session::get('success', false);
        

        // view() = Response::view() == View::make()
        return view('categories.index', [
            'categories' => $categories,
            'title' => 'categories',
            'flashMessage' => session('success'),
        ]);
    }

    public function show(Category $category)
    {
        // $category = Category::findOrFail($id);//$category = DB::table('categories')->where('id', '=', $id)->first();
        return view('categories.show',[
            'category' => $category,
        ]);

       /* if ($category == 'null') {
            abort(404);
        }*/
    }

    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('categories.create', compact('category','parents'));
    }

    public function store(Request $request) 
    {
       

        // There Method 
        $clean = $request->validate($this->rules, $this->message);
        // $clean = $this->validate($request, $rules, $message);

        //  $validator = Validator::make($request->all(), $rules, $message);

        // // $clean1 = $validator->validate();
        // if ($validator->fails()){
        //     return redirect()->back()->withErrors($validator);
        // } // = The code equle to the $clean1

        // dd(
        //     $request->name,
        //     $request->input('name'),
        //     $request->post('name'),
        //     $request['name'],
        //     $request->query('name'),
        // );

        // DB::table('categories')->insert([]);

        // $category = new Category();
        // $category->name = $request->input('name'); // = The clean['name']
        // $category->description = $request->input('description');
        // $category->parent_id = $request->input('parent_id');
        // $category->slug = Str::slug($category->name);
        // $category->save();
        
        $data = $request->all();

        if (! $data['slug']) {
            $data['slug'] = Str::slug($data['name']);
        }
        $category = Category::create( $request->all() );

        // PRG: POST Redirect Get

        return redirect()
            ->route('categoris.index')
            ->with('success', 'Category Created!');

    }

    public function edit(Category $category)
    {
        // $category = Category::findOrFail($id);
        $parents = Category::all();

        return view('categories.edit', compact('category','parents'));
    }

    public function update(Request $request,Category $category)
    {
        // $category = Category::findOrFail($id);
        
        $clean = $request->validate($this->rules, $this->message);
        // $category->name = $request->input('name');
        // $category->description = $request->input('description');
        // $category->parent_id = $request->input('parent_id');
        // $category->slug = Str::slug($category->name);
        // $category->save();

        $category->update($request->all());

        return redirect()
            ->route('categoris.index')
            ->with('success', 'Category Updata!');
    }

    public function destroy($id)
    {
        // Methdod 1
        // DB::table('categories')->where('id', $id)->delete();
        // Methdod 2
        // Category::where('id', $id)->delete();
        // Methdod 3
        // $category = Category::findOrFail($id);
        // $category->delete;
        // Method 4
        Category::destroy($id);
        // session()->flash('success', 'Category Delete!');
        // Session::flash('success', 'Category Delete!');
        return redirect('/categories')->with('success', 'Category Delete!');

    }
}
