<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function sendEmailWithResetLink(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'g-recaptcha-response' => 'required|recaptcha', // Validate reCAPTCHA
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // If validation is successful, send the password reset link
        $this->sendEmailWithResetLink($request); // Call the method from the trait

        // Redirect back with a success message
        return back()->with('status', __('A password reset link has been sent to your email address.'));
    }
}