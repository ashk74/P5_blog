<?php

namespace App\Validation;

class Validator
{
    private array $data;
    private array $errors;

    public function __construct(array $data)
    {
        $this->data = self::sanitize($data);
        $this->errors = [];
    }

    /**
     * Sanitize user data : strip slashes + strip tags + strip whitespace from the beginning and end
     *
     * @param array $data User data to be sanitize
     *
     * @return array Data sanitized
     */
    private static function sanitize(array $data): array
    {
        foreach ($data as $key => $value) {
            $data[$key] = stripslashes($data[$key]);
            $data[$key] = strip_tags($data[$key]);
            $data[$key] = trim($data[$key]);
        }
        return $data;
    }

    /**
     * Validates the data following the rules passed in parameter
     *
     * @param array $rules Rule to which the data must conform
     *
     * @return array|null Array of errors or nothing
     */
    public function validate(array $rules): ?array
    {
        foreach ($rules as $name => $rulesArray) {
            if (array_key_exists($name, $this->data)) {
                foreach ($rulesArray as $rule) {
                    switch ($rule) {
                        case 'required':
                            $this->required($name, $this->data[$name]);
                            break;
                        case 'email':
                            $this->validEmail($name, $this->data[$name]);
                            break;
                        case 'token':
                            $this->validTokens($name, $this->data[$name]);
                            break;
                        case substr($rule, 0, 3) === 'min':
                            $this->length($name, $this->data[$name], $rule);
                            break;
                        case substr($rule, 0, 3) === 'max':
                            $this->length($name, $this->data[$name], $rule);
                            break;
                        default: // Do nothing
                            break;
                    }
                }
            }
        }
        return $this->getErrors();
    }

    /**
     * Store errors messages in session
     *
     * @param array|null $errors Array containing errors or nothing
     * @param string $path Redirection path
     *
     * @return void
     */
    public function flashErrors(?array $errors, string $path): void
    {
        if ($errors) {
            $_SESSION['errors'][] = $errors;
            header("Location: {$path}");
            exit;
        }
    }

    private function required(string $name, string $value)
    {
        $value = trim($value);

        if (!isset($value) || is_null($value) || empty($value)) {
            $this->errors[$name][] = "Le champ : {$name} est requis";
        }
    }

    private function length(string $name, string $value, string $rule)
    {
        if (preg_match_all('/(\d+)/', $rule, $matches)) {
            $limit = (int) $matches[0][0];
        }

        if (substr($rule, 0, 3) === 'min') {
            if (strlen($value) < $limit) {
                $this->errors[$name][] = "Le champ : {$name} doit contenir minimum {$limit} caractères";
            }
        }

        if (substr($rule, 0, 3) === 'max') {
            if (strlen($value) > $limit) {
                $this->errors[$name][] = "Le champ : {$name} doit contenir maximum {$limit} caractères";
            }
        }
    }

    private function validEmail(string $name, string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$name][] = "Le champ : {$name} doit contenir une adresse email valide";
        }
    }

    private function validTokens(string $name, string $token)
    {
        if (!CSRF::checkTokens($token)) {
            $this->errors[$name][] = 'Les tokens doivent être initialisés et identiques';
        }
    }

    private function getErrors(): ?array
    {
        return $this->errors;
    }

    public function getSanitizedData()
    {
        return $this->data;
    }
}
