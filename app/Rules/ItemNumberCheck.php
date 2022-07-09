<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Stock;


class ItemNumberCheck implements Rule
{

    private $item_number;
    private $rack_number;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($rack_number)
    {
        $this->rack_number = $rack_number;
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

        foreach ($item_numbers as $item) {
            $current = Stock::where('item_number', $item)
                ->where('rack_number', '!=', $this->rack_number)
                ->exists();

            if (!$current) {

                $this->item_number = $item;
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
        return 'The item '.$this->item_number.' is not in that location';
    }
}
