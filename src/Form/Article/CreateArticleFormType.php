<?php

declare(strict_types=1);

namespace App\Form\Article;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateArticleFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', TextType::class, ['attr' => [
            'class' => 'form-control',
            'placeholder' => 'Title'
        ]])
            ->add('description', TextType::class, ['attr' => [
                'class' => 'form-control',
                'placeholder' => 'Description'
            ]])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'getTitle',
                'attr' => [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => 'Category title'
                ]])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'getUsername',
                'attr' => [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => 'Category title'
        ]
        ])
            ->add('send', SubmitType::class, ['attr' => [
                'class' => 'btn btn-primary btn-modify'
            ]])
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'empty_data' => new Article()
        ]);
    }
}
