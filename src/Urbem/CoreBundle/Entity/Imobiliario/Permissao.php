<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * Permissao
 */
class Permissao
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
    private $numcgm;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Licenca
     */
    private $fkImobiliarioLicencas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TipoLicenca
     */
    private $fkImobiliarioTipoLicenca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioLicencas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Permissao
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Permissao
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Permissao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Licenca $fkImobiliarioLicenca
     * @return Permissao
     */
    public function addFkImobiliarioLicencas(\Urbem\CoreBundle\Entity\Imobiliario\Licenca $fkImobiliarioLicenca)
    {
        if (false === $this->fkImobiliarioLicencas->contains($fkImobiliarioLicenca)) {
            $fkImobiliarioLicenca->setFkImobiliarioPermissao($this);
            $this->fkImobiliarioLicencas->add($fkImobiliarioLicenca);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Licenca $fkImobiliarioLicenca
     */
    public function removeFkImobiliarioLicencas(\Urbem\CoreBundle\Entity\Imobiliario\Licenca $fkImobiliarioLicenca)
    {
        $this->fkImobiliarioLicencas->removeElement($fkImobiliarioLicenca);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Licenca
     */
    public function getFkImobiliarioLicencas()
    {
        return $this->fkImobiliarioLicencas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioTipoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoLicenca $fkImobiliarioTipoLicenca
     * @return Permissao
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
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Permissao
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgm = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->numcgm, $this->codTipo);
    }
}
