<?php

namespace SharesBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class ShareRepository extends EntityRepository {

    /**
     *
     * @param $name
     * @return \SharesBundle\Entity\Share
     */
    public function findSharesByUser(User $user)
    {
        $qb = $this->createQueryBuilder("s")
            ->where(':user MEMBER OF s.user')
            ->setParameters(array('user' => $user))
        ;
        return $qb->getQuery()->getResult();
    }


    /**
     *
     * @param $name
     * @return \SharesBundle\Entity\Share
     */
    public function findShareByUser($id, User $user)
    {
        $qb = $this->createQueryBuilder("s")
            ->where(':user MEMBER OF s.user')
            ->andWhere('s.id = :id')
            ->setParameters(array('id' => $id,'user' => $user))
        ;
        return $qb->getQuery()->getOneOrNullResult();
    }

}