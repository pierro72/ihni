<?php

namespace AuthBundle\Form;

use AuthBundle\Entity\Equipe;
use AuthBundle\Entity\Role;
use AuthBundle\Entity\TeamRole;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamRoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('equipe')
//        , EntityType::class, array(
//                'class' => Equipe::class,
//                'choice_label' => 'nom'
//
//
//
//            ))
//            ->add('role')
//        , EntityType::class, array(
//                'class' => Role::class,
//                'choice_label' => 'nom'
//
//
//            ))
                ;
//        $builder
//            ->add('equipe', CollectionType::class, array(
//                'entry_type' => Equipe::class
//            ))
//            ->add('role', CollectionType::class, array(
//                'entry_type' => Role::class
//            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => TeamRole::class
        ));
    }

    public function getBlockPrefix()
    {
        return 'auth_bundle_team_role_type';
    }
}
