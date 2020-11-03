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
        $builder->add('user_name', TextType::class, ['attr' => [
                'class' => 'form-control',
                'placeholder' => 'User name'
            ]])
            ->add('first_name', TextType::class, ['attr' => [
                'class' => 'form-control',
                'placeholder' => 'First name'
            ]])
            ->add('last_name', TextType::class, ['attr' => [
                'class' => 'form-control',
                'placeholder' => 'Last name'
            ]])
            ->add('password', PasswordType::class, ['attr' => [
                'class' => 'form-control',
                'placeholder' => 'Password'
            ]]) // TODO: repeate password
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
