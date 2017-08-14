<?php

namespace crm\Entity\Repository;


class UsuariosRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $con;

    public function getCorretorPorFilial($idFilial)
    {
        $this->init();

        $sql = "SELECT
              corretor.id,
              corretor.nome,
              corretor.`sobre_nome`,
              corretor.`perfil_id`,
              corretor.`filiais_id`,
              corretor.`status`,
              corretor.supervisor_id,
              corretor.envio_bloqueado
            FROM
              `usuarios` AS corretor
            WHERE
              corretor.`perfil_id` = 2
              AND corretor.`filiais_id` = :idFilial
              AND corretor.`status` = true ;
            ";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue('idFilial', $idFilial);
        try{
            $stmt->execute();
            $dados =  $stmt->fetchAll();
            return $dados;
        }catch (\PDOException $e) {
            die(var_dump($e->getMessage()));
        }

    }

    private function getEm()
    {
        return $this->getEntityManager();
    }

    private function init()
    {
        $this->con = $this->getEm()->getConnection();
    }


}