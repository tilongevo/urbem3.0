<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ConvenioAditivosAnulacao
 */
class ConvenioAditivosAnulacao
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
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numAditivo;

    /**
     * @var \DateTime
     */
    private $dtAnulacao;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos
     */
    private $fkLicitacaoConvenioAditivos;


    /**
     * Set exercicioConvenio
     *
     * @param string $exercicioConvenio
     * @return ConvenioAditivosAnulacao
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
     * @return ConvenioAditivosAnulacao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConvenioAditivosAnulacao
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
     * Set numAditivo
     *
     * @param integer $numAditivo
     * @return ConvenioAditivosAnulacao
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
     * Set dtAnulacao
     *
     * @param \DateTime $dtAnulacao
     * @return ConvenioAditivosAnulacao
     */
    public function setDtAnulacao(\DateTime $dtAnulacao)
    {
        $this->dtAnulacao = $dtAnulacao;
        return $this;
    }

    /**
     * Get dtAnulacao
     *
     * @return \DateTime
     */
    public function getDtAnulacao()
    {
        return $this->dtAnulacao;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return ConvenioAditivosAnulacao
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * OneToOne (owning side)
     * Set LicitacaoConvenioAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos $fkLicitacaoConvenioAditivos
     * @return ConvenioAditivosAnulacao
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
     * OneToOne (owning side)
     * Get fkLicitacaoConvenioAditivos
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos
     */
    public function getFkLicitacaoConvenioAditivos()
    {
        return $this->fkLicitacaoConvenioAditivos;
    }
}
