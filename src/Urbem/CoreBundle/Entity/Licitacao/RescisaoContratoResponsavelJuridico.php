<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * RescisaoContratoResponsavelJuridico
 */
class RescisaoContratoResponsavelJuridico
{
    /**
     * PK
     * @var string
     */
    private $exercicioContrato;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $numContrato;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\RescisaoContrato
     */
    private $fkLicitacaoRescisaoContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;


    /**
     * Set exercicioContrato
     *
     * @param string $exercicioContrato
     * @return RescisaoContratoResponsavelJuridico
     */
    public function setExercicioContrato($exercicioContrato)
    {
        $this->exercicioContrato = $exercicioContrato;
        return $this;
    }

    /**
     * Get exercicioContrato
     *
     * @return string
     */
    public function getExercicioContrato()
    {
        return $this->exercicioContrato;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return RescisaoContratoResponsavelJuridico
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set numContrato
     *
     * @param integer $numContrato
     * @return RescisaoContratoResponsavelJuridico
     */
    public function setNumContrato($numContrato)
    {
        $this->numContrato = $numContrato;
        return $this;
    }

    /**
     * Get numContrato
     *
     * @return integer
     */
    public function getNumContrato()
    {
        return $this->numContrato;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return RescisaoContratoResponsavelJuridico
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return RescisaoContratoResponsavelJuridico
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * OneToOne (owning side)
     * Set LicitacaoRescisaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\RescisaoContrato $fkLicitacaoRescisaoContrato
     * @return RescisaoContratoResponsavelJuridico
     */
    public function setFkLicitacaoRescisaoContrato(\Urbem\CoreBundle\Entity\Licitacao\RescisaoContrato $fkLicitacaoRescisaoContrato)
    {
        $this->exercicioContrato = $fkLicitacaoRescisaoContrato->getExercicioContrato();
        $this->codEntidade = $fkLicitacaoRescisaoContrato->getCodEntidade();
        $this->numContrato = $fkLicitacaoRescisaoContrato->getNumContrato();
        $this->fkLicitacaoRescisaoContrato = $fkLicitacaoRescisaoContrato;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkLicitacaoRescisaoContrato
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\RescisaoContrato
     */
    public function getFkLicitacaoRescisaoContrato()
    {
        return $this->fkLicitacaoRescisaoContrato;
    }
}
