<?php

namespace App\Form;

use App\Entity\Observation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Range;

class ObservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('species',   TextType::class,[
                'constraints' => new NotBlank(),
                'constraints' => new Type([
                    'type' => 'string'
                    ]),
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 50
                    ])
                ])
            ->add('date',      DateType::class,[
                'constraints' => new Date(),
                'constraints' => new LessThanOrEqual('today'),
                'widget' => 'single_text',
                ])
            ->add('place',     TextType::class,[
                'constraints' => new Type([
                    'type' => 'string'
                    ]),
                'constraints' => new Length([
                    'max' => 50
                    ]),
                'required' => false
                ])
            ->add('latitude',  HiddenType::class,[
                'constraints' => new NotBlank(),
                'constraints' => new Type([
                    'type' => 'numeric'
                    ])
                ])
            ->add('longitude', HiddenType::class,[
                'constraints' => new NotBlank(),
                'constraints' => new Type([
                    'type' => 'numeric'
                    ])
                ])
            ->add('numbers',   ChoiceType::class,[
                'constraints' => new NotBlank(),
                'constraints' => new Type([
                    'type' => 'integer'
                    ]),
                'constraints' => new Range([
                    'min' => 1,
                    'max' => 10
                    ]),
                'choices' => Observation::NUMBERS_OF_BIRDS,
                ])
            ->add('imageFile', FileType::class,[
                'required' => false
                ])
            ->add('content',   TextareaType::class,[
                'constraints' => new NotBlank(),
                'constraints' => new Length([
                    'max' => 500
                    ]),
                'required' => false
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Observation::class,
        ]);
    }
}
