<?php

namespace AuthBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Equipe
 *
 * @ORM\Table(name="equipe")
 * @ORM\Entity(repositoryClass="AuthBundle\Repository\EquipeRepository")
 * @UniqueEntity(fields={"nom"}, message="Le nom de l'équipe est déjà utilisé")
 */
class Equipe
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
     * @var string
     * @Assert\NotBlank(message="Le champ nom doit être rempli")
     * @ORM\Column(name="nom", type="string", length=50, unique=true)
     */
    private $nom;


    /**
     * @var Date
     *
     * @ORM\Column(name="createdAt", type="datetime")
     *
     */
    private $createdAt;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AuthBundle\Entity\User", inversedBy="pilote", cascade={"persist"})
     */
    private $pilote;
    /**
     * @var ArrayCollection|TeamRole
     * @ORM\OneToMany(targetEntity="AuthBundle\Entity\TeamRole", mappedBy="equipe", cascade={"all"}, orphanRemoval=true)
     */
    private $teamRoles;
    /**
     * @var ArrayCollection|Module
     * @ORM\ManyToMany(targetEntity="AuthBundle\Entity\Module", mappedBy="equipes")
     */
    private $modules;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Equipe
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set createdAt
     *
     * @param Date $createdAt
     *
     * @return Equipe
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return Date
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teamRoles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->modules = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    /**
     * Add teamRole
     *
     * @param \AuthBundle\Entity\TeamRole $teamRole
     *
     * @return Equipe
     */
    public function addTeamRole(\AuthBundle\Entity\TeamRole $teamRole)
    {
        $teamRole->setEquipe($this);
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
     * @return ArrayCollection|TeamRole
     */
    public function getTeamRoles()
    {
        return $this->teamRoles;
    }

    /**
     * @param TeamRole|ArrayCollection $teamRoles
     */
    public function setTeamRoles($teamRoles)
    {

        $this->teamRoles = $teamRoles;
    }


    /**
     * Add module
     *
     * @param \AuthBundle\Entity\Module $module
     *
     * @return Equipe
     */
    public function addModule(\AuthBundle\Entity\Module $module)
    {
        $module->addEquipe($this);
        $this->modules[] = $module;

        return $this;
    }

    /**
     * Remove module
     *
     * @param \AuthBundle\Entity\Module $module
     */
    public function removeModule(\AuthBundle\Entity\Module $module)
    {
        $module->removeEquipe($this);
        $this->modules->removeElement($module);
    }

    /**
     * Get modules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * @return User
     */
    public function getPilote()
    {
        return $this->pilote;
    }

    /**
     * @param User $pilote
     */
    public function setPilote($pilote)
    {
        $this->pilote = $pilote;
    }




//    public function getPilote()
//    {
//        $pilote = new ArrayCollection();
//        foreach ($this->teamRoles as $teamRole){
//            if ($teamRole->getRole()->getNom() == 'pilote'){
//                $pilote->add($teamRole);
//            }
//        }
//
//        return $pilote;
//    }


    function __toString()
    {
        return $this->nom;
    }

    function toArray()
    {
        $array = array(
            'id' => $this->id,
            'name' => $this->nom,
            'createdAt' => $this->createdAt,
            'pilote' => $this->pilote->toArray(),
        )
        ;
        return $array;
    }

}
