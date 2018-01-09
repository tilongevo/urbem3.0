<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * ContratoModalidadeLicitacao
 */
class ContratoModalidadeLicitacao
{
    /**
     * PK
     * @var integer
     */
    private $codModalidade;

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
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ContratoModalidadeLicitacao
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
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
     * Add TcmgoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Contrato $fkTcmgoContrato
     * @return ContratoModalidadeLicitacao
     */
    public function addFkTcmgoContratos(\Urbem\CoreBundle\Entity\Tcmgo\Contrato $fkTcmgoContrato)
    {
        if (false === $this->fkTcmgoContratos->contains($fkTcmgoContrato)) {
            $fkTcmgoContrato->setFkTcmgoContratoModalidadeLicitacao($this);
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
