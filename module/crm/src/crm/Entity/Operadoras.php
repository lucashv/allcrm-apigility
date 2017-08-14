<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Operadoras
 *
 * @ORM\Table(name="operadoras", indexes={@ORM\Index(name="fk_operadoras_cidades1_idx", columns={"cidades_id"}), @ORM\Index(name="fk_operadora_tipos_operadora1_idx", columns={"tipos_operadora_id"})})
 * @ORM\Entity
 */
class Operadoras
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
     * @ORM\Column(name="nome_fantasia", type="string", length=100, nullable=false)
     */
    public $nomeFantasia;

    /**
     * @var string
     *
     * @ORM\Column(name="razao_social", type="string", length=100, nullable=false)
     */
    public $razaoSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="cnpj", type="string", length=20, nullable=true)
     */
    private $cnpj;

    /**
     * @var string
     *
     * @ORM\Column(name="endereco", type="string", length=45, nullable=true)
     */
    private $endereco;

    /**
     * @var string
     *
     * @ORM\Column(name="endereco_numero", type="string", length=45, nullable=true)
     */
    private $enderecoNumero;

    /**
     * @var string
     *
     * @ORM\Column(name="endereco_complemento", type="string", length=45, nullable=true)
     */
    private $enderecoComplemento;

    /**
     * @var string
     *
     * @ORM\Column(name="telefone", type="string", length=45, nullable=true)
     */
    private $telefone;

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
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var \crm\Entity\TiposOperadora
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\TiposOperadora")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipos_operadora_id", referencedColumnName="id")
     * })
     */
    private $tiposOperadora;

    /**
     * @var \crm\Entity\Cidades
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Cidades")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cidades_id", referencedColumnName="id")
     * })
     */
    private $cidades;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomeFantasia
     *
     * @param string $nomeFantasia
     *
     * @return Operadoras
     */
    public function setNomeFantasia($nomeFantasia)
    {
        $this->nomeFantasia = $nomeFantasia;

        return $this;
    }

    /**
     * Get nomeFantasia
     *
     * @return string
     */
    public function getNomeFantasia()
    {
        return $this->nomeFantasia;
    }

    /**
     * Set razaoSocial
     *
     * @param string $razaoSocial
     *
     * @return Operadoras
     */
    public function setRazaoSocial($razaoSocial)
    {
        $this->razaoSocial = $razaoSocial;

        return $this;
    }

    /**
     * Get razaoSocial
     *
     * @return string
     */
    public function getRazaoSocial()
    {
        return $this->razaoSocial;
    }

    /**
     * Set cnpj
     *
     * @param string $cnpj
     *
     * @return Operadoras
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;

        return $this;
    }

    /**
     * Get cnpj
     *
     * @return string
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * Set endereco
     *
     * @param string $endereco
     *
     * @return Operadoras
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get endereco
     *
     * @return string
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Set enderecoNumero
     *
     * @param string $enderecoNumero
     *
     * @return Operadoras
     */
    public function setEnderecoNumero($enderecoNumero)
    {
        $this->enderecoNumero = $enderecoNumero;

        return $this;
    }

    /**
     * Get enderecoNumero
     *
     * @return string
     */
    public function getEnderecoNumero()
    {
        return $this->enderecoNumero;
    }

    /**
     * Set enderecoComplemento
     *
     * @param string $enderecoComplemento
     *
     * @return Operadoras
     */
    public function setEnderecoComplemento($enderecoComplemento)
    {
        $this->enderecoComplemento = $enderecoComplemento;

        return $this;
    }

    /**
     * Get enderecoComplemento
     *
     * @return string
     */
    public function getEnderecoComplemento()
    {
        return $this->enderecoComplemento;
    }

    /**
     * Set telefone
     *
     * @param string $telefone
     *
     * @return Operadoras
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Get telefone
     *
     * @return string
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set dataCriacao
     *
     * @param \DateTime $dataCriacao
     *
     * @return Operadoras
     */
    public function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;

        return $this;
    }

    /**
     * Get dataCriacao
     *
     * @return \DateTime
     */
    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }

    /**
     * Set dataEdicao
     *
     * @param \DateTime $dataEdicao
     *
     * @return Operadoras
     */
    public function setDataEdicao($dataEdicao)
    {
        $this->dataEdicao = $dataEdicao;

        return $this;
    }

    /**
     * Get dataEdicao
     *
     * @return \DateTime
     */
    public function getDataEdicao()
    {
        return $this->dataEdicao;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Operadoras
     */
    public function setStatus($status)
    {
        $this->status = $status;

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
     * Set tiposOperadora
     *
     * @param \crm\Entity\TiposOperadora $tiposOperadora
     *
     * @return Operadoras
     */
    public function setTiposOperadora(\crm\Entity\TiposOperadora $tiposOperadora = null)
    {
        $this->tiposOperadora = $tiposOperadora;

        return $this;
    }

    /**
     * Get tiposOperadora
     *
     * @return \crm\Entity\TiposOperadora
     */
    public function getTiposOperadora()
    {
        return $this->tiposOperadora;
    }

    /**
     * Set cidades
     *
     * @param \crm\Entity\Cidades $cidades
     *
     * @return Operadoras
     */
    public function setCidades(\crm\Entity\Cidades $cidades = null)
    {
        $this->cidades = $cidades;

        return $this;
    }

    /**
     * Get cidades
     *
     * @return \crm\Entity\Cidades
     */
    public function getCidades()
    {
        return $this->cidades;
    }
}
