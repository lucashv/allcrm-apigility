<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sites
 *
 * @ORM\Table(name="sites", indexes={@ORM\Index(name="fk_site_urls1_idx", columns={"urls_id"})})
 * @ORM\Entity
 */
class Sites
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
     * @ORM\Column(name="site", type="string", length=50, nullable=false)
     */
    public $site;

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
     * @var boolean
     *
     * @ORM\Column(name="origem_leads", type="boolean", nullable=false)
     */
    private $origemLeads = false;

    /**
     * @var \crm\Entity\Urls
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Urls")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="urls_id", referencedColumnName="id")
     * })
     */
    private $urls;

    /**
     * @var \crm\Entity\Cidades
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Cidades")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cidades_id", referencedColumnName="id")
     * })
     */
    private $cidade;

        /**
     * Get Cidade
     *
     * @return integer
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * setCidade
     *
     * @param string $site
     *
     * @return This
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
        return $this;
    }


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
     * Set site
     *
     * @param string $site
     *
     * @return Sites
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set dataCriacao
     *
     * @param \DateTime $dataCriacao
     *
     * @return Sites
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
     * @return Sites
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
     * @return Sites
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
     * Set urls
     *
     * @param \crm\Entity\Urls $urls
     *
     * @return Sites
     */
    public function setUrls(\crm\Entity\Urls $urls = null)
    {
        $this->urls = $urls;

        return $this;
    }

    /**
     * Get urls
     *
     * @return \crm\Entity\Urls
     */
    public function getUrls()
    {
        return $this->urls;
    }
}
