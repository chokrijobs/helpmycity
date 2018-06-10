<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Category extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'required'=>true,
                'attr'=>[
                    'class'=>'form-control'
                ],
            ))
            ->add('description', TextareaType::class, array(
                'required'=>true,
                'attr'=>[
                    'class'=>'form-control'
                ],
            ))
            ->add('photo', FileType::class, array(
                'required'=>true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
        ));
    }

    public function getBlockPrefix()
    {
        return 'category';
    }
}
