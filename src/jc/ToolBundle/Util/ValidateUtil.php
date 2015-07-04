<?php

namespace jc\ToolBundle\Util;

class ValidateUtil
{
    private static $MAIL_REGEX = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,4}$/';
    private static $PHONE_REGEX = '/^(\\+)?[0-9. ]*$/';
    private static $URL_REGEX = '/^[a-z0-9.+_-]+$/';

    /**
     * Allows to check validity mail.
     * @param String $mail Mail we want to check validity.
     * @return boolean TRUE if mail is valid, FALSE either.
     */
    public static function checkMail($mail) {

        if (empty($mail))
            return false;

        return preg_match(self::$MAIL_REGEX, $mail);
    }

    /**
     * Allows to check validity phone number.
     * @param String $phone Phone we want to check validity.
     * @return boolean TRUE if phone is valid, FALSE either.
     */
    public static function checkPhoneNumber($phone) {

        if (empty($phone))
            return false;

        return preg_match(self::$PHONE_REGEX, $phone);
    }

    /**
     * Allows to check if text is conform to URL restriction (no accent, not special character...).<br/>
     * Allowed characters are : letter (in lower case only), number, characters '.', '-', '+' and '_'. 
     * @param String $text String we want to check characters for URL use.
     * @return boolean TRUE if string can be used in URL, FALSE either.
     */
    public static function checkForUrlRestriction($text) {

        if (empty($text))
            return false;

        return preg_match(self::$URL_REGEX, $text);
    }

    /**
     * Allows to check if password is secure. It must contain at least 6 characters + characters depending on security level.
     * @param String $password Password we want to check if matches password security.
     * @param int $level 1 for low security (only lower / upper case or letter / numeric), 2 for medium security (lower / upper case + numeric) and 3 for high security
     * (lower / upper case + numeric + special character.
     * @return boolean TRUE if password is valid, FALSE either.
     */
    public static function checkPassword($password, $level) {

        if (empty($password) || strlen($password) < 6)
            return false;

        $isSecure = (preg_match('/.*[a-z].*/', $password) && preg_match('/.*[A-Z].*/', $password))
                || (preg_match('/.*[a-zA-Z].*/', $password) && preg_match('/.*[0-9].*/', $password));

        if ($level == 2)
            $isSecure = $isSecure && preg_match('/.*([0-9]|[^a-zA-Z]).*/', $password);
        else if ($level >= 3)
            $isSecure = $isSecure && preg_match('/.*([-_+=*$%&?!]).*/', $password);

        return $isSecure;
    }
}
