<?php

namespace jc\MovieQuizzBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class QuizzResponseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('required' => false))
            ->add('responses', TextareaType::class, array('required' => false))
            ->add('trick', TextareaType::class, array('required' => false))
            ->add('positionX', TextType::class, array('required' => false))
            ->add('positionY', TextType::class, array('required' => false))
            ->add('size', ChoiceType::class, array('choices' => array(1 => 'petit', 2 => 'moyen', 3 => 'grand')))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'jc\MovieQuizzBundle\Entity\QuizzResponse'
        ));
    }
}
