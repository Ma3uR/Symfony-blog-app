<?php

declare(strict_types=1);

namespace App\Form\Category;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateCategoryFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', TextType::class, ['label' => 'Category title'])
            ->add('send', SubmitType::class)
            ->getForm();
    }
}