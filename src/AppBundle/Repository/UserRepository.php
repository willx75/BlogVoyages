<?php

namespace AppBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{

public function getAllUser()
{
    $qb = $this->createQueryBuilder('user');

    $qb->select('user');

    return $qb->getQuery()->getArrayResult();
}
}



