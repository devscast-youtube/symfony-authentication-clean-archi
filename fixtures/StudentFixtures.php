<?php

namespace DataFixtures;

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
class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr');
        for ($i = 0; $i <= 100; $i++) {
            $student = new Student(
                new Email($faker->email()),
                new Username($faker->userName()),
                new Address(
                    $faker->city(),
                    $faker->countryCode(),
                    $faker->streetAddress(),
                    $faker->streetAddress(),
                ),
                \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-40 years', '-18 years'),)
            );
            $manager->persist($student);
        }

        $manager->flush();
    }
}
