<?php

namespace App\Form;

use App\Entity\Article;
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
