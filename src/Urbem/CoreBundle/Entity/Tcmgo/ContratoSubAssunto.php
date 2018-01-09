<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * ContratoSubAssunto
 */
class ContratoSubAssunto
{
    /**
     * PK
     * @var integer
     */
    private $codSubAssunto;

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
     * Set codSubAssunto
     *
     * @param integer $codSubAssunto
     * @return ContratoSubAssunto
     */
    public function setCodSubAssunto($codSubAssunto)
    {
        $this->codSubAssunto = $codSubAssunto;
        return $this;
    }

    /**
     * Get codSubAssunto
     *
     * @return integer
     */
    public function getCodSubAssunto()
    {
        return $this->codSubAssunto;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ContratoSubAssunto
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
     * @return ContratoSubAssunto
     */
    public function addFkTcmgoContratos(\Urbem\CoreBundle\Entity\Tcmgo\Contrato $fkTcmgoContrato)
    {
        if (false === $this->fkTcmgoContratos->contains($fkTcmgoContrato)) {
            $fkTcmgoContrato->setFkTcmgoContratoSubAssunto($this);
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
