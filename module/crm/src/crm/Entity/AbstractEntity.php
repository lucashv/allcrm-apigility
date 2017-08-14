<?php
namespace crm\Entity;


use \Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class AbstractEntity
 * @package crm\Entity
 */
abstract class AbstractEntity
{
    /**
     * @var $hydrator
     */
    protected $hydrator;

    /**
     * @param array $options
     */
    public function __construct(Array $options = array())
    {
        $this->hydrator = new ClassMethods();
        $this->hidrator->hydrate($options, $this);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $this->hydrator = new ClassMethods();
        return $this->hydrator->extract($this);
    }

}