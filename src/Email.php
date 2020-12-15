<?php

namespace fffaraz\Utils;

class Email
{
    // TODO: https://github.com/egulias/EmailValidator
    public static function isValid($email): bool
    {
        if (empty($email)) return false;
        if ($email !== strtolower($email)) return false;
        if ($email !== filter_var($email, FILTER_SANITIZE_STRING)) return false;
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) return false;
        // TODO: also check common spelling errors: gmal, gmai, yaho, htmail
        return true;
    }
}
