<?php

namespace jc\EnglishQuizzBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EnglishIrregularVerbType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('verbEN', TextType::class, array('required' => false))
                ->add('verbFR', TextType::class, array('required' => false))
                ->add('preterit', TextType::class, array('required' => false))
                ->add('past', TextType::class, array('required' => false));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'jc\EnglishQuizzBundle\Entity\EnglishIrregularVerb'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jc_englishquizzbundle_englishirregularverb';
    }


}
