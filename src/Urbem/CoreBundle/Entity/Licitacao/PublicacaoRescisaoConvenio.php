<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * PublicacaoRescisaoConvenio
 */
class PublicacaoRescisaoConvenio
{
    /**
     * PK
     * @var string
     */
    private $exercicioConvenio;

    /**
     * PK
     * @var integer
     */
    private $numConvenio;

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
     * @var \Urbem\CoreBundle\Entity\Licitacao\RescisaoConvenio
     */
    private $fkLicitacaoRescisaoConvenio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtPublicacao = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set exercicioConvenio
     *
     * @param string $exercicioConvenio
     * @return PublicacaoRescisaoConvenio
     */
    public function setExercicioConvenio($exercicioConvenio)
    {
        $this->exercicioConvenio = $exercicioConvenio;
        return $this;
    }

    /**
     * Get exercicioConvenio
     *
     * @return string
     */
    public function getExercicioConvenio()
    {
        return $this->exercicioConvenio;
    }

    /**
     * Set numConvenio
     *
     * @param integer $numConvenio
     * @return PublicacaoRescisaoConvenio
     */
    public function setNumConvenio($numConvenio)
    {
        $this->numConvenio = $numConvenio;
        return $this;
    }

    /**
     * Get numConvenio
     *
     * @return integer
     */
    public function getNumConvenio()
    {
        return $this->numConvenio;
    }

    /**
     * Set cgmImprensa
     *
     * @param integer $cgmImprensa
     * @return PublicacaoRescisaoConvenio
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
     * @return PublicacaoRescisaoConvenio
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
     * @return PublicacaoRescisaoConvenio
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
     * @return PublicacaoRescisaoConvenio
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
     * Set fkLicitacaoRescisaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\RescisaoConvenio $fkLicitacaoRescisaoConvenio
     * @return PublicacaoRescisaoConvenio
     */
    public function setFkLicitacaoRescisaoConvenio(\Urbem\CoreBundle\Entity\Licitacao\RescisaoConvenio $fkLicitacaoRescisaoConvenio)
    {
        $this->exercicioConvenio = $fkLicitacaoRescisaoConvenio->getExercicioConvenio();
        $this->numConvenio = $fkLicitacaoRescisaoConvenio->getNumConvenio();
        $this->fkLicitacaoRescisaoConvenio = $fkLicitacaoRescisaoConvenio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoRescisaoConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\RescisaoConvenio
     */
    public function getFkLicitacaoRescisaoConvenio()
    {
        return $this->fkLicitacaoRescisaoConvenio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return PublicacaoRescisaoConvenio
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmImprensa = $fkSwCgm->getNumcgm();
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
}
