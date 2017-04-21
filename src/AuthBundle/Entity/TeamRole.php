<?php

namespace AuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TeamRole
 *
 * @ORM\Table(name="team_role")
 * @ORM\Entity(repositoryClass="AuthBundle\Repository\TeamRoleRepository")
 */
class TeamRole
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var Role
     * @ORM\ManyToOne(targetEntity="AuthBundle\Entity\Role")
     */
    private $role;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AuthBundle\Entity\User", inversedBy="teamRoles")
     */
    private $user;
    /**
     * @var Equipe
     * @ORM\ManyToOne(targetEntity="AuthBundle\Entity\Equipe", inversedBy="teamRoles")
     */
    private $equipe;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \AuthBundle\Entity\User $user
     *
     * @return TeamRole
     */
    public function setUser(\AuthBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AuthBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set equipe
     *
     * @param \AuthBundle\Entity\Equipe $equipe
     *
     * @return TeamRole
     */
    public function setEquipe(\AuthBundle\Entity\Equipe $equipe = null)
    {
        $this->equipe = $equipe;

        return $this;
    }

    /**
     * Get equipe
     *
     * @return \AuthBundle\Entity\Equipe
     */
    public function getEquipe()
    {
        return $this->equipe;
    }

    /**
     * Set role
     *
     * @param \AuthBundle\Entity\Role $role
     *
     * @return TeamRole
     */
    public function setRole(\AuthBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \AuthBundle\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }
}
