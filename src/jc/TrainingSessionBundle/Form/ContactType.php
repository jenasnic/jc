<?php

namespace jc\TrainingSessionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility', 'choice', array(
                    'choices' => array('Mr' => 'Mr', 'Mme' => 'Mme'),
                    'required' => false,
                    'expanded' => true,
                    'empty_value' => false))
            ->add('firstname', 'text', array('required' => false))
            ->add('lastname', 'text', array('required' => false))
            ->add('phone', 'text', array('required' => false))
            ->add('mobile', 'text', array('required' => false))
            ->add('mail', 'text', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'jc\TrainingSessionBundle\Entity\Contact'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_trainingsessionbundle_contact';
    }
}
