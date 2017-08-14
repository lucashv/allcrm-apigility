<?php
/**
 * Created by PhpStorm.
 * User: tiago.alves
 * Date: 03/02/2016
 * Time: 15:39
 */

namespace crm\V1\Rest\AgendaUsuario;


use crm\V1\Rest\AbstractService\AbstractService;
use crm\V1\Rest\DateTime\DateTime as FormatData;
use crm\V1\Rest\RelatorioParams\RelatorioParams;

class AgendaUsuarioService extends AbstractService
{

    protected $em;
    protected $agendaUsuarioFactory;
    protected $agendaRelatorio;

    public function __construct($em, $hydrator, AgendaUsuarioFactory $agendaUsuarioFactory, RelatorioParams $agendaRelatorio)
    {
        $this->em = $em;
        $this->hydrator = $hydrator;
        $this->repository = 'crm\Entity\AgendaUsuario';
        $this->agendaUsuarioFactory = $agendaUsuarioFactory;
        $this->agendaRelatorio = $agendaRelatorio;

    }

    public function fetch($params)
    {

        if($params->tipo == 'relatorioAgendaUsuario')
        {
            return $this->em->getRepository($this->repository)->getAgendaByUser($params->idUsuario);
        }

        if($params->tipo == 'relatorioGeralAgenda')
        {
            $params = $this->hydrate($this->agendaRelatorio, $params);


            return $this->em->getRepository($this->repository)->getRelatorioGeralAgenda($params);
        }
    }

    public function create($params)
    {
        $agendaUsuario = $this->agendaUsuarioFactory->create($params);
        $this->em->persist($agendaUsuario);
        $this->em->flush();
        return $agendaUsuario;
    }

    public function delete($idAngeda)
    {
        $agenda = $this->em->getReference($this->repository, $idAngeda);
        $agenda->setStatus(0);
        $this->em->persist($agenda);

        try{
            $this->em->flush();
            return true;
        }catch (\PDOException $e) {
            die(var_dump($e->getMessage()));
        }

    }

    public function update($data, $id)
    {
        $agenda = $this->em->getReference($this->repository, $id);
        $data->dataAgenda = new \DateTime($data->dataAgenda);


        $this->em->persist($agenda);
        $this->hydrate($agenda,$data);

        try{
            $this->em->flush();
            return $agenda;
        }catch (\PDOException $e) {
            die(var_dump($e->getMessage()));
        }
    }
}