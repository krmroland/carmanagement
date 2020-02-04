<?php

namespace App\Http\Requests\Products;

class ProductReadRequest extends BaseProductRequest
{
    /**
     * Gets the permission name
     * @return string
     */
    public function permissionName()
    {
        return 'products.read';
    }
}
