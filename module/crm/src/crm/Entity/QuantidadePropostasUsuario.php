<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuantidadePropostasUsuario
 * @ORM\Entity(repositoryClass="crm\Entity\Repository\QuantidadePropostasUsuarioRepository")
 * @ORM\Table(name="quantidade_propostas_usuario")
 *
 */
class QuantidadePropostasUsuario
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;


    /**
     * @var \crm\Entity\Operadoras
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\TipoPropostaOperadora")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_proposta_operadora", referencedColumnName="id", nullable = false)
     * })
     */
    private $tipoPropostaOperadora;

    /**
     * @var \crm\Entity\Usuarios
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    private $usuario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_criacao", type="datetime", nullable=false)
     */
    private $dataCriacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_edicao", type="datetime", nullable=true)
     */
    private $dataEdicao;


    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return QuantidadePropostasUsuario
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Operadoras
     */
    public function getTipoPropostaOperadora()
    {
        return $this->tipoPropostaOperadora;
    }

    /**
     * @param Operadoras $tipoPropostaOperadora
     * @return QuantidadePropostasUsuario
     */
    public function setTipoPropostaOperadora($tipoPropostaOperadora)
    {
        $this->tipoPropostaOperadora = $tipoPropostaOperadora;
        return $this;
    }

    /**
     * @return Usuarios
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param Usuarios $usuario
     * @return QuantidadePropostasUsuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
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
     * @return QuantidadePropostasUsuario
     */
    public function setDataCriacao()
    {
        $this->dataCriacao =  new \DateTime("now");
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
     * @return QuantidadePropostasUsuario
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
     * @return QuantidadePropostasUsuario
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }





}