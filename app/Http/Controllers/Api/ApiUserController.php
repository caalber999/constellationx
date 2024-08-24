<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiUserController extends Controller
{
    //
    public function fetchUsers()
    {
        $client = new Client();
        $response = $client->get('https://reqres.in/api/users');
        $users = json_decode($response->getBody(), true)['data'];

        foreach ($users as $userData) {
            $user = User::where('email', $userData['email'])->first();
            if($user == null){
                User::create([
                    'name' => $userData['first_name'] . ' ' . $userData['last_name'],
                    'email' => $userData['email'],
                    'password' => Hash::make('password123'), // Contraseña por defecto
                ]);
            }
        }

        return redirect()->back()->with('success', 'Usuarios creados exitosamente.');
    }
}
