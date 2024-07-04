<?php

namespace Imrancse94\Grocery\libs;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Imrancse94\Grocery\app\Models\GroceryUser;

class JwtGuard implements Guard
{

    private $request;
    protected $user;
    protected $access_token = "";
    protected $refresh_token = "";

    /**
     * Create a new class instance.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function attempt(array $credentials = [], $remember = false)
    {
        return $this->validate($credentials);
    }
    public function check()
    {
        return !is_null($this->user());
    }

    public function guest()
    {
        // TODO: Implement guest() method.
    }

    public function user()
    {
        if (!empty($this->user)) {
            return $this->user;
        }

        return JwtHelper::decodeToken($this->getTokenForRequest())->user ?? null;
    }

    public function id()
    {
        $user = $this->user();

        if ($user) {
            return $user->id ?? $this->user()->getAuthIdentifier();
        }

        return null;
    }

    public function validate(array $credentials = [])
    {
        if (empty($credentials['email']) || empty($credentials['password'])) {
            return false;
        }

        $user =  GroceryUser::where('email', $credentials['email'])->first();

        if (!empty($user) && Hash::check($credentials['password'], $user->password)) {
            return $this->regenerateAuth($user);
        }

        return false;
    }

    public function regenerateAuth($user)
    {
        if(empty($user)) return null;
        $user = $user->toArray();
        $this->setUser($user);
        return [
            'access_token'=>$this->access_token,
            'expires_in'=>JwtHelper::$expirationTime, // in seconds
            'refresh_token'=>$this->refresh_token,
            'user'=>$this->user,
        ];
    }


    public function hasUser()
    {
        // TODO: Implement hasUser() method.
    }

    public function setUser($user)
    {
        $this->user = $user;
        $this->access_token = JwtHelper::generateAccessToken(['token_type'=>'access_token','user'=>$user]);
        $this->refresh_token = JwtHelper::generateRefreshToken(['token_type'=>'refresh_token','user'=>$user]);
        return $this;
    }

    protected function getTokenForRequest()
    {
        return $this->request->bearerToken();
    }

    public function logout()
    {
        session()->invalidate();
    }

}
