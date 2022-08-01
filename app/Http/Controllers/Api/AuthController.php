<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\UserRole;
use App\UserLog;
use App\PasswordRequest;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendgridEmail;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;
    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }
    /**
     * Create a new token.
     *
     * @param  \App\User   $user
     * @return string
     */
    protected function jwt(User $user, $remember = false) {
        $rememberToken = $this->jwtSecret();
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->user_id, // Subject of the token
            'iat' => Carbon::now()->timestamp, // Time when JWT was issued.
            'exp' => ($remember) ? Carbon::now()->addWeeks(4)->timestamp : Carbon::now()->addDays(1)->timestamp, // 1 dia ou 1 mês
            'rmb' => $rememberToken
        ];

        // Salva o RMB no Banco do Usuário
        $user->update(array( 'remember_token' => $rememberToken ));

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }
    /**
     * Returna a Random String
     *
     * @return string
     */
    protected function jwtSecret() {
        function generateRandomString($length = 14) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
        return generateRandomString();
    }
    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function login(User $user) {
        $validator = Validator::make($this->request->all(), [
            'email'         => 'required|email',
            'password'      => 'required',
            'remember_me'   => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        // Find the user by email
        $user = User::where('email', $this->request->input('email'))->first();
        if (!$user) {
            // You wil probably have some sort of helpers or whatever
            // to make sure that you have the same response format for
            // differents kind of responses. But let's return the
            // below respose for now.
            return response()->json([
                'message' => 'Usuário não encontrado.'
            ], 400);
        }

        // Verify the status of user
        if (!$user->status) {
            return response()->json([
                'message' => 'Acesso não autorizado.'
            ], 401);
        }

        // Verify the password and generate the token
        if (Hash::check($this->request->input('password'), $user->password)) {
            $user->userRole;
            $user->companyData;

            UserLog::create([
                'user' => $user->user_id,
                'establishment' => $user->establishment,
                'log' => 'Login.'
            ]);

            return response()->json([
                'token' => $this->jwt($user, $this->request->input('remember_me')),
                'user' => $user
            ], 200);
        }

        // Bad Request response
        return response()->json([
            'message' => 'E-mail ou senha inválida.'
        ], 400);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function verifyPartnerEmail($email, Request $request)
    {
        $emailDecoded = base64_decode($email);
        $user = User::where('email', $emailDecoded)->first();
        if ($user->verified === 0) {
            $user->update(array( 'verified' => 1 ));
        }
        return view('auth.verified');
    }

    /**
     * Send Welcome Email to new Users
     *
     * @param object $user
     * @return void
     */
    public function sendWelcomeEmail($user)
    {
        $to = array(
            'name' => $user->name,
            'email' => $user->email
        );

        $data = array(
            'name' => $user->name,
            'email' => $user->email
        );

        $subject = "Bem vindo ao ".env("APP_NAME");

        $email = new SendgridEmail('signup-welcome', $to, $subject, $data);
        $email->send();
    }

    /**
     * Send Verification Email to new Users
     *
     * @param object $user
     * @return void
     */
    public function sendVerificationEmail(Request $request)
    {
        $jwt = $request->bearerToken();
        $decoded = JWT::decode($jwt, env('JWT_SECRET'), array('HS256'));
        $user = User::find($decoded->sub);
        if (!$user->companyData) {
            return response()->json([
                'message' => 'Usuário não possui estabelecimento cadastrado.'
            ], 400);
        }

        if ($user->verified === 1) {
            return response()->json([
                'message' => 'Cadastro confirmado.'
            ], 200);
        }

        // Preparando dados para envio do e-mail
        $to = array(
            'name' => $user->name,
            'email' => $user->email
        );

        $data = array(
            'name' => $user->name,
            'email' => $user->email
        );

        $subject = env("APP_NAME")." - Ativação de conta";

        $email = new SendgridEmail('user-verification', $to, $subject, $data);

        if ($email->send()) {
            return response()->json([
                'message' => "E-mail enviado para o destinarário."
            ], 201);

        } else {
            return response()->json([
                'message' => 'Não foi possível enviar o e-mail'
            ], 400);
        }
    }

    /**
     * Criar um token de senha p/ o usuário
     *
     * @return \App\PasswordRequest
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($this->request->all(), [
            'email'         => 'required|email'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $email = $request->input('email');

        // Find the user by email
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado.'
            ], 400);
        }

        // Verify the status of user
        if ($user->status === 0) {
            return response()->json([
                'message' => 'Usuário bloqueado.'
            ], 401);
        }

        // Preate creation body
        $expire = date("Y-m-d H:i:s", strtotime('+5 hours'));
        $body = [
            'user' => $user->user_id,
            'authenticity_token' => md5(uniqid($email, true)),
            'expire' => $expire
        ];
        $req = PasswordRequest::createOrUpdate($body);
        $req->user_data;

        // Send Email
        $emailPayload = [
            'name' => $req->user_data->name,
            'email' => $req->user_data->email,
            'token' => $req->authenticity_token
        ];
        User::sendPasswordRequestEmail($emailPayload);

        return response()->json([
            'message' => 'Se o usuário existir, a recuperação foi enviada.'
        ], 200);
    }

    /**
     * Criar um token de senha p/ o usuário
     *
     * @return \App\PasswordRequest
     */
    public function sendResetPassword(Request $request)
    {
        $validator = Validator::make($this->request->all(), [
            'token'     => 'required|string',
            'password'  => ['required', 'min:8']
        ]);
        if ($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        // Campos
        $token = $request->input('token');
        $password = $request->input('password');
        $passwordRequest = PasswordRequest::getIfIsValid($token);
        if (!$passwordRequest)
        {
            return response()->json([
                'message' => 'Token inválido.'
            ], 400);
        }

        $user = User::find($passwordRequest->user);
        if (!$user)
        {
            return response()->json([
                'message' => 'Usuário inválido.'
            ], 400);
        }

        try {
            $user->update([
                'password' => Hash::make($password),
                'remember_token' => ''
            ]);
            $passwordRequest->update([
                'done' => 1
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Não foi possível alterar a senha.',
            ], 400);
        }

        return response()->json([
            'message' => 'A senha foi alterada com sucesso.'
        ], 200);
    }

    public function options() {}
}
