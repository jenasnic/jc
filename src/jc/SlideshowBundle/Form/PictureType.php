<?php

namespace jc\SlideshowBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PictureType extends AbstractType
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
            ->add('rank', 'hidden')
            ->add('pictureFile', 'file', array('required' => false))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'jc\SlideshowBundle\Entity\Picture'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_slideshowbundle_picture';
    }
}
