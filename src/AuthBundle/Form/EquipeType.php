<?php

namespace AuthBundle\Form;

use AuthBundle\Entity\Module;

use AuthBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class EquipeType extends AbstractType
{
    private $authorization;

    /**
     * EquipeType constructor.
     * @param $authorization
     */
    public function __construct(AuthorizationChecker $authorization)
    {
        $this->authorization = $authorization;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $disabled = true;
        if ($this->authorization->isGranted('ROLE_ADMIN')){
            $disabled = false;
        }
        $builder
            ->add('nom')

            ->add('modules', EntityType::class, array(
                'class' => Module::class,
                'choice_label' => 'nom',
                'by_reference' => false,
                'multiple' => true,
                'expanded' => true
            ))
            ->add('pilote', EntityType::class, array(
                'class' => User::class,
                'disabled' => $disabled,
                'query_builder' => function (EntityRepository $er){
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nom', 'ASC');
                }
            ))
            ->add('teamRoles', CollectionType::class, array(
                'label' => "Utilisateurs dans l'équipe",
                'entry_type' => UserRoleType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false,

            ))


        ;

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AuthBundle\Entity\Equipe'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'authbundle_equipe';
    }


}
