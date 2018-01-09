<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * ContratoTipo
 */
class ContratoTipo
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\Contrato
     */
    private $fkTcmgoContratos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoContratos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ContratoTipo
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
     * Set descricao
     *
     * @param string $descricao
     * @return ContratoTipo
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
     * Add TcmgoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Contrato $fkTcmgoContrato
     * @return ContratoTipo
     */
    public function addFkTcmgoContratos(\Urbem\CoreBundle\Entity\Tcmgo\Contrato $fkTcmgoContrato)
    {
        if (false === $this->fkTcmgoContratos->contains($fkTcmgoContrato)) {
            $fkTcmgoContrato->setFkTcmgoContratoTipo($this);
            $this->fkTcmgoContratos->add($fkTcmgoContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Contrato $fkTcmgoContrato
     */
    public function removeFkTcmgoContratos(\Urbem\CoreBundle\Entity\Tcmgo\Contrato $fkTcmgoContrato)
    {
        $this->fkTcmgoContratos->removeElement($fkTcmgoContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\Contrato
     */
    public function getFkTcmgoContratos()
    {
        return $this->fkTcmgoContratos;
    }
}
