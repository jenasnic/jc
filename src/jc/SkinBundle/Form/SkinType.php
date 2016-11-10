<?php

namespace jc\SkinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SkinType extends AbstractType {

    const SKIN_FOLDER_PATH = 'resources/css/skins';

    /**
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('name', TextType::class, array('required' => false))
                ->add('cssFile', ChoiceType::class, array(
                        'required' => false,
                        'empty_value' => '-- Aucun --',
                        'choices' => $this->getFileList()))
                ->add('activ', CheckboxType::class, array('required' => false));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'jc\SkinBundle\Entity\Skin'
        ));
    }

    /**
     * Allows to get all files in skin folder (define throug constant SKIN_FOLDER_PATH), i.e.
     * all skin files.
     * @return array
     */
    public function getFileList() {

        $fileList = scandir(self::SKIN_FOLDER_PATH);
        $result = array();

        foreach ($fileList as $file) {

            $filePath = self::SKIN_FOLDER_PATH . '/' . $file;
            $fileInfo = pathinfo($filePath);

            if (!is_dir($filePath) && array_key_exists('extension', $fileInfo) && strcasecmp('css', $fileInfo['extension']) == 0)
                $result[$filePath] = $file;
        }

        return $result;
    }
}
