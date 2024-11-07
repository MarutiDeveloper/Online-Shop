<?php

    use App\Models\category;
    use App\Models\ProductImage;

    function getCategories(){
        return category::orderBy('name', 'ASC')
        ->with('sub_category')
        ->orderBy('id', 'DESC')
        ->where('status', 1)
        ->where('showHome', 'Yes')
        ->get();
    }

    function getProductImage ($productId) {
        return ProductImage::where('product_id', $productId)->first();
    }
?>