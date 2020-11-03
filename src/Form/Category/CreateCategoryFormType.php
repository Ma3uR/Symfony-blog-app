<?php

declare(strict_types=1);

namespace App\Form\Category;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateCategoryFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', TextType::class, ['attr' => [
            'class' => 'form-control',
            'placeholder' => 'Category title'
        ]])
            ->add('Create', SubmitType::class, ['attr' => [
            'class' => 'btn btn-primary btn-modify'
        ]])
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Category::class
        ]);
    }
}