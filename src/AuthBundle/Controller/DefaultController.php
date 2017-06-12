<?php

namespace AuthBundle\Controller;

use AuthBundle\Entity\Equipe;
use AuthBundle\Entity\Module;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * @Route("qub/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function redirectToChoices(){
        return $this->redirectToRoute('team_table');
    }
    /**
     * @Route("team_table/", name="team_table")
     */
    public function indexTeamTable()
    {

        $teams =  $this->getUser()->getEquipes();
        $teamsPilote = $this->getUser()->getPilote();
        foreach ($teamsPilote as $team){
            $teams->add($team);
        }
        //Redirige directement vers choix module si le user n'a qu'une équipe
        if ($teams->count() == 1){

            return $this->redirectToRoute('module_table', array(
                'equipe' => $teams->first()->getId()
            ));

        }


        return $this->render(':equipe:team_table.html.twig', array(
            'teams' => $teams
        ));
    }
    /**
     * @Route("team_table/{equipe}/module_table", name="module_table")
     */
    public function indexModuleTable(Equipe $equipe)
    {
        $modules = $equipe->getModules();
        //Redirige directement vers le module si le user n'a qu'un module
        if ($modules->count() == 1){
            return $this->redirectToRoute('goout', array(
                'equipe' => $equipe->getId(),
                'module' => $modules->first()->getId()
            ));
        }

        return $this->render(':equipe:module_table.html.twig', array(
            'modules' => $modules,
            'equipe' => $equipe
        ));
    }

    /**
     * @Route("goout/{equipe}/{module}", name="goout")
     */
    public function goOut(Equipe $equipe, Module $module)
    {
        $user = $this->getUser();
        $admin = $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN');

        //Retrouver le role de l'utilisateur dans l'equipe selectionnée
        $em = $this->getDoctrine()->getManager();
        $teamrole = $em->getRepository('AuthBundle:TeamRole')->findOneBy(array(
            "user" =>$user,
            "equipe"=>$equipe
        ));



        return $this->render('goout.html.twig', array(
            "module" =>$module,
            "equipe" =>$equipe,
            "user" =>$user,
            "role" =>$teamrole->getRole(),
            "admin"=>$admin
        ));
    }
}
