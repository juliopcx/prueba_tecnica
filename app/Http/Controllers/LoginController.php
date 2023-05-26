<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthenticationService;
use Illuminate\Http\Request;

class LoginController extends Controller
{   
    private $authenticationService;
    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function login(LoginRequest $request)
    {           
        $credentials = $request->validated();
        if ($this->authenticationService->attemptLogin($credentials)) {
            return response()->json(['ok' => true]); 
        }
        
        return response()->json(['ok' => false, 'message' => 'credenciales invalidas']);   

    }

}
