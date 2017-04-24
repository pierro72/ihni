<?php

namespace AuthBundle\Form;

use AuthBundle\Entity\Role;
use AuthBundle\Entity\TeamRole;
use AuthBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, array(
                'class' => User::class,
                'choice_label' => 'nom',

            ))
            ->add('role', EntityType::class, array(
                'class' => Role::class,
                'choice_label' => 'nom'
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => TeamRole::class
        ));
    }

    public function getBlockPrefix()
    {
        return 'auth_bundle_user_role';
    }
}
