<?php

namespace jc\ToolBundle\Twig;

use jc\ToolBundle\Util\TextUtil;
class TruncateExtension extends \Twig_Extension {

    public function getName() {
        return 'truncate_twig_extension';
    }

    public function getFunctions() {
        return array('truncate' => new \Twig_Function_Method($this, 'truncateText'));
    }

    /**
     * Allows to truncate text removing all HTML tag (to avoid to truncate inside tag).
     * @param string $text Text we want to truncate.
     * @param int $size Text size we want.
     * @return string Truncated text.
     */
    public function truncateText($text, $size) {

        $newText = TextUtil::removeAllHTMLTag($text);
        return TextUtil::truncateText($newText, $size);
    }
}
