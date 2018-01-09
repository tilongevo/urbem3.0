<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * ElementoLicencaDiversa
 */
class ElementoLicencaDiversa
{
    /**
     * PK
     * @var integer
     */
    private $codElemento;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codLicenca;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $ocorrencia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoElemLicenDiversaValor
     */
    private $fkEconomicoAtributoElemLicenDiversaValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa
     */
    private $fkEconomicoElementoTipoLicencaDiversa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\LicencaDiversa
     */
    private $fkEconomicoLicencaDiversa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoAtributoElemLicenDiversaValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codElemento
     *
     * @param integer $codElemento
     * @return ElementoLicencaDiversa
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ElementoLicencaDiversa
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
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return ElementoLicencaDiversa
     */
    public function setCodLicenca($codLicenca)
    {
        $this->codLicenca = $codLicenca;
        return $this;
    }

    /**
     * Get codLicenca
     *
     * @return integer
     */
    public function getCodLicenca()
    {
        return $this->codLicenca;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ElementoLicencaDiversa
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set ocorrencia
     *
     * @param integer $ocorrencia
     * @return ElementoLicencaDiversa
     */
    public function setOcorrencia($ocorrencia)
    {
        $this->ocorrencia = $ocorrencia;
        return $this;
    }

    /**
     * Get ocorrencia
     *
     * @return integer
     */
    public function getOcorrencia()
    {
        return $this->ocorrencia;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtributoElemLicenDiversaValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoElemLicenDiversaValor $fkEconomicoAtributoElemLicenDiversaValor
     * @return ElementoLicencaDiversa
     */
    public function addFkEconomicoAtributoElemLicenDiversaValores(\Urbem\CoreBundle\Entity\Economico\AtributoElemLicenDiversaValor $fkEconomicoAtributoElemLicenDiversaValor)
    {
        if (false === $this->fkEconomicoAtributoElemLicenDiversaValores->contains($fkEconomicoAtributoElemLicenDiversaValor)) {
            $fkEconomicoAtributoElemLicenDiversaValor->setFkEconomicoElementoLicencaDiversa($this);
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
     * Set fkEconomicoElementoTipoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa $fkEconomicoElementoTipoLicencaDiversa
     * @return ElementoLicencaDiversa
     */
    public function setFkEconomicoElementoTipoLicencaDiversa(\Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa $fkEconomicoElementoTipoLicencaDiversa)
    {
        $this->codElemento = $fkEconomicoElementoTipoLicencaDiversa->getCodElemento();
        $this->codTipo = $fkEconomicoElementoTipoLicencaDiversa->getCodTipo();
        $this->fkEconomicoElementoTipoLicencaDiversa = $fkEconomicoElementoTipoLicencaDiversa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoElementoTipoLicencaDiversa
     *
     * @return \Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa
     */
    public function getFkEconomicoElementoTipoLicencaDiversa()
    {
        return $this->fkEconomicoElementoTipoLicencaDiversa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaDiversa $fkEconomicoLicencaDiversa
     * @return ElementoLicencaDiversa
     */
    public function setFkEconomicoLicencaDiversa(\Urbem\CoreBundle\Entity\Economico\LicencaDiversa $fkEconomicoLicencaDiversa)
    {
        $this->codLicenca = $fkEconomicoLicencaDiversa->getCodLicenca();
        $this->exercicio = $fkEconomicoLicencaDiversa->getExercicio();
        $this->fkEconomicoLicencaDiversa = $fkEconomicoLicencaDiversa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoLicencaDiversa
     *
     * @return \Urbem\CoreBundle\Entity\Economico\LicencaDiversa
     */
    public function getFkEconomicoLicencaDiversa()
    {
        return $this->fkEconomicoLicencaDiversa;
    }
}
