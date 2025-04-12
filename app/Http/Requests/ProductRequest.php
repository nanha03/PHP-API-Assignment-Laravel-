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

}
