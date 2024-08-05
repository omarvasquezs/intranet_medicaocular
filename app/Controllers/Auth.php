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
                // Check if the user needs to change their password
                if ($user['password_reset_required']) {
                    // Redirect to password change form
                    session()->set('user_id', $user['id']); // Temporarily set user ID for password change
                    return redirect()->to('/change-password')->with('message', 'Debe cambiar su contraseña.');
                }

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
    public function changePassword()
    {
        if ($this->request->getMethod() === 'POST') {
            $newPassword = $this->request->getPost('new_password');
            $confirmPassword = $this->request->getPost('confirm_password');

            // Check if the new password is at least 8 characters long
            if (strlen($newPassword) < 8) {
                return redirect()->back()->with('error', 'La contraseña debe tener al menos 8 caracteres.');
            }

            // Ensure the new password contains both letters and numbers
            if (!preg_match('/[A-Za-z]/', $newPassword) || !preg_match('/[0-9]/', $newPassword)) {
                return redirect()->back()->with('error', 'La contraseña debe contener tanto letras como números.');
            }

            // Compare both password fields
            if ($newPassword !== $confirmPassword) {
                return redirect()->back()->with('error', 'Las contraseñas no coinciden.');
            }

            $userId = session()->get('user_id');

            // Update the user's password and reset the password_reset_required flag
            $this->usuarios
                ->update($userId, (object) [
                    'pass' => $newPassword,
                    'password_reset_required' => 0,
                ]);

            // Fetch user information
            $user = $this->usuarios->where('id', $userId)->first();

            // Fetch user roles
            $roles = $this->usuarios_roles->where('id_usuario', $userId)->findAll();
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
        } elseif (!session()->get('user_id')) {
            return redirect()->to('/login')->with('error', 'No tienes acceso.');
        }

        // Display the password change form if the request method is not POST
        return view('change_password');
    }

    public function logout()
    {
        // Destroy the session
        session()->destroy();

        // Redirect to the login page
        return redirect()->to('/login');
    }
}