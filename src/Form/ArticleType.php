<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre :',
                'attr' => array('class' => 'form-control w-100')
            ])
            ->add('content', null, [
                'label' => 'Description :',
                'attr' => [
                    'class' => 'form-control w-100',
                    'rows' => '8']
            ])
            ->add('category', null, [
                'choice_label' => 'name',
                'label' => 'Type d\'article :',
                'attr' => [
                    'class' => 'form-control w-100'
                ]
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
                'label' => 'Tag :',
                'attr' => [
                    'class' => 'form-control w-100'
                ],
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
