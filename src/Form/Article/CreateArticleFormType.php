<?php
declare(strict_types=1);

namespace App\Form\Article;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateArticleFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', TextType::class, ['label' => 'Title'])
            ->add('desc', TextType::class, ['label' => 'Description'])
            ->add('cat', TextType::class, ['label' => 'Category'])
            ->add('send', SubmitType::class)
            ->getForm();
    }
}
