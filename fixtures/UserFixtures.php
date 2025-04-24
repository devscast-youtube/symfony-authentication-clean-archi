<?php

namespace DataFixtures;

use Classroom\IdentityAndAccess\Domain\Model\Entity\User;
use Classroom\IdentityAndAccess\Domain\Model\ValueObject\Roles;
use Classroom\IdentityAndAccess\Domain\Service\PasswordHasher;
use Classroom\SharedContext\Domain\Model\ValueObject\Email;
use Classroom\StudentManagement\Domain\Model\Entity\Student;
use Classroom\StudentManagement\Domain\Model\ValueObject\Address;
use Classroom\StudentManagement\Domain\Model\ValueObject\Username;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class AppFixtures.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class UserFixtures extends Fixture
{
    public function __construct(
        private readonly PasswordHasher $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr');

        $admin = User::register('Admin', new Email('admin@admin.com'), Roles::admin())
            ->definePassword('000000', $this->passwordHasher)
            ->confirmAccount();
        $manager->persist($admin);


        for ($i = 0; $i <= 20; $i++) {
            $user = User::register($faker->name(), new Email($faker->email()), new Roles())
                ->definePassword('000000', $this->passwordHasher)
                ->confirmAccount();
            $manager->persist($user);
        }

        $manager->flush();
    }
}
