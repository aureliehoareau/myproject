<?php

namespace Site\BlogBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedbackType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',         TextType::class)
            ->add('lastname',     TextType::class)
            ->add('comment',      TextType::class)
            ->add('save',          SubmitType::class)
        ;
    
     $builder->addEventListener(
        FormEvents::PRE_SET_DATA,
        function(FormEvent $event) {
        $Feedback = $event->getData();

        if (null === $Feedback) {
          return;
        }

        if (!$Feedback->getPublished() || null === $Feedback->getId()) {
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
            'data_class' => 'Site\BlogBundle\Entity\Feedback'
        ));
    }
}
