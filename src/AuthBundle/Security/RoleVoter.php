<?php

/**
 * Created by PhpStorm.
 * User: dmetthey.stage
 * Date: 05/05/2017
 * Time: 14:50
 */

namespace AuthBundle\Security;

use AuthBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class RoleVoter extends Voter
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
        if ($attribute != 'TEAM_PILOT') {
            return false;
        }

        // if true call voteOnAttribute
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

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        return $this->isTeamPilot($user);

    }

    /**
     * @param User $user
     * @return bool
     * Check if the user is Pilot of a team
     */
    private function isTeamPilot(User $user){

            if (count($user->getPilote()) > 0) return true;

        return false;
    }
}