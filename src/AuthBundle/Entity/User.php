<?php

namespace AuthBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\Common\PropertyChangedListener;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 * @ORM\Entity(repositoryClass="AuthBundle\Repository\UserRepository")
 * @ORM\Table(name="ihni_user")
 * @UniqueEntity(
 *     fields={"nom","prenom"},
 *     errorPath="nom",
 *     message="L'utilisateur existe déjà"
 * )
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string",length=50, nullable=true)
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
     * @ORM\Column(type="string",length=50, nullable=true)
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
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * Référence le compte USER qui a créé le compte
     * @var User
     * @ORM\ManyToOne(targetEntity="AuthBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id")
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
     * @var Equipe|ArrayCollection
     * @ORM\OneToMany(targetEntity="AuthBundle\Entity\Equipe", mappedBy="pilote")
     */
    protected $pilote;

    /**
     * @var ArrayCollection|TeamRole
     * @ORM\OneToMany(targetEntity="AuthBundle\Entity\TeamRole", mappedBy="user", cascade={"all"}, orphanRemoval=true)
     */
    protected $teamRoles;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length = 10)
     */
    protected $confirmationStatus;

    /**
     * @var Assert\Date
     * @ORM\Column(type="date", nullable=true)
     */
    protected $bornDate;

    /**
     * @var string
     * @Assert\Choice(callback= "getJobConstraints" ,message="Choisir un métier valide")
     * @ORM\Column(type="string", nullable=true)
     * 
     */
    protected $jobName;
    
    static private $jobChoices = [
        "Conseil" => [
            'Manager' => 'Manager',
            'Consultant(e) Confirmé(e)' => 'Consultant(e) Confirmé(e)',
            'Consultant(e)' => 'Consultant(e)',
            'Consultant  Junior' => 'Consultant  Junior'
        ],
        "Architecture" => [
            'Architecte SI' => 'Architecte SI',
            'Architecte Technique Confirmé(e)' => 'Architecte Technique Confirmé(e)',
            'Architecte Technique' => 'Architecte Technique'
        ],
        "Études et Développement" => [
            'Ingénieur(e) Concepteur' => 'Ingénieur(e) Concepteur',
            'Ingénieur(e) Analyste' => 'Ingénieur(e) Analyste',
            'Ingénieur(e) Études & Développement' => 'Ingénieur(e) Études & Développement',
            'Analyste Programmeur(euse)' => 'Analyste Programmeur(euse)'
        ],
        "Infrastructure  & Exploitation" => [
            'Ingénieur(e) Expert Infrastructure' => 'Ingénieur(e) Expert Infrastructure',
            'Resp. Exploitation' => 'Resp. Exploitation',
            'Ingénieur(e) Infra.' => 'Ingénieur(e) Infra.',
            'Ingénieur(e) d’exploitation' => 'Ingénieur(e) d’exploitation',
            'Analyste d’exploitation' => 'Analyste d’exploitation',
            'Administrateur infrastructure' => 'Administrateur infrastructure',
            'Analyste d’exploitation' => 'Analyste d’exploitation',
            'Administrateur(trice) infrastructure' => 'Administrateur(trice) infrastructure',
            'Technicien(ne) Infra.' => 'Technicien(ne) Infra.',
            'Pilote/Technicien(ne) d’exploitation' => 'Pilote/Technicien(ne) d’exploitation'
        ]
    ];

    /**
     * User constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->teamRoles = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->plainPassword = substr(md5(uniqid(rand(), true)), 0, 6);
        $this->confirmationToken = substr(md5(uniqid(rand(), true)), 0, 6);
        $this->confirmationStatus = "waiting";
//        $this->isAdmin = $this->isAdmin();
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return Assert\Date
     */
    public function getActiveAt() {
        return $this->activeAt;
    }

    /**
     * @param Assert\Date $activeAt
     */
    public function setActiveAt($activeAt) {
        $this->activeAt = $activeAt;
    }

    /**
     * @return Assert\Date
     */
    public function getActiveUntil() {
        return $this->activeUntil;
    }

    /**
     * @param Assert\Date $activeUntil
     */
    public function setActiveUntil($activeUntil) {
        $this->activeUntil = $activeUntil;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom) {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom() {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    /**
     * 
     * @return Assert\Date
     */
    function getBornDate() {
        return $this->bornDate;
    }

    static function  getJobChoice() {
        return User::$jobChoices;
    }

    function getJobConstraints() {
        $jobConstraints= [];
        foreach (User::$jobChoices as $jobType){
            $jobConstraints = array_merge($jobType, $jobConstraints);
        }
        dump($jobConstraints);
        return $jobConstraints;
    }
    /*
     * @return string
     */

    function getJobName() {
        return $this->jobName;
    }

    function setBornDate($bornDate) {
        $this->bornDate = $bornDate;
    }

    /**
     * 
     * @param string $jobName
     */
    function setJobName($jobName) {
        $this->jobName = $jobName;
    }

    /**
     * Set createdBy
     *
     * @param \AuthBundle\Entity\User $createdBy
     *
     * @return User
     */
    public function setCreatedBy(\AuthBundle\Entity\User $createdBy = null) {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \AuthBundle\Entity\User
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * @return string
     */
    public function getConfirmationStatus() {
        return $this->confirmationStatus;
    }

    /**
     * @param string $confirmationStatus
     */
    public function setConfirmationStatus($confirmationStatus) {
        $this->confirmationStatus = $confirmationStatus;
    }

    /**
     * @return Equipe|ArrayCollection
     */
    public function getPilote() {
        return $this->pilote;
    }

    /**
     * Add teamRole
     *
     * @param \AuthBundle\Entity\TeamRole $teamRole
     *
     * @return User
     */
    public function addTeamRole(\AuthBundle\Entity\TeamRole $teamRole) {
        $this->teamRoles[] = $teamRole;
        $teamRole->setUser($this);

        return $this;
    }

    /**
     * Remove teamRole
     *
     * @param \AuthBundle\Entity\TeamRole $teamRole
     */
    public function removeTeamRole(\AuthBundle\Entity\TeamRole $teamRole) {
        $this->teamRoles->removeElement($teamRole);
    }

    /**
     * Get teamRoles
     *
     * @return ArrayCollection|TeamRole
     */
    public function getTeamRoles() {

        return $this->teamRoles;
    }

    /**
     * Set teamRoles
     *
     * @param ArrayCollection|TeamRole $teamRoles
     *
     * @return User
     */
    public function setTeamRoles($teamRoles) {
        $this->teamRoles = $teamRoles;

        return $this;
    }

    /**
     * @return ArrayCollection|Equipe
     */
    public function getEquipes() {
        $equipes = new ArrayCollection();
        foreach ($this->teamRoles as $teamRole) {
            $equipes->add($teamRole->getEquipe());
        }

        return $equipes;
    }

//    public function getEquipesPilote(){
//        $equipes = new ArrayCollection();
//        foreach ($this->teamRoles as $teamRole){
//            if ($teamRole->getRole()->getNom() == 'pilote'){
//                $equipes->add($teamRole->getEquipe());
//            }
//        }
//        return $equipes;
//    }

    function __toString() {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * @Assert\IsTrue(message="la date d'activation doit être antérieure à la date de désactivation")
     */
    public function isAnterior() {
        if ($this->activeAt != null && $this->activeUntil != null) {
            return $this->activeAt < $this->activeUntil;
        }
    }

//  Problématique en cas d'édition
//    /**
//     * @Assert\IsTrue(message="la date d'activation doit être postérieure à la date du jour")
//     */
//    public function isAfterNow()
//    {
//        $now = new \DateTime();
//        if ($this->activeAt != null) {
//            dump($this->activeAt);
//            return $this->activeAt > $now;
//        }
//    }

    /**
     * @return bool
     */
    public function isAdmin() {

        return $this->hasRole('ROLE_ADMIN');
    }

    /**
     * @param $boolean
     * @return $this
     */
    public function setAdmin($boolean) {
        if (true === $boolean) {
            $this->addRole('ROLE_ADMIN');
        } else {
            $this->removeRole('ROLE_ADMIN');
        }

        return $this;
    }

    /**
     * Retourne les infos non critiques du User sous forme de tableau
     * @return array
     */
    public function toArray() {
        $array = array(
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'username' => $this->username,
            'mail' => $this->email,
            'admin' => $this->isAdmin(),
            'createdBy' => $this->createdBy == null ? '' : $this->createdBy->toArray(),
            'createdAt' => $this->createdAt,
            'active' => $this->enabled,
            'activeAt' => $this->activeAt,
            'activeUntil' => $this->activeUntil,
        );
        return $array;
    }

}
