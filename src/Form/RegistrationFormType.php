<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'form.firstname',
                'constraints' => [
                    new NotBlank(message: 'validation.firstname.not_blank'),
                    new Length(max: 50, maxMessage: 'validation.firstname.max_length'),
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'form.lastname',
                'constraints' => [
                    new NotBlank(message: 'validation.lastname.not_blank'),
                    new Length(max: 50, maxMessage: 'validation.lastname.max_length'),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'form.email',
                'constraints' => [
                    new NotBlank(message: 'validation.email.not_blank'),
                    new Email(message: 'validation.email.invalid'),
                    new Length(max: 180, maxMessage: 'validation.email.max_length'),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                // le mot de passe est hashé dans le contrôleur, il ne doit pas être mappé sur l'entité
                'mapped' => false,
                'first_options' => ['label' => 'form.password'],
                'second_options' => ['label' => 'form.repeat_password'],
                'invalid_message' => 'validation.password.mismatch',
                'constraints' => [
                    new NotBlank(message: 'validation.password.not_blank'),
                    new Length(
                        min: 8,
                        max: 4096,
                        minMessage: 'validation.password.min_length',
                    ),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
