<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\File;


class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image',   FileType::class, [
                'constraints' => [
                    new NotBlank(),
                    new File([
                        'maxSize' => '2M',
                        'binaryFormat' => false,
                        'mimeTypes' => ['image/jpeg', 'image/jpg']
                    ])
                ]])
            ->add('title',   TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Type(['type' => 'string']),
                    new Length(['min' => 2, 'max' => 50]),
                ]])
            ->add('article', TextareaType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 50])
                    ]])
            ->add('author',  TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Type(['type' => 'string']),
                    new Length(['min' => 2, 'max' => 50])
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
