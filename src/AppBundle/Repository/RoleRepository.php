<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RoleRepository extends EntityRepository {

    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';

    /**
     *
     * @param $name
     * @return \AppBundle\Entity\Role
     */
    public function getRoleByName($name)
    {
        return $this->findOneBy(['name'=>$name]);
    }
}