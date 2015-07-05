<?php

namespace jc\DoodleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DoodleReplyType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('response', 'choice', array(
                    'choices' => array('1' => 'Je participe', '0' => 'Je ne participe pas'),
                    'required' => false,
                    'expanded' => true,
                    'empty_value' => false))
            ->add('comment', 'textarea', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'jc\DoodleBundle\Entity\DoodleReply'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jc_doodlebundle_doodlereply';
    }
}
