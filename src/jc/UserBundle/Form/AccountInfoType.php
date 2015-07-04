<?php

namespace jc\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AccountInfoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text', array('required' => false))
            ->add('lastname', 'text', array('required' => false))
            ->add('mail', 'text', array('required' => false))
            ->add('password', 'password', array('required' => false))
            ->add('confirmPassword', 'password', array('required' => false));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'jc\UserBundle\Model\AccountInfo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_userbundle_accountinfo';
    }
}
