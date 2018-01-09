<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * PeriodoMovimentacao
 */
class PeriodoMovimentacao
{
    /**
     * PK
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * @var \DateTime
     */
    private $dtInicial;

    /**
     * @var \DateTime
     */
    private $dtFinal;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ima\Pagamento910
     */
    private $fkImaPagamento910;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\BeneficiarioLancamento
     */
    private $fkBeneficioBeneficiarioLancamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa
     */
    private $fkEstagioEstagiarioEstagioBolsas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\Complementar
     */
    private $fkFolhapagamentoComplementares;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo
     */
    private $fkFolhapagamentoContratoServidorPeriodos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente
     */
    private $fkFolhapagamentoDeducaoDependentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FolhaSituacao
     */
    private $fkFolhapagamentoFolhaSituacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacaoSituacao
     */
    private $fkFolhapagamentoPeriodoMovimentacaoSituacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao
     */
    private $fkPessoalContratoServidorNivelPadroes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSalario
     */
    private $fkPessoalContratoServidorSalarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Beneficiario
     */
    private $fkBeneficioBeneficiarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConcessaoDecimo
     */
    private $fkFolhapagamentoConcessaoDecimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSituacao
     */
    private $fkPessoalContratoServidorSituacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkBeneficioBeneficiarioLancamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEstagioEstagiarioEstagioBolsas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoComplementares = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoContratoServidorPeriodos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoDeducaoDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoFolhaSituacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoPeriodoMovimentacaoSituacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorNivelPadroes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorSalarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkBeneficioBeneficiarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConcessaoDecimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorSituacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return PeriodoMovimentacao
     */
    public function setCodPeriodoMovimentacao($codPeriodoMovimentacao)
    {
        $this->codPeriodoMovimentacao = $codPeriodoMovimentacao;
        return $this;
    }

    /**
     * Get codPeriodoMovimentacao
     *
     * @return integer
     */
    public function getCodPeriodoMovimentacao()
    {
        return $this->codPeriodoMovimentacao;
    }

    /**
     * Set dtInicial
     *
     * @param \DateTime $dtInicial
     * @return PeriodoMovimentacao
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
     * @return PeriodoMovimentacao
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
     * OneToMany (owning side)
     * Add BeneficioBeneficiarioLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\BeneficiarioLancamento $fkBeneficioBeneficiarioLancamento
     * @return PeriodoMovimentacao
     */
    public function addFkBeneficioBeneficiarioLancamentos(\Urbem\CoreBundle\Entity\Beneficio\BeneficiarioLancamento $fkBeneficioBeneficiarioLancamento)
    {
        if (false === $this->fkBeneficioBeneficiarioLancamentos->contains($fkBeneficioBeneficiarioLancamento)) {
            $fkBeneficioBeneficiarioLancamento->setFkFolhapagamentoPeriodoMovimentacao($this);
            $this->fkBeneficioBeneficiarioLancamentos->add($fkBeneficioBeneficiarioLancamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioBeneficiarioLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\BeneficiarioLancamento $fkBeneficioBeneficiarioLancamento
     */
    public function removeFkBeneficioBeneficiarioLancamentos(\Urbem\CoreBundle\Entity\Beneficio\BeneficiarioLancamento $fkBeneficioBeneficiarioLancamento)
    {
        $this->fkBeneficioBeneficiarioLancamentos->removeElement($fkBeneficioBeneficiarioLancamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioBeneficiarioLancamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\BeneficiarioLancamento
     */
    public function getFkBeneficioBeneficiarioLancamentos()
    {
        return $this->fkBeneficioBeneficiarioLancamentos;
    }

    /**
     * OneToMany (owning side)
     * Add EstagioEstagiarioEstagioBolsa
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa $fkEstagioEstagiarioEstagioBolsa
     * @return PeriodoMovimentacao
     */
    public function addFkEstagioEstagiarioEstagioBolsas(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa $fkEstagioEstagiarioEstagioBolsa)
    {
        if (false === $this->fkEstagioEstagiarioEstagioBolsas->contains($fkEstagioEstagiarioEstagioBolsa)) {
            $fkEstagioEstagiarioEstagioBolsa->setFkFolhapagamentoPeriodoMovimentacao($this);
            $this->fkEstagioEstagiarioEstagioBolsas->add($fkEstagioEstagiarioEstagioBolsa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioEstagiarioEstagioBolsa
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa $fkEstagioEstagiarioEstagioBolsa
     */
    public function removeFkEstagioEstagiarioEstagioBolsas(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa $fkEstagioEstagiarioEstagioBolsa)
    {
        $this->fkEstagioEstagiarioEstagioBolsas->removeElement($fkEstagioEstagiarioEstagioBolsa);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioEstagiarioEstagioBolsas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa
     */
    public function getFkEstagioEstagiarioEstagioBolsas()
    {
        return $this->fkEstagioEstagiarioEstagioBolsas;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Complementar $fkFolhapagamentoComplementar
     * @return PeriodoMovimentacao
     */
    public function addFkFolhapagamentoComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\Complementar $fkFolhapagamentoComplementar)
    {
        if (false === $this->fkFolhapagamentoComplementares->contains($fkFolhapagamentoComplementar)) {
            $fkFolhapagamentoComplementar->setFkFolhapagamentoPeriodoMovimentacao($this);
            $this->fkFolhapagamentoComplementares->add($fkFolhapagamentoComplementar);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Complementar $fkFolhapagamentoComplementar
     */
    public function removeFkFolhapagamentoComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\Complementar $fkFolhapagamentoComplementar)
    {
        $this->fkFolhapagamentoComplementares->removeElement($fkFolhapagamentoComplementar);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoComplementares
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\Complementar
     */
    public function getFkFolhapagamentoComplementares()
    {
        return $this->fkFolhapagamentoComplementares;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoContratoServidorPeriodo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo $fkFolhapagamentoContratoServidorPeriodo
     * @return PeriodoMovimentacao
     */
    public function addFkFolhapagamentoContratoServidorPeriodos(\Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo $fkFolhapagamentoContratoServidorPeriodo)
    {
        if (false === $this->fkFolhapagamentoContratoServidorPeriodos->contains($fkFolhapagamentoContratoServidorPeriodo)) {
            $fkFolhapagamentoContratoServidorPeriodo->setFkFolhapagamentoPeriodoMovimentacao($this);
            $this->fkFolhapagamentoContratoServidorPeriodos->add($fkFolhapagamentoContratoServidorPeriodo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoContratoServidorPeriodo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo $fkFolhapagamentoContratoServidorPeriodo
     */
    public function removeFkFolhapagamentoContratoServidorPeriodos(\Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo $fkFolhapagamentoContratoServidorPeriodo)
    {
        $this->fkFolhapagamentoContratoServidorPeriodos->removeElement($fkFolhapagamentoContratoServidorPeriodo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoContratoServidorPeriodos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo
     */
    public function getFkFolhapagamentoContratoServidorPeriodos()
    {
        return $this->fkFolhapagamentoContratoServidorPeriodos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoDeducaoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente $fkFolhapagamentoDeducaoDependente
     * @return PeriodoMovimentacao
     */
    public function addFkFolhapagamentoDeducaoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente $fkFolhapagamentoDeducaoDependente)
    {
        if (false === $this->fkFolhapagamentoDeducaoDependentes->contains($fkFolhapagamentoDeducaoDependente)) {
            $fkFolhapagamentoDeducaoDependente->setFkFolhapagamentoPeriodoMovimentacao($this);
            $this->fkFolhapagamentoDeducaoDependentes->add($fkFolhapagamentoDeducaoDependente);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoDeducaoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente $fkFolhapagamentoDeducaoDependente
     */
    public function removeFkFolhapagamentoDeducaoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente $fkFolhapagamentoDeducaoDependente)
    {
        $this->fkFolhapagamentoDeducaoDependentes->removeElement($fkFolhapagamentoDeducaoDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoDeducaoDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente
     */
    public function getFkFolhapagamentoDeducaoDependentes()
    {
        return $this->fkFolhapagamentoDeducaoDependentes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoFolhaSituacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FolhaSituacao $fkFolhapagamentoFolhaSituacao
     * @return PeriodoMovimentacao
     */
    public function addFkFolhapagamentoFolhaSituacoes(\Urbem\CoreBundle\Entity\Folhapagamento\FolhaSituacao $fkFolhapagamentoFolhaSituacao)
    {
        if (false === $this->fkFolhapagamentoFolhaSituacoes->contains($fkFolhapagamentoFolhaSituacao)) {
            $fkFolhapagamentoFolhaSituacao->setFkFolhapagamentoPeriodoMovimentacao($this);
            $this->fkFolhapagamentoFolhaSituacoes->add($fkFolhapagamentoFolhaSituacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoFolhaSituacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FolhaSituacao $fkFolhapagamentoFolhaSituacao
     */
    public function removeFkFolhapagamentoFolhaSituacoes(\Urbem\CoreBundle\Entity\Folhapagamento\FolhaSituacao $fkFolhapagamentoFolhaSituacao)
    {
        $this->fkFolhapagamentoFolhaSituacoes->removeElement($fkFolhapagamentoFolhaSituacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoFolhaSituacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FolhaSituacao
     */
    public function getFkFolhapagamentoFolhaSituacoes()
    {
        return $this->fkFolhapagamentoFolhaSituacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoPeriodoMovimentacaoSituacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacaoSituacao $fkFolhapagamentoPeriodoMovimentacaoSituacao
     * @return PeriodoMovimentacao
     */
    public function addFkFolhapagamentoPeriodoMovimentacaoSituacoes(\Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacaoSituacao $fkFolhapagamentoPeriodoMovimentacaoSituacao)
    {
        if (false === $this->fkFolhapagamentoPeriodoMovimentacaoSituacoes->contains($fkFolhapagamentoPeriodoMovimentacaoSituacao)) {
            $fkFolhapagamentoPeriodoMovimentacaoSituacao->setFkFolhapagamentoPeriodoMovimentacao($this);
            $this->fkFolhapagamentoPeriodoMovimentacaoSituacoes->add($fkFolhapagamentoPeriodoMovimentacaoSituacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoPeriodoMovimentacaoSituacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacaoSituacao $fkFolhapagamentoPeriodoMovimentacaoSituacao
     */
    public function removeFkFolhapagamentoPeriodoMovimentacaoSituacoes(\Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacaoSituacao $fkFolhapagamentoPeriodoMovimentacaoSituacao)
    {
        $this->fkFolhapagamentoPeriodoMovimentacaoSituacoes->removeElement($fkFolhapagamentoPeriodoMovimentacaoSituacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoPeriodoMovimentacaoSituacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacaoSituacao
     */
    public function getFkFolhapagamentoPeriodoMovimentacaoSituacoes()
    {
        return $this->fkFolhapagamentoPeriodoMovimentacaoSituacoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorNivelPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao $fkPessoalContratoServidorNivelPadrao
     * @return PeriodoMovimentacao
     */
    public function addFkPessoalContratoServidorNivelPadroes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao $fkPessoalContratoServidorNivelPadrao)
    {
        if (false === $this->fkPessoalContratoServidorNivelPadroes->contains($fkPessoalContratoServidorNivelPadrao)) {
            $fkPessoalContratoServidorNivelPadrao->setFkFolhapagamentoPeriodoMovimentacao($this);
            $this->fkPessoalContratoServidorNivelPadroes->add($fkPessoalContratoServidorNivelPadrao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorNivelPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao $fkPessoalContratoServidorNivelPadrao
     */
    public function removeFkPessoalContratoServidorNivelPadroes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao $fkPessoalContratoServidorNivelPadrao)
    {
        $this->fkPessoalContratoServidorNivelPadroes->removeElement($fkPessoalContratoServidorNivelPadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorNivelPadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNivelPadrao
     */
    public function getFkPessoalContratoServidorNivelPadroes()
    {
        return $this->fkPessoalContratoServidorNivelPadroes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorSalario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSalario $fkPessoalContratoServidorSalario
     * @return PeriodoMovimentacao
     */
    public function addFkPessoalContratoServidorSalarios(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSalario $fkPessoalContratoServidorSalario)
    {
        if (false === $this->fkPessoalContratoServidorSalarios->contains($fkPessoalContratoServidorSalario)) {
            $fkPessoalContratoServidorSalario->setFkFolhapagamentoPeriodoMovimentacao($this);
            $this->fkPessoalContratoServidorSalarios->add($fkPessoalContratoServidorSalario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorSalario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSalario $fkPessoalContratoServidorSalario
     */
    public function removeFkPessoalContratoServidorSalarios(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSalario $fkPessoalContratoServidorSalario)
    {
        $this->fkPessoalContratoServidorSalarios->removeElement($fkPessoalContratoServidorSalario);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorSalarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSalario
     */
    public function getFkPessoalContratoServidorSalarios()
    {
        return $this->fkPessoalContratoServidorSalarios;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioBeneficiario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario
     * @return PeriodoMovimentacao
     */
    public function addFkBeneficioBeneficiarios(\Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario)
    {
        if (false === $this->fkBeneficioBeneficiarios->contains($fkBeneficioBeneficiario)) {
            $fkBeneficioBeneficiario->setFkFolhapagamentoPeriodoMovimentacao($this);
            $this->fkBeneficioBeneficiarios->add($fkBeneficioBeneficiario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioBeneficiario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario
     */
    public function removeFkBeneficioBeneficiarios(\Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario)
    {
        $this->fkBeneficioBeneficiarios->removeElement($fkBeneficioBeneficiario);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioBeneficiarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Beneficiario
     */
    public function getFkBeneficioBeneficiarios()
    {
        return $this->fkBeneficioBeneficiarios;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConcessaoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConcessaoDecimo $fkFolhapagamentoConcessaoDecimo
     * @return PeriodoMovimentacao
     */
    public function addFkFolhapagamentoConcessaoDecimos(\Urbem\CoreBundle\Entity\Folhapagamento\ConcessaoDecimo $fkFolhapagamentoConcessaoDecimo)
    {
        if (false === $this->fkFolhapagamentoConcessaoDecimos->contains($fkFolhapagamentoConcessaoDecimo)) {
            $fkFolhapagamentoConcessaoDecimo->setFkFolhapagamentoPeriodoMovimentacao($this);
            $this->fkFolhapagamentoConcessaoDecimos->add($fkFolhapagamentoConcessaoDecimo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConcessaoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConcessaoDecimo $fkFolhapagamentoConcessaoDecimo
     */
    public function removeFkFolhapagamentoConcessaoDecimos(\Urbem\CoreBundle\Entity\Folhapagamento\ConcessaoDecimo $fkFolhapagamentoConcessaoDecimo)
    {
        $this->fkFolhapagamentoConcessaoDecimos->removeElement($fkFolhapagamentoConcessaoDecimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConcessaoDecimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConcessaoDecimo
     */
    public function getFkFolhapagamentoConcessaoDecimos()
    {
        return $this->fkFolhapagamentoConcessaoDecimos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorSituacao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSituacao $fkPessoalContratoServidorSituacao
     * @return PeriodoMovimentacao
     */
    public function addFkPessoalContratoServidorSituacoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSituacao $fkPessoalContratoServidorSituacao)
    {
        if (false === $this->fkPessoalContratoServidorSituacoes->contains($fkPessoalContratoServidorSituacao)) {
            $fkPessoalContratoServidorSituacao->setFkFolhapagamentoPeriodoMovimentacao($this);
            $this->fkPessoalContratoServidorSituacoes->add($fkPessoalContratoServidorSituacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorSituacao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSituacao $fkPessoalContratoServidorSituacao
     */
    public function removeFkPessoalContratoServidorSituacoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSituacao $fkPessoalContratoServidorSituacao)
    {
        $this->fkPessoalContratoServidorSituacoes->removeElement($fkPessoalContratoServidorSituacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorSituacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSituacao
     */
    public function getFkPessoalContratoServidorSituacoes()
    {
        return $this->fkPessoalContratoServidorSituacoes;
    }

    /**
     * OneToOne (inverse side)
     * Set ImaPagamento910
     *
     * @param \Urbem\CoreBundle\Entity\Ima\Pagamento910 $fkImaPagamento910
     * @return PeriodoMovimentacao
     */
    public function setFkImaPagamento910(\Urbem\CoreBundle\Entity\Ima\Pagamento910 $fkImaPagamento910)
    {
        $fkImaPagamento910->setFkFolhapagamentoPeriodoMovimentacao($this);
        $this->fkImaPagamento910 = $fkImaPagamento910;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImaPagamento910
     *
     * @return \Urbem\CoreBundle\Entity\Ima\Pagamento910
     */
    public function getFkImaPagamento910()
    {
        return $this->fkImaPagamento910;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) "Periodo de Movimentação";
    }

    /**
     * @return string
     */
    public function getSituacao()
    {
        if (is_null($this->getCodPeriodoMovimentacao())) {
            return '';
        }

        $status = (strtoupper($this->getFkFolhapagamentoPeriodoMovimentacaoSituacoes()->last()->getSituacao()) == 'A') ? 'Aberto' : 'Fechado';

        return $status;
    }
}
