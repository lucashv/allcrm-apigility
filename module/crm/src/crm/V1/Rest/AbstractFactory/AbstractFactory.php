<?php

namespace AbstractFactory;


abstract class AbstractFactory
{
    /**
     * \Doctrine\ORM\EntityManager\
     * @var
     */
    protected $em;

    /**
     * \Hydrator\ClassMethods()
     * @var
     */
    protected $hydrator;

    /**
     * \Zend\ServiceManager\ServiceManager
     * @var
     */
    protected $sm;

    public function __construct($em, $hydrator, $sm)
    {
        $this->em = $em;
        $this->hydrator = $hydrator;
        $this->sm = $sm;
    }

    public function create(){}

}