<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Purchase;
use DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        $user->syncRoles($request->input('roles'));

        return redirect()->route('users.index')->with('success', 'Usuario actualizado y roles asignados correctamente.');
    }
    public function clienteTop(){
        // Obtener los clientes top basados en el total gastado
        $topClients = User::select('users.id', 'users.name', 'users.email', DB::raw('SUM(purchases.amount) as total_spent'))
            ->join('purchases', 'users.id', '=', 'purchases.user_id')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('total_spent', 'desc')
            ->limit(10) // Cambia el límite según tus necesidades
            ->get();

        return view('users.top_client', compact('topClients'));
    }
}

