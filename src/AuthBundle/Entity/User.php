<?php

namespace AuthBundle\Entity;

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
     * @ORM\Column(type="string",length=50,nullable=true)
     */
    protected $nom;
    /**
     * @ORM\Column(type="string",length=50,nullable=true)
     */
    protected $prenom;
    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $activeAt;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $activeUntil;
    /**
     * User constructor.
     */

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}