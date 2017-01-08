<?php

namespace Site\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;


use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DescriptionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('subtitle',      TextType::class)
            ->add('preview',       TextType::class)
            ->add('content',       CKEditorType::class, array('config_name' => 'my_config_1'))
           
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Site\BlogBundle\Entity\Description'
        ));
    }
}
