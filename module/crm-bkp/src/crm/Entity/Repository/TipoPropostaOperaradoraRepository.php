<?php

namespace crm\Entity\Repository;


use Doctrine\ORM\EntityManager;

class TipoPropostaOperaradoraRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $con;
    /**
     * @var EntityManager
     */
    protected $em;

    private function init()
    {
        $this->con = $this->getEntityManager()->getConnection();
        $this->em =  $this->getEntityManager();
    }


    public function getAll()
    {
        $this->init();

        $sql = "SELECT
                  tpo.id,
                  tpo.`operadoras_id`,
                  tpo.nome,
                  tpo.`maximo_retirada_usuario`,
                  tpo.`data_criacao`,
                  tpo.`status`
                FROM
                  tipo_proposta_operadora AS tpo
                  WHERE	tpo.`status` = 1 ; ";

        $stmt = $this->con->prepare($sql);

        try {
            $stmt->execute();
            return $stmt->fetchAll();

        }catch(\PDOException $e) {
            die(var_dump($e->getMessage()));
        }

    }

}