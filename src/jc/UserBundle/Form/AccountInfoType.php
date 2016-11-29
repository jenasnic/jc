<?php

namespace jc\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class AccountInfoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array('required' => false))
            ->add('lastname', TextType::class, array('required' => false))
            ->add('mail', TextType::class, array('required' => false))
            ->add('password', PasswordType::class, array('required' => false))
            ->add('confirmPassword', PasswordType::class, array('required' => false));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'jc\UserBundle\Model\AccountInfo'
        ));
    }
}
