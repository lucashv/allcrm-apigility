<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuarios
 *
 * @ORM\Entity(repositoryClass="crm\Entity\Repository\UsuariosRepository")
 * @ORM\Table(name="usuarios", indexes={@ORM\Index(name="fk_usuarios_perfil1_idx", columns={"perfil_id"})})
 *
 */
class Usuarios
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
     * @ORM\Column(name="nome", type="string", length=50, nullable=false)
     */
    public $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="sobre_nome", type="string", length=45, nullable=true)
     */
    public $sobreNome;

    /**
     * @var string
     *
     * @ORM\Column(name="cpf", type="string", length=11, nullable=true)
     */
    private $cpf;

    /**
     * @var string
     *
     * @ORM\Column(name="telefone_1", type="string", length=45, nullable=true)
     */
    private $telefone1;

    /**
     * @var string
     *
     * @ORM\Column(name="telefone_2", type="string", length=45, nullable=true)
     */
    private $telefone2;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150, nullable=true)
     */
    private $email;

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
    private $status;

    /**
     * @var \crm\Entity\Perfil
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Perfil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="perfil_id", referencedColumnName="id")
     * })
     */
    private $perfil;

    /**
     * @var \crm\Entity\Filial
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Filiais")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="filiais_id", referencedColumnName="id")
     * })
     */
    private $filial;

    /**
     * @var \crm\Entity\Usuarios
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="supervisor_id", referencedColumnName="id")
     * })
     */
    private $supervisor;

    /**
     * @var boolean
     *
     * @ORM\Column(name="envio_bloqueado", type="boolean", nullable=true)
     */
    private $envioBloqueado;


    /**
     * @var string
     *
     * @ORM\Column(name="user_principal_name", type="string", length=150, nullable=true)
     */
    private $userPrincipalName;

    /**
     * @return Filial
     */
    public function getFilial()
    {
        return $this->filial;
    }

    /**
     * @param Filial $filial
     * @return Usuarios
     */
    public function setFilial($filial)
    {
        $this->filial = $filial;
        return $this;
    }




    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Usuarios
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     * @return Usuarios
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return string
     */
    public function getSobreNome()
    {
        return $this->sobreNome;
    }

    /**
     * @param string $sobreNome
     * @return Usuarios
     */
    public function setSobreNome($sobreNome)
    {
        $this->sobreNome = $sobreNome;
        return $this;
    }

    /**
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     * @return Usuarios
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelefone1()
    {
        return $this->telefone1;
    }

    /**
     * @param string $telefone1
     * @return Usuarios
     */
    public function setTelefone1($telefone1)
    {
        $this->telefone1 = $telefone1;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelefone2()
    {
        return $this->telefone2;
    }

    /**
     * @param string $telefone2
     * @return Usuarios
     */
    public function setTelefone2($telefone2)
    {
        $this->telefone2 = $telefone2;
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
     * @return Usuarios
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * @return Usuarios
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
     * @return Usuarios
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
     * @return Usuarios
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return Perfil
     */
    public function getPerfil()
    {
        return $this->perfil;
    }

    /**
     * @param Perfil $perfil
     * @return Usuarios
     */
    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;
        return $this;
    }

    /**
     * @return Usuarios
     */
    public function getSupervisor()
    {
        return $this->supervisor;
    }

    /**
     * @param Usuarios $supervisor
     * @return Usuarios
     */
    public function setSupervisor($supervisor)
    {
        $this->supervisor = $supervisor;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isEnvioBloqueado()
    {
        return $this->envioBloqueado;
    }

    /**
     * @param boolean $envioBloqueado
     * @return Usuarios
     */
    public function setEnvioBloqueado($envioBloqueado)
    {
        $this->envioBloqueado = $envioBloqueado;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserPrincipalName()
    {
        return $this->userPrincipalName;
    }

    /**
     * @param string $userPrincipalName
     * @return Usuarios
     */
    public function setUserPrincipalName($userPrincipalName)
    {
        $this->userPrincipalName = $userPrincipalName;
        return $this;
    }






}