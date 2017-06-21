<?php

namespace Eship\EventBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CounselorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CounselorRepository extends EntityRepository
{
    public function getCounselorList()
    {
        $conn = $this->getEntityManager()
            ->getConnection();

        $sql = '
            SELECT DISTINCT c.counselorId, c.firstName, c.lastName, c.initial, c.department, c.position, c.isAdmin, c.isActive as active
            FROM counselor c 
            ORDER BY c.firstName ASC';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCounselor($id)
    {
        return $this->createQueryBuilder('counselor')
            ->andWhere('counselor.counselorId = :idParam')
            ->addSelect('counselor.counselorId', 'counselor.counselorEmail', 'counselor.firstName', 'counselor.lastName',
                'counselor.initial', 'counselor.age', 'counselor.gender', 'counselor.phone', 'counselor.position',
                'counselor.department', 'counselor.cndeOrganization', 'counselor.isAdmin', 'counselor.isActive',
                'counselor.courses')
            ->setParameter('idParam', $id)
            ->getQuery()
            ->execute();
    }

    public function getCounselorWorkReport($id)
    {
        return $this->createQueryBuilder('counselor')
            ->andWhere('counselor.counselorId = :idParam')
            ->leftJoin('counselor.counselorId', 'meetingReport')
            //->leftJoin('meetingReport', )
            ->addSelect('counselor.firstName', 'counselor.initial', 'counselor.lastName')
            ->setParameter('idParam', $id)
            ->getQuery()
            ->execute();
    }

}