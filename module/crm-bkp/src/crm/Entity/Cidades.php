<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cidades
 *
 * @ORM\Table(name="cidades", indexes={@ORM\Index(name="fk_cidades_estados1_idx", columns={"estados_id"})})
 * @ORM\Entity
 */
class Cidades
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
     * @var \DateTime
     *
     * @ORM\Column(name="data_criacao", type="datetime", nullable=false)
     */
    private $dataCriacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_edicao", type="datetime", nullable=true)
     */
    private $dateEdicao;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var \crm\Entity\Estados
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Estados")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estados_id", referencedColumnName="id")
     * })
     */
    private $estados;



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
     * @return Cidades
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
     * Set dataCriacao
     *
     * @param \DateTime $dataCriacao
     *
     * @return Cidades
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
     * Set dateEdicao
     *
     * @param \DateTime $dateEdicao
     *
     * @return Cidades
     */
    public function setDateEdicao($dateEdicao)
    {
        $this->dateEdicao = $dateEdicao;

        return $this;
    }

    /**
     * Get dateEdicao
     *
     * @return \DateTime
     */
    public function getDateEdicao()
    {
        return $this->dateEdicao;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Cidades
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
     * Set estados
     *
     * @param \crm\Entity\Estados $estados
     *
     * @return Cidades
     */
    public function setEstados(\crm\Entity\Estados $estados = null)
    {
        $this->estados = $estados;

        return $this;
    }

    /**
     * Get estados
     *
     * @return \crm\Entity\Estados
     */
    public function getEstados()
    {
        return $this->estados;
    }
}
