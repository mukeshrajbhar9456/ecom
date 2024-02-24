<?php

namespace App\Http\Controllers\Api\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductUserController extends BaseController
{
    public function index()
    {
        $products = Product::orderBy("id", "desc")->paginate(10);
        return $this->sendResponse($products, 'Products List.');
    }
    public function details($id)
    {
        $products =  Product::find($id);

        return $this->sendResponse($products, 'Products Details.');
    }
}
