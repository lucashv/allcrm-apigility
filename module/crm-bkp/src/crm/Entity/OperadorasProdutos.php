<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OperadorasProdutos
 *
 * @ORM\Table(name="operadoras_produtos", indexes={@ORM\Index(name="fk_operadoras_produtos_operadoras1_idx", columns={"operadoras_id"}), @ORM\Index(name="fk_operadoras_produtos_produtos1_idx", columns={"produtos_id"})})
 * @ORM\Entity
 */
class OperadorasProdutos
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
     * @var \crm\Entity\Operadoras
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Operadoras")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="operadoras_id", referencedColumnName="id")
     * })
     */
    private $operadoras;

    /**
     * @var \crm\Entity\Produtos
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Produtos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produtos_id", referencedColumnName="id")
     * })
     */
    private $produtos;



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
     * Set dataCriacao
     *
     * @param \DateTime $dataCriacao
     *
     * @return OperadorasProdutos
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
     * @return OperadorasProdutos
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
     * @return OperadorasProdutos
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
     * Set operadoras
     *
     * @param \crm\Entity\Operadoras $operadoras
     *
     * @return OperadorasProdutos
     */
    public function setOperadoras(\crm\Entity\Operadoras $operadoras = null)
    {
        $this->operadoras = $operadoras;

        return $this;
    }

    /**
     * Get operadoras
     *
     * @return \crm\Entity\Operadoras
     */
    public function getOperadoras()
    {
        return $this->operadoras;
    }

    /**
     * Set produtos
     *
     * @param \crm\Entity\Produtos $produtos
     *
     * @return OperadorasProdutos
     */
    public function setProdutos(\crm\Entity\Produtos $produtos = null)
    {
        $this->produtos = $produtos;

        return $this;
    }

    /**
     * Get produtos
     *
     * @return \crm\Entity\Produtos
     */
    public function getProdutos()
    {
        return $this->produtos;
    }
}
