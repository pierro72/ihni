<?php

namespace AuthBundle\Form;

use AuthBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReglageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'admin',
                EntityType::class,
                array(
                    'class' => User::class,
                    'multiple' => true,
                    'expanded' => false,
                    'label' => 'Ajouter ou supprimer des Administrateurs',
                    'required' => false
                )
            );

    }

    public function configureOptions(OptionsResolver $resolver)
    {


    }

    public function getBlockPrefix()
    {
        return 'auth_bundle_reglage';
    }
}
