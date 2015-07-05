<?php

namespace jc\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use jc\TestBundle\Model\SimpleForm;
use jc\TestBundle\Model\ComplexForm;
use jc\TestBundle\Model\ComplexListForm;
use jc\TestBundle\Form\SimpleFormType;
use jc\TestBundle\Form\ComplexFormType;
use jc\TestBundle\Form\ComplexListFormType;

class TestFormController extends Controller {

    public function simpleTestAction() {

        $request = $this->getRequest();

        if ($request->isMethod('POST')) {

            $form = $this->createForm(new SimpleFormType(), new SimpleForm(null, null, null));
            $form->handleRequest($request);

            return $this->render('jcTestBundle::simpleForm.html.twig', array(
                    'myForm' => $form->createView(),
                    'message' => 'Formulaire validé...'
            ));
        }
        else {

            $form = $this->createForm(new SimpleFormType(), new SimpleForm('A', 'alpha', 1));

            return $this->render('jcTestBundle::simpleForm.html.twig', array(
                    'myForm' => $form->createView(),
                    'message' => 'Formulaire en cours...'
            ));
        }
    }

    public function complexTestAction() {

        $request = $this->getRequest();

        if ($request->isMethod('POST')) {

            $form = $this->createForm(new ComplexFormType(), new ComplexForm(null, null));
            $form->handleRequest($request);

            return $this->render('jcTestBundle::complexForm.html.twig', array(
                    'myForm' => $form->createView(),
                    'message' => 'Formulaire validé...'
            ));
        }
        else {

            $simpleForm = new SimpleForm('A', 'alpha', 1);
            $form = $this->createForm(new ComplexFormType(), new ComplexForm('Complex-A', $simpleForm));

            return $this->render('jcTestBundle::complexForm.html.twig', array(
                    'myForm' => $form->createView(),
                    'message' => 'Formulaire en cours...'
            ));
        }
    }

    public function complexListTestAction() {

        $request = $this->getRequest();

        if ($request->isMethod('POST')) {

            $form = $this->createForm(new ComplexListFormType(), new ComplexListForm(null, array()));
            $form->handleRequest($request);
            var_dump($form->getData());

            return $this->render('jcTestBundle::complexListForm.html.twig', array(
                    'myForm' => $form->createView(),
                    'message' => 'Formulaire validé...'
            ));
        }
        else {

            $simpleForm1 = new SimpleForm('A', 'alpha', 1);
            $simpleForm2 = new SimpleForm('B', 'bravo', 2);
            $simpleForm3 = new SimpleForm('C', 'charlie', 3);

            $elementList = array($simpleForm1, $simpleForm2, $simpleForm3);

            $form = $this->createForm(new ComplexListFormType(), new ComplexListForm('Complex-A', $elementList));

            return $this->render('jcTestBundle::complexListForm.html.twig', array(
                    'myForm' => $form->createView(),
                    'message' => 'Formulaire en cours...'
            ));
        }
    }
}
