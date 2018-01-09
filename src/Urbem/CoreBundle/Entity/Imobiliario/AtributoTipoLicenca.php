<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * AtributoTipoLicenca
 */
class AtributoTipoLicenca
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
    private $codAtributo;

    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * @var boolean
     */
    private $ativo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaLoteValor
     */
    private $fkImobiliarioAtributoTipoLicencaLoteValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaImovelValor
     */
    private $fkImobiliarioAtributoTipoLicencaImovelValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TipoLicenca
     */
    private $fkImobiliarioTipoLicenca;

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
        $this->fkImobiliarioAtributoTipoLicencaLoteValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioAtributoTipoLicencaImovelValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return AtributoTipoLicenca
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
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoTipoLicenca
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
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoTipoLicenca
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoTipoLicenca
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
     * @return AtributoTipoLicenca
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
     * Add ImobiliarioAtributoTipoLicencaLoteValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaLoteValor $fkImobiliarioAtributoTipoLicencaLoteValor
     * @return AtributoTipoLicenca
     */
    public function addFkImobiliarioAtributoTipoLicencaLoteValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaLoteValor $fkImobiliarioAtributoTipoLicencaLoteValor)
    {
        if (false === $this->fkImobiliarioAtributoTipoLicencaLoteValores->contains($fkImobiliarioAtributoTipoLicencaLoteValor)) {
            $fkImobiliarioAtributoTipoLicencaLoteValor->setFkImobiliarioAtributoTipoLicenca($this);
            $this->fkImobiliarioAtributoTipoLicencaLoteValores->add($fkImobiliarioAtributoTipoLicencaLoteValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoTipoLicencaLoteValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaLoteValor $fkImobiliarioAtributoTipoLicencaLoteValor
     */
    public function removeFkImobiliarioAtributoTipoLicencaLoteValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaLoteValor $fkImobiliarioAtributoTipoLicencaLoteValor)
    {
        $this->fkImobiliarioAtributoTipoLicencaLoteValores->removeElement($fkImobiliarioAtributoTipoLicencaLoteValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoTipoLicencaLoteValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaLoteValor
     */
    public function getFkImobiliarioAtributoTipoLicencaLoteValores()
    {
        return $this->fkImobiliarioAtributoTipoLicencaLoteValores;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoTipoLicencaImovelValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaImovelValor $fkImobiliarioAtributoTipoLicencaImovelValor
     * @return AtributoTipoLicenca
     */
    public function addFkImobiliarioAtributoTipoLicencaImovelValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaImovelValor $fkImobiliarioAtributoTipoLicencaImovelValor)
    {
        if (false === $this->fkImobiliarioAtributoTipoLicencaImovelValores->contains($fkImobiliarioAtributoTipoLicencaImovelValor)) {
            $fkImobiliarioAtributoTipoLicencaImovelValor->setFkImobiliarioAtributoTipoLicenca($this);
            $this->fkImobiliarioAtributoTipoLicencaImovelValores->add($fkImobiliarioAtributoTipoLicencaImovelValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoTipoLicencaImovelValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaImovelValor $fkImobiliarioAtributoTipoLicencaImovelValor
     */
    public function removeFkImobiliarioAtributoTipoLicencaImovelValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaImovelValor $fkImobiliarioAtributoTipoLicencaImovelValor)
    {
        $this->fkImobiliarioAtributoTipoLicencaImovelValores->removeElement($fkImobiliarioAtributoTipoLicencaImovelValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoTipoLicencaImovelValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaImovelValor
     */
    public function getFkImobiliarioAtributoTipoLicencaImovelValores()
    {
        return $this->fkImobiliarioAtributoTipoLicencaImovelValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioTipoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoLicenca $fkImobiliarioTipoLicenca
     * @return AtributoTipoLicenca
     */
    public function setFkImobiliarioTipoLicenca(\Urbem\CoreBundle\Entity\Imobiliario\TipoLicenca $fkImobiliarioTipoLicenca)
    {
        $this->codTipo = $fkImobiliarioTipoLicenca->getCodTipo();
        $this->fkImobiliarioTipoLicenca = $fkImobiliarioTipoLicenca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioTipoLicenca
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\TipoLicenca
     */
    public function getFkImobiliarioTipoLicenca()
    {
        return $this->fkImobiliarioTipoLicenca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoTipoLicenca
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
}
