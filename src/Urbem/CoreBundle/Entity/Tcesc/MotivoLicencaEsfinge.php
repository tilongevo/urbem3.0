<?php
 
namespace Urbem\CoreBundle\Entity\Tcesc;

/**
 * MotivoLicencaEsfinge
 */
class MotivoLicencaEsfinge
{
    /**
     * PK
     * @var integer
     */
    private $codMotivoLicencaEsfinge;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcesc\MotivoLicencaEsfingeSw
     */
    private $fkTcescMotivoLicencaEsfingeSws;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcescMotivoLicencaEsfingeSws = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codMotivoLicencaEsfinge
     *
     * @param integer $codMotivoLicencaEsfinge
     * @return MotivoLicencaEsfinge
     */
    public function setCodMotivoLicencaEsfinge($codMotivoLicencaEsfinge)
    {
        $this->codMotivoLicencaEsfinge = $codMotivoLicencaEsfinge;
        return $this;
    }

    /**
     * Get codMotivoLicencaEsfinge
     *
     * @return integer
     */
    public function getCodMotivoLicencaEsfinge()
    {
        return $this->codMotivoLicencaEsfinge;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return MotivoLicencaEsfinge
     */
    public function setDescricao($descricao = null)
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
     * Add TcescMotivoLicencaEsfingeSw
     *
     * @param \Urbem\CoreBundle\Entity\Tcesc\MotivoLicencaEsfingeSw $fkTcescMotivoLicencaEsfingeSw
     * @return MotivoLicencaEsfinge
     */
    public function addFkTcescMotivoLicencaEsfingeSws(\Urbem\CoreBundle\Entity\Tcesc\MotivoLicencaEsfingeSw $fkTcescMotivoLicencaEsfingeSw)
    {
        if (false === $this->fkTcescMotivoLicencaEsfingeSws->contains($fkTcescMotivoLicencaEsfingeSw)) {
            $fkTcescMotivoLicencaEsfingeSw->setFkTcescMotivoLicencaEsfinge($this);
            $this->fkTcescMotivoLicencaEsfingeSws->add($fkTcescMotivoLicencaEsfingeSw);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcescMotivoLicencaEsfingeSw
     *
     * @param \Urbem\CoreBundle\Entity\Tcesc\MotivoLicencaEsfingeSw $fkTcescMotivoLicencaEsfingeSw
     */
    public function removeFkTcescMotivoLicencaEsfingeSws(\Urbem\CoreBundle\Entity\Tcesc\MotivoLicencaEsfingeSw $fkTcescMotivoLicencaEsfingeSw)
    {
        $this->fkTcescMotivoLicencaEsfingeSws->removeElement($fkTcescMotivoLicencaEsfingeSw);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcescMotivoLicencaEsfingeSws
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcesc\MotivoLicencaEsfingeSw
     */
    public function getFkTcescMotivoLicencaEsfingeSws()
    {
        return $this->fkTcescMotivoLicencaEsfingeSws;
    }
}
