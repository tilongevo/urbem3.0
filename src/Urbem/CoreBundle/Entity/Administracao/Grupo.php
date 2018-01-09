<?php

namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Grupo
 */
class Grupo
{
    /**
     * PK
     * @var integer
     */
    private $codGrupo;

    /**
     * @var string
     */
    private $nomGrupo;

    /**
     * @var string
     */
    private $descGrupo;

    /**
     * @var boolean
     */
    private $ativo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\GrupoPermissao
     */
    private $fkAdministracaoGrupoPermissoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\GrupoUsuario
     */
    private $fkAdministracaoGrupoUsuarios;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoGrupoPermissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoGrupoUsuarios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return Grupo
     */
    public function setCodGrupo($codGrupo)
    {
        $this->codGrupo = $codGrupo;
        return $this;
    }

    /**
     * Get codGrupo
     *
     * @return integer
     */
    public function getCodGrupo()
    {
        return $this->codGrupo;
    }

    /**
     * Set nomGrupo
     *
     * @param string $nomGrupo
     * @return Grupo
     */
    public function setNomGrupo($nomGrupo)
    {
        $this->nomGrupo = $nomGrupo;
        return $this;
    }

    /**
     * Get nomGrupo
     *
     * @return string
     */
    public function getNomGrupo()
    {
        return $this->nomGrupo;
    }

    /**
     * Set descGrupo
     *
     * @param string $descGrupo
     * @return Grupo
     */
    public function setDescGrupo($descGrupo)
    {
        $this->descGrupo = $descGrupo;
        return $this;
    }

    /**
     * Get descGrupo
     *
     * @return string
     */
    public function getDescGrupo()
    {
        return $this->descGrupo;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Grupo
     */
    public function setAtivo($ativo = null)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * Add AdministracaoGrupoPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\GrupoPermissao $fkFkAdministracaoGrupoPermissoes
     * @return Grupo
     */
    public function addFkAdministracaoGrupoPermissoes(\Urbem\CoreBundle\Entity\Administracao\GrupoPermissao $fkAdministracaoGrupoPermissao)
    {
        if (false === $this->fkAdministracaoGrupoPermissoes->contains($fkAdministracaoGrupoPermissao)) {
            $fkAdministracaoGrupoPermissao->setFkAdministracaoGrupo($this);
            $this->fkAdministracaoGrupoPermissoes->add($fkAdministracaoGrupoPermissao);
        }

        return $this;
    }

    /**
     * Remove AdministracaoGrupoPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\GrupoPermissao $fkFkAdministracaoGrupoPermissoes
     */
    public function removeFkAdministracaoGrupoPermissoes(\Urbem\CoreBundle\Entity\Administracao\GrupoPermissao $fkAdministracaoGrupoPermissao)
    {
        $this->fkAdministracaoGrupoPermissoes->removeElement($fkAdministracaoGrupoPermissao);
    }

    /**
     * Get fkAdministracaoGrupoPermissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\GrupoPermissao
     */
    public function getFkAdministracaoGrupoPermissoes()
    {
        return $this->fkAdministracaoGrupoPermissoes;
    }

    /**
     * Add AdministracaoGrupoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\GrupoUsuario $fkFkAdministracaoGrupoUsuarios
     * @return Grupo
     */
    public function addFkAdministracaoGrupoUsuarios(\Urbem\CoreBundle\Entity\Administracao\GrupoUsuario $fkAdministracaoGrupoUsuario)
    {
        if (false === $this->fkAdministracaoGrupoUsuarios->contains($fkAdministracaoGrupoUsuario)) {
            $fkAdministracaoGrupoUsuario->setFkAdministracaoGrupo($this);
            $this->fkAdministracaoGrupoUsuarios->add($fkAdministracaoGrupoUsuario);
        }

        return $this;
    }

    /**
     * Remove AdministracaoGrupoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\GrupoUsuario $fkFkAdministracaoGrupoUsuarios
     */
    public function removeFkAdministracaoGrupoUsuarios(\Urbem\CoreBundle\Entity\Administracao\GrupoUsuario $fkAdministracaoGrupoUsuario)
    {
        $this->fkAdministracaoGrupoUsuarios->removeElement($fkAdministracaoGrupoUsuario);
    }

    /**
     * Get fkAdministracaoGrupoUsuarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\GrupoUsuario
     */
    public function getFkAdministracaoGrupoUsuarios()
    {
        return $this->fkAdministracaoGrupoUsuarios;
    }

    public function setFkAdministracaoGrupoUsuarios($fkAdministracaoGrupoUsuarios)
    {
        $this->fkAdministracaoGrupoUsuarios = $fkAdministracaoGrupoUsuarios;
    }
}
