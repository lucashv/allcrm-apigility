<?php
namespace crm\V1\Rest\AbstractService;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator\ClassMethods;


abstract class AbstractService
{
    private $hoje;

    /**
     * @var $em \Doctrine\ORM\EntityManager
     */
    protected $em;
    protected $entity;
    /**
     * @var \Zend\Stdlib\Hydrator\ClassMethods
     */
    protected $hydrator;

    public function __construct(EntityManager $em,$repository, $entity)
    {
        $this->em = $em;

        $this->repository = $repository;
        $this->entity = $entity;
    }

    /**
     * Converte array em objetos
     * @param $entity
     * @param $data
     * @return mixed
     */
    public function hydrate($entity, $data)
    {
        return $this->hydrator->hydrate((array) $data,$entity);
    }

    /**
     * Converte Objeto em array
     * @param $object
     * @return mixed
     */
    public function extract($object)
    {
        return $this->hydrator->extract($object);
    }

    public function save($data)
    {
        $entity = new $this->entity();
        $this->hydrate($entity,$data);
        $this->em->persist($entity);
        $this->em->flush();
        return $this->extract($entity);
    }

    public function update($id,$data)
    {

        $entity = $this->em->getRepository($this->repository)
                       ->find($id);
        if (!is_null($entity)) {
            $this->em->persist($entity);
            $this->hydrate($entity, $data);
            $this->em->flush();
            return true;
        }
        return false;
    }

    /**
     * Retorna todos os registro de uma entidade definida no repository da classe filha
     * @return bool
     */
    public function fetchAll()
    {
        $query = $this->em->createQuery('SELECT u FROM '.$this->repository.' u where u.status = 1');
        $results = $query->getResult();
        if(!is_null($results)) {
            return $this->extractAll( $results );
        }
        return new ApiProblem('404', "Recurso não localizado");
    }

    /**
     * Retorna o timeStamp atual
     * para utilizar em creates e update
     * @return bool|string
     */
    protected function getDataAtual()
    {
        $this->hoje = date("Y-m-d H:i:s");
        return $this->hoje;
    }

    protected function extractAll(array $objetcts)
    {
        $data =  array();

        foreach($objetcts as $object)
        {
            $data[]= $this->extract($object);
        }
        return $data;


    }


}