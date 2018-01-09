<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ContratoInstrumento
 */
class ContratoInstrumento
{
    /**
     * PK
     * @var integer
     */
    private $codInstrumento;

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
     * Set codInstrumento
     *
     * @param integer $codInstrumento
     * @return ContratoInstrumento
     */
    public function setCodInstrumento($codInstrumento)
    {
        $this->codInstrumento = $codInstrumento;
        return $this;
    }

    /**
     * Get codInstrumento
     *
     * @return integer
     */
    public function getCodInstrumento()
    {
        return $this->codInstrumento;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ContratoInstrumento
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
     * @return ContratoInstrumento
     */
    public function addFkTcemgContratos(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        if (false === $this->fkTcemgContratos->contains($fkTcemgContrato)) {
            $fkTcemgContrato->setFkTcemgContratoInstrumento($this);
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
