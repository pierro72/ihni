<?php

namespace AuthBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Equipe
 *
 * @ORM\Table(name="equipe")
 * @ORM\Entity(repositoryClass="AuthBundle\Repository\EquipeRepository")
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
     *
     * @ORM\Column(name="nom", type="string", length=50, unique=true)
     */
    private $nom;

    /**
     * @var Date
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;
    /**
     * @var ArrayCollection|TeamRole
     * @ORM\OneToMany(targetEntity="AuthBundle\Entity\TeamRole", mappedBy="equipe", cascade={"persist"})
     */
    private  $teamRoles;
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeamRoles()
    {
        return $this->teamRoles;
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
}
