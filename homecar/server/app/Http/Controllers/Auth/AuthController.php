<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\MailService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $user;
    private $mail;
    public function __construct(User $user, MailService $mail)
    {
        $this->user = $user;
        $this->mail = $mail;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $params = $request->all();
            $params['password'] = bcrypt($params['password']);
            $params['role'] = UserRole::User;

            // gen token verify mail
            $verify_token = Str::random(40);
            $params['verify_mail_token'] = $verify_token;

            $user = $this->user->create($params);

            $verify_link = asset("api/auth/verify?token=$verify_token");

            $this->mail->sendMailRegister($user->email, $user->name, $verify_link);
            if ($user) {
                return response()->json($user);
            }
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function verify(Request $request)
    {
        $token = $request->token;

        if (!$token) {
            return response()->json([
                'message' => 'error',
            ], 403);
        }

        $user = $this->user->where('verify_mail_token', $token)->first();

        if (!$user) {
            return response()->json([
                'message' => 'error',
            ], 403);
        }

        $user->verify = true;
        $user->verify_mail_token = null;

        $user->save();

        return true;
    }

    public function login(LoginRequest $request)
    {
        try {
            $params = $request->only(['email', 'password']);
            if (!Auth::attempt($params)) {
                return response()->json([
                    'message' => 'unauthorized'
                ], 400);
            }
            $user = $request->user();

            if (!$user->verify) {
                return response()->json([
                    'message' => 'Tài khoản chưa được xác thực email'
                ], 400);
            }

            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;

            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);

            $token->save();
            return response()->json([
                'user' => $user,
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();

        return response()->json([
            'message' => 'logout successfully'
        ], 200);
    }
}
