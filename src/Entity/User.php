<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class User
{
    /**
     * @var int
     * @ORM\GeneratedValue()
     * @ORM\Id()
     * @ORM\Column(type=integer)
     */
    public $id;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true)
     */
    public $username;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public $password;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public $firstname;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public $lastname;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true, nullable=true)
     */
    public $email;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public $birthday;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public $created;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public $updated;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public $role;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    public $active;
}