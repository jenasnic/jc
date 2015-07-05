<?php

namespace jc\NewsBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * NewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NewsRepository extends EntityRepository
{
    public function getMaxRank()
    {
        try
        {
            $query = $this->_em->createQuery('SELECT MAX(n.rank) FROM jcNewsBundle:News n');
            return $query->getSingleScalarResult();
        }
        catch (Exception $ex) {
            return '1';
        }
    }
}