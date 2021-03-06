<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OutrasOrigensContato
 *
 * @ORM\Table(name="outras_origens_interacoes")
 * @ORM\Entity
 */
class OutrasOrigensInteracoes
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
     * @ORM\Column(name="outra_origem", type="string", length=50, nullable=false)
     */
    private $outraOrigem;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_criacao", type="string", nullable=false)
     */
    private $dataCriacao = 'CURRENT_TIMESTAMP';

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
    private $status = '1';

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OutrasOrigensContato
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getOutraOrigem()
    {
        return $this->outraOrigem;
    }

    /**
     * @param string $outraOrigem
     * @return OutrasOrigensContato
     */
    public function setOutraOrigem($outraOrigem)
    {
        $this->outraOrigem = $outraOrigem;
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
     * @return OutrasOrigensContato
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
     * @return OutrasOrigensContato
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
     * @return OutrasOrigensContato
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
}
