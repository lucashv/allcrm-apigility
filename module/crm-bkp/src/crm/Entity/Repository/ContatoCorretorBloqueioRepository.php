<?php

namespace  crm\Entity\Repository;

class  ContatoCorretorBloqueioRepository extends \Doctrine\ORM\EntityRepository
{



  public function findByContatoCorretor(int $idContato, int $idCorretor)
  {
      $criteria = array(
          'contato' =>$idContato,
          'corretor' => $idCorretor
      );
      $dados = $this->_em->getRepository('crm\Entity\ContatoCorretorBloqueio')->findBy($criteria);


      $sql = "SELECT
                  id,
                 `contato_id` as contato,
                 corretor_usuario_id as  corretor,
                 `data_bloqueio` as dataBloqueio,
                 status
                FROM
                  `contato_corretor_bloqueio`
                WHERE status = 1 AND contato_id = {$idContato} AND corretor_usuario_id = {$idCorretor}";
      $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
  }

}
