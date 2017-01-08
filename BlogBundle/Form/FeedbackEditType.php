<?php
// src/OC/PlatformBundle/Form/ProductEditType.php

namespace Site\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FeedbackEditType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->remove('date');
  }

  public function getParent()
  {
    return FeedbackType::class;
  }
}
