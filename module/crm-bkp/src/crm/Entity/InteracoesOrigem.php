<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InteracoesOrigem
 *
 * @ORM\Table(name="interacoes_origem", indexes={@ORM\Index(name="fk_contatos_origem_site1_idx", columns={"site_id"}), @ORM\Index(name="fk_contatos_origem_fornecedor1_idx", columns={"fornecedor_id"})})
 * @ORM\Entity
 */
class InteracoesOrigem
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
     * @ORM\Column(name="origem", type="string", length=45, nullable=false)
     */
    public $origem;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_criacao", type="datetime", nullable=false)
     */
    public $dataCriacao = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_edicao", type="datetime", nullable=true)
     */
    public $dataEdicao;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    public $status;



    /**
     * @var \crm\Entity\Fornecedores
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Fornecedores")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fornecedor_id", referencedColumnName="id")
     * })
     */
    public $fornecedor;

    /**
     * @var \crm\Entity\OutrasOrigensContato
     * @ORM\ManyToOne(targetEntity="crm\Entity\OutrasOrigensInteracoes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="outras_origens_interacoes_id", referencedColumnName="id")
     * })
     */
    public $outrasOrigensInteracoes;

    /**
     * @var \crm\Entity\Sites
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Sites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="site_id", referencedColumnName="id")
     * })
     */
    public $sites;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return InteracoesOrigem
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrigem()
    {
        return $this->origem;
    }

    /**
     * @param string $origem
     * @return InteracoesOrigem
     */
    public function setOrigem($origem)
    {
        $this->origem = $origem;
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
     * @return InteracoesOrigem
     */
    public function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;
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
     * @return InteracoesOrigem
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
     * @return InteracoesOrigem
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return Fornecedores
     */
    public function getFornecedor()
    {
        return $this->fornecedor;
    }

    /**
     * @param Fornecedores $fornecedor
     * @return InteracoesOrigem
     */
    public function setFornecedor($fornecedor)
    {
        $this->fornecedor = $fornecedor;
        return $this;
    }

    /**
     * @return OutrasOrigensContato
     */
    public function getOutrasOrigensInteracoes()
    {
        return $this->outrasOrigensInteracoes;
    }

    /**
     * @param OutrasOrigensContato $outrasOrigensInteracoes
     * @return InteracoesOrigem
     */
    public function setOutrasOrigensInteracoes($outrasOrigensInteracoes)
    {
        $this->outrasOrigensInteracoes = $outrasOrigensInteracoes;
        return $this;
    }

    /**
     * @return Sites
     */
    public function getSites()
    {
        return $this->sites;
    }

    /**
     * @param Sites $sites
     * @return InteracoesOrigem
     */
    public function setSites($sites)
    {
        $this->sites = $sites;
        return $this;
    }


}
