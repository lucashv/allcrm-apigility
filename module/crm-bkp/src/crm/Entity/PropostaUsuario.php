<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuantidadePropostasUsuario
 * @ORM\Entity(repositoryClass="crm\Entity\Repository\PropostaUsuarioRepository")
 * @ORM\Table(name="proposta_usuario")
 *
 */
class PropostaUsuario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \crm\Entity\Usuarios
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    private $usuario;

    /**
     * @var \crm\Entity\Propostas
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Propostas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="propostas", referencedColumnName="id")
     * })
     */
    private $proposta;

    /**
     * @var string
     *
     * @ORM\Column(name="observacao", type="text", length=200, nullable=false)
     */
    protected $observacao;

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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PropostaUsuario
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return PropostaUsuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * @return Propostas
     */
    public function getProposta()
    {
        return $this->proposta;
    }

    /**
     * @param Propostas $proposta
     * @return PropostaUsuario
     */
    public function setProposta($proposta)
    {
        $this->proposta = $proposta;
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
     * @return PropostaUsuario
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
     * @return PropostaUsuario
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
     * @return PropostaUsuario
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
     * @return PropostaUsuario
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }




}