<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ContratoAditivos
 */
class ContratoAditivos
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
    private $dtVencimento;

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
    private $valorContratado;

    /**
     * @var string
     */
    private $objeto;

    /**
     * @var string
     */
    private $fundamentacao;

    /**
     * @var \DateTime
     */
    private $fimExecucao;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * @var integer
     */
    private $tipoTermoAditivo;

    /**
     * @var integer
     */
    private $tipoValor;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\ContratoAditivosAnulacao
     */
    private $fkLicitacaoContratoAditivosAnulacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoContratoAditivos
     */
    private $fkLicitacaoPublicacaoContratoAditivos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    private $fkLicitacaoContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\TipoTermoAditivo
     */
    private $fkLicitacaoTipoTermoAditivo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\TipoAlteracaoValor
     */
    private $fkLicitacaoTipoAlteracaoValor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoPublicacaoContratoAditivos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicioContrato
     *
     * @param string $exercicioContrato
     * @return ContratoAditivos
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
     * @return ContratoAditivos
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
     * @return ContratoAditivos
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContratoAditivos
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
     * @return ContratoAditivos
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
     * @return ContratoAditivos
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
     * Set dtVencimento
     *
     * @param \DateTime $dtVencimento
     * @return ContratoAditivos
     */
    public function setDtVencimento(\DateTime $dtVencimento)
    {
        $this->dtVencimento = $dtVencimento;
        return $this;
    }

    /**
     * Get dtVencimento
     *
     * @return \DateTime
     */
    public function getDtVencimento()
    {
        return $this->dtVencimento;
    }

    /**
     * Set dtAssinatura
     *
     * @param \DateTime $dtAssinatura
     * @return ContratoAditivos
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
     * @return ContratoAditivos
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
     * Set valorContratado
     *
     * @param integer $valorContratado
     * @return ContratoAditivos
     */
    public function setValorContratado($valorContratado)
    {
        $this->valorContratado = $valorContratado;
        return $this;
    }

    /**
     * Get valorContratado
     *
     * @return integer
     */
    public function getValorContratado()
    {
        return $this->valorContratado;
    }

    /**
     * Set objeto
     *
     * @param string $objeto
     * @return ContratoAditivos
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
     * Set fundamentacao
     *
     * @param string $fundamentacao
     * @return ContratoAditivos
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
     * Set fimExecucao
     *
     * @param \DateTime $fimExecucao
     * @return ContratoAditivos
     */
    public function setFimExecucao(\DateTime $fimExecucao = null)
    {
        $this->fimExecucao = $fimExecucao;
        return $this;
    }

    /**
     * Get fimExecucao
     *
     * @return \DateTime
     */
    public function getFimExecucao()
    {
        return $this->fimExecucao;
    }

    /**
     * Set justificativa
     *
     * @param string $justificativa
     * @return ContratoAditivos
     */
    public function setJustificativa($justificativa = null)
    {
        $this->justificativa = $justificativa;
        return $this;
    }

    /**
     * Get justificativa
     *
     * @return string
     */
    public function getJustificativa()
    {
        return $this->justificativa;
    }

    /**
     * Set tipoTermoAditivo
     *
     * @param integer $tipoTermoAditivo
     * @return ContratoAditivos
     */
    public function setTipoTermoAditivo($tipoTermoAditivo = null)
    {
        $this->tipoTermoAditivo = $tipoTermoAditivo;
        return $this;
    }

    /**
     * Get tipoTermoAditivo
     *
     * @return integer
     */
    public function getTipoTermoAditivo()
    {
        return $this->tipoTermoAditivo;
    }

    /**
     * Set tipoValor
     *
     * @param integer $tipoValor
     * @return ContratoAditivos
     */
    public function setTipoValor($tipoValor = null)
    {
        $this->tipoValor = $tipoValor;
        return $this;
    }

    /**
     * Get tipoValor
     *
     * @return integer
     */
    public function getTipoValor()
    {
        return $this->tipoValor;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoPublicacaoContratoAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoContratoAditivos $fkLicitacaoPublicacaoContratoAditivos
     * @return ContratoAditivos
     */
    public function addFkLicitacaoPublicacaoContratoAditivos(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoContratoAditivos $fkLicitacaoPublicacaoContratoAditivos)
    {
        if (false === $this->fkLicitacaoPublicacaoContratoAditivos->contains($fkLicitacaoPublicacaoContratoAditivos)) {
            $fkLicitacaoPublicacaoContratoAditivos->setFkLicitacaoContratoAditivos($this);
            $this->fkLicitacaoPublicacaoContratoAditivos->add($fkLicitacaoPublicacaoContratoAditivos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoPublicacaoContratoAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoContratoAditivos $fkLicitacaoPublicacaoContratoAditivos
     */
    public function removeFkLicitacaoPublicacaoContratoAditivos(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoContratoAditivos $fkLicitacaoPublicacaoContratoAditivos)
    {
        $this->fkLicitacaoPublicacaoContratoAditivos->removeElement($fkLicitacaoPublicacaoContratoAditivos);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoPublicacaoContratoAditivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoContratoAditivos
     */
    public function getFkLicitacaoPublicacaoContratoAditivos()
    {
        return $this->fkLicitacaoPublicacaoContratoAditivos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     * @return ContratoAditivos
     */
    public function setFkLicitacaoContrato(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        $this->exercicioContrato = $fkLicitacaoContrato->getExercicio();
        $this->codEntidade = $fkLicitacaoContrato->getCodEntidade();
        $this->numContrato = $fkLicitacaoContrato->getNumContrato();
        $this->fkLicitacaoContrato = $fkLicitacaoContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoContrato
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    public function getFkLicitacaoContrato()
    {
        return $this->fkLicitacaoContrato;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ContratoAditivos
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
     * Set fkLicitacaoTipoTermoAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\TipoTermoAditivo $fkLicitacaoTipoTermoAditivo
     * @return ContratoAditivos
     */
    public function setFkLicitacaoTipoTermoAditivo(\Urbem\CoreBundle\Entity\Licitacao\TipoTermoAditivo $fkLicitacaoTipoTermoAditivo)
    {
        $this->tipoTermoAditivo = $fkLicitacaoTipoTermoAditivo->getCodTipo();
        $this->fkLicitacaoTipoTermoAditivo = $fkLicitacaoTipoTermoAditivo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoTipoTermoAditivo
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\TipoTermoAditivo
     */
    public function getFkLicitacaoTipoTermoAditivo()
    {
        return $this->fkLicitacaoTipoTermoAditivo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoTipoAlteracaoValor
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\TipoAlteracaoValor $fkLicitacaoTipoAlteracaoValor
     * @return ContratoAditivos
     */
    public function setFkLicitacaoTipoAlteracaoValor(\Urbem\CoreBundle\Entity\Licitacao\TipoAlteracaoValor $fkLicitacaoTipoAlteracaoValor)
    {
        $this->tipoValor = $fkLicitacaoTipoAlteracaoValor->getCodTipo();
        $this->fkLicitacaoTipoAlteracaoValor = $fkLicitacaoTipoAlteracaoValor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoTipoAlteracaoValor
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\TipoAlteracaoValor
     */
    public function getFkLicitacaoTipoAlteracaoValor()
    {
        return $this->fkLicitacaoTipoAlteracaoValor;
    }

    /**
     * OneToOne (inverse side)
     * Set LicitacaoContratoAditivosAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoAditivosAnulacao $fkLicitacaoContratoAditivosAnulacao
     * @return ContratoAditivos
     */
    public function setFkLicitacaoContratoAditivosAnulacao(\Urbem\CoreBundle\Entity\Licitacao\ContratoAditivosAnulacao $fkLicitacaoContratoAditivosAnulacao)
    {
        $fkLicitacaoContratoAditivosAnulacao->setFkLicitacaoContratoAditivos($this);
        $this->fkLicitacaoContratoAditivosAnulacao = $fkLicitacaoContratoAditivosAnulacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoContratoAditivosAnulacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\ContratoAditivosAnulacao
     */
    public function getFkLicitacaoContratoAditivosAnulacao()
    {
        return $this->fkLicitacaoContratoAditivosAnulacao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->numAditivo." - ". $this->numContrato;
    }
}
