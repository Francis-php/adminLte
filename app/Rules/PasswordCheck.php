<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class PasswordCheck implements  ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    protected $formData;

    public function __construct($formData)
    {
        $this->formData= $formData;
    }


    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $value=strtolower($value);
        $email=strstr($this->formData['email'],'@',true);
        $fullNameEmail=strtolower($this->formData['first_name'])." ".strtolower($email). " ".strtolower($this->formData['last_name']);
        $userParts=explode(" ",$fullNameEmail);

        foreach ($userParts as $part){
            if(Str::contains($value,$part)){
                $fail('The password must not contain private information.');
            }
        }
    }

}
