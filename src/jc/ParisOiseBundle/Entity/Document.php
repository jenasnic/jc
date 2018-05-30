<?php

namespace jc\ParisOiseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Document
 *
 * @ORM\Table(name="document")
 * @ORM\Entity(repositoryClass="jc\ParisOiseBundle\Repository\DocumentRepository")
 */
class Document
{
    const STATUS_START = 0;
    const STATUS_ARTISAN = 1;
    const STATUS_SEND = 2;
    const STATUS_RECEIVED = 3;
    const STATUS_BANK = 4;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var Construction
     *
     * @ORM\ManyToOne(targetEntity="jc\ParisOiseBundle\Entity\Construction", inversedBy="contacts")
     * @ORM\JoinColumn(name="construction_id", nullable=false)
     */
    private $construction;

    /**
     * @var DocumentType
     *
     * @ORM\ManyToOne(targetEntity="jc\ParisOiseBundle\Entity\DocumentType")
     * @ORM\JoinColumn(name="type_id", nullable=false)
     */
    private $type;

    /**
     * @var ArrayCollection $files
     *
     * @ORM\OneToMany(targetEntity="DocumentFile", mappedBy="document", cascade={"remove"})
     * @ORM\OrderBy({"uploadDate" = "ASC"})
     */
    private $files;


    public function __construct()
    {
        $this->pictures = new ArrayCollection();
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
     * Set status
     *
     * @param integer $status
     * @return Document
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set construction
     *
     * @param jc\ParisOiseBundle\Construction $construction
     * @return Contact
     */
    public function setConstruction($construction)
    {
        $this->construction = $construction;

        return $this;
    }

    /**
     * Get construction
     *
     * @return jc\ParisOiseBundle\Construction
     */
    public function getConstruction()
    {
        return $this->construction;
    }

    /**
     * Set type
     *
     * @param jc\ParisOiseBundle\DocumentType $type
     * @return Contact
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return jc\ParisOiseBundle\DocumentType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add file to Document
     *
     * @param DocumentFile $file
     * @return Document
     */
    public function addFile(DocumentFile $file)
    {
        $this->pictures[] = $file;
        $file->setDocument($this);
        return $this;
    }

    /**
     * Remove file from files
     *
     * @param DocumentFile $file
     */
    public function removeFile(DocumentFile $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * Get file list
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Get status display name (for IHM)
     *
     * @return string
     */
    public function getStatusDisplayName()
    {
        switch ($this->status) {
            case self::STATUS_START :
                return 'JC3M';
            case self::STATUS_ARTISAN :
                return 'Artisan';
            case self::STATUS_SEND :
                return 'Envoyé';
            case self::STATUS_RECEIVED :
                return 'Reçu';
            case self::STATUS_BANK :
                return 'Banque';
            default :
                return 'Erreur';
        }
    }
}
