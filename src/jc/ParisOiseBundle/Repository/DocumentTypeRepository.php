<?php

namespace jc\ParisOiseBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * DocumentTypeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DocumentTypeRepository extends EntityRepository {

    public function getMaxRank() {

        try {

            $query = $this->_em->createQuery('SELECT MAX(dt.rank) FROM jcParisOiseBundle:DocumentType dt');
            return $query->getSingleScalarResult();
        }
        catch (Exception $ex) {
            return '1';
        }
    }
}
