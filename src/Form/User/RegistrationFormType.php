<?php
declare(strict_types=1);

namespace App\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType {
    // TODO: implement config of this form type that will set data class User instead of raw array

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('user_name', TextType::class, ['label' => 'User name'])
            ->add('first_name', TextType::class, ['label' => 'First Name'])
            ->add('last_name', TextType::class, ['label' => 'Last name'])
            ->add('password', PasswordType::class, ['label' => 'Password'])
            ->add('send', SubmitType::class)
            ->getForm();
    }
}
