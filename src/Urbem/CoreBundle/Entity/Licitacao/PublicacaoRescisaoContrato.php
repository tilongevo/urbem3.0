<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * PublicacaoRescisaoContrato
 */
class PublicacaoRescisaoContrato
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
     * PK
     * @var integer
     */
    private $cgmImprensa;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtPublicacao;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $numPublicacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\RescisaoContrato
     */
    private $fkLicitacaoRescisaoContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    private $fkLicitacaoVeiculosPublicidade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtPublicacao = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set exercicioContrato
     *
     * @param string $exercicioContrato
     * @return PublicacaoRescisaoContrato
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
     * @return PublicacaoRescisaoContrato
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
     * @return PublicacaoRescisaoContrato
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
     * Set cgmImprensa
     *
     * @param integer $cgmImprensa
     * @return PublicacaoRescisaoContrato
     */
    public function setCgmImprensa($cgmImprensa)
    {
        $this->cgmImprensa = $cgmImprensa;
        return $this;
    }

    /**
     * Get cgmImprensa
     *
     * @return integer
     */
    public function getCgmImprensa()
    {
        return $this->cgmImprensa;
    }

    /**
     * Set dtPublicacao
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtPublicacao
     * @return PublicacaoRescisaoContrato
     */
    public function setDtPublicacao(\Urbem\CoreBundle\Helper\DatePK $dtPublicacao)
    {
        $this->dtPublicacao = $dtPublicacao;
        return $this;
    }

    /**
     * Get dtPublicacao
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtPublicacao()
    {
        return $this->dtPublicacao;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return PublicacaoRescisaoContrato
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set numPublicacao
     *
     * @param integer $numPublicacao
     * @return PublicacaoRescisaoContrato
     */
    public function setNumPublicacao($numPublicacao = null)
    {
        $this->numPublicacao = $numPublicacao;
        return $this;
    }

    /**
     * Get numPublicacao
     *
     * @return integer
     */
    public function getNumPublicacao()
    {
        return $this->numPublicacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoRescisaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\RescisaoContrato $fkLicitacaoRescisaoContrato
     * @return PublicacaoRescisaoContrato
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
     * ManyToOne (inverse side)
     * Get fkLicitacaoRescisaoContrato
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\RescisaoContrato
     */
    public function getFkLicitacaoRescisaoContrato()
    {
        return $this->fkLicitacaoRescisaoContrato;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoVeiculosPublicidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade
     * @return PublicacaoRescisaoContrato
     */
    public function setFkLicitacaoVeiculosPublicidade(\Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade)
    {
        $this->cgmImprensa = $fkLicitacaoVeiculosPublicidade->getNumcgm();
        $this->fkLicitacaoVeiculosPublicidade = $fkLicitacaoVeiculosPublicidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoVeiculosPublicidade
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    public function getFkLicitacaoVeiculosPublicidade()
    {
        return $this->fkLicitacaoVeiculosPublicidade;
    }
}
