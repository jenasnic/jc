<?php

namespace jc\SudokuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SudokuFormType extends AbstractType {

    /**
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('blockSize', 'hidden')->add('lineList', 'collection', array(
                'type' => new SudokuLineFormType(),
                'allow_add' => true
        ));
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {

        $resolver->setDefaults(array(
                'data_class' => 'jc\SudokuBundle\Model\Helper\SudokuForm'
        ));
    }

    /**
     *
     * @return string
     */
    public function getName() {

        return 'jc_sudokubundle_sudokuform';
    }
}
