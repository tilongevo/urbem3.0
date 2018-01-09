<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * TipoAtributo
 */
class TipoAtributo
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAtributoDinamico
     */
    private $fkSwAtributoDinamicos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoAtributoDinamicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwAtributoDinamicos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoAtributo
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return TipoAtributo
     */
    public function setNomTipo($nomTipo)
    {
        $this->nomTipo = $nomTipo;
        return $this;
    }

    /**
     * Get nomTipo
     *
     * @return string
     */
    public function getNomTipo()
    {
        return $this->nomTipo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoAtributo
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return TipoAtributo
     */
    public function addFkAdministracaoAtributoDinamicos(\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico)
    {
        if (false === $this->fkAdministracaoAtributoDinamicos->contains($fkAdministracaoAtributoDinamico)) {
            $fkAdministracaoAtributoDinamico->setFkAdministracaoTipoAtributo($this);
            $this->fkAdministracaoAtributoDinamicos->add($fkAdministracaoAtributoDinamico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     */
    public function removeFkAdministracaoAtributoDinamicos(\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico)
    {
        $this->fkAdministracaoAtributoDinamicos->removeElement($fkAdministracaoAtributoDinamico);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoAtributoDinamicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    public function getFkAdministracaoAtributoDinamicos()
    {
        return $this->fkAdministracaoAtributoDinamicos;
    }

    /**
     * OneToMany (owning side)
     * Add SwAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoDinamico $fkSwAtributoDinamico
     * @return TipoAtributo
     */
    public function addFkSwAtributoDinamicos(\Urbem\CoreBundle\Entity\SwAtributoDinamico $fkSwAtributoDinamico)
    {
        if (false === $this->fkSwAtributoDinamicos->contains($fkSwAtributoDinamico)) {
            $fkSwAtributoDinamico->setFkAdministracaoTipoAtributo($this);
            $this->fkSwAtributoDinamicos->add($fkSwAtributoDinamico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoDinamico $fkSwAtributoDinamico
     */
    public function removeFkSwAtributoDinamicos(\Urbem\CoreBundle\Entity\SwAtributoDinamico $fkSwAtributoDinamico)
    {
        $this->fkSwAtributoDinamicos->removeElement($fkSwAtributoDinamico);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwAtributoDinamicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAtributoDinamico
     */
    public function getFkSwAtributoDinamicos()
    {
        return $this->fkSwAtributoDinamicos;
    }

    /**
     * Exemplo: 4 - Lista Múltipla
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%d - %s', $this->codTipo, $this->nomTipo);
    }
}
