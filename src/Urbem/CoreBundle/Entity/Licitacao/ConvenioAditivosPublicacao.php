<?php

namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ConvenioAditivosPublicacao
 */
class ConvenioAditivosPublicacao
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
    private $numAditivo;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtPublicacao;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $exercicio;

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
     * @var \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos
     */
    private $fkLicitacaoConvenioAditivos;

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
     * @return ConvenioAditivosPublicacao
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
     * @return ConvenioAditivosPublicacao
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
     * Set numAditivo
     *
     * @param integer $numAditivo
     * @return ConvenioAditivosPublicacao
     */
    public function setNumAditivo($numAditivo)
    {
        $this->numAditivo = $numAditivo;
        return $this;
    }

    /**
     * Get numAditivo
     *
     * @return integer
     */
    public function getNumAditivo()
    {
        return $this->numAditivo;
    }

    /**
     * Set dtPublicacao
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtPublicacao
     * @return ConvenioAditivosPublicacao
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ConvenioAditivosPublicacao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConvenioAditivosPublicacao
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return ConvenioAditivosPublicacao
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
     * @return ConvenioAditivosPublicacao
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
     * Set fkLicitacaoConvenioAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos $fkLicitacaoConvenioAditivos
     * @return ConvenioAditivosPublicacao
     */
    public function setFkLicitacaoConvenioAditivos(\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos $fkLicitacaoConvenioAditivos)
    {
        $this->exercicioConvenio = $fkLicitacaoConvenioAditivos->getExercicioConvenio();
        $this->numConvenio = $fkLicitacaoConvenioAditivos->getNumConvenio();
        $this->exercicio = $fkLicitacaoConvenioAditivos->getExercicio();
        $this->numAditivo = $fkLicitacaoConvenioAditivos->getNumAditivo();
        $this->fkLicitacaoConvenioAditivos = $fkLicitacaoConvenioAditivos;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoConvenioAditivos
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos
     */
    public function getFkLicitacaoConvenioAditivos()
    {
        return $this->fkLicitacaoConvenioAditivos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ConvenioAditivosPublicacao
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
}
