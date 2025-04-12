<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    
    //  if user authorized to make request.
     
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if($this->isMethod('post')) {
            return [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|min:0|max:99999.99|numeric',
                'quantity' => 'required|integer|min:0',
            ];
        } elseif ($this->isMethod('put')) {
            return [
                'name' => 'string|max:255',
                'description' => 'string',
                'price' => 'numeric|min:0|max:99999.99',
                'quantity' => 'integer|min:0',
            ];
        }
        return [];
    }

}
