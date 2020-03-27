<?php

namespace App\Products\Entities;

use App\Accounts\RecordsAccountDataHistoryModel;

class ProductVariantTenant extends RecordsAccountDataHistoryModel
{
    /**
     * The dates fields
     * @var array
     */
    protected $dates = [
        'joined_at',
        'left_at',
        'accepted_invitation_at',
        'expected_join_data',
        'expected_leave_data',
    ];

    /**
     * The casts array
     * @var array
     */
    protected $casts = ['due_amount' => 'decimal:8,2', 'paid_amount' => 'decimal:8,2'];
}
