<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Length;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class,[
                'constraints' => [
                    new NotBlank (),
                    new Type(['type' => 'string']),
                    new Length(['min' => 2, 'max' => 25])
                ]])
            ->add('lastName', TextType::class,[
                'constraints' => [
                    new NotBlank (),
                    new Type(['type' => 'string']),
                    new Length(['min' => 2, 'max' => 25])
                ]])                
            ->add('email', TextType::class,[
                'constraints' => [
                    new NotBlank (),
                    new Type(['type' => 'string']),
                    new Email(['checkMX' => true])
                ]])                
            ->add('object', TextType::class,[
                'constraints' => [
                    new NotBlank (),
                    new Type(['type' => 'string']),
                    new Length(['min' => 2, 'max' => 25])
                ]])                
            ->add('message', TextType::class,[
                'constraints' => [
                    new NotBlank (),
                    new Type(['type' => 'string']),
                    new Length(['min' => 10])
                ]])                
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
