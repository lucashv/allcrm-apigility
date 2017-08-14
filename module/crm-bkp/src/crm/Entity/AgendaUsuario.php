<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InteracoesContato
 *
 * @ORM\Table(name="agenda_usuario")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="crm\Entity\Repository\AgendaUsuarioRepository")
 */
class AgendaUsuario
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
     * @ORM\Column(name="titulo", type="string", length=200, nullable=false)
     */
    public $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=300, nullable=false)
     */
    public $descricao;


    /**
     * @var \crm\Entity\Usuarios
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Usuarios" )
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     * })
     */
    public $usuario;

    /**
     * @var \crm\Entity\Contatos
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Contatos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contato_id", referencedColumnName="id")
     * })
     */
    public $contato;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_agenda", type="datetime", nullable=false)
     */
    public $dataAgenda;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_criacao", type="datetime", nullable=false)
     */
    public $dataCriacao;

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
    public $status = 1;

    /**
     * @var boolean
     *
     * @ORM\Column(name="concluida", type="boolean", nullable=false)
     */
    public $concluida = false;



    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return AgendaUsuario
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param string $titulo
     * @return AgendaUsuario
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     * @return AgendaUsuario
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @return Usuarios
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param Usuarios $usuario
     * @return AgendaUsuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
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
     * @return AgendaUsuario
     */
    public function setContato($contato)
    {
        $this->contato = $contato;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataAgenda()
    {
        return $this->dataAgenda;
    }

    /**
     * @param \DateTime $dataAgenda
     * @return AgendaUsuario
     */
    public function setDataAgenda($dataAgenda)
    {
        $this->dataAgenda = $dataAgenda;
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
     * @return AgendaUsuario
     */
    public function setDataCriacao()
    {
        $this->dataCriacao = new \DateTime("now");;
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
     * @return AgendaUsuario
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
     * @return AgendaUsuario
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isConcluida()
    {
        return $this->concluida;
    }

    /**
     * @param boolean $concluida
     * @return AgendaUsuario
     */
    public function setConcluida($concluida)
    {
        $this->concluida = $concluida;
        return $this;
    }






}