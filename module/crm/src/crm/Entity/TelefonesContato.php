<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TelefonesContato
 * @ORM\Entity(repositoryClass="crm\Entity\Repository\TelefonesContatoRepository")
 * @ORM\Table(name="telefones_contato", indexes={@ORM\Index(name="fk_contatos_telefones_contato1_idx", columns={"contato_id"})})
 *
 */
class TelefonesContato
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
     * @ORM\Column(name="telefone", type="string", length=20, nullable=true)
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
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status = true;

    /**
     * @var \crm\Entity\Contatos
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Contatos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contato_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $contato;



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
     * Set telefone
     *
     * @param string $telefone
     *
     * @return TelefonesContato
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
     * @return TelefonesContato
     */
    public function setDataCriacao()
    {
        $this->dataCriacao =  new \DateTime("now");

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
     * @return TelefonesContato
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
     * @return TelefonesContato
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
     * Set contato
     *
     * @param \crm\Entity\Contatos $contato
     *
     * @return TelefonesContato
     */
    public function setContato(\crm\Entity\Contatos $contato = null)
    {
        $this->contato = $contato;

        return $this;
    }

    /**
     * Get contato
     *
     * @return \crm\Entity\Contatos
     */
    public function getContato()
    {
        return $this->contato;
    }
}
