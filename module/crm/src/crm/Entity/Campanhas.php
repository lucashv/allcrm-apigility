<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Campanhas
 *
 * @ORM\Table(name="campanhas", indexes={@ORM\Index(name="fk_campanhas_filiais1_idx", columns={"filiais_id"}), @ORM\Index(name="fk_campanhas_grupo_vendas1_idx", columns={"grupo_vendas_id"})})
 * @ORM\Entity
 */
class Campanhas
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
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", length=65535, nullable=true)
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
     * @var \crm\Entity\Filiais
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Filiais")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="filiais_id", referencedColumnName="id")
     * })
     */
    private $filiais;

    /**
     * @var \crm\Entity\GrupoVendas
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\GrupoVendas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="grupo_vendas_id", referencedColumnName="id")
     * })
     */
    private $grupoVendas;



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
     * @return Campanhas
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
     * @return Campanhas
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
     * @return Campanhas
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
     * @return Campanhas
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
     * @return Campanhas
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
     * Set filiais
     *
     * @param \crm\Entity\Filiais $filiais
     *
     * @return Campanhas
     */
    public function setFiliais(\crm\Entity\Filiais $filiais = null)
    {
        $this->filiais = $filiais;

        return $this;
    }

    /**
     * Get filiais
     *
     * @return \crm\Entity\Filiais
     */
    public function getFiliais()
    {
        return $this->filiais;
    }

    /**
     * Set grupoVendas
     *
     * @param \crm\Entity\GrupoVendas $grupoVendas
     *
     * @return Campanhas
     */
    public function setGrupoVendas(\crm\Entity\GrupoVendas $grupoVendas = null)
    {
        $this->grupoVendas = $grupoVendas;

        return $this;
    }

    /**
     * Get grupoVendas
     *
     * @return \crm\Entity\GrupoVendas
     */
    public function getGrupoVendas()
    {
        return $this->grupoVendas;
    }
}
