<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends BaseController
{
    public function index()
    {
        $product = Product::orderBy("id","desc")->paginate(10);
        return $this->sendResponse($product, 'Product Lists.');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'brand' => 'required',
            'category' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        // Handle image upload
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'uploads/products/' . $imageName;
            Storage::disk('public')->put($imagePath, file_get_contents($image));
            $input['thumbnail'] = $imagePath;
        }
        // Create product
        $product = Product::create($input);

        if ($product) {
            return $this->sendResponse($product, 'Product created successfully.');
        } else {
            return $this->sendError('Error occurred while creating product.');
        }
    }


    public function edit($id)
    {
        $product = Product::find($id);

        if ($product) {
            return $this->sendResponse($product, 'Product Details.');
        } else {
            return $this->sendError('Error occurred while creating product.');
        }
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'brand' => 'required',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'uploads/products/' . $imageName;
            Storage::disk('public')->put($imagePath, file_get_contents($image));
            $input['thumbnail'] = $imagePath;
        }
        // Create product
        $product = Product::where('id',$id)->update($input);

        if ($product) {
            return $this->sendResponse($product, 'Product Update successfully.');
        } else {
            return $this->sendError('Error occurred while Update product.');
        }

    }

    public function delete($id)
    {
        $product = Product::where('id',$id)->delete();
        if ($product) {
            return $this->sendResponse($product, 'Product Delete successfully.');
        } else {
            return $this->sendError('Error occurred while Delete product.');
        }
    }

    public function show($id)
    {
        $product = Product::find($id);

        if ($product) {
            return $this->sendResponse($product, 'Product Details.');
        } else {
            return $this->sendError('Error occurred while creating product.');
        }
    }
}
