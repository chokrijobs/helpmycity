<?php
/**
 * Created by PhpStorm.
 * User: chokri
 * Date: 07/06/18
 * Time: 22:41
 */

namespace AppBundle\Form;

use AppBundle\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WebserviceUser extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => true,
                ],
            ))
            ->add('email', TextType::class, array(
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => true,
                ],
            ))
            ->add('name', TextType::class, array(
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ))
            ->add('lastName', TextType::class, array(
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ))

            ->add('roles', ChoiceType::class, array(
                'required' => false,
                'multiple' => false,
                'choices' => [
                    "ROLE_USER" => "ROLE_USER",
                    'ROLE_AGENT' => 'ROLE_AGENT',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                ],
                'choice_value' => function ($choice) {
                   /* print_r($choice);
                    echo '<br>';*/
                    if (is_array($choice) && isset($choice[0])) {
                        $choice = $choice[0];
                        return isset($choice['role']) ? $choice['role'] : $choice;
                    } else {
                        return $choice;
                    }


                },
                //'choices_as_values' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Security\User\WebserviceUser',
        ));
    }

    public function getBlockPrefix()
    {
        return 'user';
    }
}