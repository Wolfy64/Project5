<?php

namespace App\Form;

use App\Entity\Observation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

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
            ->add('town',      TextType::class,[
                'label' => 'Ville',
                'attr' => ['class' => 'searchTextField']
                ])
            ->add('latitude',  IntegerType::class,[
                'label' => 'Latitude'
                ])
            ->add('longitude', IntegerType::class,[
                'label' => 'Longitude'
                ])
            ->add('numbers',   IntegerType::class,[
                'label' => 'Nombre d\'oiseaux'
                ])
            ->add('imageFile', FileType::class,[
                'label' => 'Télécharger la photo de l\'especes'
                ])
            ->add('content',   TextareaType::class,[
                'label' => 'Autres informations'
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
