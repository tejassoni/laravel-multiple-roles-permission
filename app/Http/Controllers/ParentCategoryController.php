<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

class ParentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {        
        //KEY : MULTIPERMISSION
        $this->middleware('permission:category-list|category-create|category-edit|category-show|category-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);    
        $this->middleware('permission:category-show', ['only' => ['show']]);    
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        $categories = Category::where('status',Category::STATUS_ACTIVE)->orderBy('updated_at','desc')->get();
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $created = Category::create(['name' => $request->name, 'description' => $request->description, 'user_id' => auth()->user()->id]);

        if ($created) { // inserted success
            return redirect()->route('category.index')
                ->withSuccess('created successfully...!');
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'fails not created..!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->all());

        return redirect()->route('category.index')
            ->withSuccess('Updated Successfully...!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('category.index')
            ->withSuccess('Deleted Successfully.');
    }
}