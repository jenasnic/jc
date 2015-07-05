<?php

namespace jc\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SimpleFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', 'text', array('required' => false))
            ->add('label', 'text', array('required' => false))
            ->add('value', 'text', array('required' => false))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'jc\TestBundle\Model\SimpleForm'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'testbundle_simpleform';
    }
}
