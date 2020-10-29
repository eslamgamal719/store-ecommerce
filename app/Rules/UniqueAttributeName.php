<?php

namespace App\Rules;

use App\Models\AttributeTranslation;
use Illuminate\Contracts\Validation\Rule;

class UniqueAttributeName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    private $attributeName;
    private $attributeId;

    public function __construct($attributeName, $attributeId)
    {
        $this->attributeName = $attributeName;
        $this->attributeId = $attributeId;
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
        if($this->attributeId) { //for edit form

            $attribute = AttributeTranslation::where('name', $value)->where('attribute_id', '!=', $this->attributeId)->first();

        }else {  // for create form

            $attribute = AttributeTranslation::where('name', $value)->first();
        }

        if($attribute) {
            return false;    //that is means the validation is failed
        }else {
            return true;     //that is means the validation is success
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('admin/product.name exists before');
    }
}
