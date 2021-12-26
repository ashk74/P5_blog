<?php

namespace App\Controllers;

use App\Utils\Mailer;
use App\Validation\Validator;

class ContactController extends Controller
{
    private array $contactInfos;

    public function contactPost()
    {
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'firstname' => ['required', 'min:2', 'max:70'],
            'lastname' => ['required', 'min:2', 'max:70'],
            'email' => ['required', 'email'],
            'message' => ['required', 'min:100'],
            'token' => ['required', 'token']
        ]);

        if (!$errors) {
            $this->contactInfos = $validator->getData();

            $this->contactInfos['fullname'] = $this->contactInfos['firstname'] . ' ' . $this->contactInfos['lastname'];

            $mail = (new Mailer)->sendMail($this->contactInfos);
            return header('Location: /?success=true');
        } else {
            $validator->flashErrors($errors, '/');
        }
    }
}
