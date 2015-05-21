<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use AppBundle\Entity\User;
use AppBundle\Entity\Role;
use AppBundle\Repository\RoleRepository;

class FixtureLoader implements FixtureInterface
{
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
    {
        $roleUser = new Role();

        $roleUser->setName(RoleRepository::ROLE_USER);

        $manager->persist($roleUser);

        $roleAdmin = new Role();

        $roleAdmin->setName(RoleRepository::ROLE_ADMIN);

        $manager->persist($roleAdmin);

        $user = new User();

        $user->setFirstName('Philip');

        $user->setLastName('Shcherbanich');

        $user->setEmail('filippf@bk.ru');

        $user->setUsername('filippf');

        $user->setPassword('admin');

        $user->getUserRoles()->add($roleAdmin);

        $manager->persist($user);

        $manager->flush();
    }
}