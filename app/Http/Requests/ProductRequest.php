<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'intitule' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Changez 'photo' par 'image'
            'cat_id' => 'required|exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'intitule.required' => 'Le nom du produit est requis.',
            'prix.required' => 'Le prix du produit est requis.',
            'cat_id.required' => 'La catégorie est requise.',
        ];
    }
}
