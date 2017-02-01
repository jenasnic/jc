<?php

namespace jc\ToolBundle\Twig;

class PicturePropertiesExtension extends \Twig_Extension {

    private $rootDir;

    public function __construct($rootDir) {
        $this->rootDir = $rootDir;
    }

    public function getName() {
        return 'picture_properties_twig_extension';
    }

    public function getFunctions() {
        return array(
                new \Twig_SimpleFunction('pictureWidth', array($this, 'getPictureWidth')),
                new \Twig_SimpleFunction('pictureHeight', array($this, 'getPictureHeight')));
    }

    /**
     * @param string $pictureUrl
     * @return width for specified picture URL.
     */
    public function getPictureWidth($pictureUrl) {
        return getimagesize($this->rootDir . '/../web' . $pictureUrl)[0];
    }

    /**
     * @param string $pictureUrl
     * @return height for specified picture URL.
     */
    public function getPictureHeight($pictureUrl) {
        return getimagesize($this->rootDir . '/../web' . $pictureUrl)[1];
    }
}
