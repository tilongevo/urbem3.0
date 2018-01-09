<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * TipoCondominio
 */
class TipoCondominio
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
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Condominio
     */
    private $fkImobiliarioCondominios;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioCondominios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoCondominio
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
     * @return TipoCondominio
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
     * OneToMany (owning side)
     * Add ImobiliarioCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Condominio $fkImobiliarioCondominio
     * @return TipoCondominio
     */
    public function addFkImobiliarioCondominios(\Urbem\CoreBundle\Entity\Imobiliario\Condominio $fkImobiliarioCondominio)
    {
        if (false === $this->fkImobiliarioCondominios->contains($fkImobiliarioCondominio)) {
            $fkImobiliarioCondominio->setFkImobiliarioTipoCondominio($this);
            $this->fkImobiliarioCondominios->add($fkImobiliarioCondominio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Condominio $fkImobiliarioCondominio
     */
    public function removeFkImobiliarioCondominios(\Urbem\CoreBundle\Entity\Imobiliario\Condominio $fkImobiliarioCondominio)
    {
        $this->fkImobiliarioCondominios->removeElement($fkImobiliarioCondominio);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioCondominios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Condominio
     */
    public function getFkImobiliarioCondominios()
    {
        return $this->fkImobiliarioCondominios;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codTipo, $this->nomTipo);
    }
}
