<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Rota
 */
class Rota
{
    /**
     * PK
     * @var integer
     */
    private $codRota;

    /**
     * @var string
     */
    private $descricaoRota;

    /**
     * @var string
     */
    private $traducaoRota;

    /**
     * @var string
     */
    private $rotaSuperior;

    /**
     * @var boolean
     */
    private $relatorio = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\GrupoPermissao
     */
    private $fkAdministracaoGrupoPermissoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoGrupoPermissoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codRota
     *
     * @param integer $codRota
     * @return Rota
     */
    public function setCodRota($codRota)
    {
        $this->codRota = $codRota;
        return $this;
    }

    /**
     * Get codRota
     *
     * @return integer
     */
    public function getCodRota()
    {
        return $this->codRota;
    }

    /**
     * Set descricaoRota
     *
     * @param string $descricaoRota
     * @return Rota
     */
    public function setDescricaoRota($descricaoRota)
    {
        $this->descricaoRota = $descricaoRota;
        return $this;
    }

    /**
     * Get descricaoRota
     *
     * @return string
     */
    public function getDescricaoRota()
    {
        return $this->descricaoRota;
    }

    /**
     * Set traducaoRota
     *
     * @param string $traducaoRota
     * @return Rota
     */
    public function setTraducaoRota($traducaoRota)
    {
        $this->traducaoRota = $traducaoRota;
        return $this;
    }

    /**
     * Get traducaoRota
     *
     * @return string
     */
    public function getTraducaoRota()
    {
        return $this->traducaoRota;
    }

    /**
     * Set rotaSuperior
     *
     * @param string $rotaSuperior
     * @return Rota
     */
    public function setRotaSuperior($rotaSuperior = null)
    {
        $this->rotaSuperior = $rotaSuperior;
        return $this;
    }

    /**
     * Get rotaSuperior
     *
     * @return string
     */
    public function getRotaSuperior()
    {
        return $this->rotaSuperior;
    }

    /**
     * Set relatorio
     *
     * @param boolean $relatorio
     * @return Rota
     */
    public function setRelatorio($relatorio)
    {
        $this->relatorio = $relatorio;
        return $this;
    }

    /**
     * Get relatorio
     *
     * @return boolean
     */
    public function getRelatorio()
    {
        return $this->relatorio;
    }

    /**
     * Add AdministracaoGrupoPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\GrupoPermissao $fkFkAdministracaoGrupoPermissoes
     * @return Rota
     */
    public function addFkAdministracaoGrupoPermissoes(\Urbem\CoreBundle\Entity\Administracao\GrupoPermissao $fkAdministracaoGrupoPermissao)
    {
        if (false === $this->fkAdministracaoGrupoPermissoes->contains($fkAdministracaoGrupoPermissao)) {
            $fkAdministracaoGrupoPermissao->setFkAdministracaoRota($this);
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
}
