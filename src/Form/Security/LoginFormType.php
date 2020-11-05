<?php

declare(strict_types=1);

namespace App\Form\Security;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('_username', TextType::class, ['attr' => [
            'class' => 'form-control',
            'placeholder' => 'User name',
        ]])
            ->add('_password', PasswordType::class, ['attr' => [
                'class' => 'form-control',
                'placeholder' => 'Password'
            ]])
            ->add('send', SubmitType::class, ['attr' => [
                'class' => 'btn btn-primary btn-modify'
            ]])
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
