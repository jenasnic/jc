<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new jc\ContactBundle\jcContactBundle(),
            new jc\DoodleBundle\jcDoodleBundle(),
            new jc\FTPSlideshowBundle\jcFTPSlideshowBundle(),
            new jc\HomeBundle\jcHomeBundle(),
            new jc\MenuBundle\jcMenuBundle(),
            new jc\NewsBundle\jcNewsBundle(),
            new jc\SkinBundle\jcSkinBundle(),
            new jc\SkyrimBundle\jcSkyrimBundle(),
            new jc\SlideshowBundle\jcSlideshowBundle(),
            new jc\StaticTextBundle\jcStaticTextBundle(),
            new jc\SudokuBundle\jcSudokuBundle(),
            new jc\TestBundle\jcTestBundle(),
            new jc\ToolBundle\jcToolBundle(),
            new jc\TrainingSessionBundle\jcTrainingSessionBundle(),
            new jc\UserBundle\jcUserBundle(),
            new jc\UserFileBundle\jcUserFileBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
