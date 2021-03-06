<?php

namespace jc\TrainingSessionBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ContactRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContactRepository extends EntityRepository {

    /**
     * Allows to count number of contacts available for training session.
     * @return Number of contacts.
     */
    public function countTrainingSessionContact() {

        try {

            $query = $this->_em->createQuery('SELECT COUNT(c) FROM jcTrainingSessionBundle:Contact c');
            return $query->getSingleScalarResult();
        }
        catch (Exception $ex) {
            return 0;
        }
    }
}
