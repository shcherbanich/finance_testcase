<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class ShareRepository extends EntityRepository
{

    /**
     *
     * @param $user
     * @return \AppBundle\Entity\Share[]
     */
    public function findSharesByUser(User $user)
    {
        $qb = $this->createQueryBuilder("s")
            ->where(':user MEMBER OF s.user')
            ->setParameters(array('user' => $user));

        return $qb->getQuery()->getResult();
    }


    /**
     *
     * @param $id
     * @param $user
     * @param $default
     * @return \AppBundle\Entity\Share|mixed
     */
    public function findShareByUser($id, User $user, $default = null)
    {
        $qb = $this->createQueryBuilder("s")
            ->where(':user MEMBER OF s.user')
            ->andWhere('s.id = :id')
            ->setParameters(array('id' => $id, 'user' => $user));

        $result = $qb->getQuery()->getOneOrNullResult();

        return $result?$result:$default;
    }

    /**
     *
     * @param $name
     * @param $default
     * @return \AppBundle\Entity\Share|mixed
     */
    public function findShareByName($name,$default = null)
    {
        $result = $this->findOneBy(['name' => $name]);

        return $result?$result:$default;
    }

}