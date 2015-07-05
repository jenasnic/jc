<?php

namespace jc\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComplexListFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('required' => false))
            ->add('elementList', 'collection', array('type' => new SimpleFormType(), 'allow_add' => true))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'jc\TestBundle\Model\ComplexListForm'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'testbundle_complexlistform';
    }
}
