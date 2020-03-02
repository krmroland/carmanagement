<?php

Route::apiResource('tenants', TenantsController::class)->middleware('auth');
