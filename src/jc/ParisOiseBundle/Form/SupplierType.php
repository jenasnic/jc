<?php

namespace jc\ParisOiseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SupplierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('required' => false))
            ->add('street1', TextType::class, array('required' => false))
            ->add('street2', TextType::class, array('required' => false))
            ->add('zip', TextType::class, array('required' => false))
            ->add('city', TextType::class, array('required' => false))
            ->add('trade', TextType::class, array('required' => false))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'jc\ParisOiseBundle\Entity\Supplier'
        ));
    }
}
