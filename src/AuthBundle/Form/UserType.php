<?php

namespace AuthBundle\Form;

use AuthBundle\Entity\TeamRole;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('prenom')
            ->add('nom')
            ->add('email', EmailType::class)
            ->add('username')
            ->add('plainPassword', PasswordType::class)
            ->add('teamRoles', CollectionType::class, array(
                'entry_type' => TeamRoleType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false,

            ))
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
//            '
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