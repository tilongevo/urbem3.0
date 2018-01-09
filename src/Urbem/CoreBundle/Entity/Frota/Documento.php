<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * Documento
 */
class Documento
{
    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * @var string
     */
    private $nomDocumento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoDocumento
     */
    private $fkFrotaVeiculoDocumentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFrotaVeiculoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return Documento
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set nomDocumento
     *
     * @param string $nomDocumento
     * @return Documento
     */
    public function setNomDocumento($nomDocumento)
    {
        $this->nomDocumento = $nomDocumento;
        return $this;
    }

    /**
     * Get nomDocumento
     *
     * @return string
     */
    public function getNomDocumento()
    {
        return $this->nomDocumento;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaVeiculoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoDocumento $fkFrotaVeiculoDocumento
     * @return Documento
     */
    public function addFkFrotaVeiculoDocumentos(\Urbem\CoreBundle\Entity\Frota\VeiculoDocumento $fkFrotaVeiculoDocumento)
    {
        if (false === $this->fkFrotaVeiculoDocumentos->contains($fkFrotaVeiculoDocumento)) {
            $fkFrotaVeiculoDocumento->setFkFrotaDocumento($this);
            $this->fkFrotaVeiculoDocumentos->add($fkFrotaVeiculoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoDocumento $fkFrotaVeiculoDocumento
     */
    public function removeFkFrotaVeiculoDocumentos(\Urbem\CoreBundle\Entity\Frota\VeiculoDocumento $fkFrotaVeiculoDocumento)
    {
        $this->fkFrotaVeiculoDocumentos->removeElement($fkFrotaVeiculoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoDocumento
     */
    public function getFkFrotaVeiculoDocumentos()
    {
        return $this->fkFrotaVeiculoDocumentos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s - %s',
            $this->codDocumento,
            $this->nomDocumento
        );
    }
}
