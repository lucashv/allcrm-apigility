<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plantoes
 *
 * @ORM\Table(name="tipos_plantoes")
 * @ORM\Entity
 */
class TiposPlantoes
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
     * @ORM\Column(name="tipo", type="string", length=150, nullable=false)
     */
    public $tipo;

    /**
     * @var integer
     *
     * @ORM\Column(name="validade", type="integer", nullable=false)
     */
    public $validade;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_criacao", type="string", nullable=true)
     */
    private $dataCriacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_edicao", type="string", nullable=true)
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
     * @return TiposPlantoes
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     * @return TiposPlantoes
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * @return int
     */
    public function getValidade()
    {
        return $this->validade;
    }

    /**
     * @param int $validade
     * @return TiposPlantoes
     */
    public function setValidade($validade)
    {
        $this->validade = $validade;
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
     * @return TiposPlantoes
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
     * @return TiposPlantoes
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
     * @return TiposPlantoes
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

}