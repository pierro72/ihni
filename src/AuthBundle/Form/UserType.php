<?php

namespace AuthBundle\Form;

use AuthBundle\Entity\TeamRole;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class UserType extends AbstractType
{
    private $authorization;

    /**
     * UserType constructor.
     * @param AuthorizationChecker $authorizationChecker
     */
    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorization = $authorizationChecker;
    }


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder

            ->add('prenom')
            ->add('nom')
            ->add('email', EmailType::class)

            ;


            //Vérifie si l'utilisateur est nouveau ou si role Admin pour afficher ou pas le bloc
            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event){
               $user = $event->getData();
               $form = $event->getForm();

               if (!$user || null === $user->getId()||$this->authorization->isGranted('ROLE_ADMIN')){
                   $form

                       ->add('teamRoles', CollectionType::class, array(
                           'label' => "Equipes",
                           'entry_type' => TeamRoleType::class,
                           'allow_add' => true,
                           'allow_delete' => true,
                           'by_reference' => false,
                           'required' => false,
                       ));
               }
               $form
                   ->add('activeAt', DateType::class, [
                       'widget' => 'single_text',

                       'html5' => false,
                       'label' => "Actif à partir du : ",
                       'required' => false,
                       'attr' => [
                           'class' => 'datepicker',
                           'placeholder' => "Laissez vide pour activer immédiatement"
                       ]
                   ])
                   ->add('activeUntil', DateType::class, [
                       'widget' => 'single_text',
                       'html5' => false,
                       'label' => "Actif jusqu'au : ",
                       'required' => false,
                       'attr' => [
                           'placeholder' => "Laissez vide pour activer indéfiniment",
                           'class' => "datepicker"
                       ]
                   ])

               ;
            });





    }



    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AuthBundle\Entity\User',
//
        ));
    }

//    /**
//     * {@inheritdoc}
//     */
//    public function getBlockPrefix()
//    {
//        return 'authbundle_user';
//    }


}