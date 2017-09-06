<?php

namespace AuthBundle\Controller;

use AuthBundle\Entity\Equipe;
use AuthBundle\Entity\TeamRole;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Equipe controller.
 * @Security("is_granted('TEAM_PILOT') or has_role('ROLE_ADMIN')")
 * @Route("qub/ihni/equipe")
 */
class EquipeController extends Controller
{
    /**
     * Lists all equipe entities.
     *
     * @Route("/", name="equipe_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
        {
            $equipes = $em->getRepository('AuthBundle:Equipe')->findAll();
        }
        else{
            $equipes = $this->getUser()->getPilote();
        }

        return $this->render('equipe/index.html.twig', array(
            'equipes' => $equipes,
        ));
    }

    /**
     * Creates a new equipe entity.
     *
     * @Route("/new", name="equipe_new")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $equipe = new Equipe();
        $form = $this->createForm('AuthBundle\Form\EquipeType', $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipe);
            $em->flush();

            return $this->redirectToRoute('equipe_show', array('id' => $equipe->getId()));
        }

        return $this->render('equipe/new.html.twig', array(
            'equipe' => $equipe,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a equipe entity.
     *
     * @Route("/{id}", name="equipe_show")
     * @Method("GET")
     */
    public function showAction(Equipe $equipe)
    {
        $deleteForm = $this->createDeleteForm($equipe);
        $em = $this->getDoctrine()->getManager();
        $modules = $em->getRepository('AuthBundle:Module')->findAll();

        return $this->render('equipe/show.html.twig', array(
            'equipe' => $equipe,
            'modules' => $modules,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing equipe entity.
     *
     * @Route("/{id}/edit", name="equipe_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Equipe $equipe)
    {

        $deleteForm = $this->createDeleteForm($equipe);
        $editForm = $this->createForm('AuthBundle\Form\EquipeType', $equipe);

        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {


            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('equipe_show', array('id' => $equipe->getId()));
        }

        return $this->render('equipe/new.html.twig', array(
            'equipe' => $equipe,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a equipe entity.
     *
     * @Route("/{id}", name="equipe_delete")
     * @Method("DELETE")
     */
    public function deleteAction(
        Equipe $equipe)
    {

            $em = $this->getDoctrine()->getManager();
            $em->remove($equipe);
            $em->flush();


        return $this->redirectToRoute('equipe_index');
    }

    /**
     * Creates a form to delete a equipe entity.
     *
     * @param Equipe $equipe The equipe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Equipe $equipe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('equipe_delete', array('id' => $equipe->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
