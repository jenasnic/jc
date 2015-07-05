<?php

namespace jc\TrainingSessionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use jc\TrainingSessionBundle\Entity\Location;
use jc\TrainingSessionBundle\Form\LocationType;

class LocationBOController extends Controller {

    public function listAction() {

        $locationList = $this->getDoctrine()->getManager()->getRepository('jcTrainingSessionBundle:Location')->findBy(array(), array('name' => 'asc'));
        return $this->render('jcTrainingSessionBundle:BO:locationList.html.twig', array('locationList' => $locationList));
    }

    public function editAction($id) {

        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getManager();

        if ($id > 0)
            $location = $entityManager->getRepository('jcTrainingSessionBundle:Location')->find($id);
        else {

            // Use default value for location (BA-110)
            $location = new Location();
            $location->setLatitude($this->container->getParameter('jc_training_session.location.default_latitude'));
            $location->setLongitude($this->container->getParameter('jc_training_session.location.default_longitude'));
            $location->setZoom($this->container->getParameter('jc_training_session.location.default_zoom'));
        }

        // If user has submit form => save location
        if ($request->getMethod() == 'POST') {

            try {

                $form = $this->createForm(new LocationType(), $location);
                $form->bind($request);

                if ($form->isValid()) {

                    $entityManager->persist($location);
                    $entityManager->flush();

                    $request->getSession()->getFlashBag()->add('bo-log-message', 'Sauvegarde de la localisation OK');

                    return $this->redirect($this->generateUrl('jc_training_session_bo_location_list'));
                }
                else
                    $request->getSession()->getFlashBag()->add('bo-warning-message', 'Certains champs ne sont pas remplis correctement');
            }
            catch (Exception $e) {
                $request->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la sauvegarde de la localisation');
            }
        }
        else
            $form = $this->createForm(new LocationType(), $location);

        return $this->render('jcTrainingSessionBundle:BO:locationEdit.html.twig', array('locationToEdit' => $form->createView()));
    }

    public function deleteAction($id) {

        if ($id > 0) {

            try {

                $entityManager = $this->getDoctrine()->getManager();
                $locationToDelete = $entityManager->getRepository('jcTrainingSessionBundle:Location')->find($id);

                // If location found => delete it
                if ($locationToDelete != null) {

                    $entityManager->remove($locationToDelete);
                    $entityManager->flush();

                    $this->getRequest()->getSession()->getFlashBag()->add('bo-log-message', 'Suppression de la localisation OK');
                }
            }
            catch (Exception $e) {
                $this->getRequest()->getSession()->getFlashBag()->add('bo-error-message', 'Erreur lors de la suppression de la localisation');
            }
        }

        // Return to locations list
        return $this->redirect($this->generateUrl('jc_training_session_bo_location_list'));
    }
}
