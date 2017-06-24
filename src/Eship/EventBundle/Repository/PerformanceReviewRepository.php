<?php

namespace Eship\EventBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PerformanceReviewRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PerformanceReviewRepository extends EntityRepository
{
    /**
     * Query that returns a list of all the performance reviews on the system
     */
    public function getPerformanceReviewSummary()
    {
        return $this->createQueryBuilder('pr') //alias of the table
            ->leftJoin('pr.counselor', 'counselor') //left join of performance review table and counselor table
            ->addSelect('pr.performanceReviewId', 'pr.date', 'pr.clientEmail', 'pr.clientFirstName', 'pr.clientLastName',
                'pr.satisfactionLevel', 'pr.comment', 'pr.usefulnessOfService', 'pr.city', 'pr.phone','counselor.firstName',
                'counselor.initial', 'counselor.lastName') //Select clause of the query
            ->addOrderBy('pr.date') //Order By
            ->getQuery() //finishing the query
            ->execute();
    }

}
