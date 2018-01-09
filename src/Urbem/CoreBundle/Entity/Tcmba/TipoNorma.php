<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoNorma
 */
class TipoNorma
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\VinculoTipoNorma
     */
    private $fkTcmbaVinculoTipoNormas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmbaVinculoTipoNormas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoNorma
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
     * @return TipoNorma
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
     * Add TcmbaVinculoTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\VinculoTipoNorma $fkTcmbaVinculoTipoNorma
     * @return TipoNorma
     */
    public function addFkTcmbaVinculoTipoNormas(\Urbem\CoreBundle\Entity\Tcmba\VinculoTipoNorma $fkTcmbaVinculoTipoNorma)
    {
        if (false === $this->fkTcmbaVinculoTipoNormas->contains($fkTcmbaVinculoTipoNorma)) {
            $fkTcmbaVinculoTipoNorma->setFkTcmbaTipoNorma($this);
            $this->fkTcmbaVinculoTipoNormas->add($fkTcmbaVinculoTipoNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaVinculoTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\VinculoTipoNorma $fkTcmbaVinculoTipoNorma
     */
    public function removeFkTcmbaVinculoTipoNormas(\Urbem\CoreBundle\Entity\Tcmba\VinculoTipoNorma $fkTcmbaVinculoTipoNorma)
    {
        $this->fkTcmbaVinculoTipoNormas->removeElement($fkTcmbaVinculoTipoNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaVinculoTipoNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\VinculoTipoNorma
     */
    public function getFkTcmbaVinculoTipoNormas()
    {
        return $this->fkTcmbaVinculoTipoNormas;
    }
}
