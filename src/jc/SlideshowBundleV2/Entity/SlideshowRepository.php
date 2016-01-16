<?php

namespace jc\SlideshowBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SlideshowRepository
 * WARNING : Request used in this repository requires jcDatabaseBundle to call specific SQL functions for dates.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SlideshowRepository extends EntityRepository {

    public function getMaxRank() {

        try {

            $query = $this->_em->createQuery('SELECT MAX(s.rank) FROM jcSlideshowBundle:Slideshow s');
            return $query->getSingleScalarResult();
        }
        catch (Exception $ex) {
            return '1';
        }
    }

    public function getAllYear() {

        try {

            $query = $this->_em->createQuery('SELECT DISTINCT year(s.date) AS year FROM jcSlideshowBundle:Slideshow s ORDER BY year DESC');
            return $query->getArrayResult();
        }
        catch (Exception $ex) {
            return array();
        }
    }

    public function getSlideshowForYear($year) {

        try {

            $query = $this->_em->createQuery('SELECT s FROM jcSlideshowBundle:Slideshow s WHERE year(s.date) = :year ORDER BY s.date DESC');
            $query->setParameter('year', $year);

            return $query->getResult();
        }
        catch (Exception $ex) {
            return array();
        }
    }
}
