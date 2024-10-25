<?php

namespace App\Services\notification;

use Illuminate\Http\Request;
use App\Jobs\Email;
use App\Models\{User};

trait Auth{
    use \App\Services\Notify;

    /**
     * Send password reset link to user.
     * 
     * @param User $user
     * @param string $token
     */
    public function resetPassword(User $user, string $token){
        $this->email(new Email([
			'emailClass' => 'DefaultMail',
			'to' => $user,
			'subject' => __('Reset Password'),
			'name' => $user->name,
			'contents' => view('email.auth.password')->withLink(route('password.reset', ['token' => $token, 'email' => $user->email]).'#reset')->render(),
		]));
    }

    /**
     * Send email verify link.
     * 
     * @param User $user
     * @param string $token
     */
    public function verifyEmail(User $user, string $link){
        $this->email(new Email([
			'emailClass' => 'DefaultMail',
			'to' => $user,
			'subject' => __('Verify email address'),
			'name' => $user->name,
			'contents' => view('email.auth.verify')->withLink($link)->render(),
		]));
    }
}