<?php
namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Propostas
 * @ORM\Entity(repositoryClass="crm\Entity\Repository\PropostasRepository")
 * @ORM\Table(name="propostas")
 *
 *
 */
class Propostas
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
     * @var \crm\Entity\Operadoras
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\TipoPropostaOperadora")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_proposta_operadora", referencedColumnName="id", nullable = false)
     * })
     */
    private $tipoPropostaOperadora;

    /**
     * @var \crm\Entity\Operadoras
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\SituacaoProposta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="situacao_proposta", referencedColumnName="id", nullable = false)
     * })
     */
    private $situacaoProposta;

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
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Operadoras
     */
    public function getTipoPropostaOperadora()
    {
        return $this->tipoPropostaOperadora;
    }

    /**
     * @param Operadoras $tipoPropostaOperadora
     */
    public function setTipoPropostaOperadora($tipoPropostaOperadora)
    {
        $this->tipoPropostaOperadora = $tipoPropostaOperadora;
    }

    /**
     * @return Operadoras
     */
    public function getSituacaoProposta()
    {
        return $this->situacaoProposta;
    }

    /**
     * @param Operadoras $situacaoProposta
     */
    public function setSituacaoProposta($situacaoProposta)
    {
        $this->situacaoProposta = $situacaoProposta;
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
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
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
     */
    public function setDataCriacao()
    {
        $this->dataCriacao = new \DateTime("now");
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
     */
    public function setDataEdicao($dataEdicao)
    {
        $this->dataEdicao = $dataEdicao;
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
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }




}