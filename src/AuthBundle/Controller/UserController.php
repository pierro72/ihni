<?php

namespace AuthBundle\Controller;

use AuthBundle\Entity\Equipe;
use AuthBundle\Entity\TeamRole;
use AuthBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 * @Security("is_granted('TEAM_PILOT') or has_role('ROLE_ADMIN')")
 * @Route("qub/ihni/user")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities if Role_Admin is granted else list users in theam where the user is Pilote
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {


            $users = $em->getRepository('AuthBundle:User')->findAll();
        } else {
            $currentUser = $this->getUser();
            $currentTeam = new ArrayCollection();
            $users = new ArrayCollection();

            foreach ($currentUser->getTeamRoles() as $teamRole) {
                if ($teamRole->getRole()->getNom() == 'pilote') {
                    $currentTeam[] = $teamRole->getEquipe();
                }
            }
            foreach ($currentTeam as $item) {
                $result = $em->getRepository('AuthBundle:User')->findByTeam($item);
                foreach ($result as $user) {
                    if(!$users->contains($user))
                    {
                        $users[] = $user;
                    }
                }
            }
        }

        return $this->render(
            'user/index.html.twig',
            array(
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
    public function newAction(Request $request)
    {
        $user = new User();


        $form = $this->createForm('AuthBundle\Form\UserType', $user);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $username = substr($user->getPrenom(), 0, 1).$user->getNom();
            $user->setUsername($username);

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);

            $em->flush();

            $this->sendInvitation($user);


            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render(
            'user/new.html.twig',
            array(
                'user' => $user,
                'intention' => 'create',
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {

        return $this->render(
            'user/show.html.twig',
            array(
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
    public function editAction(Request $request, User $user)
    {

        $editForm = $this->createForm('AuthBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }



        return $this->render(
            ':user:new.html.twig',
            array(
                'user' => $user,
                'intention' => 'edit',
                'form' => $editForm->createView(),

            )
        );
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}/delete", name="user_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, User $user)
    {


        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();


        return $this->redirectToRoute('user_index');
    }


    /**
     * envoi une invitation de confirmation de compte
     * @param User $user
     */
    private function sendInvitation(User $user)
    {
        $invitation = \Swift_Message::newInstance()
            ->setFrom('IHNI@sodifrance.fr')
            ->setTo($user->getEmail())
            ->setSubject('Confirmation de votre compte QualityBox')
            ->setBody(
                $this->renderView(
                    ':email:invitation.html.twig',
                    array(
                        'user' => $user,
                    )
                ),
                'text/html'
            );
        $this->get('mailer')->send($invitation);

    }


}
