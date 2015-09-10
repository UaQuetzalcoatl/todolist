<?php

namespace Fp\AppBundle\Tests\Document;

use Fp\AppBundle\Document\Point;

/**
 * Description of PointTest
 *
 * @author alex
 */
class PointTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Point
     */
    protected $point;

    public function setUp()
    {
        $this->point = new Point();
    }

    public function testGetterAndSetter()
    {
        $this->assertNull($this->point->getId());

        $this->point->setName('testName');
        $this->assertEquals('testName', $this->point->getName());

        $date = new \DateTime();
        $this->point->setDueDate($date);
        $this->assertEquals($date, $this->point->getDueDate());

        $this->point->setDueDate();
        $this->assertNull($this->point->getDueDate());
    }
}
