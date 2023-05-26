<?php
namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AuthenticationService
{
    private $xmlFilePath;
    public function __construct()
    {
        $this->xmlFilePath = storage_path('app/public/credentials.xml');
    }

    public function attemptLogin(array $credentials): bool
    {
        $users = $this->getUsersFromXml();

        foreach ($users as $user) {
            if ($user['nombre'] === $credentials['username'] && $user['contrasena'] === $credentials['password']) {             
                $this->logUserActivity($user['nombre'], 'Inicio de sesión');
                return true;
            }
        }

        return false;
    }

    private function getUsersFromXml(): array
    {
        $xmlString = File::get($this->xmlFilePath);
        $xml = simplexml_load_string($xmlString);
        $users = [];

        foreach ($xml->usuario as $usuario) {
            $user = [
                'nombre' => (string) $usuario->nombre,
                'contrasena' => (string) $usuario->contrasena,
                'correo' => (string) $usuario->correo
            ];
            $users[] = $user;
        }

        return $users;
    }

    private function logUserActivity(string $username, string $action): void
    {
        //siguiente paso
    }
}
