<?php

namespace Fp\AppBundle\Document;

use JMS\Serializer\Annotation;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * @MongoDb\Document
 * @Annotation\ExclusionPolicy("all")
 *
 * @author alex
 */
class Point
{
    /**
     * @MongoDB\Id
     * @Annotation\Expose
     * @Annotation\Type("string")
     *
     * @var string
     */
    protected $id;

    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     * @Assert\Length(max=30)
     * @Annotation\Expose
     * @Annotation\Type("string")
     *
     * @var string
     */
    protected $name;

    /**
     * @MongoDB\Date
     * @Assert\NotBlank()
     * @Assert\DateTime()
     * @Annotation\Expose
     * @Annotation\Type("DateTime<'Y-m-d'>")
     * @Annotation\SerializedName("dueDate")
     *
     * @var DateTime
     */
    protected $dueDate;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return \Fp\AppBundle\Document\Point
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set dueDate
     *
     * @param DateTime $dueDate
     * @return self
     */
    public function setDueDate(DateTime $dueDate = null)
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     * Get dueDate
     *
     * @return DateTime $dueDate
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Test virtual property
     *
     * @Annotation\VirtualProperty()
     * @Annotation\SerializedName("greeting")
     *
     * @return string
     */
    public function testVirtualProperty()
    {
        return 'I\'m a serializer';
    }
}
