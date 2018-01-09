<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ContratoModalidadeLicitacao
 */
class ContratoModalidadeLicitacao
{
    /**
     * PK
     * @var integer
     */
    private $codModalidadeLicitacao;

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
     * Set codModalidadeLicitacao
     *
     * @param integer $codModalidadeLicitacao
     * @return ContratoModalidadeLicitacao
     */
    public function setCodModalidadeLicitacao($codModalidadeLicitacao)
    {
        $this->codModalidadeLicitacao = $codModalidadeLicitacao;
        return $this;
    }

    /**
     * Get codModalidadeLicitacao
     *
     * @return integer
     */
    public function getCodModalidadeLicitacao()
    {
        return $this->codModalidadeLicitacao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ContratoModalidadeLicitacao
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
     * @return ContratoModalidadeLicitacao
     */
    public function addFkTcemgContratos(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        if (false === $this->fkTcemgContratos->contains($fkTcemgContrato)) {
            $fkTcemgContrato->setFkTcemgContratoModalidadeLicitacao($this);
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
