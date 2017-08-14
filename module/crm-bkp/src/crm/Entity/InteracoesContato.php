<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InteracoesContato
 *
 * @ORM\Table(name="interacoes_contato", indexes={@ORM\Index(name="fk_interacoes_contato_contatos1_idx", columns={"contato_id"}), @ORM\Index(name="fk_interacoes_contato_usuarios1_idx", columns={"usuario_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="crm\Entity\Repository\InteracoesContatoRepository")
 */
class InteracoesContato
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
     * @ORM\Column(name="descricao", type="string", length=200, nullable=false)
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
    private $status = 1;

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
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    private $usuario;

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
     * @var \crm\Entity\Usuarios
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\SituacoesInteracoes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="situacao_interecoes_id", referencedColumnName="id")
     * })
     */
    private $situacoesInteracoes;

    /**
     * @var \crm\Entity\InteracoesOrigem
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\InteracoesOrigem", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="interacoes_origem_id", referencedColumnName="id")
     * })
     */
    public $interacoesOrigem;


    /**
     * @var \crm\Entity\Produto
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Produtos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produtos_id", referencedColumnName="id")
     * })
     */
    private $produto;

    /**
     * @var \this
     *
     * @ORM\ManyToOne(targetEntity="InteracoesContato")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="interacao_pai_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $interacaoPai;

    /**
     * @var \this
     *
     * @ORM\ManyToOne(targetEntity="TiposEnvio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_envio_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $tipoEnvio = null;


    /**
     * @var boolean
     *
     * @ORM\Column(name="email_enviado", type="boolean", nullable=true)
     */
    private $emailEnviado = 1;

    /**
    * @var string
    *
    * @ORM\Column(name="observacao_envio", type="string", length=200, nullable=true)
    */
    private $observacaoEnvio;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="TiposLigacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_ligacao_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $tipoLigacao = null;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Plantoes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="plantao_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $plantao = null;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return InteracoesContato
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return InteracoesContato
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
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
     * @return InteracoesContato
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
     * @return InteracoesContato
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
     * @return InteracoesContato
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
     * @return InteracoesContato
     */
    public function setContato($contato)
    {
        $this->contato = $contato;
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
     * @return InteracoesContato
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
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
     * @return InteracoesContato
     */
    public function setCorretor($corretor)
    {
        $this->corretor = $corretor;
        return $this;
    }

    /**
     * @return Usuarios
     */
    public function getSituacoesInteracoes()
    {
        return $this->situacoesInteracoes;
    }

    /**
     * @param Usuarios $situacoesInteracoes
     * @return InteracoesContato
     */
    public function setSituacoesInteracoes($situacoesInteracoes)
    {
        $this->situacoesInteracoes = $situacoesInteracoes;
        return $this;
    }

    /**
     * @return InteracoesOrigem
     */
    public function getInteracoesOrigem()
    {
        return $this->interacoesOrigem;
    }

    /**
     * @param InteracoesOrigem $interacoesOrigem
     * @return InteracoesContato
     */
    public function setInteracoesOrigem($interacoesOrigem)
    {
        $this->interacoesOrigem = $interacoesOrigem;
        return $this;
    }

    /**
     * @return Produto
     */
    public function getProduto()
    {
        return $this->produto;
    }

    /**
     * @param Produto $produto
     * @return InteracoesContato
     */
    public function setProduto($produto)
    {
        $this->produto = $produto;
        return $this;
    }

    /**
     * @return \this
     */
    public function getInteracaoPai()
    {
        return $this->interacaoPai;
    }

    /**
     * @param \this $interacaoPai
     * @return InteracoesContato
     */
    public function setInteracaoPai($interacaoPai)
    {
        $this->interacaoPai = $interacaoPai;
        return $this;
    }

    /**
     * @return \this
     */
    public function getTipoEnvio()
    {
        return $this->tipoEnvio;
    }

    /**
     * @param \this $tipoEnvio
     * @return InteracoesContato
     */
    public function setTipoEnvio($tipoEnvio)
    {
        $this->tipoEnvio = $tipoEnvio;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isEmailEnviado()
    {
        return $this->emailEnviado;
    }

    /**
     * @param boolean $emailEnviado
     * @return InteracoesContato
     */
    public function setEmailEnviado($emailEnviado)
    {
        $this->emailEnviado = $emailEnviado;
        return $this;
    }

    /**
     * @return string
     */
    public function getObservacaoEnvio()
    {
        return $this->observacaoEnvio;
    }

    /**
     * @param string $observacaoEnvio
     * @return InteracoesContato
     */
    public function setObservacaoEnvio($observacaoEnvio)
    {
        $this->observacaoEnvio = $observacaoEnvio;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipoLigacao()
    {
        return $this->tipoLigacao;
    }

    /**
     * @param mixed $tipoLigacao
     * @return InteracoesContato
     */
    public function setTipoLigacao($tipoLigacao)
    {
        $this->tipoLigacao = $tipoLigacao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlantao()
    {
        return $this->plantao;
    }

    /**
     * @param mixed $plantao
     * @return InteracoesContato
     */
    public function setPlantao($plantao)
    {
        $this->plantao = $plantao;
        return $this;
    }








}
