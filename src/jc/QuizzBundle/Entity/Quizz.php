<?php

namespace jc\QuizzBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Quizz
 *
 * @ORM\Table(name="quizz")
 * @ORM\Entity(repositoryClass="jc\QuizzBundle\Repository\QuizzRepository")
 */
class Quizz
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="displayResponse", type="boolean")
     */
    private $displayResponse;

    /**
     * @var boolean
     *
     * @ORM\Column(name="displayTrick", type="boolean")
     */
    private $displayTrick;

    /**
     * @var string
     *
     * @ORM\Column(name="pictureUrl", type="text")
     */
    private $pictureUrl;

    /**
     * Additional property used to upload file for picture
     */
    private $pictureFile;

    /**
     * @var ArrayCollection $responses
     *
     * @ORM\OneToMany(targetEntity="QuizzResponse", mappedBy="quizz", cascade={"remove"})
     * @ORM\OrderBy({"title" = "ASC"})
     */
    private $responses;


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
     * Set name
     *
     * @param string $name
     * @return Quizz
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set displayResponse
     *
     * @param boolean $displayResponse
     * @return Quizz
     */
    public function setDisplayResponse($displayResponse)
    {
        $this->displayResponse = $displayResponse;

        return $this;
    }

    /**
     * Get displayResponse
     *
     * @return boolean
     */
    public function getDisplayResponse()
    {
        return $this->displayResponse;
    }

    /**
     * Set displayTrick
     *
     * @param boolean $displayTrick
     * @return Quizz
     */
    public function setDisplayTrick($displayTrick)
    {
        $this->displayTrick = $displayTrick;

        return $this;
    }

    /**
     * Get displayTrick
     *
     * @return boolean
     */
    public function getDisplayTrick()
    {
        return $this->displayTrick;
    }

    /**
     * Set pictureUrl
     *
     * @param string $pictureUrl
     * @return Quizz
     */
    public function setPictureUrl($pictureUrl)
    {
        $this->pictureUrl = $pictureUrl;

        return $this;
    }

    /**
     * Get pictureUrl
     *
     * @return string
     */
    public function getPictureUrl()
    {
        return $this->pictureUrl;
    }

    /**
     * Add response to quizz
     *
     * @param QuizzResponse $response
     * @return Quizz
     */
    public function addResponse(QuizzResponse $response)
    {
        $this->responses[] = $response;
        return $this;
    }

    /**
     * Remove response from quizz
     *
     * @param QuizzResponse $response
     */
    public function removeResponse(QuizzResponse $response)
    {
        $this->responses->removeElement($response);
    }

    /**
     * Get response list
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * Set file
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $pictureFile
     * @return Quizz
     */
    public function setPictureFile($pictureFile)
    {
        $this->pictureFile = $pictureFile;

        return $this;
    }

    /**
     * Get picture file
     *
     * @return Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getPictureFile()
    {
        return $this->pictureFile;
    }
}
