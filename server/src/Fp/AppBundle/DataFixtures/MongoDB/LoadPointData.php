<?php

namespace Fp\AppBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Fp\AppBundle\Document\Point;

/**
 * Description of LoadPointData
 *
 * @author alex
 */
class LoadPointData extends AbstractFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $point1 = new Point();
        $point1->setName('point1')
                ->setDueDate(new \DateTime());
        $this->setReference('point-one', $point1);

        $point2 = new Point();
        $point2->setName('point2')
                ->setDueDate(new \DateTime());
        $this->setReference('point-two', $point2);

        $manager->persist($point1);
        $manager->persist($point2);
        $manager->flush();
    }
}
