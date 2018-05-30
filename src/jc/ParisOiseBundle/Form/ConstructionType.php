<?php

namespace jc\ParisOiseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ConstructionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class, array('required' => false))
            ->add('firstname1', TextType::class, array('required' => false))
            ->add('lastname1', TextType::class, array('required' => false))
            ->add('birthDate1', DateTimeType::class, array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'invalid_message' => 'La date saisie n\'est pas valide'
            ))
            ->add('birthPlace1', TextType::class, array('required' => false))
            ->add('nationality1', TextType::class, array('required' => false))
            ->add('job1', TextType::class, array('required' => false))
            ->add('phone1', TextType::class, array('required' => false))
            ->add('mail1', TextType::class, array('required' => false))
            ->add('firstname2', TextType::class, array('required' => false))
            ->add('lastname2', TextType::class, array('required' => false))
            ->add('birthDate2', DateTimeType::class, array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'invalid_message' => 'La date saisie n\'est pas valide'
            ))
            ->add('birthPlace2', TextType::class, array('required' => false))
            ->add('nationality2', TextType::class, array('required' => false))
            ->add('job2', TextType::class, array('required' => false))
            ->add('phone2', TextType::class, array('required' => false))
            ->add('mail2', TextType::class, array('required' => false))
            ->add('customerUnion', ChoiceType::class, array(
                    'choices_as_values' => true,
                    'choices' => array('Mariés' => 'MARIED', 'Pacs' => 'PACS', 'Union libre' => 'FREE_UNION', 'Célibataire' => 'SINGLE'),
                    'required' => false,
                    'expanded' => true,
                    'placeholder' => null))
            ->add('customerStreet1', TextType::class, array('required' => false))
            ->add('customerStreet2', TextType::class, array('required' => false))
            ->add('customerZip', TextType::class, array('required' => false))
            ->add('customerCity', TextType::class, array('required' => false))
            ->add('constructionStreet1', TextType::class, array('required' => false))
            ->add('constructionStreet2', TextType::class, array('required' => false))
            ->add('constructionZip', TextType::class, array('required' => false))
            ->add('constructionCity', TextType::class, array('required' => false))
            ->add('note', TextareaType::class, array('required' => false))
            ->add('depositDate1', DateTimeType::class, array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'invalid_message' => 'La date saisie n\'est pas valide'
            ))
            ->add('depositDate2', DateTimeType::class, array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'invalid_message' => 'La date saisie n\'est pas valide'
            ))
            ->add('validateDate', DateTimeType::class, array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'invalid_message' => 'La date saisie n\'est pas valide'
            ))
            ->add('signDate', DateTimeType::class, array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'invalid_message' => 'La date saisie n\'est pas valide'
            ))
            ->add('contacts', CollectionType::class, array(
                    'entry_type' => ContactType::class,
                    'allow_add' => false,
                    'allow_delete' => false
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'jc\ParisOiseBundle\Entity\Construction'
        ));
    }
}
