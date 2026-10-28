<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product') instanceof \App\Models\Product
            ? $this->route('product')->id
            : $this->route('product');

        return [
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:100', Rule::unique('products', 'sku')->ignore($productId)],
            'description' => ['nullable', 'string', 'max:2000'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'max:999999.99', 'lte:price'],
            'category' => ['required', 'string', 'max:100'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'low_stock_threshold' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:Active,Inactive,Draft'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:3072'],
        ];
    }

    /**
     * Custom error messages for friendly UX.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The product name is required.',
            'sku.required' => 'The SKU code is required.',
            'sku.unique' => 'This SKU is already registered to another product.',
            'price.required' => 'The product price is required.',
            'price.min' => 'Price cannot be negative.',
            'sale_price.lte' => 'Sale price must be less than or equal to the regular price.',
            'stock_quantity.required' => 'Stock quantity is required.',
            'stock_quantity.min' => 'Stock quantity must be a non-negative number.',
            'category.required' => 'Please select or enter a valid category.',
            'status.required' => 'Please specify the publication status.',
            'image.image' => 'The uploaded file must be an image.',
            'image.max' => 'Product image size may not exceed 3MB.',
        ];
    }
}
