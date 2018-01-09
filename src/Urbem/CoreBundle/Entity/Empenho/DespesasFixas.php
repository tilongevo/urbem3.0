<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * DespesasFixas
 */
class DespesasFixas
{
    /**
     * PK
     * @var integer
     */
    private $codDespesaFixa;

    /**
     * PK
     * @var integer
     */
    private $codDespesa;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $codLocal;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $numIdentificacao;

    /**
     * @var string
     */
    private $numContrato;

    /**
     * @var string
     */
    private $diaVencimento;

    /**
     * @var string
     */
    private $historico;

    /**
     * @var string
     */
    private $status = 'A';

    /**
     * @var \DateTime
     */
    private $dtInicial;

    /**
     * @var \DateTime
     */
    private $dtFinal;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemEmpenhoDespesasFixas
     */
    private $fkEmpenhoItemEmpenhoDespesasFixas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    private $fkOrcamentoDespesa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Local
     */
    private $fkOrganogramaLocal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\TipoDespesaFixa
     */
    private $fkEmpenhoTipoDespesaFixa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEmpenhoItemEmpenhoDespesasFixas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codDespesaFixa
     *
     * @param integer $codDespesaFixa
     * @return DespesasFixas
     */
    public function setCodDespesaFixa($codDespesaFixa)
    {
        $this->codDespesaFixa = $codDespesaFixa;
        return $this;
    }

    /**
     * Get codDespesaFixa
     *
     * @return integer
     */
    public function getCodDespesaFixa()
    {
        return $this->codDespesaFixa;
    }

    /**
     * Set codDespesa
     *
     * @param integer $codDespesa
     * @return DespesasFixas
     */
    public function setCodDespesa($codDespesa)
    {
        $this->codDespesa = $codDespesa;
        return $this;
    }

    /**
     * Get codDespesa
     *
     * @return integer
     */
    public function getCodDespesa()
    {
        return $this->codDespesa;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return DespesasFixas
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return DespesasFixas
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return DespesasFixas
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
     * Set codLocal
     *
     * @param integer $codLocal
     * @return DespesasFixas
     */
    public function setCodLocal($codLocal)
    {
        $this->codLocal = $codLocal;
        return $this;
    }

    /**
     * Get codLocal
     *
     * @return integer
     */
    public function getCodLocal()
    {
        return $this->codLocal;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return DespesasFixas
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
     * Set numIdentificacao
     *
     * @param string $numIdentificacao
     * @return DespesasFixas
     */
    public function setNumIdentificacao($numIdentificacao)
    {
        $this->numIdentificacao = $numIdentificacao;
        return $this;
    }

    /**
     * Get numIdentificacao
     *
     * @return string
     */
    public function getNumIdentificacao()
    {
        return $this->numIdentificacao;
    }

    /**
     * Set numContrato
     *
     * @param string $numContrato
     * @return DespesasFixas
     */
    public function setNumContrato($numContrato)
    {
        $this->numContrato = $numContrato;
        return $this;
    }

    /**
     * Get numContrato
     *
     * @return string
     */
    public function getNumContrato()
    {
        return $this->numContrato;
    }

    /**
     * Set diaVencimento
     *
     * @param string $diaVencimento
     * @return DespesasFixas
     */
    public function setDiaVencimento($diaVencimento)
    {
        $this->diaVencimento = $diaVencimento;
        return $this;
    }

    /**
     * Get diaVencimento
     *
     * @return string
     */
    public function getDiaVencimento()
    {
        return $this->diaVencimento;
    }

    /**
     * Set historico
     *
     * @param string $historico
     * @return DespesasFixas
     */
    public function setHistorico($historico)
    {
        $this->historico = $historico;
        return $this;
    }

    /**
     * Get historico
     *
     * @return string
     */
    public function getHistorico()
    {
        return $this->historico;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return DespesasFixas
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dtInicial
     *
     * @param \DateTime $dtInicial
     * @return DespesasFixas
     */
    public function setDtInicial(\DateTime $dtInicial)
    {
        $this->dtInicial = $dtInicial;
        return $this;
    }

    /**
     * Get dtInicial
     *
     * @return \DateTime
     */
    public function getDtInicial()
    {
        return $this->dtInicial;
    }

    /**
     * Set dtFinal
     *
     * @param \DateTime $dtFinal
     * @return DespesasFixas
     */
    public function setDtFinal(\DateTime $dtFinal)
    {
        $this->dtFinal = $dtFinal;
        return $this;
    }

    /**
     * Get dtFinal
     *
     * @return \DateTime
     */
    public function getDtFinal()
    {
        return $this->dtFinal;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return DespesasFixas
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoItemEmpenhoDespesasFixas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemEmpenhoDespesasFixas $fkEmpenhoItemEmpenhoDespesasFixas
     * @return DespesasFixas
     */
    public function addFkEmpenhoItemEmpenhoDespesasFixas(\Urbem\CoreBundle\Entity\Empenho\ItemEmpenhoDespesasFixas $fkEmpenhoItemEmpenhoDespesasFixas)
    {
        if (false === $this->fkEmpenhoItemEmpenhoDespesasFixas->contains($fkEmpenhoItemEmpenhoDespesasFixas)) {
            $fkEmpenhoItemEmpenhoDespesasFixas->setFkEmpenhoDespesasFixas($this);
            $this->fkEmpenhoItemEmpenhoDespesasFixas->add($fkEmpenhoItemEmpenhoDespesasFixas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoItemEmpenhoDespesasFixas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemEmpenhoDespesasFixas $fkEmpenhoItemEmpenhoDespesasFixas
     */
    public function removeFkEmpenhoItemEmpenhoDespesasFixas(\Urbem\CoreBundle\Entity\Empenho\ItemEmpenhoDespesasFixas $fkEmpenhoItemEmpenhoDespesasFixas)
    {
        $this->fkEmpenhoItemEmpenhoDespesasFixas->removeElement($fkEmpenhoItemEmpenhoDespesasFixas);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoItemEmpenhoDespesasFixas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemEmpenhoDespesasFixas
     */
    public function getFkEmpenhoItemEmpenhoDespesasFixas()
    {
        return $this->fkEmpenhoItemEmpenhoDespesasFixas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     * @return DespesasFixas
     */
    public function setFkOrcamentoDespesa(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        $this->exercicio = $fkOrcamentoDespesa->getExercicio();
        $this->codDespesa = $fkOrcamentoDespesa->getCodDespesa();
        $this->fkOrcamentoDespesa = $fkOrcamentoDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    public function getFkOrcamentoDespesa()
    {
        return $this->fkOrcamentoDespesa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return DespesasFixas
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return DespesasFixas
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
     * ManyToOne (inverse side)
     * Set fkOrganogramaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal
     * @return DespesasFixas
     */
    public function setFkOrganogramaLocal(\Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal)
    {
        $this->codLocal = $fkOrganogramaLocal->getCodLocal();
        $this->fkOrganogramaLocal = $fkOrganogramaLocal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaLocal
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Local
     */
    public function getFkOrganogramaLocal()
    {
        return $this->fkOrganogramaLocal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoTipoDespesaFixa
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\TipoDespesaFixa $fkEmpenhoTipoDespesaFixa
     * @return DespesasFixas
     */
    public function setFkEmpenhoTipoDespesaFixa(\Urbem\CoreBundle\Entity\Empenho\TipoDespesaFixa $fkEmpenhoTipoDespesaFixa)
    {
        $this->codTipo = $fkEmpenhoTipoDespesaFixa->getCodTipo();
        $this->fkEmpenhoTipoDespesaFixa = $fkEmpenhoTipoDespesaFixa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoTipoDespesaFixa
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\TipoDespesaFixa
     */
    public function getFkEmpenhoTipoDespesaFixa()
    {
        return $this->fkEmpenhoTipoDespesaFixa;
    }
}
