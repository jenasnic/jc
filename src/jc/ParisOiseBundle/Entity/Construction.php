<?php

namespace jc\ParisOiseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Construction
 *
 * @ORM\Table(name="construction")
 * @ORM\Entity(repositoryClass="jc\ParisOiseBundle\Repository\ConstructionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Construction
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
     * @ORM\Column(name="reference", type="string", length=55, unique=true)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname1", type="string", length=255, nullable=true)
     */
    private $firstname1;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname1", type="string", length=255, nullable=true)
     */
    private $lastname1;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate1", type="datetime", nullable=true)
     */
    private $birthDate1;

    /**
     * @var string
     *
     * @ORM\Column(name="birthPlace1", type="string", length=255, nullable=true)
     */
    private $birthPlace1;

    /**
     * @var string
     *
     * @ORM\Column(name="nationality1", type="string", length=55, nullable=true)
     */
    private $nationality1;

    /**
     * @var string
     *
     * @ORM\Column(name="job1", type="string", length=255, nullable=true)
     */
    private $job1;

    /**
     * @var string
     *
     * @ORM\Column(name="phone1", type="string", length=55, nullable=true)
     */
    private $phone1;

    /**
     * @var string
     *
     * @ORM\Column(name="mail1", type="string", length=255, nullable=true)
     */
    private $mail1;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname2", type="string", length=255, nullable=true)
     */
    private $firstname2;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname2", type="string", length=255, nullable=true)
     */
    private $lastname2;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate2", type="datetime", nullable=true)
     */
    private $birthDate2;

    /**
     * @var string
     *
     * @ORM\Column(name="birthPlace2", type="string", length=255, nullable=true)
     */
    private $birthPlace2;

    /**
     * @var string
     *
     * @ORM\Column(name="nationality2", type="string", length=55, nullable=true)
     */
    private $nationality2;

    /**
     * @var string
     *
     * @ORM\Column(name="job2", type="string", length=255, nullable=true)
     */
    private $job2;

    /**
     * @var string
     *
     * @ORM\Column(name="phone2", type="string", length=55, nullable=true)
     */
    private $phone2;

    /**
     * @var string
     *
     * @ORM\Column(name="mail2", type="string", length=255, nullable=true)
     */
    private $mail2;

    /**
     * @var string
     *
     * @ORM\Column(name="customerUnion", type="string", length=55)
     */
    private $customerUnion;

    /**
     * @var string
     *
     * @ORM\Column(name="customerStreet1", type="string", length=255, nullable=true)
     */
    private $customerStreet1;

    /**
     * @var string
     *
     * @ORM\Column(name="customerStreet2", type="string", length=255, nullable=true)
     */
    private $customerStreet2;

    /**
     * @var string
     *
     * @ORM\Column(name="customerZip", type="string", length=10, nullable=true)
     */
    private $customerZip;

    /**
     * @var string
     *
     * @ORM\Column(name="customerCity", type="string", length=55, nullable=true)
     */
    private $customerCity;

    /**
     * @var string
     *
     * @ORM\Column(name="constructionStreet1", type="string", length=255, nullable=true)
     */
    private $constructionStreet1;

    /**
     * @var string
     *
     * @ORM\Column(name="constructionStreet2", type="string", length=255, nullable=true)
     */
    private $constructionStreet2;

    /**
     * @var string
     *
     * @ORM\Column(name="constructionZip", type="string", length=10, nullable=true)
     */
    private $constructionZip;

    /**
     * @var string
     *
     * @ORM\Column(name="constructionCity", type="string", length=55, nullable=true)
     */
    private $constructionCity;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="depositDate1", type="datetime", nullable=true)
     */
    private $depositDate1;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="depositDate2", type="datetime", nullable=true)
     */
    private $depositDate2;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validateDate", type="datetime", nullable=true)
     */
    private $validateDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="signDate", type="datetime", nullable=true)
     */
    private $signDate;

    /**
     * @var ArrayCollection $contacts
     *
     * @ORM\OneToMany(targetEntity="Contact", mappedBy="construction", cascade={"persist", "remove"})
     */
    private $contacts;


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
     * Set reference
     *
     * @param string $reference
     * @return Construction
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set firstname1
     *
     * @param string $firstname1
     * @return Construction
     */
    public function setFirstname1($firstname1)
    {
        $this->firstname1 = $firstname1;

        return $this;
    }

    /**
     * Get firstname1
     *
     * @return string
     */
    public function getFirstname1()
    {
        return $this->firstname1;
    }

    /**
     * Set lastname1
     *
     * @param string $lastname1
     * @return Construction
     */
    public function setLastname1($lastname1)
    {
        $this->lastname1 = $lastname1;

        return $this;
    }

    /**
     * Get lastname1
     *
     * @return string
     */
    public function getLastname1()
    {
        return $this->lastname1;
    }

    /**
     * Set birthDate1
     *
     * @param \DateTime $birthDate1
     * @return Construction
     */
    public function setBirthDate1($birthDate1)
    {
        $this->birthDate1 = $birthDate1;

        return $this;
    }

    /**
     * Get birthDate1
     *
     * @return \DateTime
     */
    public function getBirthDate1()
    {
        return $this->birthDate1;
    }

    /**
     * Set birthPlace1
     *
     * @param string $birthPlace1
     * @return Construction
     */
    public function setBirthPlace1($birthPlace1)
    {
        $this->birthPlace1 = $birthPlace1;

        return $this;
    }

    /**
     * Get birthPlace1
     *
     * @return string
     */
    public function getBirthPlace1()
    {
        return $this->birthPlace1;
    }

    /**
     * Set nationality1
     *
     * @param string $nationality1
     * @return Construction
     */
    public function setNationality1($nationality1)
    {
        $this->nationality1 = $nationality1;

        return $this;
    }

    /**
     * Get nationality1
     *
     * @return string
     */
    public function getNationality1()
    {
        return $this->nationality1;
    }

    /**
     * Set job1
     *
     * @param string $job1
     * @return Construction
     */
    public function setJob1($job1)
    {
        $this->job1 = $job1;

        return $this;
    }

    /**
     * Get job1
     *
     * @return string
     */
    public function getJob1()
    {
        return $this->job1;
    }

    /**
     * Set phone1
     *
     * @param string $phone1
     * @return Construction
     */
    public function setPhone1($phone1)
    {
        $this->phone1 = $phone1;

        return $this;
    }

    /**
     * Get phone1
     *
     * @return string
     */
    public function getPhone1()
    {
        return $this->phone1;
    }

    /**
     * Set mail1
     *
     * @param string $mail1
     * @return Construction
     */
    public function setMail1($mail1)
    {
        $this->mail1 = $mail1;

        return $this;
    }

    /**
     * Get mail1
     *
     * @return string
     */
    public function getMail1()
    {
        return $this->mail1;
    }

    /**
     * Set firstname2
     *
     * @param string $firstname2
     * @return Construction
     */
    public function setFirstname2($firstname2)
    {
        $this->firstname2 = $firstname2;

        return $this;
    }

    /**
     * Get firstname2
     *
     * @return string
     */
    public function getFirstname2()
    {
        return $this->firstname2;
    }

    /**
     * Set lastname2
     *
     * @param string $lastname2
     * @return Construction
     */
    public function setLastname2($lastname2)
    {
        $this->lastname2 = $lastname2;

        return $this;
    }

    /**
     * Get lastname2
     *
     * @return string
     */
    public function getLastname2()
    {
        return $this->lastname2;
    }

    /**
     * Set birthDate2
     *
     * @param \DateTime $birthDate2
     * @return Construction
     */
    public function setBirthDate2($birthDate2)
    {
        $this->birthDate2 = $birthDate2;

        return $this;
    }

    /**
     * Get birthDate2
     *
     * @return \DateTime
     */
    public function getBirthDate2()
    {
        return $this->birthDate2;
    }

    /**
     * Set birthPlace2
     *
     * @param string $birthPlace2
     * @return Construction
     */
    public function setBirthPlace2($birthPlace2)
    {
        $this->birthPlace2 = $birthPlace2;

        return $this;
    }

    /**
     * Get birthPlace2
     *
     * @return string
     */
    public function getBirthPlace2()
    {
        return $this->birthPlace2;
    }

    /**
     * Set nationality2
     *
     * @param string $nationality2
     * @return Construction
     */
    public function setNationality2($nationality2)
    {
        $this->nationality2 = $nationality2;

        return $this;
    }

    /**
     * Get nationality2
     *
     * @return string
     */
    public function getNationality2()
    {
        return $this->nationality2;
    }

    /**
     * Set job2
     *
     * @param string $job2
     * @return Construction
     */
    public function setJob2($job2)
    {
        $this->job2 = $job2;

        return $this;
    }

    /**
     * Get job2
     *
     * @return string
     */
    public function getJob2()
    {
        return $this->job2;
    }

    /**
     * Set phone2
     *
     * @param string $phone2
     * @return Construction
     */
    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;

        return $this;
    }

    /**
     * Get phone2
     *
     * @return string
     */
    public function getPhone2()
    {
        return $this->phone2;
    }

    /**
     * Set mail2
     *
     * @param string $mail2
     * @return Construction
     */
    public function setMail2($mail2)
    {
        $this->mail2 = $mail2;

        return $this;
    }

    /**
     * Get mail2
     *
     * @return string
     */
    public function getMail2()
    {
        return $this->mail2;
    }

    /**
     * Set customerUnion
     *
     * @param string $customerUnion
     * @return Construction
     */
    public function setCustomerUnion($customerUnion)
    {
        $this->customerUnion = $customerUnion;

        return $this;
    }

    /**
     * Get customerUnion
     *
     * @return string
     */
    public function getCustomerUnion()
    {
        return $this->customerUnion;
    }

    /**
     * Set customerStreet1
     *
     * @param string $customerStreet1
     * @return Construction
     */
    public function setCustomerStreet1($customerStreet1)
    {
        $this->customerStreet1 = $customerStreet1;

        return $this;
    }

    /**
     * Get customerStreet1
     *
     * @return string
     */
    public function getCustomerStreet1()
    {
        return $this->customerStreet1;
    }

    /**
     * Set customerStreet2
     *
     * @param string $customerStreet2
     * @return Construction
     */
    public function setCustomerStreet2($customerStreet2)
    {
        $this->customerStreet2 = $customerStreet2;

        return $this;
    }

    /**
     * Get customerStreet2
     *
     * @return string
     */
    public function getCustomerStreet2()
    {
        return $this->customerStreet2;
    }

    /**
     * Set customerZip
     *
     * @param string $customerZip
     * @return Construction
     */
    public function setCustomerZip($customerZip)
    {
        $this->customerZip = $customerZip;

        return $this;
    }

    /**
     * Get customerZip
     *
     * @return string
     */
    public function getCustomerZip()
    {
        return $this->customerZip;
    }

    /**
     * Set customerCity
     *
     * @param string $customerCity
     * @return Construction
     */
    public function setCustomerCity($customerCity)
    {
        $this->customerCity = $customerCity;

        return $this;
    }

    /**
     * Get customerCity
     *
     * @return string
     */
    public function getCustomerCity()
    {
        return $this->customerCity;
    }

    /**
     * Set constructionStreet1
     *
     * @param string $constructionStreet1
     * @return Construction
     */
    public function setConstructionStreet1($constructionStreet1)
    {
        $this->constructionStreet1 = $constructionStreet1;

        return $this;
    }

    /**
     * Get constructionStreet1
     *
     * @return string
     */
    public function getConstructionStreet1()
    {
        return $this->constructionStreet1;
    }

    /**
     * Set constructionStreet2
     *
     * @param string $constructionStreet2
     * @return Construction
     */
    public function setConstructionStreet2($constructionStreet2)
    {
        $this->constructionStreet2 = $constructionStreet2;

        return $this;
    }

    /**
     * Get constructionStreet2
     *
     * @return string
     */
    public function getConstructionStreet2()
    {
        return $this->constructionStreet2;
    }

    /**
     * Set constructionZip
     *
     * @param string $constructionZip
     * @return Construction
     */
    public function setConstructionZip($constructionZip)
    {
        $this->constructionZip = $constructionZip;

        return $this;
    }

    /**
     * Get constructionZip
     *
     * @return string
     */
    public function getConstructionZip()
    {
        return $this->constructionZip;
    }

    /**
     * Set constructionCity
     *
     * @param string $constructionCity
     * @return Construction
     */
    public function setConstructionCity($constructionCity)
    {
        $this->constructionCity = $constructionCity;

        return $this;
    }

    /**
     * Get constructionCity
     *
     * @return string
     */
    public function getConstructionCity()
    {
        return $this->constructionCity;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Construction
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set depositDate1
     *
     * @param \DateTime $depositDate1
     * @return Construction
     */
    public function setDepositDate1($depositDate1)
    {
        $this->depositDate1 = $depositDate1;

        return $this;
    }

    /**
     * Get depositDate1
     *
     * @return \DateTime
     */
    public function getDepositDate1()
    {
        return $this->depositDate1;
    }

    /**
     * Set depositDate2
     *
     * @param \DateTime $depositDate2
     * @return ContactNotary
     */
    public function setDepositDate2($depositDate2)
    {
        $this->depositDate2 = $depositDate2;

        return $this;
    }

    /**
     * Get depositDate2
     *
     * @return \DateTime
     */
    public function getDepositDate2()
    {
        return $this->depositDate2;
    }

    /**
     * Set validateDate
     *
     * @param \DateTime $validateDate
     * @return ContactNotary
     */
    public function setValidateDate($validateDate)
    {
        $this->validateDate = $validateDate;

        return $this;
    }

    /**
     * Get validateDate
     *
     * @return \DateTime
     */
    public function getValidateDate()
    {
        return $this->validateDate;
    }

    /**
     * Set signDate
     *
     * @param \DateTime $signDate
     * @return ContactNotary
     */
    public function setSignDate($signDate)
    {
        $this->signDate = $signDate;

        return $this;
    }

    /**
     * Get signDate
     *
     * @return \DateTime
     */
    public function getSignDate()
    {
        return $this->signDate;
    }

    /**
     * Add contact to construction
     *
     * @param Contact $picture
     * @return Construction
     */
    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;
        $contact->setConstruction($this);
        return $this;
    }

    /**
     * Remove contact from construction
     *
     * @param Contact $contact
     */
    public function removeContact(Contact $contact)
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * Get contact list
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Get customer display name (for IHM)
     *
     * @return string
     */
    public function getCustomerDisplayName()
    {
        $customerName1 = $this->firstname1 . ' ' . $this->lastname1;
        $customerName2 = $this->firstname2 . ' ' . $this->lastname2;

        if (strlen($customerName1) == 1)
            return $customerName2;
        else if (strlen($customerName2) == 1)
            return $customerName1;
        else return $customerName1 . ' / ' . $customerName2;
    }

    /**
     * @ORM\PostLoad
     */
    public function sortContacts() {

        // Sort contacts depending on type (using rank)
        $iterator = $this->contacts->getIterator();
        $iterator->uasort(function ($first, $second) {
            return (int)$first->getType()->getRank() > (int)$second->getType()->getRank() ? 1 : -1;
        });

        $this->contacts = new ArrayCollection(iterator_to_array($iterator));
    }
}
