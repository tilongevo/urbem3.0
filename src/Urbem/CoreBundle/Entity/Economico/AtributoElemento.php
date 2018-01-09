<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * AtributoElemento
 */
class AtributoElemento
{
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
    private $codElemento;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoElemCadEconomicoValor
     */
    private $fkEconomicoAtributoElemCadEconomicoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoElemLicenDiversaValor
     */
    private $fkEconomicoAtributoElemLicenDiversaValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Elemento
     */
    private $fkEconomicoElemento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoAtributoElemCadEconomicoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoAtributoElemLicenDiversaValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoElemento
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
     * @return AtributoElemento
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
     * Set codElemento
     *
     * @param integer $codElemento
     * @return AtributoElemento
     */
    public function setCodElemento($codElemento)
    {
        $this->codElemento = $codElemento;
        return $this;
    }

    /**
     * Get codElemento
     *
     * @return integer
     */
    public function getCodElemento()
    {
        return $this->codElemento;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoElemento
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
     * @return AtributoElemento
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
     * Add EconomicoAtributoElemCadEconomicoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoElemCadEconomicoValor $fkEconomicoAtributoElemCadEconomicoValor
     * @return AtributoElemento
     */
    public function addFkEconomicoAtributoElemCadEconomicoValores(\Urbem\CoreBundle\Entity\Economico\AtributoElemCadEconomicoValor $fkEconomicoAtributoElemCadEconomicoValor)
    {
        if (false === $this->fkEconomicoAtributoElemCadEconomicoValores->contains($fkEconomicoAtributoElemCadEconomicoValor)) {
            $fkEconomicoAtributoElemCadEconomicoValor->setFkEconomicoAtributoElemento($this);
            $this->fkEconomicoAtributoElemCadEconomicoValores->add($fkEconomicoAtributoElemCadEconomicoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtributoElemCadEconomicoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoElemCadEconomicoValor $fkEconomicoAtributoElemCadEconomicoValor
     */
    public function removeFkEconomicoAtributoElemCadEconomicoValores(\Urbem\CoreBundle\Entity\Economico\AtributoElemCadEconomicoValor $fkEconomicoAtributoElemCadEconomicoValor)
    {
        $this->fkEconomicoAtributoElemCadEconomicoValores->removeElement($fkEconomicoAtributoElemCadEconomicoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtributoElemCadEconomicoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoElemCadEconomicoValor
     */
    public function getFkEconomicoAtributoElemCadEconomicoValores()
    {
        return $this->fkEconomicoAtributoElemCadEconomicoValores;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtributoElemLicenDiversaValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoElemLicenDiversaValor $fkEconomicoAtributoElemLicenDiversaValor
     * @return AtributoElemento
     */
    public function addFkEconomicoAtributoElemLicenDiversaValores(\Urbem\CoreBundle\Entity\Economico\AtributoElemLicenDiversaValor $fkEconomicoAtributoElemLicenDiversaValor)
    {
        if (false === $this->fkEconomicoAtributoElemLicenDiversaValores->contains($fkEconomicoAtributoElemLicenDiversaValor)) {
            $fkEconomicoAtributoElemLicenDiversaValor->setFkEconomicoAtributoElemento($this);
            $this->fkEconomicoAtributoElemLicenDiversaValores->add($fkEconomicoAtributoElemLicenDiversaValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtributoElemLicenDiversaValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoElemLicenDiversaValor $fkEconomicoAtributoElemLicenDiversaValor
     */
    public function removeFkEconomicoAtributoElemLicenDiversaValores(\Urbem\CoreBundle\Entity\Economico\AtributoElemLicenDiversaValor $fkEconomicoAtributoElemLicenDiversaValor)
    {
        $this->fkEconomicoAtributoElemLicenDiversaValores->removeElement($fkEconomicoAtributoElemLicenDiversaValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtributoElemLicenDiversaValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoElemLicenDiversaValor
     */
    public function getFkEconomicoAtributoElemLicenDiversaValores()
    {
        return $this->fkEconomicoAtributoElemLicenDiversaValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoElemento
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
     * ManyToOne (inverse side)
     * Set fkEconomicoElemento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Elemento $fkEconomicoElemento
     * @return AtributoElemento
     */
    public function setFkEconomicoElemento(\Urbem\CoreBundle\Entity\Economico\Elemento $fkEconomicoElemento)
    {
        $this->codElemento = $fkEconomicoElemento->getCodElemento();
        $this->fkEconomicoElemento = $fkEconomicoElemento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoElemento
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Elemento
     */
    public function getFkEconomicoElemento()
    {
        return $this->fkEconomicoElemento;
    }
}
