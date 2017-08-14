<?php

namespace crm\Entity\Repository;


use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository extends EntityRepository
{
    private function getEm()
    {
        return $this->getEntityManager();
    }

}