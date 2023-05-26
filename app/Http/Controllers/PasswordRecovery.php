<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordRecovery extends Controller
{
    public function reset(Request $request)
    {
        $email = $request->input('email');
        $user = $this->findUserByField('correo', $email);

        if ($user) {
            $token = $this->generateResetToken();
            $this->storeUserField($user, 'token', $token);
            //$this->sendResetEmail($user, $token);

            return response()->json(['ok' => true, 'message' => 'Correo electrónico de recuperación enviado']);
        }

        return response()->json(['ok' => false, 'error' => 'Correo electrónico no encontrado']);
    }

    private function findUserByField($fieldName, $fieldValue)
    {
        $xmlPath = storage_path('app/public/credentials.xml');

        if (!file_exists($xmlPath)) {
            return null;
        }

        $xml = simplexml_load_file($xmlPath);

        foreach ($xml->usuario as $usuario) {
            if ($usuario->$fieldName == $fieldValue) {
                return $usuario;
            }
        }

        return null;
    }

    private function generateResetToken()
    {
        return Str::random(60);
    }

    private function storeUserField($user, $fieldName, $fieldValue)
    {
        $xmlPath = storage_path('app/public/credentials.xml');

        if (!file_exists($xmlPath)) {
            return;
        }

        $xml = simplexml_load_file($xmlPath);

        foreach ($xml->usuario as $usuario) {
            if ($usuario->correo == $user->correo) {
                $usuario->$fieldName = $fieldValue;
                break;
            }
        }

        $xml->asXML($xmlPath);
    }

    private function sendResetEmail($user, $token)
    {
        $resetUrl = route('password.reset.verify', $token);
        Mail::send('emails.reset-password', ['resetUrl' => $resetUrl], function ($message) use ($user) {
            $message->to($user->correo->__toString(), $user->nombre->__toString())->subject('Recuperación de Contraseña')->from('tudireccion@dominio.com', 'Tu Nombre');
        });
    }

    public function verifyToken($token)
    {
        $user = $this->findUserByField('token', $token);

        if (!$user) {
            return response()->json(['ok' => false, 'error' => 'Token inválido']);
        }

        return response()->json(['ok' => true, 'message' => 'Token válido']);
    }
}
