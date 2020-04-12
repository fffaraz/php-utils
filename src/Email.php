<?php

namespace fffaraz\Utils;

class Email
{
    public static function isValid($email): bool
    {
        if (empty($email)) {
            return false;
        }

        $email = filter_var($email, FILTER_SANITIZE_STRING);

        return !(filter_var($email, FILTER_VALIDATE_EMAIL) === false);
    }
}
