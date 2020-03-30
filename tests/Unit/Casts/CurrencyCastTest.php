<?php

namespace Tests\Unit\Casts;

use Tests\TestCase;
use Tests\TestModel;
use App\Casts\Currency;
use Illuminate\Validation\ValidationException;

class CurrencyCastTest extends TestCase
{
    public function testSetReturnsTheValueIfAGivenCurrencyCodeIsValid()
    {
        $model = new TestModel();

        $caster = new Currency();

        $this->assertEquals($caster->set($model, 'currency', 'UGX', []), 'UGX');
    }

    public function testSetCurrencyFailsForInvalidCurrencySymbols()
    {
        $model = new TestModel();

        $caster = new Currency();

        $this->expectException(ValidationException::class);

        $caster->set($model, 'currency', 'INVALID-CURRENCY-SYMBOL', []);
    }

    public function testGetReturnsTheFullCurrencyObjectFromCurrencySymbol()
    {
        $model = new TestModel();

        $caster = new Currency();

        $this->assertEquals($caster->get($model, 'currency', 'UGX', []), [
            'symbol' => 'USh',
            'name' => 'Ugandan Shilling',
            'symbol_native' => 'USh',
            'decimal_digits' => 0,
            'rounding' => 0,
            'code' => 'UGX',
            'name_plural' => 'Ugandan shillings',
        ]);
    }
}
