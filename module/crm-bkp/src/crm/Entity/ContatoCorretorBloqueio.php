<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContatoCorretorBloqueio
 *
 * @ORM\Table(name="contato_corretor_bloqueio")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="crm\Entity\Repository\ContatoCorretorBloqueioRepository")
 */
class ContatoCorretorBloqueio
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
     * @var \crm\Entity\Contatos
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Contatos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contato_id", referencedColumnName="id")
     * })
     */
    private $contato;


    /**
     * @var \crm\Entity\Usuarios
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="corretor_usuario_id", referencedColumnName="id")
     * })
     */
    protected $corretor;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_bloqueio", type="datetime", nullable=false)
     */
    public $dataBloqueio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_desbloqueio", type="datetime", nullable=true)
     */
    private $dataDesbloqueio;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status = 1;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ContatoCorretorBloqueio
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Contatos
     */
    public function getContato()
    {
        return $this->contato;
    }

    /**
     * @param Contatos $contato
     * @return ContatoCorretorBloqueio
     */
    public function setContato($contato)
    {
        $this->contato = $contato;
        return $this;
    }

    /**
     * @return Usuarios
     */
    public function getCorretor()
    {
        return $this->corretor;
    }

    /**
     * @param Usuarios $corretor
     * @return ContatoCorretorBloqueio
     */
    public function setCorretor($corretor)
    {
        $this->corretor = $corretor;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataBloqueio()
    {
        return $this->dataBloqueio;
    }

    /**
     * @param \DateTime $dataBloqueio
     * @return ContatoCorretorBloqueio
     */
    public function setDataBloqueio($data = false)
    {
        $this->dataBloqueio = isset($data) ? $data : new \DateTime("now");
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataDesbloqueio()
    {
        return $this->dataDesbloqueio;
    }

    /**
     * @param \DateTime $dataDesbloqueio
     * @return ContatoCorretorBloqueio
     */
    public function setDataDesbloqueio($dataDesbloqueio)
    {
        $this->dataDesbloqueio = $dataDesbloqueio;
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
     * @return ContatoCorretorBloqueio
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }



}
