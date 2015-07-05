<?php

namespace jc\DoodleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DoodleType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('required' => false))
            ->add('comment', 'textarea', array('required' => false))
            ->add('eventDate', 'datetime', array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'invalid_message' => 'La date saisie n\'est pas valide'
            ))
            ->add('replyDate', 'datetime', array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'invalid_message' => 'La date saisie n\'est pas valide'
            ))
            ->add('closed', 'checkbox', array('required' => false))
            ->add('sent', 'hidden')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'jc\DoodleBundle\Entity\Doodle'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_doodlebundle_doodle';
    }
}
