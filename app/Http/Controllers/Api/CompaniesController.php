<?php

namespace App\Http\Controllers\Api;

use App\Establishment;
use App\UserLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompaniesController extends Controller
{

    public function showAll()
    {
        return response()->json(Establishment::all());
    }


    public function showOne($id)
    {
        return response()->json(Establishment::find($id));
    }


    public function create(Request $request)
    {
        $item = Establishment::create($request->all());

        return response()->json($item, 201);
    }


    public function update($id, Request $request)
    {
        $item = Establishment::findOrFail($id);
        $item->update($request->all());

        return response()->json($item, 200);
    }


    public function delete($id)
    {
        Establishment::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }


    public function enableClicktag(Request $request)
    {
        $user = $request->auth;

        if (!$user->manage_integrations) {
            return response()->json([
                'message' => 'Sem permissão para gerenciar integrações.'
            ], 400);
        }

        try {
            $user->companyData->update([
                'clicktag' => 1
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Não foi possível ativar a clicktag.'
            ], 400);
        }

        UserLog::create([
            'user' => $user->user_id,
            'establishment' => $user->establishment,
            'log' => 'Ativar clicktag.'
        ]);

        return response()->json([
            "message" => "Inserção de clicktag ativada."
        ], 201);
    }


    public function disableClicktag(Request $request)
    {
        $user = $request->auth;

        if (!$user->manage_integrations) {
            return response()->json([
                'message' => 'Sem permissão para gerenciar integrações.'
            ], 400);
        }

        try {
            $user->companyData->update([
                'clicktag' => 0
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Não foi possível desativar a clicktag.'
            ], 400);
        }

        UserLog::create([
            'user' => $user->user_id,
            'establishment' => $user->establishment,
            'log' => 'Desativar clicktag.'
        ]);

        return response()->json([
            "message" => "Inserção de clicktag desativada."
        ], 201);
    }
}