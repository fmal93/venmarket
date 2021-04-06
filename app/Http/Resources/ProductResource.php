<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'brand' => $this->Brand->name,
            'img_url' => $this->productImage->img_url,
            'stock' => $this->productValue->productStock->stock,
            'product_value' => $this->productValue->detail,
            'price' => $this->productValue->price,
            'sku' => $this->productValue->sku,
        ];
    }
}
