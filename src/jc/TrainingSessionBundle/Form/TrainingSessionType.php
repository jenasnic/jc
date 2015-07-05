<?php

namespace jc\TrainingSessionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrainingSessionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('required' => false))
            ->add('description', 'textarea', array('required' => false))
            ->add('date', 'datetime', array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'invalid_message' => 'La date saisie n\'est pas valide'
            ))
            ->add('timeHourStart', 'text', array('required' => false))
            ->add('timeMinuteStart', 'text', array('required' => false))
            ->add('timeHourEnd', 'text', array('required' => false))
            ->add('timeMinuteEnd', 'text', array('required' => false))
            ->add('pictureUrl', 'hidden', array('required' => false))
            ->add('pictureFile', 'file', array('required' => false))
            ->add('contact', 'entity', array(
                    'required' => false,
                    'empty_value' => '-',
                    'class' => 'jcTrainingSessionBundle:Contact',
                    'property' => 'fullname'
            ))
            ->add('location', 'entity', array(
                    'required' => true,
                    'class' => 'jcTrainingSessionBundle:Location',
                    'property' => 'name'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'jc\TrainingSessionBundle\Entity\TrainingSession'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_trainingsessionbundle_trainingsession';
    }
}
