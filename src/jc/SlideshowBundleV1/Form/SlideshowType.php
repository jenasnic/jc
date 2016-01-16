<?php

namespace jc\SlideshowBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SlideshowType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('required' => false))
            ->add('description', 'textarea', array('required' => false))
            ->add('date', 'datetime', array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'invalid_message' => 'La date saisie n\'est pas valide'
            ))
            ->add('pictureFile', 'file', array('required' => false))
            ->add('pictureUrl', 'hidden', array('required' => false))
            ->add('rank', 'hidden')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'jc\SlideshowBundle\Entity\Slideshow'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_slideshowbundle_slideshow';
    }
}
