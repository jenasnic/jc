<?php

namespace jc\ParisOiseBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ContactTypeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContactTypeRepository extends EntityRepository {

    public function getMaxRank() {

        try {

            $query = $this->_em->createQuery('SELECT MAX(c.rank) FROM jcParisOiseBundle:ContactType c');
            return $query->getSingleScalarResult();
        }
        catch (Exception $ex) {
            return '1';
        }
    }
}