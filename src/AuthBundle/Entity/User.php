<?php

namespace AuthBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
/**
 * @ORM\Entity
 * @ORM\Table(name="ihni_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string",length=50,nullable=true)
     */
    protected $nom;
    /**
     * @var string
     * @ORM\Column(type="string",length=50,nullable=true)
     */
    protected $prenom;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;
    /**
     * Référence le compte USER qui a créé le compte
     * @var User
     * @ORM\ManyToOne(targetEntity="AuthBundle\Entity\User")
     */
    protected $createdBy;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $activeAt;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $activeUntil;
    /**
     * @var ArrayCollection|TeamRole
     * @ORM\OneToMany(targetEntity="AuthBundle\Entity\TeamRole", mappedBy="user")
     */
    private $teamRoles;
    /**
     * User constructor.
     */

    public function __construct()
    {
        parent::__construct();
        $this->teamRoles = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getActiveAt()
    {
        return $this->activeAt;
    }

    /**
     * @param \DateTime $activeAt
     */
    public function setActiveAt($activeAt)
    {
        $this->activeAt = $activeAt;
    }

    /**
     * @return \DateTime
     */
    public function getActiveUntil()
    {
        return $this->activeUntil;
    }

    /**
     * @param \DateTime $activeUntil
     */
    public function setActiveUntil($activeUntil)
    {
        $this->activeUntil = $activeUntil;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }




    /**
     * Set createdBy
     *
     * @param \AuthBundle\Entity\User $createdBy
     *
     * @return User
     */
    public function setCreatedBy(\AuthBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \AuthBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Add teamRole
     *
     * @param \AuthBundle\Entity\TeamRole $teamRole
     *
     * @return User
     */
    public function addTeamRole(\AuthBundle\Entity\TeamRole $teamRole)
    {
        $this->teamRoles[] = $teamRole;

        return $this;
    }

    /**
     * Remove teamRole
     *
     * @param \AuthBundle\Entity\TeamRole $teamRole
     */
    public function removeTeamRole(\AuthBundle\Entity\TeamRole $teamRole)
    {
        $this->teamRoles->removeElement($teamRole);
    }

    /**
     * Get teamRoles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeamRoles()
    {
        return $this->teamRoles;
    }
}
