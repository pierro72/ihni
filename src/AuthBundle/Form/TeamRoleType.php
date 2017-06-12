<?php

namespace AuthBundle\Form;

use AuthBundle\Entity\Equipe;
use AuthBundle\Entity\Role;
use AuthBundle\Entity\TeamRole;
use AuthBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;


class TeamRoleType extends AbstractType
{
    private $authorization;
    private $tokenStorage;

    /**
     * TeamRoleType constructor.
     * @param $authorizationChecker
     */
    public function __construct(AuthorizationChecker $authorizationChecker, TokenStorageInterface $tokenStorage)
    {
        $this->authorization = $authorizationChecker;
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Si Role admin Le formulaire laisse toute liberté de crea/modif
        if ($this->authorization->isGranted('ROLE_ADMIN')) {

            $builder->add(
                'equipe',
                EntityType::class,
                array(
                    'class' => Equipe::class,
                    'choice_label' => 'nom',

                )
            );
            $builder->add(
                'role',
                EntityType::class,
                array(
                    'class' => Role::class,
                    'choice_label' => 'nom',

                )
            );
        } //Si Role Pilote restreint les choix aux équipes piloté et rôles classiques
        else {
            $user = $this->tokenStorage->getToken()->getUser();

            $builder->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use ($user) {
                        $form = $event->getForm();

                        $formOptions = array(
                            'class'         => Equipe::class,
                            'choice_label'  => 'nom',
                            'query_builder' => function(EntityRepository $er) use ($user) {
                                return $er->createQueryBuilder('e')
                                    ->innerJoin('e.teamRoles', 't')
                                    ->innerJoin('t.user','u')
                                    ->where('u = :zeuser')
                                    ->setParameter('zeuser', $user)
                                    ->andWhere("t.role = 1")
                                    ;
                            }
                        );
                        $form->add(
                            'equipe',
                            EntityType::class,
                            $formOptions
                            )
                            ->add(
                                'role',
                                EntityType::class,
                                array(
                                    'class' => Role::class,
                                    'query_builder' => function (EntityRepository $er) {
                                        return $er->createQueryBuilder('u')
                                            ->where("u.nom != 'pilote'");
                                    },
                                    'choice_label' => 'nom',
                                )
                            )
                        ;
                }
            );

        }


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => TeamRole::class,
            )
        );
    }

    public function getBlockPrefix()
    {
        return 'auth_bundle_team_role_type';
    }
}
