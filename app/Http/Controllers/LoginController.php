<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Controllers\LoginController as NovaLoginController;

class LoginController extends NovaLoginController
{
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return with($request->only($this->username(), 'password'), function ($input) {
            $input['u_emailadres'] = $input[$this->username()];
            unset($input[$this->username()]);

            return $input;
        });
    }
}
