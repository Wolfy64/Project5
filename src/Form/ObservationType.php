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

class ObservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('species',   TextType::class,[
                'label' => 'Nom de l\'espèce'
                ])
            ->add('date',      DateType::class,[
                'label' => 'Date de l\'observation',
                'widget' => 'single_text',
                ])
            ->add('place',     TextType::class,[
                'label' => 'Lieu',
                'required' => false,
                'attr' => ['class' => 'searchTextField']
                ])
            ->add('latitude',  HiddenType::class)
            ->add('longitude', HiddenType::class)
            ->add('numbers',   ChoiceType::class,[
                'label' => 'Nombre d\'oiseaux',
                'choices' => Observation::NUMBERS_OF_BIRDS,
                ])
            ->add('imageFile', FileType::class,[
                'label' => 'Télécharger la photo de l\'especes',
                'required' => false
                ])
            ->add('content',   TextareaType::class,[
                'label' => 'Autres informations',
                'required' => false
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Observation::class,
        ]);
    }
}
