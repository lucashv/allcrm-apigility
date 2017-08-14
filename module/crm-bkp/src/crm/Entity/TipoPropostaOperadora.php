<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoPropostaOperadora
 * @ORM\Entity(repositoryClass="crm\Entity\Repository\TipoPropostaOperaradoraRepository")
 * @ORM\Table(name="tipo_proposta_operadora")
 *
 *
 */
class TipoPropostaOperadora
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
     * @ORM\ManyToOne(targetEntity="crm\Entity\Operadoras")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="operadoras_id", referencedColumnName="id", nullable = true)
     * })
     */
    private $operadora;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=150, nullable=false)
     */
    protected $nome;

    /**
     * @var integer
     *
     * @ORM\Column(name="maximo_retirada_usuario", type="integer", nullable=false)
     */
    private $maximoRetiradaUsuario;

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
     * @return TipoPropostaOperadora
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Operadoras
     */
    public function getOperadora()
    {
        return $this->operadora;
    }

    /**
     * @param Operadoras $operadora
     * @return TipoPropostaOperadora
     */
    public function setOperadora($operadora)
    {
        $this->operadora = $operadora;
        return $this;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     * @return TipoPropostaOperadora
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaximoRetiradaUsuario()
    {
        return $this->maximoRetiradaUsuario;
    }

    /**
     * @param int $maximoRetiradaUsuario
     * @return TipoPropostaOperadora
     */
    public function setMaximoRetiradaUsuario($maximoRetiradaUsuario)
    {
        $this->maximoRetiradaUsuario = $maximoRetiradaUsuario;
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
     * @return TipoPropostaOperadora
     */
    public function setDataCriacao()
    {
        $this->dataCriacao = new \DateTime("now");
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
     * @return TipoPropostaOperadora
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
     * @return TipoPropostaOperadora
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

}