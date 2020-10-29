<?php

declare(strict_types=1);

namespace App\Form\Article;

use App\Entity\Category;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateArticleFormType extends AbstractType {
    // TODO: implement config of this form type that will set data class Article instead of raw array
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', TextType::class, ['label' => 'Title'])
            ->add('desc', TextType::class, ['label' => 'Description'])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'getTitle'
        ])
            ->add('users', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'getUsername'
        ])
            ->add('send', SubmitType::class)
            ->getForm();
    }
}
