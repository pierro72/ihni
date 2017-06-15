<?php

namespace AuthBundle\Form;

use AuthBundle\Entity\Role;
use AuthBundle\Entity\TeamRole;
use AuthBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder

            ->add(
                'user',
                EntityType::class,
                array(
                    'class' => User::class,
                    'query_builder' => function (EntityRepository $er){
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.nom', 'ASC');
                    }

                )
            )
            ->add(
                'role',
                EntityType::class,
                array(
                    'class' => Role::class,
                    'choice_label' => 'nom',

                )
            );

//        $builder
//            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
//
//                $form = $event->getForm();
//                $teamRole = $event->getData();
//
//                if(!$teamRole == null){
//                    if ($teamRole->getRole()->getNom() == 'pilote'){
//                        $form
//
//                            ->add('user', EntityType::class, array(
//                                'class' => User::class,
//                                'disabled' => true,
//
//                            ))
//                            ->add('role', EntityType::class, array(
//                                'class' => Role::class,
//                                'disabled' => true,
//
//                                'choice_label' => 'nom'
//                            ))
//                        ;
//
//                    }
//                    else{
//
//                        $form->add(
//                            'user',
//                            EntityType::class,
//                            array(
//                                'class' => User::class,
//                            )
//                        )
//                            ->add(
//                                'role',
//                                EntityType::class,
//                                array(
//                                    'class' => Role::class,
//                                    'choice_label' => 'nom',
//                                )
//                            );
//
//                    }
//                    ;
//                }
//
//
//
//
//            }
//            )
//
//            ;







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
        return 'auth_bundle_user_role';
    }
}
