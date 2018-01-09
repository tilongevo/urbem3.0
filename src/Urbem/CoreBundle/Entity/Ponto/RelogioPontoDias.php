<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * RelogioPontoDias
 */
class RelogioPontoDias
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var integer
     */
    private $codPonto;

    /**
     * @var \DateTime
     */
    private $dtPonto;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\RelogioPontoHorario
     */
    private $fkPontoRelogioPontoHorarios;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\DadosRelogioPonto
     */
    private $fkPontoDadosRelogioPonto;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPontoRelogioPontoHorarios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return RelogioPontoDias
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set codPonto
     *
     * @param integer $codPonto
     * @return RelogioPontoDias
     */
    public function setCodPonto($codPonto)
    {
        $this->codPonto = $codPonto;
        return $this;
    }

    /**
     * Get codPonto
     *
     * @return integer
     */
    public function getCodPonto()
    {
        return $this->codPonto;
    }

    /**
     * Set dtPonto
     *
     * @param \DateTime $dtPonto
     * @return RelogioPontoDias
     */
    public function setDtPonto(\DateTime $dtPonto)
    {
        $this->dtPonto = $dtPonto;
        return $this;
    }

    /**
     * Get dtPonto
     *
     * @return \DateTime
     */
    public function getDtPonto()
    {
        return $this->dtPonto;
    }

    /**
     * OneToMany (owning side)
     * Add PontoRelogioPontoHorario
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\RelogioPontoHorario $fkPontoRelogioPontoHorario
     * @return RelogioPontoDias
     */
    public function addFkPontoRelogioPontoHorarios(\Urbem\CoreBundle\Entity\Ponto\RelogioPontoHorario $fkPontoRelogioPontoHorario)
    {
        if (false === $this->fkPontoRelogioPontoHorarios->contains($fkPontoRelogioPontoHorario)) {
            $fkPontoRelogioPontoHorario->setFkPontoRelogioPontoDias($this);
            $this->fkPontoRelogioPontoHorarios->add($fkPontoRelogioPontoHorario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoRelogioPontoHorario
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\RelogioPontoHorario $fkPontoRelogioPontoHorario
     */
    public function removeFkPontoRelogioPontoHorarios(\Urbem\CoreBundle\Entity\Ponto\RelogioPontoHorario $fkPontoRelogioPontoHorario)
    {
        $this->fkPontoRelogioPontoHorarios->removeElement($fkPontoRelogioPontoHorario);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoRelogioPontoHorarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\RelogioPontoHorario
     */
    public function getFkPontoRelogioPontoHorarios()
    {
        return $this->fkPontoRelogioPontoHorarios;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoDadosRelogioPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DadosRelogioPonto $fkPontoDadosRelogioPonto
     * @return RelogioPontoDias
     */
    public function setFkPontoDadosRelogioPonto(\Urbem\CoreBundle\Entity\Ponto\DadosRelogioPonto $fkPontoDadosRelogioPonto)
    {
        $this->codContrato = $fkPontoDadosRelogioPonto->getCodContrato();
        $this->fkPontoDadosRelogioPonto = $fkPontoDadosRelogioPonto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoDadosRelogioPonto
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\DadosRelogioPonto
     */
    public function getFkPontoDadosRelogioPonto()
    {
        return $this->fkPontoDadosRelogioPonto;
    }
}
