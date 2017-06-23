<?php

namespace AuthBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Module
 *
 * @ORM\Table(name="module")
 * @ORM\Entity(repositoryClass="AuthBundle\Repository\ModuleRepository")
 */
class Module
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
     * @var string
     * @ORM\Column(name="url", type="string", length=10, unique=true)
     */
    private $url;
    /**
     * @var ArrayCollection|Equipe
     * @ORM\ManyToMany(targetEntity="AuthBundle\Entity\Equipe",inversedBy="modules", cascade={"persist"})
     */
    private $equipes;
    /**
     * @var string
     * @ORM\Column(unique=true,type="string",nullable=false, length=13)
     */
    private $apiKey;



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
     * @return Module
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
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->equipes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->apiKey = substr(md5(uniqid(rand(), true)), 0, 12);

    }

    /**
     * Add equipe
     *
     * @param \AuthBundle\Entity\Equipe $equipe
     *
     * @return Module
     */
    public function addEquipe(\AuthBundle\Entity\Equipe $equipe)
    {
        $this->equipes[] = $equipe;

        return $this;
    }

    /**
     * Remove equipe
     *
     * @param \AuthBundle\Entity\Equipe $equipe
     */
    public function removeEquipe(\AuthBundle\Entity\Equipe $equipe)
    {
        $this->equipes->removeElement($equipe);
    }

    /**
     * Get equipes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipes()
    {
        return $this->equipes;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

}
