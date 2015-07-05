<?php

namespace jc\SudokuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SudokuLineFormType extends AbstractType {

    /**
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('cellList', 'collection', array(
                'type' => new SudokuCellFormType(),
                'allow_add' => true
        ));
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {

        $resolver->setDefaults(array(
                'data_class' => 'jc\SudokuBundle\Model\Helper\SudokuLineForm'
        ));
    }

    /**
     *
     * @return string
     */
    public function getName() {

        return 'jc_sudokubundle_sudokulineform';
    }
}
