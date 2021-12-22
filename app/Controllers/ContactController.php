<?php

namespace App\Controllers;

use App\Utils\Mailer;
use App\Validation\Validator;

class ContactController extends Controller
{
    public function contactPost()
    {
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'firstname' => ['required', 'min:2', 'max:70'],
            'lastname' => ['required', 'min:2', 'max:70'],
            'email' => ['required', 'email'],
            'message' => ['required', 'min:100']
        ]);

        $cleanedData = $validator->getData();
        $cleanedData['fullname'] = $cleanedData['firstname'] . ' ' . $cleanedData['lastname'];

        if (!empty($errors)) {
            $validator->flashErrors($errors, '/');
        } else {
            $mail = (new Mailer)->sendMail($cleanedData);
            return header('Location: /?success=true');
        }
    }
}
