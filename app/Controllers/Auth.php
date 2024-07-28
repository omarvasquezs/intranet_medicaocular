<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function login()
    {
        return view('login');
    }
    public function authenticate()
    {
        if ($this->request->getMethod() === 'POST') {
            // Handle user login here
            $data = $this->request->getPost();
            $user = $this->usuarios->where('usuario', $data['username'])->first();

            if (!$user) {
                return redirect()->back()->with('error', 'Usuario no existe.');
            } elseif ($user['estado'] != 1) {
                return redirect()->back()->with('error', 'Usuario bloqueado.');
            } elseif ($user['pass'] != $data['password']) {
                return redirect()->back()->with('error', 'Contraseña Incorrecta.');
            } else {
                // Fetch user roles
                $roles = $this->usuarios_roles->where('id_usuario', $user['id'])->findAll();
                $rolesArray = array_column($roles, 'id_rol');

                // Set user session or token and redirect to dashboard
                session()->set([
                    'user_id' => $user['id'],
                    'nombres' => $user['nombres'],
                    'usuario' => $user['usuario'],
                    'dni' => $user['dni'],
                    'birthday' => $user['birthday'],
                    'id_cargo' => $user['id_cargo'],
                    'id_area' => $user['id_area'],
                    'fecha_creacion' => $user['fecha_creacion'],
                    'fecha_actualizacion' => $user['fecha_actualizacion'],
                    'firma' => $user['firma'],
                    'roles' => $rolesArray
                ]);
                return redirect()->to('/');
            }
        }
    }
    public function logout()
    {
        // Destroy the session
        session()->destroy();

        // Redirect to the login page
        return redirect()->to('/login');
    }
}