<?php

namespace AuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("qub/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("team_table/")
     */
    public function indexAction()
    {
        $currentUser = $this->getUser();
        $currentTeam = new ArrayCollection();

        foreach ($currentUser->getTeamroles() as $teamrole){
            $currentTeam[] = $teamrole->getEquipe();
        }

        return $this->render('AuthBundle:Default:index.html.twig');
    }
}
