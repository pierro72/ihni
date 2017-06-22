<?php

namespace AuthBundle\Controller;

use AuthBundle\Entity\Equipe;
use AuthBundle\Entity\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends Controller
{
    /**
     * @param User $user
     * @Route("/teams/{id}")
     * @Method("GET")
     */
    public function getTeamsByUserAction(User $user){

        $teams = $user->getEquipes();

        $formatTeam = [];

        foreach ($teams as $team) {

            $formatTeam[] = [
                'id' => $team->getId(),
                'name' => $team->getName(),

            ];
        }

    }
}
