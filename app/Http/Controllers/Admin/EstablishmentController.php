<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Establishment;
use App\User;
use App\UserLog;
use App\UserRole;
use App\Helpers\Helper;

class EstablishmentController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $establishments = Establishment::orderBy('establishment_id', 'DESC');
        $data = [
            'items' => $establishments->paginate(20)
        ];
        return view('admin.establishments.index', $data);
    }

    public function view($id)
    {
        $establishment = Establishment::findOrFail($id);
        $users = User::where('establishment', $id)->orderBy('user_id', 'DESC');
        $data = [
            'establishment' => $establishment,
            'users' => $users->paginate(8)
        ];
        return view('admin.establishments.view', $data);
    }

    public function edit($id)
    {
        $user = Establishment::findOrFail($id);
        $data = [
            'establishment' => $user
        ];
        return view('admin.establishments.edit', $data);
    }

    public function create(Request $request)
    {
        $auth = Auth::user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'user_name' => 'required|string',
            'user_email' => 'required|string',
            'user_password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $establishment = Establishment::create([
            'name'                      => $request->input('name'),
            'email'                     => $request->input('user_email'),
            'slug'                      => (new Helper())->slugify($request->input('name'))
        ]);

        $role = UserRole::where('name', 'player')->first();
        $user = User::create([
            'name'                  => $request->input('user_name'),
            'username'              => $request->input('user_email'),
            'email'                 => $request->input('user_email'),
            'password'              => Hash::make($request->input('user_password')),
            'role'                  => $role->role_id,
            'establishment'         => $establishment->establishment_id,
            'status'                => 1,
            'verified'              => 0
        ]);

        UserLog::create([
            'user'          => $auth->user_id,
            'establishment' => $establishment->establishment_id,
            'log'           => "Cadastrou uma empresa: $establishment->establishment_id - $establishment->name"
        ]);

        return redirect(route('admin.establishments'));
    }

    public function new()
    {
        return view('admin.establishments.new');
    }
}
