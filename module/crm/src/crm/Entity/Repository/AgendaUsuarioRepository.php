<?php

namespace crm\Entity\Repository;
use crm\V1\Rest\RelatorioParams\RelatorioParams;

class AgendaUsuarioRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $con;

    protected $em;

    protected $agendaRelatorio;

    private function getEm()
    {
        return $this->getEntityManager();
    }

    private function init()
    {
        $this->con = $this->getEm()->getConnection();
        $this->em = $this->getEm();
    }

    public function getAgendaByUser($idUsuario)
    {
        $this->init();
        $sql = "SELECT
              a.titulo,
              a.id as id,
              a.descricao,
              DATE_FORMAT(a.data_agenda,'%d-%m-%Y %T')AS dataAgenda,
              a.`status`,
              u.nome,
              u.`sobre_nome`,
              u.id as idUsuarioCadatro,
              c.id as idContato,
              a.concluida
            FROM
              `agenda_usuario` AS a
              JOIN usuarios AS u
              ON a.usuario_id = u.id
              JOIN contatos AS c
              ON c.id = a.contato_id
              WHERE a.`status` = 1 AND a.`usuario_id` = :idUsuario ORDER BY a.data_criacao ASC;";

        $stmt = $this->con->prepare($sql);

        if($idUsuario) {
            $stmt->bindValue('idUsuario',$idUsuario);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getRelatorioGeralAgenda($params) {

        $stmt = $this->getQueryRelatorioGeralAgenda($params);
        try {
            $stmt->execute();
            $dados =  $stmt->fetchAll();
            return $dados;


        } catch (\PDOException $e) {

                $erro = array(
                    'params' => $params,
                    'msg' => $e->getMessage()
                );
                die(var_dump($erro));
        }
    }

    private function getQueryRelatorioGeralAgenda($params)
    {
        $this->init();

        $sql = "SELECT
                  a.id,
                  a.status,
                  a.titulo,
                  a.descricao,
                  DATE_FORMAT(a.data_agenda,'%d-%m-%Y %T')AS data_agenda,
                  a.data_criacao,
                  a.usuario_id as usuarioAgenda,
                  a.concluida,
                  a.contato_id
                FROM
                  agenda_usuario AS a
                 WHERE a.usuario_id = :idUsuario ";


        if(!is_null($params->dataInicio) && $params->dataFim) {
            $sql .= " AND a.data_agenda BETWEEN  '{$params->dataInicio }' AND '{$params->dataFim}'  ";
        }

        if($params->inativos) {
            $sql.= " AND a.status = :inativos " ;
        } else {
            $sql.= " AND a.status = 1" ;
        }

        if($params->concluidos) {
            $sql.= " AND a.concluida = 1 ";
        } else {
            $sql.= " AND a.concluida = 0 ";
        }


        $stmt = $this->con->prepare($sql);



        if($params->idUsuario) {
            $stmt->bindValue('idUsuario',(int)$params->idUsuario);
        }

        if($params->inativos) {
            $stmt->bindValue('inativos',(int)0);
        }


        return $stmt;




    }





}