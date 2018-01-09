<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * TipoResponsavelTecnico
 */
class TipoResponsavelTecnico
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelTecnico
     */
    private $fkTcmgoResponsavelTecnicos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoResponsavelTecnicos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoResponsavelTecnico
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
     * @return TipoResponsavelTecnico
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
     * Add TcmgoResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelTecnico $fkTcmgoResponsavelTecnico
     * @return TipoResponsavelTecnico
     */
    public function addFkTcmgoResponsavelTecnicos(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelTecnico $fkTcmgoResponsavelTecnico)
    {
        if (false === $this->fkTcmgoResponsavelTecnicos->contains($fkTcmgoResponsavelTecnico)) {
            $fkTcmgoResponsavelTecnico->setFkTcmgoTipoResponsavelTecnico($this);
            $this->fkTcmgoResponsavelTecnicos->add($fkTcmgoResponsavelTecnico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ResponsavelTecnico $fkTcmgoResponsavelTecnico
     */
    public function removeFkTcmgoResponsavelTecnicos(\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelTecnico $fkTcmgoResponsavelTecnico)
    {
        $this->fkTcmgoResponsavelTecnicos->removeElement($fkTcmgoResponsavelTecnico);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoResponsavelTecnicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ResponsavelTecnico
     */
    public function getFkTcmgoResponsavelTecnicos()
    {
        return $this->fkTcmgoResponsavelTecnicos;
    }
}
