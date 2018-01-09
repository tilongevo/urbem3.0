<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * AtributoTipoLicencaDiversa
 */
class AtributoTipoLicencaDiversa
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoLicencaDiversaValor
     */
    private $fkEconomicoAtributoLicencaDiversaValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa
     */
    private $fkEconomicoTipoLicencaDiversa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoAtributoLicencaDiversaValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return AtributoTipoLicencaDiversa
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
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoTipoLicencaDiversa
     */
    public function setCodCadastro($codCadastro)
    {
        $this->codCadastro = $codCadastro;
        return $this;
    }

    /**
     * Get codCadastro
     *
     * @return integer
     */
    public function getCodCadastro()
    {
        return $this->codCadastro;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoTipoLicencaDiversa
     */
    public function setCodAtributo($codAtributo)
    {
        $this->codAtributo = $codAtributo;
        return $this;
    }

    /**
     * Get codAtributo
     *
     * @return integer
     */
    public function getCodAtributo()
    {
        return $this->codAtributo;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoTipoLicencaDiversa
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return AtributoTipoLicencaDiversa
     */
    public function setAtivo($ativo)
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
     * OneToMany (owning side)
     * Add EconomicoAtributoLicencaDiversaValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoLicencaDiversaValor $fkEconomicoAtributoLicencaDiversaValor
     * @return AtributoTipoLicencaDiversa
     */
    public function addFkEconomicoAtributoLicencaDiversaValores(\Urbem\CoreBundle\Entity\Economico\AtributoLicencaDiversaValor $fkEconomicoAtributoLicencaDiversaValor)
    {
        if (false === $this->fkEconomicoAtributoLicencaDiversaValores->contains($fkEconomicoAtributoLicencaDiversaValor)) {
            $fkEconomicoAtributoLicencaDiversaValor->setFkEconomicoAtributoTipoLicencaDiversa($this);
            $this->fkEconomicoAtributoLicencaDiversaValores->add($fkEconomicoAtributoLicencaDiversaValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtributoLicencaDiversaValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoLicencaDiversaValor $fkEconomicoAtributoLicencaDiversaValor
     */
    public function removeFkEconomicoAtributoLicencaDiversaValores(\Urbem\CoreBundle\Entity\Economico\AtributoLicencaDiversaValor $fkEconomicoAtributoLicencaDiversaValor)
    {
        $this->fkEconomicoAtributoLicencaDiversaValores->removeElement($fkEconomicoAtributoLicencaDiversaValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtributoLicencaDiversaValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoLicencaDiversaValor
     */
    public function getFkEconomicoAtributoLicencaDiversaValores()
    {
        return $this->fkEconomicoAtributoLicencaDiversaValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoTipoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa $fkEconomicoTipoLicencaDiversa
     * @return AtributoTipoLicencaDiversa
     */
    public function setFkEconomicoTipoLicencaDiversa(\Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa $fkEconomicoTipoLicencaDiversa)
    {
        $this->codTipo = $fkEconomicoTipoLicencaDiversa->getCodTipo();
        $this->fkEconomicoTipoLicencaDiversa = $fkEconomicoTipoLicencaDiversa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoTipoLicencaDiversa
     *
     * @return \Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa
     */
    public function getFkEconomicoTipoLicencaDiversa()
    {
        return $this->fkEconomicoTipoLicencaDiversa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoTipoLicencaDiversa
     */
    public function setFkAdministracaoAtributoDinamico(\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico)
    {
        $this->codModulo = $fkAdministracaoAtributoDinamico->getCodModulo();
        $this->codCadastro = $fkAdministracaoAtributoDinamico->getCodCadastro();
        $this->codAtributo = $fkAdministracaoAtributoDinamico->getCodAtributo();
        $this->fkAdministracaoAtributoDinamico = $fkAdministracaoAtributoDinamico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoAtributoDinamico
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    public function getFkAdministracaoAtributoDinamico()
    {
        return $this->fkAdministracaoAtributoDinamico;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s', $this->getCodAtributo());
    }
}
