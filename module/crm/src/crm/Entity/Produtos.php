<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produtos
 *
 * @ORM\Table(name="produtos", indexes={@ORM\Index(name="fk_produtos_tipos_produtos1_idx", columns={"tipos_produtos_id"})})
 * @ORM\Entity
 */
class Produtos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=50, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", length=65535, nullable=false)
     */
    private $descricao;

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
     * @var \crm\Entity\TiposProdutos
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\TiposProdutos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipos_produtos_id", referencedColumnName="id")
     * })
     */
    private $tiposProdutos;



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
     * Set nome
     *
     * @param string $nome
     *
     * @return Produtos
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return Produtos
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set dataCriacao
     *
     * @param \DateTime $dataCriacao
     *
     * @return Produtos
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
     * @return Produtos
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
     * @return Produtos
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
     * Set tiposProdutos
     *
     * @param \crm\Entity\TiposProdutos $tiposProdutos
     *
     * @return Produtos
     */
    public function setTiposProdutos(\crm\Entity\TiposProdutos $tiposProdutos = null)
    {
        $this->tiposProdutos = $tiposProdutos;

        return $this;
    }

    /**
     * Get tiposProdutos
     *
     * @return \crm\Entity\TiposProdutos
     */
    public function getTiposProdutos()
    {
        return $this->tiposProdutos;
    }
}
