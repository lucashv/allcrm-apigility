<?php

namespace crm\Entity\Repository;


class ModulosPermissoesRepository  extends \Doctrine\ORM\EntityRepository
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $con;


    public function getByPerfil($idPerfil)
    {
        $this->init();

        $sql = "SELECT
                  mo.id AS moduloId,
                  mo.nome moduloNome,
                  mo.descricao AS moduloDescricao,
                  p.id AS perfilId,
                  p.descricao AS perfil
                FROM
                  `modulos_permissoes` AS md
                 JOIN `perfil` AS p
                 ON p.`id` = md.`perfil_id`
                 JOIN `modulos` AS mo
                 ON mo.id = md.`modulos_id`
                 WHERE mo.`status` = TRUE AND p.`status` = TRUE
                 AND p.id = :idPerfil";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue('idPerfil', $idPerfil);

        try {
            $stmt->execute();
            $dados =  $stmt->fetchAll();
            return $dados;

        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    private function init()
    {
        $this->con = $this->getEm()->getConnection();
    }

    private function getEm()
    {
        return $this->getEntityManager();
    }


}