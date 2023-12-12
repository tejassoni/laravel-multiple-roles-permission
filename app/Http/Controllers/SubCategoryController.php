<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use App\Http\Requests\SubCategoryStoreRequest;
use App\Http\Requests\SubCategoryUpdateRequest;

class SubCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //KEY : MULTIPERMISSION
        $this->middleware('permission:subcategory-list|subcategory-create|subcategory-edit|subcategory-show|subcategory-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:subcategory-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:subcategory-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:subcategory-delete', ['only' => ['destroy']]);
        $this->middleware('permission:subcategory-show', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        $subcategories = SubCategory::with(['getCatUserHasOne', 'getParentCatHasOne'])
        ->where('user_id', auth()->user()->id)
        ->orderBy('updated_at', 'desc')
        ->where('status',SubCategory::STATUS_ACTIVE)
        ->get();
        return view('subcategory.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parent_category = Category::where('status', SubCategory::STATUS_ACTIVE)
        ->get();
        return view('subcategory.create', \compact('parent_category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubCategoryStoreRequest $request)
    {
        $created = SubCategory::create(['name' => $request->name, 'description' => $request->description, 'parent_category_id' => $request->select_parent_cat, 'user_id' => auth()->user()->id]);

        if ($created) { // inserted success
            return redirect()->route('subcategory.index')
                ->withSuccess('Created successfully...!');
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'fails not created..!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subcategory)
    {        
        return view('subcategory.show', compact('subcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subcategory)
    {       
        $parent_category = Category::where('status', Category::STATUS_ACTIVE)->where('user_id', auth()->user()->id)->get();
        return view('subcategory.edit', compact('subcategory', 'parent_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubCategoryUpdateRequest $request, SubCategory $subcategory)
    {
        $subcategory->update(['name' => $request->name, 'description' => $request->description, 'parent_category_id' => $request->select_parent_cat, 'user_id' => auth()->user()->id]);

        return redirect()->route('subcategory.index')
            ->withSuccess('Updated Successfully...!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('subcategory.index')
            ->withSuccess('Deleted Successfully.');
    }   
}