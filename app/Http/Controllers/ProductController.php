<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
        $this->middleware('permission:product-show', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        return response()->view('products.index', [
            'products' => Product::with(['getParentCategoryHasOne'])->orderBy('updated_at', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $parent_category = Category::where('status', Category::STATUS_ACTIVE)->get();
        $subCategories = SubCategory::where('status', Category::STATUS_ACTIVE)->get();
        return view('products.create', compact('parent_category', 'subCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request) {
        $fileName = null;
        if($request->hasFile('image')) {
            $filehandle = $this->_singleFileUploads($request, 'image', 'public/products');            
            $fileName = $filehandle['data']['name'];
        }
        $created = Product::create(['name' => $request->name, 'description' => $request->description,'image' => $fileName, 'parent_category_id' => $request->select_parent_cat, 'price' => $request->price, 'qty' => $request->qty, 'user_id' => auth()->user()->id]);

        if($created) { // inserted success
            return redirect()->route('products.index')
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
    public function show(Product $product) {
        $product->with('getParentCatHasOne')->where('user_id', auth()->user()->id);
        $parent_category = Category::where('status', Category::STATUS_ACTIVE)->get();
        $subCategories = SubCategory::where('status', Category::STATUS_ACTIVE)->get();
        return view('products.show', compact('product', 'parent_category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product) {
        $product->with('getParentCatHasOne')->where('user_id', auth()->user()->id);
        $parent_category = Category::where('status', Category::STATUS_ACTIVE)->get();
        $subCategories = SubCategory::where('status', Category::STATUS_ACTIVE)->get();
        return view('products.edit', compact('product', 'parent_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product) {
        $fileName = $product->image;
        if($request->hasFile('image')) {
            if (Storage::exists('/public/products/'.$product->image)) {
                Storage::delete('/public/products/'.$product->image);
            }
            $filehandle = $this->_singleFileUploads($request, 'image', 'public/products');            
            $fileName = $filehandle['data']['name'];
        }
        $product->update(['name' => $request->name, 'description' => $request->description,'image' => $fileName, 'parent_category_id' => $request->select_parent_cat, 'price' => $request->price, 'qty' => $request->qty, 'user_id' => auth()->user()->id]);

        return redirect()->route('products.index')
            ->withSuccess('Updated Successfully...!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->withSuccess('Deleted Successfully.');
    }

    /**
     * _singleFileUploads : Complete Fileupload Handling
     * @param  Request $request
     * @param  $htmlformfilename : input type file name
     * @param  $uploadfiletopath : Public folder paths 'foldername/subfoldername' Example public/user
     * @return File save with array return
     */
    private function _singleFileUploads($request = "", $htmlformfilename = "", $uploadfiletopath = "")
    {
        try {

            // check parameter empty Validation
            if (empty($request) || empty($htmlformfilename) || empty($uploadfiletopath)) {
                throw new \Exception("Required Parameters are missing", 400);
            }

            // check if folder exist at public directory if not exist then create folder 0777 permission
            if (!file_exists($uploadfiletopath)) {
                $oldmask = umask(0);
                mkdir($uploadfiletopath, 0777, true);
                umask($oldmask);
            }

            $fileNameOnly = preg_replace("/[^a-z0-9\_\-]/i", '', basename($request->file($htmlformfilename)->getClientOriginalName(), '.' . $request->file($htmlformfilename)->getClientOriginalExtension()));
            $fileFullName = $fileNameOnly . "_" . date('dmY') . "_" . time() . "." . $request->file($htmlformfilename)->getClientOriginalExtension();
            $path = $request->file($htmlformfilename)->storeAs($uploadfiletopath, $fileFullName);
            // $request->file($htmlformfilename)->move(public_path($uploadfiletopath), $fileFullName);
            $resp['status'] = true;
            $resp['data'] = array('name' => $fileFullName, 'url' => url('storage/' . str_replace('public/', '', $uploadfiletopath) . '/' . $fileFullName), 'path' => \storage_path('app/' . $path), 'extenstion' => $request->file($htmlformfilename)->getClientOriginalExtension(), 'type' => $request->file($htmlformfilename)->getMimeType(), 'size' => $request->file($htmlformfilename)->getSize());
            $resp['message'] = "File uploaded successfully..!";
        } catch (\Exception $ex) {
            $resp['status'] = false;
            $resp['data'] = ['name'=>null];
            $resp['message'] = 'File not uploaded...!';
            $resp['ex_message'] = $ex->getMessage();
            $resp['ex_code'] = $ex->getCode();
            $resp['ex_file'] = $ex->getFile();
            $resp['ex_line'] = $ex->getLine();
        }
        return $resp;
    }
}
