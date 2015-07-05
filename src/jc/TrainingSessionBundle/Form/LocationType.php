<?php

namespace jc\TrainingSessionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LocationType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('required' => false))
            ->add('address', 'textarea', array('required' => false))
            ->add('city', 'text', array('required' => false))
            ->add('zipCode', 'text', array('required' => false))
            ->add('showMap', 'checkbox', array('required' => false))
            ->add('latitude', 'text', array('required' => false))
            ->add('longitude', 'text', array('required' => false))
            ->add('zoom', 'choice', array('required' => false, 'empty_value' => false, 'choices' => array(
                    '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10',
                    '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18')))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'jc\TrainingSessionBundle\Entity\Location'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_trainingsessionbundle_location';
    }
}
