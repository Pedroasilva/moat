<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use App\UserLog;
use App\Establishment;

class UsersController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::orderBy('user_id', 'DESC');
        $data = [
            'items' => $users->paginate(20)
        ];
        return view('admin.users.index', $data);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $data = [
            'user' => $user
        ];
        return view('admin.users.view', $data);
    }

    public function block($id)
    {
        $auth = Auth::user();
        $user = User::findOrFail($id);
        $user->update([ 'status' => 0 ]);
        UserLog::create([
            'user' => $auth->user_id,
            'establishment' => $user->establishment,
            'log' => "Bloqueou o usuário ID $id - $user->name"
        ]);
        return redirect(route('admin.users.view', ['userId' => $id]));
    }

    public function unblock($id)
    {
        $auth = Auth::user();
        $user = User::findOrFail($id);
        $user->update([ 'status' => 1 ]);
        UserLog::create([
            'user' => $auth->user_id,
            'establishment' => $user->establishment,
            'log' => "Desbloqueou o usuário ID $id - $user->name"
        ]);
        return redirect(route('admin.users.view', ['userId' => $id]));
    }
}
