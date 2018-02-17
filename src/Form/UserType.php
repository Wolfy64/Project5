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
                'constraints' => [
                    new NotBlank(),
                    new Email(['checkMX' => true])
                ]])
            ->add('firstName',     TextType::class,[
                'constraints' => [
                    new NotBlank(),
                    new Type(['type' => 'string']),
                    new Length(['min' => 2,'max' => 25])
                ]])
            ->add('lastName',      TextType::class,[
                'constraints' => [
                    new NotBlank(),
                    new Type(['type' => 'string']),
                    new Length(['min' => 2,'max' => 25])
                ]])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 4,'max' => 100])
                ]])
            ->add('termsOfUse',    CheckboxType::class,[
                'required' => true
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
