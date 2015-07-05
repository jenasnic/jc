<?php

namespace jc\DoodleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DoodleReply
 *
 * @ORM\Table(name="doodleReply")
 * @ORM\Entity(repositoryClass="jc\DoodleBundle\Entity\DoodleReplyRepository")
 */
class DoodleReply
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
     * @var jc\DoodleBundle\Entity\Doodle
     *
     * @ORM\ManyToOne(targetEntity="jc\DoodleBundle\Entity\Doodle", fetch="LAZY")
     * @ORM\JoinColumn(name="doodleId", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $doodle;

    /**
     * @var jc\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="jc\UserBundle\Entity\User", fetch="EAGER")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var boolean
     *
     * @ORM\Column(name="response", type="boolean")
     */
    private $response;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;


    /**
     * Set doodle
     *
     * @param jc\DoodleBundle\Entity\Doodle $doodle
     * @return DoodleReply
     */
    public function setDoodle($doodle)
    {
        $this->doodle = $doodle;

        return $this;
    }

    /**
     * Get doodle
     *
     * @return jc\DoodleBundle\Entity\Doodle
     */
    public function getDoodle()
    {
        return $this->doodle;
    }

    /**
     * Set user
     *
     * @param jc\UserBundle\Entity\User $user
     * @return DoodleReply
     */
    public function setUser($user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return jc\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set response
     *
     * @param int $date
     * @return DoodleReply
     */
    public function setResponse($response)
    {
        $this->response = $response;
    
        return $this;
    }

    /**
     * Get response
     *
     * @return int
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return DoodleReply
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }
}
