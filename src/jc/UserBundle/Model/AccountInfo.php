<?php

namespace jc\UserBundle\Model;

/**
 * AccountInfo
 */
class AccountInfo
{
    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $mail;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $confirmPassword;


    /**
     * Set firstname
     * @param string $firstname
     * @return AccountInfo
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get firstname
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     * @param string $lastname
     * @return AccountInfo
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Get lastname
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set mail
     * @param string $mail
     * @return AccountInfo
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set confirmPassword
     * @param string $confirmPassword
     * @return AccountInfo
     */
    public function setConfirmPassword($confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;
        return $this;
    }

    /**
     * Get confirmPassword
     * @return string 
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * Set password
     * @param string $password
     * @return AccountInfo
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
}
