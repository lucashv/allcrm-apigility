<?php


namespace crm\Entity\Repository;

use crm\V1\Rest\TelefonesContato\TelefonesContatoFactory;


class TelefonesContatoRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $con;

    protected $em;


    private function init()
    {
       $this->em  = $this->getEm();
       $this->con = $this->getEm()->getConnection();
    }

    private function getEm()
    {
        return $this->getEntityManager();
    }

    public function insertTelefonesContatos( int $idContato, $telefone, TelefonesContatoFactory $telefoneFactory )
    {
        $this->init();

        $novoTelefone = $telefoneFactory->create($telefone,$idContato);
        $this->em->persist($novoTelefone);

        try{
            $this->em->flush();
            return $novoTelefone;

        }catch (\PDOException $e) {
            die(var_dump($e->getMessage()));
        }


    }

}