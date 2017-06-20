<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AuthBundle\Controller;

use AuthBundle\Entity\User;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * Surcharge le Controller de confirmation FOSUSER afin de valider l'utilisateur une fois qu'il a cliqué sur le lien de confirmation envoyé par mail et qu'il a changé son mot de passe par defaut
 * Override the FOSUSER Confirmation controller to validate the user once he passes through email validation link to change his default password
 */
class RegistrationController extends \FOS\UserBundle\Controller\RegistrationController
{


    /**
     * Receive the confirmation token from user email provider, ask to change the password of the user, confirm the account when done.
     *
     * @param Request $request
     * @param string  $token
     * @return Response
     */
    public function confirmAction(Request $request, $token)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface
         * Use the reset form for asking to change the password
         */
        $formFactory = $this->get('fos_user.resetting.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        /** @var  $user User*/
        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
        }

//      $now = new \DateTime();

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = new FormEvent($form, $request);

            $user->setConfirmationToken(null);
//            if (!$user->getActiveAt()== null && !$user->getActiveUntil()==null){
//                if($user->getActiveAt() > $now){
//                    $response = $this->redirectToRoute('auth_default_index');
//                }
//            }
            $user->setEnabled(true);
            $user->setConfirmationStatus("accepted");

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $response = $this->redirectToRoute('auth_default_index');
            }

            $dispatcher->dispatch(
                FOSUserEvents::REGISTRATION_CONFIRMED,
                new FilterUserResponseEvent($user, $request, $response)
            );

            return $response;
        }

        return $this->render('@FOSUser/Registration/register.html.twig', array(
            'token' => $token,
            'form' => $form->createView(),
        ));
    }

}
