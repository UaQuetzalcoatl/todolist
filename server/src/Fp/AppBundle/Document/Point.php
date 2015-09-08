<?php

namespace Fp\AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use DateTime;

/**
 * @MongoDb\Document
 *
 * @author alex
 */
class Point
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $name;

    /**
     * @MongoDB\Date
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
}
