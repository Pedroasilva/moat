<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\UserRole;
use App\Establishment;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendgridEmail;

class UserController extends Controller
{

    public function getRandomHex($num_bytes=4) {
        return bin2hex(openssl_random_pseudo_bytes($num_bytes));
    }

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
     * Edit user profile
     *
     * @return User
     */
    public function edit(Request $request)
    {
        $user = $request->auth;

        $user->update($request->all());
        $user->userRole;
        return response()->json([
            'data' => $user
        ], 201);
    }

    // /**
    //  * Add a company to a user account
    //  *
    //  * @return Establishment
    //  */
    // public function addCompany(Request $request)
    // {
    //     $jwt = $request->bearerToken();
    //     $decoded = JWT::decode($jwt, env('JWT_SECRET'), array('HS256'));
    //     $user = User::findOrFail($decoded->sub);

    //     if ($user->companyData) {
    //         return response()->json([
    //             'message' => 'Usuário já possui estabelecimento cadastrado.'
    //         ], 400);
    //     }

    //     $request->request->add([
    //         'slug' => $this->getRandomHex(10)
    //     ]);

    //     $establishment = Establishment::create($request->all());
    //     if ($establishment) {
    //         User::where('user_id', $decoded->sub)->update(array(
    //             'establishment' => $establishment->establishment_id
    //         ));
    //     }

    //     $data = array(
    //         "company" => $establishment
    //     );

    //     return response()->json($data, 201);
    // }

    /**
     * Return user info
     *
     * @return User
     */
    public function userInfo(Request $request)
    {
        $user = $request->auth;
        $user->userRole;
        return response()->json([
            'user' => $user
        ], 200);
    }

    /**
     * Return user company
     *
     * @return Establishment
     */
    public function myCompany(Request $request)
    {
        $user = $request->auth;
        $data = array(
            "company" => $user->companyData
        );
        return response()->json($data, 200);
    }

    /**
     * Edit a company to a user account
     *
     * @return Establishment
     */
    public function editCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"          => "string",
            "phonenumber"   => "string",
            "site_url"      => "string",
            "city"          => "string",
            "state"         => "string",
            "country"       => "string",
            "slug"          => "string"
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $jwt = $request->bearerToken();
        $decoded = JWT::decode($jwt, env('JWT_SECRET'), array('HS256'));
        $user = User::findOrFail($decoded->sub);

        if (!$user->manage_company) {
            return response()->json([
                'message' => 'Sem permissão para gerenciar company.'
            ], 400);
        }

        $data = [];
        if ($request->has('name')) { $data["name"] = $request->input('name'); }
        if ($request->has('phonenumber')) { $data["phonenumber"] = $request->input('phonenumber'); }
        if ($request->has('site_url')) { $data["site_url"] = $request->input('site_url'); }
        if ($request->has('city')) { $data["city"] = $request->input('city'); }
        if ($request->has('state')) { $data["state"] = $request->input('state'); }
        if ($request->has('country')) { $data["country"] = $request->input('country'); }
        if ($request->has('slug')) { $data["slug"] = $request->input('slug'); }
        
        $user->companyData->update($data);
        $data = array(
            "company" => $user->companyData
        );

        return response()->json($data, 200);
    }

    /**
     * Activate user when
     *
     * @param string $user
     * @return true
     */
    public function activate($user)
    {
        $userEmail = base64_decode($user);
        if (!$userEmail) {
            return response()->json([
                'message' => 'Usuário invalido.'
            ], 400);
        }

        $user = User::where('email', $userEmail)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado.'
            ], 400);
        }

        User::where('email', $userEmail)->update(array( 'status' => 1 ));

        return response()->json([
            'message' => "Usuário ativado com sucesso."
        ], 200);
    }

    /**
     * Block user by Admin
     *
     * @param user_id $user / Base64 Encoded
     * @return void
     */
    public function block($user)
    {
        $userId = base64_decode($user);
        if (!$userId) {
            return response()->json([
                'message' => 'Usuário invalido.'
            ], 400);
        }

        $user = User::findOrFail($userId);
        $user->update(array( 'status' => 0 ));

        return response()->json([
            'message' => "Usuário bloqueado com sucesso."
        ], 200);
    }

    /**
     * Add an user to my company
     *
     * @return Establishment
     */
    public function addCompanyUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                  => 'required',
            'email'                 => 'required|email',
            'password'              => 'required',
            'manage_users'          => 'required|boolean',
            'manage_campaigns'      => 'required|boolean',
            'manage_templates'      => 'required|boolean',
            'manage_assets'         => 'required|boolean',
            'manage_engine'         => 'required|boolean',
            'manage_integrations'   => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = $request->auth;

        if (!$user->companyData) {
            return response()->json([
                'message' => 'Usuário não possui estabelecimento cadastrado.'
            ], 400);
        }

        if (!$user->manage_users) {
            return response()->json([
                'message' => 'Sem permissão para gerenciar usuários.'
            ], 400);
        }

        if (User::where('email', $request->input('email'))->exists()) {
            return response()->json([
                'message' => 'Já existe um usuário com este e-mail.'
            ], 400);
        }

        $role = UserRole::where('name', 'player')->first();
        $request->request->add([
            'username' => $request->input('email'),
            'establishment' => $user->establishment,
            'status' => 1,
            'verified' => 0,
            'role' => $role->role_id
        ]);

        // Transforma o password em hash
        $request->merge([
            'password' => Hash::make($request->input('password'))
        ]);

        $newUser = User::create($request->all());
        $data = array(
            "user" => $newUser
        );
        return response()->json($data, 201);
    }

    /**
     * Remove an user of my company
     *
     * @return User
     */
    public function removeCompanyUser($id, Request $request)
    {
        $user = $request->auth;

        if (!$user->companyData) {
            return response()->json([
                'message' => 'Usuário não possui estabelecimento cadastrado.'
            ], 400);
        }

        if (!$user->manage_users) {
            return response()->json([
                'message' => 'Sem permissão para gerenciar usuários.'
            ], 400);
        }
        
        $theUser = User::where([
            'user_id' => $id,
            'establishment' => $user->establishment
        ]);
        
        if (sizeof($theUser->get()) == 0) {
            return response()->json([
                'message' => 'Usuário não encontrado.'
            ], 400);
        }
        $theUser->delete();
        $data = array(
            "message" => "Usuário removido"
        );
        return response()->json($data, 200);
    }

    /**
     * Remove an user of my company
     *
     * @return User
     */
    public function editCompanyUser($id, Request $request)
    {
        $user = $request->auth;

        if (!$user->companyData) {
            return response()->json([
                'message' => 'Usuário não possui estabelecimento cadastrado.'
            ], 400);
        }

        if (!$user->manage_users) {
            return response()->json([
                'message' => 'Sem permissão para gerenciar usuários.'
            ], 400);
        }
        
        $theUser = User::where([
            'user_id' => $id,
            'establishment' => $user->establishment
        ]);
        
        if (sizeof($theUser->get()) == 0) {
            return response()->json([
                'message' => 'Usuário não encontrado.'
            ], 400);
        }

        // Transforma o password em hash
        if ($request->has('password')) {
            $request->merge([
                'password' => Hash::make($request->input('password'))
            ]);
        }

        $theUser->update($request->all());
        $data = array(
            "message" => "Usuário atualizado",
            "user" => $theUser->first()
        );
        return response()->json($data, 200);
    }

    /**
     * Return users of my company
     *
     * @return User
     */
    public function companyUsers(Request $request)
    {
        $user = $request->auth;

        if (!$user->manage_users) {
            return response()->json([
                'message' => 'Sem permissão para gerenciar usuários.'
            ], 400);
        }
        
        return response()->json([
            'users' => $user->companyData->users
        ], 200);
    }

    /**
     * Create a new user request
     *
     * @param  array  $data
     */
    protected function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'company' => 'required|string',
            'telephone' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'lgpd' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $lgpd = $request->input('lgpd');
        if ($lgpd == 0) {
            return response()->json([
                "message" => "Você deve aceitar os termos de lgpd"
            ], 400);
        }

        try {
            Establishment::sendNewSignupEmail($request->all());
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Ocorreu um erro com a sua solicitação"
            ], 400);
        }

        return response()->json([
            "message" => "Solicitação de cadastro enviada com sucesso"
        ], 200);
    }

    public function options() {}
}
