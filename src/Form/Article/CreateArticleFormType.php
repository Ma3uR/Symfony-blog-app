<?php
declare(strict_types=1);

namespace App\Form\Article;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateArticleFormType extends AbstractType {
    // TODO: implement config of this form type that will set data class Article instead of raw array
    // TODO: implement new action in new controller to create category
    // TODO: implement select category from existed in database

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', TextType::class, ['label' => 'Title'])
            ->add('desc', TextType::class, ['label' => 'Description'])
            ->add('cat', TextType::class, ['label' => 'Category'])
            ->add('send', SubmitType::class)
            ->getForm();
    }
}
