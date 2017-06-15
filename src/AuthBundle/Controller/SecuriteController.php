<?php

namespace AuthBundle\Controller;

use AuthBundle\Entity\Module;
use AuthBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class SecuriteController
 * @package AuthBundle\Controller
 * @Security("has_role ('ROLE_ADMIN')")
 * @Route("qub/ihni/securite")
 */
class SecuriteController extends Controller
{
    /**
     * @Route("/", name="reglage")
     * @Method({"POST","GET"})
     */
    public function ReglageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AuthBundle:User')->findAll();
        $modules = $em->getRepository('AuthBundle:Module')->findAll();
        $admins = array();


        foreach ($users as $user) {
            if ($user->hasRole('ROLE_ADMIN')) {
                $admins[] = $user;
            }
        }
        $data = array("admin" => $admins);


        $adminForm = $this->createForm('AuthBundle\Form\ReglageType', $data);


        $adminForm->handleRequest($request);

        if ($adminForm->isSubmitted() && $adminForm->isValid()) {
            $posts = $adminForm->get('admin')->getData();
            $difAdd = array_diff($posts, $admins);
            $difRem = array_diff($admins, $posts);

            foreach ($difAdd as $user) {
                $user->setAdmin(true);
            }
            foreach ($difRem as $user) {
                $user->setAdmin(false);
            }
            $em->flush();

            return $this->redirectToRoute('reglage');
        }

        $module = new Module();
        $form = $this->createForm('AuthBundle\Form\ModuleType', $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($module);
            $em->flush();

            return $this->redirectToRoute('reglage');
        }

        return $this->render(
            'reglage/reglage.html.twig',
            array(
                'inAdmin' => true,
                'users' => $users,
//            'admins' => $admins,
                'adminForm' => $adminForm->createView(),
                'modules' => $modules,
                'module' => $module,
                'form' => $form->createView(),
            )
        );

    }
}
