<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;

class FirebaseUserController extends Controller
{
    protected $auth;

public function __construct()
{
    $factory = (new Factory)
        ->withServiceAccount(base_path('storage/app/firebase/flory-service-account.json'));

    $this->auth = $factory->createAuth();
}

    public function index()
    {
        $users = [];
        foreach ($this->auth->listUsers() as $user) {
            $users[] = [
                'uid' => $user->uid,
                'email' => $user->email,
                'name' => $user->displayName,
                'verified' => $user->emailVerified ? 'Yes' : 'No',
            ];
        }

        return view('firebase.users.index', compact('users'));
    }
}
