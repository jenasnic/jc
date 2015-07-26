<?php

namespace jc\ToolBundle\Service;

use Doctrine\ORM\EntityManager;
use jc\ToolBundle\Service\Model\PaginationInformation;
use Doctrine\ORM\Query\Expr;

class PaginationService {

    private $entityManager;
    private $paginationCount;

    public function __construct(EntityManager $entityManager, $paginationCount) {

        $this->entityManager = $entityManager;
        $this->paginationCount = $paginationCount;
    }

    /**
     * Allows to get pagination information for specified entity.
     * @param integer $page Page we want to get (matching current pagination).
     * @param String $entityName Name of entity we want to get pagiantion information.
     * @param String $orderField Optional field to sort result items.
     * @param String $orderValue Optional field to define sort order to use (if result items are sorted).
     * @param array $filters Optional filters as array (field name as key, filter value as value).
     * @return PaginationInformation matching specified parameters.
     */
    public function getPaginationInformation($page, $entityName, $orderField = null, $orderValue = null, $filters = null) {

        try {

            // Count total item defined for specifed entity
            $queryCount = $this->entityManager->getRepository($entityName)->createQueryBuilder('e');
            $queryCount->select('COUNT(e.id)');

            // Add filters
            $this->addConditionToQueryBuilder($queryCount, $filters);

            $totalCount = $queryCount->getQuery()->getSingleScalarResult();

            // Prepare request to get all entities using optional sort field
            $queryBuilder = $this->entityManager->getRepository($entityName)->createQueryBuilder('e');
            if (!empty($orderField) && !empty($orderValue))
                $queryBuilder->addOrderBy('e.' . $orderField, $orderValue);

            // Add filters
            $this->addConditionToQueryBuilder($queryBuilder, $filters);

            // Add pagination parameter
            $startIndex = ($page - 1) * $this->paginationCount;
            $queryBuilder->setFirstResult($startIndex)->setMaxResults($this->paginationCount);

            $itemList = $queryBuilder->getQuery()->getResult();

            $pageCount = (int)($totalCount / $this->paginationCount);
            if ($totalCount % $this->paginationCount > 0)
                $pageCount ++;

            return new PaginationInformation($page, $pageCount, $totalCount, $itemList);
        }
        catch (Exception $ex) {
            return null;
        }
    }

    private function addConditionToQueryBuilder($queryBuilder, $filters) {

        // Add filter if exist
        if (!empty($filters)) {

            foreach ($filters as $key => $value) {
                $queryBuilder->andWhere('e.' . $key . ' = :' . $key)
                ->setParameter($key, $value);
            }
        }
    }
}
