<?php

namespace jc\QuizzBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * WinnerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class WinnerRepository extends EntityRepository
{
    /**
     * Allows to get all winner for specified quizz identifier.
     * @param int $quizzId Quizz we are searching for responses.
     * @return Array of winner for specified quizz (as Winner).
     */
    public function getWinnerForQuizzId($quizzId) {

        try {

            $queryBuilder = $this->createQueryBuilder('w');
            $queryBuilder = $queryBuilder->join('w.quizz', 'q')
                    ->where('q.id = :quizzId')
                    ->setParameter('quizzId', $quizzId);

            $query = $queryBuilder->getQuery();
            return $query->getResult();
        }
        catch (Exception $ex) {
            return null;
        }
    }

    /**
     * Allows to get clear winner list for specified quizz identifier.
     * @param int $quizzId Quizz we want to clear winner list.
     * @return TRUE in case of success, FALSE either.
     */
    public function removeWinnerForQuizzId($quizzId) {

        try {

            $winnerList = $this->getWinnerForQuizzId($quizzId);

            foreach ($winnerList as $winner)
                $this->_em->remove($winner);

            $this->_em->flush();

            /*$queryBuilder = $this->createQueryBuilder('w');
            $queryBuilder
                    ->delete('jcQuizzBundle:Winner', 'w')
                    ->join('w.quizz', 'q')
                    ->where('q.id = :quizzId')
                    ->setParameter('quizzId', $quizzId)
                    ;

            $query = $queryBuilder->getQuery();
            $query->execute();*/

            return true;
        }
        catch (Exception $ex) {
            return false;
        }
    }
}
