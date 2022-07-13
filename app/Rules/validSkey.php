<?php

namespace App\Rules;

use App\Models\Signupkey;
use Exception;
use Illuminate\Contracts\Validation\Rule;

class validSkey implements Rule
{
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
        if (!empty($value)) {
            try {
                $sk = Signupkey::where('skey', $value)->first();
                if ($sk->skey == $value) {
                    if ($sk->status == 'Pending') {
                        return true;
                    }
                }
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid Signup key.';
    }
}
