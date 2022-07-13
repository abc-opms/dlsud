<?php

namespace App\Actions\Fortify;

use App\Models\Signupkey;
use App\Models\User;
use App\Rules\validSkey;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'skey' => ['required', new validSkey],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'sig' => ['required', 'image', 'max:2048'],

            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $sgnkey = Signupkey::where('skey', $input['skey'])->first();

        $user = User::create([
            'dept_code' => $sgnkey->dept_code,
            'subdept_code' => $sgnkey->subdept_code,
            'school_id' => $sgnkey->school_id,
            'email' => $sgnkey->email,

            'signature_path' => $input['sig']->hashName(),
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'position' => 'Head',
            'password' => Hash::make($input['password']),
        ]);

        $input['sig']->store('public/esigs');

        $user->attachRole($sgnkey->role);

        Signupkey::where('skey', $input['skey'])->update(['status' => 'Active']);

        return $user;
    }
}
