<?php

namespace AuthBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="string",length=50,nullable=false)
     * @Assert\NotBlank(message="Entrez le nom du nouvel utilisateur.",groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min = 3,
     *     max = 50,
     *     minMessage="Le nom doit comporter au moins 3 caractères",
     *     maxMessage="Le nom doit comporter moins de 50 caractères",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $nom;
    /**
     * @var string
     * @ORM\Column(type="string",length=50,nullable=false)
     * @Assert\NotBlank(message="Entrez le prénom du nouvel utilisateur.",groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min = 3,
     *     max = 50,
     *     minMessage="Le prénom doit comporter au moins 3 caractères",
     *     maxMessage="Le prénom doit comporter moins de 50 caractères",
     *     groups={"Registration", "Profile"}
     * )
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
     * @ORM\Column(nullable=true)
     */
    protected $createdBy;
    /**
     * @var Assert\Date
     * @ORM\Column(type="date", nullable=true)
     */
    protected $activeAt;
    /**
     * @var Assert\Date

     * @ORM\Column(type="date", nullable=true)
     */
    protected $activeUntil;
    /**
     * @var ArrayCollection|TeamRole
     * @ORM\OneToMany(targetEntity="AuthBundle\Entity\TeamRole", mappedBy="user", cascade={"all"}, orphanRemoval=true)

     */
    protected $teamRoles;
    /**
     * User constructor.
     */

    public function __construct()
    {
        parent::__construct();
        $this->teamRoles = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Assert\Date
     */
    public function getActiveAt()
    {
        return $this->activeAt;
    }

    /**
     * @param Assert\Date $activeAt
     */
    public function setActiveAt($activeAt)
    {
        $this->activeAt = $activeAt;
    }

    /**
     * @return Assert\Date
     */
    public function getActiveUntil()
    {
        return $this->activeUntil;
    }

    /**
     * @param Assert\Date $activeUntil
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
        $teamRole->setUser($this);

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
     * @return ArrayCollection|TeamRole
     */
    public function getTeamRoles()
    {
        return $this->teamRoles;
    }

    /**
     * Set teamRoles
     *
     * @param ArrayCollection|TeamRole $teamRoles
     *
     * @return User
     */
    public function setTeamRoles($teamRoles)
    {
        $this->teamRoles = $teamRoles;

        return $this;
    }

    function __toString()
    {
        return $this->nom.' '.$this->prenom;
    }

    /**
     * @Assert\IsTrue(message="la date d'activation doit être antérieure à la date de désactivation")
     */
    public function isAnterior(){
        return $this->activeAt < $this->activeUntil;
    }

    /**
     * @Assert\IsTrue(message="la date d'activation doit être postérieure à la date du jour")
     */
    public function isAfterNow(){
        $now =  new \DateTime();
        return $this->activeAt > $now;
    }


}
