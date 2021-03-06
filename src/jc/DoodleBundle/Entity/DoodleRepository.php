<?php

namespace jc\DoodleBundle\Entity;

use Doctrine\ORM\EntityRepository;
use \DateTime;

/**
 * DoodleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DoodleRepository extends EntityRepository
{

    /**
     * Allows to get doodle which are not yet deprecated (i.e. date not yet expired), nor closed.
     * @param Datetime $datetime Reference date to use to filter doodle => get only doodle with date post to datetime.
     * @return List of doodle not closed and with event date not post to specified date.
     */
    public function getActivDoodle($datetime) {

        if ($datetime == null)
            $datetime = new DateTime();

        $queryBuilder = $this->createQueryBuilder('d')
                ->where('d.eventDate > :limitDate')
                ->andWhere('d.closed = false')
                ->setParameter('limitDate', $datetime);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Allows to get all doodle specify user hasn't reply yet.
     * @param jc\UserBundle\Entity\User $user User we want to find unreply doodle.
     * @return List of doodle specify user hasn't reply yet.
     */
    public function getUnreplyDoodleForUser($user) {

        $query = $this->_em->createQuery('SELECT DISTINCT d FROM jcDoodleBundle:Doodle d JOIN d.replyList dr WHERE d.closed = false AND d.sent = true '
                . 'AND d.id NOT IN (SELECT d2.id FROM jcDoodleBundle:DoodleReply dr2 JOIN dr2.doodle d2 JOIN dr2.user u WITH u.id = 3)');

        return $query->getResult();
    }

    /**
     * Allows to get all doodle specify user has reply.
     * @param jc\UserBundle\Entity\User $user User we want to find reply doodle.
     * @return List of doodle specify user has reply.
     */
    public function getReplyDoodleForUser($user) {

        $query = $this->_em->createQuery('SELECT DISTINCT d FROM jcDoodleBundle:Doodle d JOIN d.replyList dr WITH dr.user = :user WHERE d.closed = false AND d.sent = true');
        $query->setParameter('user', $user);

        return $query->getResult();
    }

    /**
     * Allows to get all users who don't have reply to specified doodle.
     * @param jc\DoodleBundle\Entity\Doodle $doodle Doodle we want to get users who don't have reply.
     * @return List of users who don't have reply to specified doodle.
     */
    public function getMissingUserForDoodle($doodle)
    {
        try
        {
            // Get admin role to build condition later
            $adminRole = $this->_em->createQuery('SELECT r FROM jcUserBundle:Role r WHERE r.code = :adminCode')
                    ->setParameter('adminCode', 'ROLE_ADMIN')
                    ->getSingleResult();

            // Get all user who are not admin and who doesn't exist in doodle reply list
            $queryBuilder = $this->_em->createQueryBuilder()
                    ->select('u')
                    ->from('jcUserBundle:User', 'u');
            $queryBuilder = $queryBuilder->where(':adminRole NOT MEMBER OF u.internalRoles')
                    ->setParameter('adminRole', $adminRole);

            // If doodle already contains reply => exclude users who have reply
            if (count($doodle->getReplyList()) > 0) {

                $idToExclude = array();
    
                foreach ($doodle->getReplyList() as $doodleReply)
                    $idToExclude[] = $doodleReply->getUser()->getId();

                $queryBuilder->andWhere($queryBuilder->expr()->notIn('u.id', $idToExclude));
            }

            $query = $queryBuilder->getQuery();

            return $query->getResult();
        }
        catch (Exception $ex) {
            return array();
        }
    }
}
