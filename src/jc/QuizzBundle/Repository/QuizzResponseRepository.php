<?php

namespace jc\QuizzBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * QuizzResponseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuizzResponseRepository extends EntityRepository {

    /**
     * Allows to check if response match for quizz
     * @param string $response Response we check if exist for quizz.
     * @param int $quizzId Quizz we are searching for responses.
     * @return Array of responses matching specified paramters (as  QuizzResponse)
     */
    public function searchMatchingResponseForQuizzId($response, $quizzId) {

        try {

            $queryBuilder = $this->createQueryBuilder('qr');
            $queryBuilder = $queryBuilder->join('qr.quizz', 'q')
                ->where('q.id = :quizzId')
                ->setParameter('quizzId', $quizzId)
                ->andWhere('qr.responses LIKE :response')
                ->setParameter('response', "%;$response;%");

            $query = $queryBuilder->getQuery();
            return $query->getResult();
        }
        catch (\Exception $ex) {
            return null;
        }
    }

    /**
     * Allows to search response matching specified coordinates
     * @param int $positionX Quizz we are searching for responses.
     * @param int $positionY Quizz we are searching for responses.
     * @param int $quizzId Quizz we are searching for responses.
     * @return Array of responses matching specified paramters (as QuizzResponse)
     */
    public function searchMatchingResponseWithCoordonate($coordonateX, $coordonateY, $quizzId) {

        try {

            $queryBuilder = $this->createQueryBuilder('qr');
            $queryBuilder = $queryBuilder->join('qr.quizz', 'q')
            ->where('q.id = :quizzId')
            ->setParameter('quizzId', $quizzId)
            //->andWhere('(Pow(:coordonateX - qr.positionX, 2) + Pow(:coordonateY - qr.positionY, 2)) <= Pow(25 * POW(2, (qr.size - 1)), 2)')
            ->andWhere(':coordonateX >= qr.positionX')
            ->andWhere(':coordonateX <= qr.positionX + 25 * POW(2, (qr.size))')
            ->andWhere(':coordonateY >= qr.positionY')
            ->andWhere(':coordonateY <= qr.positionY + 25 * POW(2, (qr.size))')
            ->setParameter('coordonateX', $coordonateX)
            ->setParameter('coordonateY', $coordonateY);

            $query = $queryBuilder->getQuery();
            return $query->getResult();
        }
        catch (\Exception $ex) {
            return null;
        }
    }
}
