<?php

namespace jc\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="jc\UserBundle\Entity\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=55, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var ArrayCollection $roles
     *
     * @ORM\ManyToMany(targetEntity="jc\UserBundle\Entity\Role", cascade={"persist"})
     * @ORM\JoinTable(name="user_role",
     *      joinColumns={@ORM\JoinColumn(name="userId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="roleId", referencedColumnName="id")}
     * )
     */
    private $internalRoles;


    public function __construct()
    {
        $this->internalRoles = new ArrayCollection();
    }

    public function eraseCredentials()
    {
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return User
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Add role to user
     *
     * @param Role $role
     * @return User
     */
    public function addRole(Role $role)
    {
        $this->internalRoles[] = $role;
        return $this;
    }

    /**
     * Remove role from user
     *
     * @param Role $role
     */
    public function removeRole(Role $role)
    {
        $this->pictures->removeElement($picture);
    }

    /**
     * Get roles
     *
     * @return ArrayCollection
     */
    public function getInternalRoles()
    {
        return $this->internalRoles;
    }

    /**
     * Method from user interface to get list of roles as simple array (code only).
     */
    public function getRoles() {

        $result = array();

        foreach ($this->internalRoles as $internalRole)
            $result[] = $internalRole->getCode();

        return $result;
    }

    /**
     * Allows to know if user is admin or not.
     * @return TRUE if current user is admin, FALSE either.
     */
    public function isAdmin() {

        foreach ($this->internalRoles as $internalRole) {

            if ($internalRole->getCode() === 'ROLE_ADMIN')
                return true;
        }

        return false;
    }
}
