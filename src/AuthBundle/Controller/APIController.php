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
class APIController extends Controller {

    /**
     * @param User $user
     * @Route("api/user/{id}")
     * @Method("GET")
     * @return JsonResponse
     */
    public function getUserById(User $user, Request $request) {
        $authUser = $this->getUser();
        $noAuthMessage = $this->noAuthMessage($authUser, $request);
        if ($noAuthMessage !== null) {
            return $noAuthMessage;
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

        return new JsonResponse($response, 200);
    }

    /**
     * @Route("api/team")
     * @Method("GET")
     * @return JsonResponse 
     */
    public function getAllTeams(Request $request) {
        $authUser = $this->getUser();
        $noAuthMessage = $this->noAuthMessage($authUser, $request);
        if ($noAuthMessage !== null) {
            return $noAuthMessage;
        }
        $em = $this->getDoctrine()->getManager();       
        $teams = $em->getRepository("AuthBundle:Equipe")->findAll();
        $teamsJSON = [];
        foreach ($teams as $team) {
            $teamsJSON [] = array(
                "team" => $team->toArray()
            );
        }
        return new JsonResponse($teamsJSON, 200);
    }

    /**
     * @param Equipe $equipe
     * @Route("api/team/{id}")
     * @Method("GET")
     * @return JsonResponse
     */
    public function getUsersbyTeam(Request $request, Equipe $equipe) {
        $authUser = $this->getUser();
        $noAuthMessage = $this->noAuthMessage($authUser, $request);
        if ($noAuthMessage !== null) {
            return $noAuthMessage;
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

        return new JsonResponse($response, 200);
    }

    /**
     * @Route("api/alluser")
     * @Method("GET")
     * @return JsonResponse
     */
    public function getAllUser(Request $request) {
        $authUser = $this->getUser();
        $noAuthMessage = $this->noAuthMessage($authUser, $request);
        if ($noAuthMessage !== null) {
            return $noAuthMessage;
        }
        $em = $this->getDoctrine()->getManager();
        
        $users = $em->getRepository("AuthBundle:User")->findAll();

        $usersJson = [];
        foreach ($users as $user) {
            $usersJson[] = array(
                'user' => $user->toArray(),
            );
        }

        return new JsonResponse($usersJson, 200);
    }

    /**
     * @Route("api/authme")
     * @Method({"GET"})
     * @return JsonResponse
     */
    public function authMe() {
        $authUser = $this->getUser();
        $noAuthMessage = $this->noAuthMessage($authUser, null);
        if ($noAuthMessage !== null) {
            return $noAuthMessage;
        }
        $userJson = $authUser->toArray();


        return new JsonResponse($userJson, 200);
    }

    private function noAuthMessage($authUser, $request) {

        if ($authUser !== null) {
            return;
        } elseif ($request !== null) {
            $er = $this->getDoctrine()->getManager()->getRepository("AuthBundle:Module");
            $keyManager = $er->createQueryBuilder('m')
                    ->select('m.apiKey')
                    ->getQuery()
                    ->getResult();

            $apiKey = $request->get('apikey');
            if ($apiKey !== null && in_array($apiKey, array_column($keyManager, 'apiKey')) == true) {
                return;
            }

            return new JsonResponse(['message' => 'clé API valide nécessaire'], Response::HTTP_FORBIDDEN);
        } else {
            return new JsonResponse(['message' => 'pas authentifié'], Response::HTTP_FORBIDDEN);
        }
    }

}
