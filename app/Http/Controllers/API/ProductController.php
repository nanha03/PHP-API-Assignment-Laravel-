<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function show($id)
    {
        try {
            $path = public_path('products/products.json');
            $productsJson = json_decode(file_get_contents($path), true);
            // Logic to retrieve a product by ID
            $product = null;
            foreach ($productsJson['products'] as $item) {
                if ($item['id'] == $id) {
                    $product = $item;
                    break;
                }
            }
            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }
            return response()->json(['product' => $product], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong. Please try again later.'], 500);
        }
    }
}
