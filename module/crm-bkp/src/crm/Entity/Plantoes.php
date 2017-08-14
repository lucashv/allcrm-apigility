<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plantoes
 *
 * @ORM\Table(name="plantoes")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="crm\Entity\Repository\PlantoesRepository")
 */
class Plantoes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;


    /**
     * @var \crm\Entity\Usuarios
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_corretor_id", referencedColumnName="id")
     * })
     */
    public $usuarioCorretor;

    /**
     * @var \crm\Entity\Usuarios
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    public $usuarioCadastro;

    /**
     * @var \crm\Entity\TiposPlantoes
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\TiposPlantoes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipos_plantoes_id", referencedColumnName="id")
     * })
     */
    private $tipo;

    /**
     * @var \crm\Entity\TiposPlantoes
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Filiais")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="filiais_id", referencedColumnName="id")
     * })
     */
    private $filial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_criacao", type="string", nullable=true)
     */
    private $dataCriacao;


    /**
     * @var \Bollean
     *
     * @ORM\Column(name="bloqueado", type="boolean", nullable=true)
     */
    private $bloqueado;

    /**
     * @var \Bollean
     *
     * @ORM\Column(name="ramal", type="string", nullable=true)
     */
    private $ramal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ultimo_envio", type="string", nullable=true)
     */
    private $ultimoEnvio;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_edicao", type="string", nullable=true)
     */
    private $dataEdicao;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="posicao", type="integer", nullable=true)
     *
     */
    private $posicao;

    /**
     * @var integer
     *
     * @ORM\Column(name="reposicao", type="integer", nullable=true)
     *
     */
    private $reposicao = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="reposicao_paga", type="integer", nullable=true)
     *
     */
    private $reposicaoPaga = 0;


    /**
     * @var integer
     *
     * @ORM\Column(name="ligacoes_perdidas", type="integer", nullable=true)
     *
     */
    private $ligacoesPerdidas = 0;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Plantoes
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Usuarios
     */
    public function getUsuarioCorretor()
    {
        return $this->usuarioCorretor;
    }

    /**
     * @param Usuarios $usuarioCorretor
     * @return Plantoes
     */
    public function setUsuarioCorretor($usuarioCorretor)
    {
        $this->usuarioCorretor = $usuarioCorretor;
        return $this;
    }

    /**
     * @return Usuarios
     */
    public function getUsuarioCadastro()
    {
        return $this->usuarioCadastro;
    }

    /**
     * @param Usuarios $usuarioCadastro
     * @return Plantoes
     */
    public function setUsuarioCadastro($usuarioCadastro)
    {
        $this->usuarioCadastro = $usuarioCadastro;
        return $this;
    }

    /**
     * @return TiposPlantoes
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param TiposPlantoes $tipo
     * @return Plantoes
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * @return TiposPlantoes
     */
    public function getFilial()
    {
        return $this->filial;
    }

    /**
     * @param TiposPlantoes $filial
     * @return Plantoes
     */
    public function setFilial($filial)
    {
        $this->filial = $filial;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }

    /**
     * @param \DateTime $dataCriacao
     * @return Plantoes
     */
    public function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;
        return $this;
    }

    /**
     * @return \Bollean
     */
    public function getBloqueado()
    {
        return $this->bloqueado;
    }

    /**
     * @param \Bollean $bloqueado
     * @return Plantoes
     */
    public function setBloqueado($bloqueado)
    {
        $this->bloqueado = $bloqueado;
        return $this;
    }

    /**
     * @return \Bollean
     */
    public function getRamal()
    {
        return $this->ramal;
    }

    /**
     * @param \Bollean $ramal
     * @return Plantoes
     */
    public function setRamal($ramal)
    {
        $this->ramal = $ramal;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUltimoEnvio()
    {
        return $this->ultimoEnvio;
    }

    /**
     * @param \DateTime $ultimoEnvio
     * @return Plantoes
     */
    public function setUltimoEnvio($ultimoEnvio)
    {
        $this->ultimoEnvio = $ultimoEnvio;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataEdicao()
    {
        return $this->dataEdicao;
    }

    /**
     * @param \DateTime $dataEdicao
     * @return Plantoes
     */
    public function setDataEdicao($dataEdicao)
    {
        $this->dataEdicao = $dataEdicao;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isStatus()
    {
        return $this->status;
    }

    /**
     * @param boolean $status
     * @return Plantoes
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosicao()
    {
        return $this->posicao;
    }

    /**
     * @param int $posicao
     * @return Plantoes
     */
    public function setPosicao($posicao)
    {
        $this->posicao = $posicao;
        return $this;
    }

    /**
     * @return int
     */
    public function getReposicao()
    {
        return $this->reposicao;
    }

    /**
     * @param int $reposicao
     * @return Plantoes
     */
    public function setReposicao($reposicao)
    {
        $this->reposicao = $reposicao;
        return $this;
    }

    /**
     * @return int
     */
    public function getReposicaoPaga()
    {
        return $this->reposicaoPaga;
    }

    /**
     * @param int $reposicaoPaga
     * @return Plantoes
     */
    public function setReposicaoPaga($reposicaoPaga)
    {
        $this->reposicaoPaga = $reposicaoPaga;
        return $this;
    }

    /**
     * @return int
     */
    public function getLigacoesPerdidas()
    {
        return $this->ligacoesPerdidas;
    }

    /**
     * @param int $ligacoesPerdidas
     * @return Plantoes
     */
    public function setLigacoesPerdidas($ligacoesPerdidas)
    {
        $this->ligacoesPerdidas = $ligacoesPerdidas;
        return $this;
    }





}
