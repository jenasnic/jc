<?php

namespace jc\SlideshowBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class SlideshowType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('required' => false))
            ->add('description', TextareaType::class, array('required' => false))
            ->add('date', DateTimeType::class, array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'invalid_message' => 'La date saisie n\'est pas valide'
            ))
            ->add('pictureFile', FileType::class, array('required' => false))
            ->add('pictureUrl', HiddenType::class, array('required' => false))
            ->add('rank', 'hidden')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'jc\SlideshowBundle\Entity\Slideshow'
        ));
    }
}
