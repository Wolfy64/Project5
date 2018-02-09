<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',      EmailType::class,[
                'constraints' => new NotBlank(),
                'constraints' => new Email([
                    'checkMX' => true
                    ]),
                'label' => 'Email'
                ])
            ->add('firstName',     TextType::class,[
                'constraints' => new NotBlank(),
                'constraints' => new Type([
                    'type' => 'string']),
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 25
                    ]),
                'label' => 'Prénom'
                ])
            ->add('lastName',      TextType::class,[
                'constraints' => new NotBlank(),
                'constraints' => new Type([
                    'type' => 'string'
                ]),
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 25
                ]),
                'label' => 'Nom'
                ])
            ->add('plainPassword', RepeatedType::class, [
                'constraints' => new NotBlank(),
                'constraints' => new Length([
                    'min' => 4,
                    'max' => 100
                ]),
                'type'           => PasswordType::class,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer votre mot de passe']])
            ->add('termsOfUse',    CheckboxType::class,[
                'label'    => 'J\'accepte les conditions d\'utilisation',
                'required' => true,
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            ]);
    }
}
