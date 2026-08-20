<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfileType extends AbstractType
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
            ->add('imageFile', VichImageType::class, [
                'label' => 'form.profile_image',
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => true,
                'constraints' => [
                    new Image(
                        maxSize: '2M',
                        maxSizeMessage: 'validation.image.max_size',
                        mimeTypesMessage: 'validation.image.mime_types',
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
