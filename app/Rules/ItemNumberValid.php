<?php

namespace App\Rules;

use App\Models\Stock;
use App\Models\WorkOrder;
use Illuminate\Contracts\Validation\Rule;

class ItemNumberValid implements Rule
{

    private $attribute;
    private $qty;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $item_numbers = explode("\r\n", str_replace(' ', '', $value));

        $item_count = [];

        foreach ($item_numbers as $item) {

            if (!isset($item_count[$item])) {
                $item_count[$item] = 0;
            } else {
                $item_count[$item] = $item_count[$item] + 1;
            }

            $current = Stock::where('item_number', $item)->count();

            $workorder = WorkOrder::where('LINE #1', $item)->get();

            $available = 0;
            if (!$workorder->isEmpty()) {
                $available = $workorder->sum('QTY');
            }

            if (($current + $item_count[$item]) >= $available) {
                $this->attribute = $item;
                $this->qty = $available;

                return false;
            }

        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This Item Number ' . $this->attribute . ' is not allowed. Available: ' . $this->qty;
    }
}
