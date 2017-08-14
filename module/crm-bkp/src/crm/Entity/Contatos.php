<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contatos
 * @ORM\Entity(repositoryClass="crm\Entity\Repository\ContatoRepository")
 * @ORM\Table(name="contatos")
 *
 *
 */
class Contatos
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
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=150, nullable=false)
     */
    protected $nome;

    /**
     * @var integer
     *
     * @ORM\Column(name="idade", type="integer", nullable=true)
     */
    private $idade;

    /**
     * @var string
     *
     * @ORM\Column(name="observacao", type="text", length=65535, nullable=true)
     */
    private $observacao;

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
     * @var string
     *
     * @ORM\Column(name="empresa", type="string", length=100, nullable=true)
     */
    private $empresa;

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
     * @var boolean
     *
     * @ORM\Column(name="numero_pessoas_empresas", type="integer", nullable=true)
     */
    private $numeroPessoasEmpresas = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="interesse", type="string", nullable=true)
     */
    private $interesse;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enviar_para", type="string", nullable=true)
     */
    private $enviarPara;

    /**
     * @return boolean
     */
    public function getInteresse()
    {
        return $this->interesse;
    }

    /**
     * @param boolean $interesse
     * @return Contatos
     */
    public function setInteresse($interesse)
    {
        $this->interesse = $interesse;
        return $this;
    }


     /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Contatos
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return Contatos
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdade()
    {
        return $this->idade;
    }

    /**
     * @param int $idade
     * @return Contatos
     */
    public function setIdade($idade)
    {
        $this->idade = $idade;
        return $this;
    }

    /**
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * @param string $observacao
     * @return Contatos
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
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
     * @return Contatos
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
     * @return Contatos
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
     * @return Contatos
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * @param string $empresa
     * @return Contatos
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
        return $this;
    }

    /**
     * @return string
     */
    public function getOperadora()
    {
        return $this->operadora;
    }

    /**
     * @param string $operadora
     * @return Contatos
     */
    public function setOperadora($operadora)
    {
        $this->operadora = $operadora;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isNumeroPessoasEmpresas()
    {
        return $this->numeroPessoasEmpresas;
    }

    /**
     * @param boolean $numeroPessoasEmpresas
     * @return Contatos
     */
    public function setNumeroPessoasEmpresas($numeroPessoasEmpresas)
    {
        $this->numeroPessoasEmpresas = $numeroPessoasEmpresas;
        return $this;
    }

    /**
     * @return string
     */
    public function getServico()
    {
        return $this->servico;
    }

    /**
     * @param string $servico
     * @return Contatos
     */
    public function setServico($servico)
    {
        $this->servico = $servico;
        return $this;
    }


    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get numeroPessoasEmpresas
     *
     * @return boolean
     */
    public function getNumeroPessoasEmpresas()
    {
        return $this->numeroPessoasEmpresas;
    }

    /**
     * @return boolean
     */
    public function isEnviarPara()
    {
        return $this->enviarPara;
    }

    /**
     * @param boolean $enviarPara
     * @return Contatos
     */
    public function setEnviarPara($enviarPara)
    {
        $this->enviarPara = $enviarPara;
        return $this;
    }


}
