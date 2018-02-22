<?php

namespace App\Form\Naturalist;

use App\Entity\Observation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Length;

class ModifyObservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commonName', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Type(['type' => 'string']),
                    new Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('content', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new Length(['max' => 500])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Observation::class,
        ]);
    }
}

