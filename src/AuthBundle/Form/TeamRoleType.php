<?php

namespace AuthBundle\Form;

use AuthBundle\Entity\Equipe;
use AuthBundle\Entity\Role;
use AuthBundle\Entity\TeamRole;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class TeamRoleType extends AbstractType
{
    private $authorization;

    /**
     * TeamRoleType constructor.
     * @param $authorizationChecker
     */
    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorization = $authorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if( $this->authorization->isGranted('ROLE_ADMIN')){

            $builder->add('equipe', EntityType::class, array(
                'class' => Equipe::class,
                'choice_label' => 'nom'

            ));
            $builder->add('role', EntityType::class, array(
                'class' => Role::class,
                'choice_label' => 'nom'

            ))
            ;
        }
        else {
            $builder->add('equipe', EntityType::class, array(
                'class' => Equipe::class,
                'choice_label' => 'nom',
                'disabled' => true

            ))
            ;
            $builder->add('role', EntityType::class, array(
                'class' => Role::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('u')
                        ->where("u.nom != 'pilote'");
                },
                'choice_label' => 'nom',


            ))
            ;
        }




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
