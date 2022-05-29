<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Factory\UserFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        UserFactory::createOne(['email' => 'admin@example.com']);
        UserFactory::createMany(10);

    }
}

