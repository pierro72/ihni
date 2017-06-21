<?php
/**
 * Created by PhpStorm.
 * User: dmetthey.stage
 * Date: 20/06/2017
 * Time: 14:56
 */

namespace AuthBundle;


use AuthBundle\Entity\User;
use Doctrine\ORM\EntityManager;


class sendInvitation
{

    protected $mailer;
    protected $manager;
    protected $templating;

    /**
     * sendInvitation constructor.
     * @param $mailer
     */
    public function __construct( \Swift_Mailer $mailer, EntityManager $manager, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->manager = $manager;
        $this->templating = $templating;

    }


    /**
     * envoi une invitation de confirmation de compte
     */
    /**
     * @param User $user
     * @return int
     */
    public function sendInvitation(User $user)
    {


        $user->setConfirmationStatus("pending");
        $this->manager->flush();

        $invitation = \Swift_Message::newInstance()
            ->setFrom('IHNI@sodifrance.fr')
            ->setTo($user->getEmail())
            ->setSubject('Confirmation de votre compte QualityBox')
            ->setBody(
                $this->templating->render(
                    ':email:invitation.html.twig',
                    array(
                        'user' => $user,
                    )
                ),
                'text/html'
            );



        return $this->mailer->send($invitation);

    }


}