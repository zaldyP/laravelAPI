<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Contracts\IUser;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;


//use App\Providers\RouteServiceProvider;
//use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    protected $users;
    public function __construct(IUser $users)
    {
        //$this->middleware('auth');
        //$this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
        $this->users = $users;
    }

    public function verify(Request $request, User $user)
    {
        //check if the url is valid signed url
        if(! URL::hasValidSignature($request)){
            return response()->json(['errors' => [
                'message' => "Invalid verification link or signature",
            ]],422);
        }

        // check if the user has already verified account
        if($user->hasVerifiedEmail()){
            return response()->json(["errors" => [
                "message" => "Email address already verify",
            ]],422);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return response()->json(['message', 'Email successfully verified'],200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function resend(Request $request)
    {
        $this->validate($request, [
           'email' => ['email', 'required']
        ]);


        $user = $this->users->findWhereFirst('email', $request->email);
        //$user = User::where('email', $request->email)->first();
        if( !$user){
            return response()->json(["errors" => [
               "message" => "No user could be found with this user email",
            ] ],422);
        }

        // check if the user has already verified account
        if($user->hasVerifiedEmail()){
            return response()->json(["errors" => [
                "message" => "Email address already verify",
            ]],422);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(["status" => "Verification link resent" ]);
    }

}
