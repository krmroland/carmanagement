<?php

namespace App\Products\Variants;

use App\Tenants\Entities\Tenant;

class TenantActions extends VariantActions
{
    /**
     * Returns the current tenant
     * @return \App\Tenants\Entities\Tenant|null
     */
    public function current()
    {
        return $this->variant->currentTenant;
    }

    /**
     * Adds a tenant to the current product variant
     */
    public function add(Tenant $tenant)
    {
        if ($this->has($tenant)) {
            return $this->raiseError('Tenant already belongs to the product');
        }

        $this->variant->tenants()->attach($tenant);

        // send an invitation email // notification
    }

    /**
     * Determines if the current variant has a given tenant
     * @return boolean
     */
    public function has(Tenant $tenant)
    {
        return $this->variant
            ->tenants()
            ->wherePivot('tenant_id', $tenant->id)
            ->exists();
    }
}
