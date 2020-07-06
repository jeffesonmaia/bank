<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Account;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $account = Account::where('number', $request->account)->first();
            if (!$account) {
                throw new \Exception('Error in Login');
            }

            if ($account->status == Account::STATUS_INACTIVE) {
                throw new Exception('Conta inativa');
            }

            if (!Hash::check($request->password, $account->password, [])) {
                throw new \Exception('Error in Login');
            }

            $tokenResult = $account->createToken('authToken')->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Login',
                'error' => $error,
            ]);
        }
    }

    public function username()
    {
        return 'account';
    }
}
