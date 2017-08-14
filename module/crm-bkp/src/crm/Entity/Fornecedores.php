<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fornecedores
 *
 * @ORM\Table(name="fornecedores", indexes={@ORM\Index(name="fk_fornecedores_tipo_fornecedores1_idx", columns={"tipo_fornecedores_id"})})
 * @ORM\Entity
 */
class Fornecedores
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
     * @ORM\Column(name="razao_social", type="string", length=50, nullable=false)
     */
    private $razaoSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="nome_fantasia", type="string", length=50, nullable=false)
     */
    private $nomeFantasia;

    /**
     * @var string
     *
     * @ORM\Column(name="cnpj", type="string", length=20, nullable=false)
     */
    private $cnpj;

    /**
     * @var string
     *
     * @ORM\Column(name="telefone", type="string", length=12, nullable=false)
     */
    private $telefone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="site", type="string", length=45, nullable=false)
     */
    private $site;

    /**
     * @var string
     *
     * @ORM\Column(name="endereco", type="string", length=150, nullable=true)
     */
    private $endereco;

    /**
     * @var string
     *
     * @ORM\Column(name="endereco_numero", type="string", length=45, nullable=true)
     */
    private $enderecoNumero;

    /**
     * @var string
     *
     * @ORM\Column(name="endereco_complemento", type="string", length=45, nullable=true)
     */
    private $enderecoComplemento;

    /**
     * @var string
     *
     * @ORM\Column(name="cep", type="string", length=45, nullable=true)
     */
    private $cep;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_criacao", type="datetime", nullable=true)
     */
    private $dataCriacao = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_alteracao", type="datetime", nullable=true)
     */
    private $dataAlteracao;

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
     * @var \crm\Entity\TiposFornecedores
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\TiposFornecedores")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_fornecedores_id", referencedColumnName="id")
     * })
     */
    private $tipoFornecedores;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Fornecedores
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getRazaoSocial()
    {
        return $this->razaoSocial;
    }

    /**
     * @param string $razaoSocial
     * @return Fornecedores
     */
    public function setRazaoSocial($razaoSocial)
    {
        $this->razaoSocial = $razaoSocial;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomeFantasia()
    {
        return $this->nomeFantasia;
    }

    /**
     * @param string $nomeFantasia
     * @return Fornecedores
     */
    public function setNomeFantasia($nomeFantasia)
    {
        $this->nomeFantasia = $nomeFantasia;
        return $this;
    }

    /**
     * @return string
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * @param string $cnpj
     * @return Fornecedores
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param string $telefone
     * @return Fornecedores
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Fornecedores
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param string $site
     * @return Fornecedores
     */
    public function setSite($site)
    {
        $this->site = $site;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @param string $endereco
     * @return Fornecedores
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
        return $this;
    }

    /**
     * @return string
     */
    public function getEnderecoNumero()
    {
        return $this->enderecoNumero;
    }

    /**
     * @param string $enderecoNumero
     * @return Fornecedores
     */
    public function setEnderecoNumero($enderecoNumero)
    {
        $this->enderecoNumero = $enderecoNumero;
        return $this;
    }

    /**
     * @return string
     */
    public function getEnderecoComplemento()
    {
        return $this->enderecoComplemento;
    }

    /**
     * @param string $enderecoComplemento
     * @return Fornecedores
     */
    public function setEnderecoComplemento($enderecoComplemento)
    {
        $this->enderecoComplemento = $enderecoComplemento;
        return $this;
    }

    /**
     * @return string
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @param string $cep
     * @return Fornecedores
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
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
     * @return Fornecedores
     */
    public function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDataAlteracao()
    {
        return $this->dataAlteracao;
    }

    /**
     * @param \DateTime $dataAlteracao
     * @return Fornecedores
     */
    public function setDataAlteracao($dataAlteracao)
    {
        $this->dataAlteracao = $dataAlteracao;
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
     * @return Fornecedores
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return TiposFornecedores
     */
    public function getTipoFornecedores()
    {
        return $this->tipoFornecedores;
    }

    /**
     * @param TiposFornecedores $tipoFornecedores
     * @return Fornecedores
     */
    public function setTipoFornecedores($tipoFornecedores)
    {
        $this->tipoFornecedores = $tipoFornecedores;
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
