<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * ContratoAssunto
 */
class ContratoAssunto
{
    /**
     * PK
     * @var integer
     */
    private $codAssunto;

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
     * Set codAssunto
     *
     * @param integer $codAssunto
     * @return ContratoAssunto
     */
    public function setCodAssunto($codAssunto)
    {
        $this->codAssunto = $codAssunto;
        return $this;
    }

    /**
     * Get codAssunto
     *
     * @return integer
     */
    public function getCodAssunto()
    {
        return $this->codAssunto;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ContratoAssunto
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
     * @return ContratoAssunto
     */
    public function addFkTcmgoContratos(\Urbem\CoreBundle\Entity\Tcmgo\Contrato $fkTcmgoContrato)
    {
        if (false === $this->fkTcmgoContratos->contains($fkTcmgoContrato)) {
            $fkTcmgoContrato->setFkTcmgoContratoAssunto($this);
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
