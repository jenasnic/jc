<?php

namespace jc\FTPSlideshowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use jc\FTPSlideshowBundle\Entity\Slideshow;
use jc\FTPSlideshowBundle\Entity\Picture;

class FTPSlideshowFOController extends Controller {

    public function indexAction() {

        try {

            // Get all existing directories used to build slideshow
            $rootPath = $this->container->getParameter('jc_ftp_slideshow.root_path');
            $basePath = $this->container->getParameter('kernel.root_dir') . '/../web' . $rootPath;
            $finder = Finder::create();
            $folderList = $finder->in($basePath)->depth(0)->directories();
        }
        catch ( Exception $e ) {

            $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de l\'exploration du dossier courant');
            return $this->render('jcFTPSlideshowBundle:FO:index.html.twig');
        }

        $entityManager = $this->getDoctrine()->getManager();

        $slideshowList = array();

        // Browse each folder found (i.e. slideshow) and add them to slideshow list
        foreach ($folderList as $folder) {

            // Search matching slideshow defined in back office (for name, description...)
            $name = $folder->getFilename();
            $slideshow = $entityManager->getRepository('jcFTPSlideshowBundle:Slideshow')->findOneBy(array('name' => $name));

            // If no slideshow found in BO => use default folder name for title
            if ($slideshow == null) {

                $slideshow = new Slideshow();
                $slideshow->setName($name);
                $slideshow->setTitle($name);
            }

            $slideshowList[] = $slideshow;
        }

        return $this->render('jcFTPSlideshowBundle:FO:index.html.twig', array('slideshowList' => $slideshowList));
    }

    public function displayAction($folder) {

        $entityManager = $this->getDoctrine()->getManager();

        try {

            $slideshow = $entityManager->getRepository('jcFTPSlideshowBundle:Slideshow')->findOneBy(array('name' => $folder));

            if ($slideshow == null) {

                $slideshow = new Slideshow();
                $slideshow->setName($folder);
                $slideshow->setTitle($folder);
            }

            // Get all existing directories for costa rica pictures
            $rootPath = $this->container->getParameter('jc_ftp_slideshow.root_path');
            $basePath = $this->container->getParameter('kernel.root_dir') . '/../web' . $rootPath . '/' . $folder;
            $finder = Finder::create();
            $fileList = $finder->in($basePath)->depth(0)->files();

            $pictureList = array();
            foreach ($fileList as $file) {

                $name = $file->getFilename();
                $picture = $entityManager->getRepository('jcFTPSlideshowBundle:Picture')->findOneBy(array('name' => $name));
                if ($picture == null) {

                    $picture = new Picture();
                    $picture->setName($name);
                    $picture->setTitle($name);
                }

                $pictureList[] = $picture;
            }

            return $this->render('jcFTPSlideshowBundle:FO:slideshow.html.twig', array(
                    'slideshow' => $slideshow,
                    'pictureList' => $pictureList
            ));
        }
        catch ( Exception $e ) {
            $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de l\'exploration du dossier courant');
        }
    }
}
