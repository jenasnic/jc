<?php

namespace jc\ToolBundle\Util;

class TextUtil {

    /**
     * Allows to remove all HTML from specified text (tags with its attributes...).
     * @param text Text we want to remove HTML code.
     * @return Specified text without HTML tags, i.e. without HTML structure.
     */
    public static function removeAllHTMLTag($text) {

        // Remove all HTML tag => text between < and >
        if (!empty($text))
            return preg_replace('/(<[^>]*>)/', '', $text);

        return null;
    }

    /**
     * Allows to truncate specified text with specified length.<br/>
     * NOTE : We do not truncate in the middle of a word but before => final size might be smaller than specified size.<br/>
     * WARNING : If text contains HTML code, text might be truncated on HTHML => causes errors.<br/>
     * In this case, it is highly recommended to remove HTML tags before.
     * @param text Text we want to truncate.
     * @param size Max length of new truncated text (if more than current text size => no truncation).
     * @return Truncated text with specified length.
     */
    public static function truncateText($text, $size) {

        if (!empty($text) && $size > 0 && strlen($text) > $size) {

            // Truncate on 'space' (to not cut word)
            $maxSize = stripos($text, ' ', $size);

            if ($maxSize == -1)
                return substr($text, 0, $size);

            return substr($text, 0, $maxSize);
        }
        else
            return $text;
    }

    /**
     * Sanitize a string by replacing all accent characters by the same characters without accent and by replacing special characters by "-"
     * @param stringToSanitize
     * @return a "clean" string sanitize from any accent or special characters
     */
    public static function sanitize($stringToSanitize) {

        // Process accent "àáâãäåæçèéêëìíîïðñòóôõö÷øùúûüýþÿ"
        $noAccentArray = str_split("aaaaaa-ceeeeiiiionooooo--uuuuy-y");

        $stringArray = str_split(strtolower($stringToSanitize));
        $result = '';
        $noAppend = false;

        foreach ($stringArray as $c) {

            $asciiChar = ord($c);

            // Add normal character (97-122 => a-z) and number (48-57 => 0-9)
            if (($asciiChar >= 97 && $asciiChar <= 122) || ($asciiChar >= 48 && $asciiChar <= 57)) {
                $result .= $c;
                $noAppend = false;
            }
            // Replace accent with normal character (224-255 => accent)
            // NOTE : Using UNICODE and not ASCII
            else if ($asciiChar >= 224 && $asciiChar <= 255) {

                $result .= $noAccentArray[$asciiChar - 224];
                $noAppend = false;
            }
            // Replace other character with '-' (only if last character is not '-')
            else if (!$noAppend){
                $result .= '-';
                $noAppend = true;
            }
        }

        // If last character is '-', remove it
        /*if (substr($result, -1) == '-')
            return substr($result, -1);*/

        return $result;
    }
}
