<?php

namespace jc\ToolBundle\Util;

use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class PasswordUtil
{
    private static $LOWER_CASE = 'abcdefghijklmnopqrstuvwxyz';
    private static $UPPER_CASE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private static $NUMERIC = '0123456789';
    private static $SPECIAL = '-_+=*$%&?!';

    /**
     * Encode a string using SHA. Useful to get password hash.
     * @param String $password string to encode.
     * @return String encoded string using SHA.
     */
    public static function encodePassword($password) {

        // Use SHA to encode password (without salt => null)
        $shaEncoder = new MessageDigestPasswordEncoder();
        return $shaEncoder->encodePassword($password, null);
    }

    /**
     * Allows to generate a random password.<br/>
     * NOTE : password size depends on specified parameter (minimum size is equal to number of parameter set to TRUE).
     * @param int $size Number of characters for password.
     * @param boolean $withLowerCase TRUE to include lower case character in password, FALSE either.
     * @param boolean $withUpperCase TRUE to include upper case character in password, FALSE either.
     * @param boolean $withNumeric TRUE to include numeric character in password (i.e. number), FALSE either.
     * @param boolean $withSpecial TRUE to include special character in password, FALSE either.
     * @return String A random password matching specified parameters.
     */
    public static function generatePassword($size, $withLowerCase, $withUpperCase, $withNumeric, $withSpecial) {

        $minSize = ($withLowerCase ? 1 : 0) + ($withUpperCase ? 1 : 0) + ($withNumeric ? 1 : 0) + ($withSpecial ? 1 : 0);
        if ($minSize == 0 || $size < $minSize)
            return null;

        $result = '';
        $selectableChar = self::buildSelectableCharBuilder($withLowerCase, $withUpperCase, $withNumeric, $withSpecial);

        for ($i = 0; $i < $size; $i++) {

            // If remaining size is less than minimum size => check if all required type of character are used or not
            // => we must add required character type before it is too late
            if ($size < $minSize + $i) {

                // Reset selectable characters list
                $selectableChar = '';

                // If lower case is required but not already added => add lower characters
                if ($withLowerCase && !self::hasCommonCharacter($result, self::$LOWER_CASE))
                    $selectableChar .= self::$LOWER_CASE;
                // If upper case is required but not already added => add upper characters
                if ($withUpperCase && !self::hasCommonCharacter($result, self::$UPPER_CASE))
                    $selectableChar .= self::$UPPER_CASE;
                // If numeric is required but not already added => add numeric characters
                if ($withNumeric && !self::hasCommonCharacter($result, self::$NUMERIC))
                    $selectableChar .= self::$NUMERIC;
                // If special character is required but not already added => add special characters
                if ($withSpecial && !self::hasCommonCharacter($result, self::$SPECIAL))
                    $selectableChar .= self::$SPECIAL;

                // If all required characters type has been added and if there are still characters to add => used all required character type
                if (strlen($selectableChar) == 0)
                    $selectableChar = self::buildSelectableCharBuilder($withLowerCase, $withUpperCase, $withNumeric, $withSpecial);
            }

            // Generate one char selection value
            $c = rand(0, strlen($selectableChar) - 1);
            $result .= $selectableChar{$c};
        }

        return $result;
    }

    /**
     * Allows to know if both specified string have common character or not.<br/>
     * NOTE : This method is case sensitive.
     * @param String $s1 First string.
     * @param String $s2 Second string.
     * @return boolean TRUE if specified String have common characters (one or many), FALSE either.
     */
    private static function hasCommonCharacter($s1, $s2) {

        if (empty($s1) || empty($s2))
            return false;

        // Browse all characters of s1 and search it in s2
        for ($i = 0; $i < strlen($s1); $i++)
            if (strpos($s2, $s1{$i}) !== false)
                return true;

        return false;
    }

    /**
     * Allows to build a StringBuilder containing all specified character types.
     * @param boolean $withLowerCase TRUE to include lower case character in password, FALSE either.
     * @param boolean $withUpperCase TRUE to include upper case character in password, FALSE either.
     * @param boolean $withNumeric TRUE to include numeric character in password (i.e. number), FALSE either.
     * @param boolean $withSpecial TRUE to include special character in password, FALSE either.
     * @return String A string containing all required character types.
     */
    private static function buildSelectableCharBuilder($withLowerCase, $withUpperCase, $withNumeric, $withSpecial) {

        // Add all required characters to build password
        $selectableChar = '';

        if ($withLowerCase)
            $selectableChar .= self::$LOWER_CASE;
        if ($withUpperCase)
            $selectableChar .= self::$UPPER_CASE;
        if ($withNumeric)
            $selectableChar .= self::$NUMERIC;
        if ($withSpecial)
            $selectableChar .= self::$SPECIAL;

        return $selectableChar;
    }
}
