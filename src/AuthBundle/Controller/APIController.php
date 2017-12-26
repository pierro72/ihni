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
    public function getTeamsByUserAction(User $user, Request $request)
    {


        $er = $this->getDoctrine()->getManager()->getRepository("AuthBundle:Module");
        $keyManager = $er->createQueryBuilder('m')
            ->select('m.apiKey')
            ->getQuery()
            ->getResult();

       

        $apiKey = $request->get('apikey');

        if ($apiKey == null || in_array($apiKey, array_column($keyManager, 'apiKey')) == false) {
            return new JsonResponse(['message' => 'clé API valide nécessaire'], Response::HTTP_FORBIDDEN);
        }
        if ($user == null) {
            return new JsonResponse(['message' => 'Aucun utilisateur avec cette id'], Response::HTTP_FORBIDDEN);
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
        if (!$pilotes == null) {
            foreach ($pilotes as $pilote) {
                $formatTeam[] = [
                    'equipe' => $pilote->toArray(),
                    'role' => 'pilote',
                ];
            }
        }
        $response = array(
            'info' => $user->toArray(),
            'equipes_role' => $formatTeam,

        );

        return new JsonResponse($response, 200, array('Access-Control-Allow-Origin' => '*'));

    }
    /**
     * @Route("api/team")
     * @Method("GET")
     * @return JsonResponse 
     */
    public function getAllTeams(Request $request)
    {
        $apiKey = $request->get('apikey');
        $em = $this->getDoctrine()->getManager();
        $keyManager = $em->getRepository("AuthBundle:Module")->createQueryBuilder('m')
                ->select('m.apiKey')
                ->getQuery()
                ->getResult();

        if ($apiKey == null || in_array($apiKey, array_column($keyManager, 'apiKey')) == false) {
            return new JsonResponse(['message' => 'clé API valide nécessaire'], Response::HTTP_FORBIDDEN);
        }
        
        $teams  = $em->getRepository("AuthBundle:Equipe")->findAll();
        $teamsJSON = [];
        foreach ($teams as $team){
            $teamsJSON [] = array(
                "team" => $team->toArray()
            );
        }
        return new JsonResponse($teamsJSON, 200, array('Access-Control-Allow-Origin' => '*'));
    }

    /**
     * @param Equipe $equipe
     * @Route("api/team/{id}")
     * @Method("GET")
     * @return JsonResponse
     */
    public function getUsersbyTeam(Request $request, Equipe $equipe)
    {
        $er = $this->getDoctrine()->getManager()->getRepository("AuthBundle:Module");
        $keyManager = $er->createQueryBuilder('m')
            ->select('m.apiKey')
            ->getQuery()
            ->getResult();


        $apiKey = $request->get('apikey');

        if ($apiKey == null || in_array($apiKey, array_column($keyManager, 'apiKey')) == false) {
            return new JsonResponse(['message' => 'clé API valide nécessaire'], Response::HTTP_FORBIDDEN);
        }
        if ($equipe == null) {
            return new JsonResponse(['message' => 'Aucun utilisateur avec cette id'], Response::HTTP_FORBIDDEN);
        }
        $teamRoles = $equipe->getTeamRoles();
        $users = [];
        foreach ($teamRoles as $teamRole) {
            $users[] = array(
                "user" => $teamRole->getUser()->toArray(),
                "role" => $teamRole->getRole()->getNom(),
            );
            
        }
        $users[] = array(
            "user" => $equipe->getPilote()->toArray(),
            "role" => "pilote",
        );
        $response = array(
            'info' => $equipe->toArray(),
            'users' => $users,
        );

        return new JsonResponse($response, 200, array('Access-Control-Allow-Origin' => '*'));
    }

    /**
     * @Route("api/alluser")
     * @Method("GET")
     * @return JsonResponse
     */
    public function getAllUser(Request $request)
    {
        $apiKey = $request->get('apikey');
        $em = $this->getDoctrine()->getManager();
        $keyManager = $em->getRepository("AuthBundle:Module")->createQueryBuilder('m')
            ->select('m.apiKey')
            ->getQuery()
            ->getResult();

        if ($apiKey == null || in_array($apiKey, array_column($keyManager, 'apiKey')) == false) {
            return new JsonResponse(['message' => 'clé API valide nécessaire'], Response::HTTP_FORBIDDEN);
        }


        $users = $em->getRepository("AuthBundle:User")->findAll();

        $usersJson = [];
        foreach ($users as $user) {
            $usersJson[] = array(
                'user' => $user->toArray(),
            );
        }

        return new JsonResponse($usersJson, 200, array('Access-Control-Allow-Origin' => '*'));
    }
    
    /**
     * @Route("api/authme")
     * @Method({"GET"})
     * @return JsonResponse
     */
    public function authMe(Request $request)
    {
        $session = $this->container->get('session');
        $sessionL = var_dump($session);
        
        return new JsonResponse($sessionL, 200, array('Access-Control-Allow-Origin' => '*'));
    }
}
