<?php

namespace Site\BlogBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Site\MediaBundle\Form\ImageType;
use Site\BlogBundle\Form\DescriptionType;
use Site\BlogBundle\Entity\Description;
use Site\MediaBundle\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description',         DescriptionType::class)
            ->add('user', EntityType::class, array(
                'class' => 'SiteUserBundle:User',
                'choice_label' => 'username'))
            ->add('image',         ImageType::class, array(
                'required' => false,))
            ->add('categories', EntityType::class, array(
                'class' => 'SiteMediaBundle:Category',
                'choice_label' => 'name',
                'multiple' => true,))
            ->add('language',            EntityType::class, array(
                'class' => 'SiteMediaBundle:Language',
                'choice_label' => 'name'))
             ->add('date',          DateTimeType::class)
            ->add('save',          SubmitType::class)
    ;
    $builder->addEventListener(
        FormEvents::PRE_SET_DATA,
        function(FormEvent $event) {
        $Article = $event->getData();

        if (null === $Article) {
          return;
        }

        if (!$Article->getPublished() || null === $Article->getId()) {
          $event->getForm()->add('published', CheckboxType::class, array('required' => false));
        } else {
          $event->getForm()->add('published');
        }
      }
    );
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Site\BlogBundle\Entity\Article'
        ));
    }
}
