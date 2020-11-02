<?php

declare(strict_types=1);

namespace App\Form\User;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('user_name', TextType::class,
            [
                'label' => 'User name',
            ])
            ->add('first_name', TextType::class, ['label' => 'First Name'])
            ->add('last_name', TextType::class, ['label' => 'Last name'])
            ->add('password', PasswordType::class, ['label' => 'Password'])
            ->add('send', SubmitType::class)
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => User::class,
            'empty_data' => new User()
        ]);
    }
}
