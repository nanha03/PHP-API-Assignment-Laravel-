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

    public function store(ProductRequest $request)
    {
        try {
            $path = public_path('products/products.json');
            $productsJson = json_decode(file_get_contents($path), true);
            $productsCount = count($productsJson['products']);

            $newProduct = [
                'id' => 'p' . $productsCount + 1,
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'quantity' => $request->input('quantity'),
            ];
            
            // Add the new product to the array
            $productsJson['products'][] = $newProduct;
            
            // Save the updated array back to the JSON file
            file_put_contents($path, json_encode($productsJson, JSON_PRETTY_PRINT));

            $product = $productsJson['products'][$productsCount];
            
            if (!$product) {
                return response()->json(['error' => 'Product not created.'], 404);
            }
            return response()->json(['product' => $product], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong. Please try again later.'], 500);
        }
    }


    public function update(ProductRequest $request, $id)
    {
        try {
            $path = public_path('products/products.json');
        $productsJson = json_decode(file_get_contents($path), true);
        
        // Logic to retrieve a product by ID
        $product = null;
        $productIndex = null;
        foreach ($productsJson['products'] as $key => $item) {
            if ($item['id'] == $id) {
                $product = $item;
                $productIndex = $key;
                break;
            }
        }
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Update the product details
        $newProduct = [
            'id' => $product['id'],
            'name' => $request->input('name') ?? $product['name'],
            'description' => $request->input('description') ?? $product['description'],
            'price' => $request->input('price') ?? $product['price'],
            'quantity' => $request->input('quantity') ?? $product['quantity'],
        ];
        
        // Add the new product to the array
        $productsJson['products'][$productIndex] = $newProduct;
        
        // Save the updated array back to the JSON file
        file_put_contents($path, json_encode($productsJson, JSON_PRETTY_PRINT));
        $updatedProduct = $productsJson['products'][$productIndex];
        
        if (!$updatedProduct) {
            return response()->json(['error' => 'Product not updated.'], 404);
        }
        return response()->json(['product' => $updatedProduct], 200);
        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. Please try again later.'], 500);
        }
    }
}
