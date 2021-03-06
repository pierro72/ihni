<?php

namespace AuthBundle\Controller;

use AuthBundle\Entity\Equipe;
use AuthBundle\Entity\TeamRole;
use AuthBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Event\GetResponseNullableUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 * @Security("is_granted('TEAM_PILOT') or has_role('ROLE_ADMIN')")
 * @Route("qub/ihni/user")
 */
class UserController extends Controller {

    /**
     * Lists all user entities if Role_Admin is granted else list users in theam where the user is Pilote
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {


            $users = $em->getRepository('AuthBundle:User')->findAll();
        } else {

            $equipePilote = $this->getUser()->getPilote();
            $users = new ArrayCollection();


            $users->add($this->getUser());
            foreach ($equipePilote as $equipe) {
                $teamRoles = $equipe->getTeamRoles();
                foreach ($teamRoles as $teamRole) {
                    $users->add($teamRole->getUser());
                }
            }
        }

        return $this->render(
                        'user/index.html.twig', array(
                    'users' => $users,
                        )
        );
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $user = new User();


        $form = $this->createForm('AuthBundle\Form\UserType', $user);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //injecte la classe GenerateUsername
            $formater = $this->get('app.generateUsername');

            $username = $formater->generateUsername($user->getPrenom(), $user->getNom());
            $user->setUsername($username);
            $user->setCreatedBy($this->getUser());

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);

            $em->flush();

            //vérifie si la date d'activation du compte est valide avant d'envoyer l'invitation
            if ($user->getActiveAt() < new \DateTime() || $user->getActiveAt() == null) {
                $this->get('app.sendinvitation')->sendInvitation($user);
            }


            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render(
                        'user/new.html.twig', array(
                    'user' => $user,
                    'intention' => 'create',
                    'form' => $form->createView(),
                    'action' => 'Ajouter'
                        )
        );
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user) {

        return $this->render(
                        'user/show.html.twig', array(
                    'user' => $user,
                        )
        );
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user) {

        $editForm = $this->createForm('AuthBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            //injecte la classe GenerateUsername
            $formater = $this->get('app.generateUsername');

            $username = $formater->generateUsername($user->getPrenom(), $user->getNom());
            $user->setUsername($username);


            $em = $this->getDoctrine()->getManager();
            $em->flush();


            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }


        return $this->render(
                        ':user:new.html.twig', array(
                    'user' => $user,
                    'intention' => 'edit',
                    'form' => $editForm->createView(),
                    'action' => 'Éditer'
                        )
        );
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}/delete", name="user_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, User $user) {


        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();


        return $this->redirectToRoute('user_index');
    }

    /**
     * @param Request $request
     * @param User $user
     * @Route("/{id}/sendrequest", name="send_request")
     * @Method("POST")
     * @return Response
     */
    public function sendrequestAction(User $user, Request $request = null) {
        $tokenGenerator = $this->get('fos_user.util.token_generator');
        $user->setConfirmationToken($tokenGenerator->generateToken());
        $this->getDoctrine()->getManager()->flush();

        if (!$request == null) {
            $mailaddress = $request->get('mailaddress');
            $user->setEmail($mailaddress);
        }


        $result = $this->get('app.sendinvitation')->sendInvitation($user);

        return new Response(
                json_encode(
                        [
                            'success' => $result,
                        ]
                )
        );
    }

//      Voir service
//    /**
//     * envoi une invitation de confirmation de compte
//     */
//    /**
//     * @param User $user
//     * @return int
//     */
//    private function sendInvitation(User $user)
//    {
//        $invitation = \Swift_Message::newInstance()
//            ->setFrom('IHNI@sodifrance.fr')
//            ->setTo($user->getEmail())
//            ->setSubject('Confirmation de votre compte Cube')
//            ->setBody(
//                $this->renderView(
//                    ':email:invitation.html.twig',
//                    array(
//                        'user' => $user,
//                    )
//                ),
//                'text/html'
//            );
//        $user->setConfirmationStatus("pending");
//        $this->getDoctrine()->getManager()->flush();
//
//        return $this->get('mailer')->send($invitation);
//
//    }
}
