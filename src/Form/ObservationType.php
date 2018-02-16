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
use Symfony\Component\Validator\Constraints\File;

class ObservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('species',   TextType::class,[
                'constraints' => [
                    new NotBlank(),
                    new Type(['type' => 'string']),
                    new Length(['min' => 2,'max' => 50])
                ]])
            ->add('date',      DateType::class,[
                'widget' => 'single_text',
                'constraints' => [
                    new Date(),
                    new LessThanOrEqual('today')
                ]])
            ->add('place',     TextType::class,[
                'required' => false,
                'constraints' => [
                    new Type(['type' => 'string']),
                    new Length(['max' => 50]),
                ]])
            ->add('latitude',  HiddenType::class,[
                'constraints' => [
                    new NotBlank(['message' => 'Vous devez sélectionner un lieu sur la carte']),
                    new Type(['type' => 'string'])
                ]])
            ->add('longitude', HiddenType::class,[
                'constraints' => [
                    new NotBlank(['message' => 'Vous devez sélectionner un lieu sur la carte']),
                    new Type(['type' => 'string'])
                ]])
            ->add('numbers',   ChoiceType::class,[
                'choices' => Observation::NUMBERS_OF_BIRDS,
                'constraints' => [
                    new NotBlank(),
                    new Type(['type' => 'integer']),
                    new Range(['min' => 1,'max' => 10])
                ]])
            ->add('image',     FileType::class,[
                'required' => false,
                'empty_data' => null,
                'constraints' => new File([
                    'maxSize' => '2M',
                    'binaryFormat' => false,
                    'mimeTypes' => ['image/jpeg', 'image/jpg']
                ])])
            ->add('content',   TextareaType::class,[
                'required' => false,
                'constraints' => [

                    new Length(['max' => 500])
                ]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Observation::class,
        ]);
    }
}
