<?php

namespace jc\ParisOiseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OrderItemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class, array('required' => false))
            ->add('status', ChoiceType::class, array(
                    'choices_as_values' => true,
                    'choices' => array('0' => 'Démarrage', '1' => 'Reçu', '2' => 'Prévisionnel', '3' => 'Réel', '4' => 'Final'),
                    'required' => false,
                    'expanded' => true,
                    'placeholder' => null))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'jc\ParisOiseBundle\Entity\OrderItem'
        ));
    }
}
