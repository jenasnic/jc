<?php

namespace jc\FTPSlideshowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use jc\FTPSlideshowBundle\Entity\Slideshow;
use jc\FTPSlideshowBundle\Form\SlideshowType;
use jc\FTPSlideshowBundle\Entity\Picture;
use jc\FTPSlideshowBundle\Form\PictureType;

class FTPSlideshowBOController extends Controller {

    public function indexAction() {

        $request = $this->getRequest();

        try {

            // Get all existing directories for costa rica pictures
            $rootPath = $this->container->getParameter('jc_ftp_slideshow.root_path');
            $basePath = $this->container->getParameter('kernel.root_dir') . '/../web' . $rootPath;
            $finder = Finder::create();
            $folderList = $finder->in($basePath)->depth(0)->directories();
        }
        catch ( Exception $e ) {
            $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de l\'exploration du dossier racine');
        }

        return $this->render('jcFTPSlideshowBundle:BO:slideshowList.html.twig', array(
                'folderList' => $folderList
        ));
    }

    public function processFolderAction($name) {

        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getManager();

        // Get all pictures matching current folder
        try {

            // Get all existing files in folder
            $rootPath = $this->container->getParameter('jc_ftp_slideshow.root_path');
            $basePath = $this->container->getParameter('kernel.root_dir') . '/../web' . $rootPath . '/' . $name;
            $finder = Finder::create();
            $fileList = $finder->in($basePath)->depth(0)->files();
        }
        catch ( Exception $e ) {
            $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de l\'exploration du dossier courant');
        }

        // Get slideshow matching current folder
        $slideshow = $entityManager->getRepository('jcFTPSlideshowBundle:Slideshow')->findOneBy(array('name' => $name));

        // If slideshow not yet processed => create it
        if ($slideshow == null) {

            $slideshow = new Slideshow();
            $slideshow->setName($name);
            $slideshow->setTitle($name);
            $entityManager->persist($slideshow);
            $entityManager->flush();
        }

        // If user has submit form => save slideshow
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(new SlideshowType(), $slideshow);
                $form->bind($request);

                if ($form->isValid()) {

                    $entityManager->persist($slideshow);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde du diaporama OK');

                    return $this->redirect($this->generateUrl('jc_ftp_slideshow_bo_index'));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch ( Exception $e ) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde de la course');
            }
        }
        else
            $form = $this->createForm(new SlideshowType(), $slideshow);

        return $this->render('jcFTPSlideshowBundle:BO:slideshowEdit.html.twig', array(
                'slideshowToEdit' => $form->createView(),
                'fileList' => $fileList
        ));
    }

    public function processPictureAction($folderName, $name) {

        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getManager();

        // Get picture matching current file
        $picture = $entityManager->getRepository('jcFTPSlideshowBundle:Picture')->findOneBy(array('name' => $name));

        // If picture not yet processed => create it
        if ($picture == null) {

            $picture = new Picture();
            $picture->setName($name);
            $picture->setTitle($name);
            $picture->setFolderName($folderName);
            $entityManager->persist($picture);
            $entityManager->flush();
        }

        // If user has submit form => save picture
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(new PictureType(), $picture);
                $form->bind($request);

                if ($form->isValid()) {

//                     $entityManager->persist($picture);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde de l\'image OK');

                    return $this->redirect($this->generateUrl('jc_ftp_slideshow_bo_slideshow', array('name' => $picture->getFolderName())));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch ( Exception $e ) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde de la course');
            }
        }
        else
            $form = $this->createForm(new PictureType(), $picture);

        return $this->render('jcFTPSlideshowBundle:BO:pictureEdit.html.twig', array('pictureToEdit' => $form->createView()));
    }
}
