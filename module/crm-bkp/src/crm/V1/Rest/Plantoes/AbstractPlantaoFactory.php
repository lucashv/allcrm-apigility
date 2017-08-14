<?php


namespace crm\V1\Rest\Plantoes;

use crm\Entity\Plantoes;
use crm\V1\Rest\AbstractService\AbstractService;

/**
 * Retorna objetos plantoes com suas respectivas dependencias.
 * Class AbstractPlantaoFactory
 * @package crm\V1\Rest\Plantoes
 */
class AbstractPlantaoFactory extends AbstractService
{
    protected $plantoesEntity;
    protected $em;
    protected $hydrator;
    protected $sm;

    public function __construct($em,$hydratorm,$sm, Plantoes $plantoesEntity)
    {
        $this->em = $em;
        $this->hydrator = $hydratorm;
        $this->sm = $sm;
        $this->plantoesEntity = $plantoesEntity;
    }

    public function create($data)
    {
        $idFilial        = isset($data->corretor['idFilial']) ? $data->corretor['idFilial']  : $data->corretor['filial']['id'];
        $usuarioCadastro = $this->em->getRepository('crm\Entity\Usuarios')->find($data->usuarioCadastro);
        $usuarioCorretor = $this->em->getRepository('crm\Entity\Usuarios')->find($data->corretor['id']);
        $filial          = $this->em->getRepository('crm\Entity\Filiais')->find($idFilial);
        $tipoPlantao     = $this->em->getRepository('crm\Entity\TiposPlantoes')->find($data->tipo['id']);
        $this->plantoesEntity->setUsuarioCorretor($usuarioCorretor)
                             ->setUsuarioCadastro($usuarioCadastro)
                             ->setTipo($tipoPlantao)
                             ->setFilial($filial)
                             ->setDataCriacao($this->getDataAtual())
                             ->setStatus(1)
                             ->setBloqueado(0)
                             ->setRamal($data->ramal)
                             ->setUltimoEnvio($this->getDataAtual())
                             ->setPosicao($data->posicao);
        return $this->plantoesEntity;
    }


}