<?php

namespace crm\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModulosPermissoes
 * @ORM\Entity(repositoryClass="crm\Entity\Repository\ModulosPermissoesRepository")
 * @ORM\Table(name="modulos_permissoes", indexes={@ORM\Index(name="fk_modulos_permissoes_modulos1_idx", columns={"modulos_id"}), @ORM\Index(name="fk_modulos_permissoes_usuarios1_idx", columns={"usuarios_id"}), @ORM\Index(name="fk_modulos_permissoes_perfil1_idx", columns={"perfil_id"})})
 *
 */
class ModulosPermissoes
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
     * @var \crm\Entity\Modulos
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Modulos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modulos_id", referencedColumnName="id")
     * })
     */
    private $modulos;

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
     * @var \crm\Entity\Usuarios
     *
     * @ORM\ManyToOne(targetEntity="crm\Entity\Usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuarios_id", referencedColumnName="id")
     * })
     */
    private $usuarios;

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
     * Set modulos
     *
     * @param \crm\Entity\Modulos $modulos
     *
     * @return ModulosPermissoes
     */
    public function setModulos(\crm\Entity\Modulos $modulos = null)
    {
        $this->modulos = $modulos;

        return $this;
    }

    /**
     * Get modulos
     *
     * @return \crm\Entity\Modulos
     */
    public function getModulos()
    {
        return $this->modulos;
    }

    /**
     * Set perfil
     *
     * @param \crm\Entity\Perfil $perfil
     *
     * @return ModulosPermissoes
     */
    public function setPerfil(\crm\Entity\Perfil $perfil = null)
    {
        $this->perfil = $perfil;

        return $this;
    }

    /**
     * Get perfil
     *
     * @return \crm\Entity\Perfil
     */
    public function getPerfil()
    {
        return $this->perfil;
    }

    /**
     * Set usuarios
     *
     * @param \crm\Entity\Usuarios $usuarios
     *
     * @return ModulosPermissoes
     */
    public function setUsuarios(\crm\Entity\Usuarios $usuarios = null)
    {
        $this->usuarios = $usuarios;

        return $this;
    }

    /**
     * Get usuarios
     *
     * @return \crm\Entity\Usuarios
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }
}
