<?php

namespace jc\SudokuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SudokuCellFormType extends AbstractType {

    /**
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('status', 'hidden')->add('value', 'text', array(
                'label' => false,
                'required' => false
        ));
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {

        $resolver->setDefaults(array(
                'data_class' => 'jc\SudokuBundle\Model\Helper\SudokuCellForm'
        ));
    }

    /**
     *
     * @return string
     */
    public function getName() {

        return 'jc_sudokubundle_sudokucellform';
    }
}
