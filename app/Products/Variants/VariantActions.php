<?php

namespace App\Products\Variants;

use App\Helpers\BaseAction;
use App\Products\Models\ProductVariant;

abstract class VariantActions extends BaseAction
{
    /**
     * The Product Variant Model
     * @var \App\Products\Models\ProductVariant\
     */
    protected $variant;

    /**
     * Creates an instance of thus class
     */
    public function __construct(ProductVariant $variant)
    {
        $this->variant = $variant;
    }
}
