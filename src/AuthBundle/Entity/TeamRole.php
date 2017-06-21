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
     * @ORM\ManyToOne(targetEntity="AuthBundle\Entity\Role", inversedBy="teamRoles", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;
    /**
     * @var User
     * @Assert\NotNull(message="Le champ Utilisateur doit être rempli")
     *
     * @ORM\ManyToOne(targetEntity="AuthBundle\Entity\User", inversedBy="teamRoles", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    /**
     * @var Equipe
     * @Assert\NotNull(message="Le champ Equipe doit être rempli")
     *
     * @ORM\ManyToOne(targetEntity="AuthBundle\Entity\Equipe", inversedBy="teamRoles")
     * @ORM\JoinColumn(nullable=false)
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
