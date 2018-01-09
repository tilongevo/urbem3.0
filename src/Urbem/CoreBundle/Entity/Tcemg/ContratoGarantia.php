<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ContratoGarantia
 */
class ContratoGarantia
{
    /**
     * PK
     * @var integer
     */
    private $codGarantia;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    private $fkTcemgContratos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgContratos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codGarantia
     *
     * @param integer $codGarantia
     * @return ContratoGarantia
     */
    public function setCodGarantia($codGarantia)
    {
        $this->codGarantia = $codGarantia;
        return $this;
    }

    /**
     * Get codGarantia
     *
     * @return integer
     */
    public function getCodGarantia()
    {
        return $this->codGarantia;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ContratoGarantia
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
     * Add TcemgContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato
     * @return ContratoGarantia
     */
    public function addFkTcemgContratos(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        if (false === $this->fkTcemgContratos->contains($fkTcemgContrato)) {
            $fkTcemgContrato->setFkTcemgContratoGarantia($this);
            $this->fkTcemgContratos->add($fkTcemgContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato
     */
    public function removeFkTcemgContratos(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        $this->fkTcemgContratos->removeElement($fkTcemgContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    public function getFkTcemgContratos()
    {
        return $this->fkTcemgContratos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
