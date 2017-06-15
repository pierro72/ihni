<?php
/**
 * Created by PhpStorm.
 * User: dmetthey.stage
 * Date: 05/05/2017
 * Time: 17:02
 */

namespace AuthBundle\Security;


use AuthBundle\Entity\Equipe;
use AuthBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TeamVoter extends Voter
{

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if ($attribute != 'TEAM_MATE'){
            return false;
        }

        if(!$subject instanceof Equipe){
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        return $this->isTeamMatePilot($user, $subject);
    }

    /**
     * @param $user
     * @param $equipe
     * @return bool
     * Vérifie si le user fait partie de l'équipe et en est le pilote
     */
    private function isTeamMatePilot(User $user, Equipe $equipe){

            if($equipe.getPilote() == $user) return true;

        return false;
    }
}