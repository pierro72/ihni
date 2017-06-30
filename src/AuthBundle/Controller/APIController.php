<?php

namespace AuthBundle\Controller;

use AuthBundle\Entity\Equipe;
use AuthBundle\Entity\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * API Controller
 
 */
class APIController extends Controller
{
    /**
     * @param User $user
     * @Route("api/user/{id}")
     * @Method("GET")

     * @return JsonResponse
     */
    public function getTeamsByUserAction(User $user, Request $request){


        $er = $this->getDoctrine()->getManager()->getRepository("AuthBundle:Module");
        $keyManager = $er->createQueryBuilder('m')
            ->select('m.apiKey')
            ->getQuery()
            ->getResult();


        $apiKey = $request->get('apikey');

        if ($apiKey == null || array_search($apiKey, array_column($keyManager,'apiKey')) == false){
            return new JsonResponse(['message' => 'clé API valide nécessaire'], Response::HTTP_NOT_FOUND);
        }
        if($user == null){
            return new JsonResponse(['message' => 'Aucun utilisateur avec cette id'], Response::HTTP_NOT_FOUND);
        }

        $teamRoles = $user->getTeamRoles();
        $formatTeam = [];
        foreach ($teamRoles as $teamRole) {
            $formatTeam[] = [
                'equipe' => $teamRole->getEquipe()->toArray(),
                'role' => $teamRole->getRole()->getNom(),
            ];
        }
        $pilotes = $user->getPilote();
        if(!$pilotes == null){
            foreach ($pilotes as $pilote){
                $formatTeam[] = [
                    'equipe' => $pilote->toArray(),
                    'role' => 'pilote'
                ];
            }
        }
        $response = array(
            'info' => $user->toArray(),
            'equipes_role' => $formatTeam,

        );

        return new JsonResponse($response,200,array('Access-Control-Allow-Origin'=> '*'));

    }
    /**
     * @param Equipe $equipe
     * @Route("api/team/{id}")
     * @Method("GET")
     * @return JsonResponse
     */
    public function getUsersbyTeam(Request $request, Equipe $equipe){
        $er = $this->getDoctrine()->getManager()->getRepository("AuthBundle:Module");
        $keyManager = $er->createQueryBuilder('m')
            ->select('m.apiKey')
            ->getQuery()
            ->getResult();


        $apiKey = $request->get('apikey');

        if ($apiKey == null || array_search($apiKey, array_column($keyManager,'apiKey')) == false){
            return new JsonResponse(['message' => 'clé API valide nécessaire'], Response::HTTP_NOT_FOUND);
        }
        if($equipe == null){
            return new JsonResponse(['message' => 'Aucun utilisateur avec cette id'], Response::HTTP_NOT_FOUND);
        }
        $teamRoles = $equipe->getTeamRoles();
        $users = [];
        foreach ($teamRoles as $teamRole){
            $users[]= array(
               "user" => $teamRole->getUser()->toArray(),
                "role"=> $teamRole->getRole()->getNom()
            );
        }
        $response = array(
            'info' => $equipe->toArray(),
            'users' => $users
        );

        return new JsonResponse($response,200,array('Access-Control-Allow-Origin'=> '*'));
    }
}
