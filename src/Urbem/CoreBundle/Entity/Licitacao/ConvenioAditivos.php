<?php

namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ConvenioAditivos
 */
class ConvenioAditivos
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
     * @var integer
     */
    private $responsavelJuridico;

    /**
     * @var \DateTime
     */
    private $dtVigencia;

    /**
     * @var \DateTime
     */
    private $dtAssinatura;

    /**
     * @var \DateTime
     */
    private $inicioExecucao;

    /**
     * @var integer
     */
    private $valorConvenio;

    /**
     * @var string
     */
    private $objeto;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var string
     */
    private $fundamentacao;

    /**
     * @var integer
     */
    private $codNormaAutorizativa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosAnulacao
     */
    private $fkLicitacaoConvenioAditivosAnulacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosPublicacao
     */
    private $fkLicitacaoConvenioAditivosPublicacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    private $fkLicitacaoConvenio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoConvenioAditivosPublicacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicioConvenio
     *
     * @param string $exercicioConvenio
     * @return ConvenioAditivos
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
     * @return ConvenioAditivos
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
     * @return ConvenioAditivos
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
     * @return ConvenioAditivos
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
     * Set responsavelJuridico
     *
     * @param integer $responsavelJuridico
     * @return ConvenioAditivos
     */
    public function setResponsavelJuridico($responsavelJuridico)
    {
        $this->responsavelJuridico = $responsavelJuridico;
        return $this;
    }

    /**
     * Get responsavelJuridico
     *
     * @return integer
     */
    public function getResponsavelJuridico()
    {
        return $this->responsavelJuridico;
    }

    /**
     * Set dtVigencia
     *
     * @param \DateTime $dtVigencia
     * @return ConvenioAditivos
     */
    public function setDtVigencia(\DateTime $dtVigencia)
    {
        $this->dtVigencia = $dtVigencia;
        return $this;
    }

    /**
     * Get dtVigencia
     *
     * @return \DateTime
     */
    public function getDtVigencia()
    {
        return $this->dtVigencia;
    }

    /**
     * Set dtAssinatura
     *
     * @param \DateTime $dtAssinatura
     * @return ConvenioAditivos
     */
    public function setDtAssinatura(\DateTime $dtAssinatura)
    {
        $this->dtAssinatura = $dtAssinatura;
        return $this;
    }

    /**
     * Get dtAssinatura
     *
     * @return \DateTime
     */
    public function getDtAssinatura()
    {
        return $this->dtAssinatura;
    }

    /**
     * Set inicioExecucao
     *
     * @param \DateTime $inicioExecucao
     * @return ConvenioAditivos
     */
    public function setInicioExecucao(\DateTime $inicioExecucao)
    {
        $this->inicioExecucao = $inicioExecucao;
        return $this;
    }

    /**
     * Get inicioExecucao
     *
     * @return \DateTime
     */
    public function getInicioExecucao()
    {
        return $this->inicioExecucao;
    }

    /**
     * Set valorConvenio
     *
     * @param integer $valorConvenio
     * @return ConvenioAditivos
     */
    public function setValorConvenio($valorConvenio)
    {
        $this->valorConvenio = $valorConvenio;
        return $this;
    }

    /**
     * Get valorConvenio
     *
     * @return integer
     */
    public function getValorConvenio()
    {
        return $this->valorConvenio;
    }

    /**
     * Set objeto
     *
     * @param string $objeto
     * @return ConvenioAditivos
     */
    public function setObjeto($objeto)
    {
        $this->objeto = $objeto;
        return $this;
    }

    /**
     * Get objeto
     *
     * @return string
     */
    public function getObjeto()
    {
        return $this->objeto;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return ConvenioAditivos
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
     * Set fundamentacao
     *
     * @param string $fundamentacao
     * @return ConvenioAditivos
     */
    public function setFundamentacao($fundamentacao)
    {
        $this->fundamentacao = $fundamentacao;
        return $this;
    }

    /**
     * Get fundamentacao
     *
     * @return string
     */
    public function getFundamentacao()
    {
        return $this->fundamentacao;
    }

    /**
     * Set codNormaAutorizativa
     *
     * @param integer $codNormaAutorizativa
     * @return ConvenioAditivos
     */
    public function setCodNormaAutorizativa($codNormaAutorizativa)
    {
        $this->codNormaAutorizativa = $codNormaAutorizativa;
        return $this;
    }

    /**
     * Get codNormaAutorizativa
     *
     * @return integer
     */
    public function getCodNormaAutorizativa()
    {
        return $this->codNormaAutorizativa;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoConvenioAditivosPublicacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosPublicacao $fkLicitacaoConvenioAditivosPublicacao
     * @return ConvenioAditivos
     */
    public function addFkLicitacaoConvenioAditivosPublicacoes(\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosPublicacao $fkLicitacaoConvenioAditivosPublicacao)
    {
        if (false === $this->fkLicitacaoConvenioAditivosPublicacoes->contains($fkLicitacaoConvenioAditivosPublicacao)) {
            $fkLicitacaoConvenioAditivosPublicacao->setFkLicitacaoConvenioAditivos($this);
            $this->fkLicitacaoConvenioAditivosPublicacoes->add($fkLicitacaoConvenioAditivosPublicacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoConvenioAditivosPublicacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosPublicacao $fkLicitacaoConvenioAditivosPublicacao
     */
    public function removeFkLicitacaoConvenioAditivosPublicacoes(\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosPublicacao $fkLicitacaoConvenioAditivosPublicacao)
    {
        $this->fkLicitacaoConvenioAditivosPublicacoes->removeElement($fkLicitacaoConvenioAditivosPublicacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoConvenioAditivosPublicacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosPublicacao
     */
    public function getFkLicitacaoConvenioAditivosPublicacoes()
    {
        return $this->fkLicitacaoConvenioAditivosPublicacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio
     * @return ConvenioAditivos
     */
    public function setFkLicitacaoConvenio(\Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio)
    {
        $this->numConvenio = $fkLicitacaoConvenio->getNumConvenio();
        $this->exercicioConvenio = $fkLicitacaoConvenio->getExercicio();
        $this->fkLicitacaoConvenio = $fkLicitacaoConvenio;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    public function getFkLicitacaoConvenio()
    {
        return $this->fkLicitacaoConvenio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ConvenioAditivos
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->responsavelJuridico = $fkSwCgm->getNumcgm();
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
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return ConvenioAditivos
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNormaAutorizativa = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * OneToOne (inverse side)
     * Set LicitacaoConvenioAditivosAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosAnulacao $fkLicitacaoConvenioAditivosAnulacao
     * @return ConvenioAditivos
     */
    public function setFkLicitacaoConvenioAditivosAnulacao(\Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosAnulacao $fkLicitacaoConvenioAditivosAnulacao)
    {
        $fkLicitacaoConvenioAditivosAnulacao->setFkLicitacaoConvenioAditivos($this);
        $this->fkLicitacaoConvenioAditivosAnulacao = $fkLicitacaoConvenioAditivosAnulacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoConvenioAditivosAnulacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosAnulacao
     */
    public function getFkLicitacaoConvenioAditivosAnulacao()
    {
        return $this->fkLicitacaoConvenioAditivosAnulacao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->numAditivo) {
            return $this->numAditivo . '/' . $this->exercicio;
        } else {
            return 'Aditivos de Convênio';
        }
    }

    /**
     * @param \Doctrine\Common\Collections\Collection|ConvenioAditivosPublicacao $fkLicitacaoConvenioAditivosPublicacoes
     */
    public function setFkLicitacaoConvenioAditivosPublicacoes($fkLicitacaoConvenioAditivosPublicacoes)
    {
        $this->fkLicitacaoConvenioAditivosPublicacoes = $fkLicitacaoConvenioAditivosPublicacoes;
    }
}
