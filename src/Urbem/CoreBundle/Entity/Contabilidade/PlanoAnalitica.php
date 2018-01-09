<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * PlanoAnalitica
 */
class PlanoAnalitica
{
    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codConta;

    /**
     * @var string
     */
    private $naturezaSaldo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco
     */
    private $fkContabilidadePlanoBanco;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso
     */
    private $fkContabilidadePlanoRecurso;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel
     */
    private $fkEmpenhoContrapartidaResponsavel;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tceal\DespesaReceitaExtra
     */
    private $fkTcealDespesaReceitaExtra;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tceam\VinculoElencoPlanoContas
     */
    private $fkTceamVinculoElencoPlanoContas;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\ArquivoExt
     */
    private $fkTcemgArquivoExt;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\BalanceteExtmmaa
     */
    private $fkTcemgBalanceteExtmmaa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcepe\PlanoAnaliticaTipoRetencao
     */
    private $fkTcepePlanoAnaliticaTipoRetencao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\BalanceteExtmmaa
     */
    private $fkTcmgoBalanceteExtmmaa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\BalancoAfraaaa
     */
    private $fkTcmgoBalancoAfraaaa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\BalancoComaaaa
     */
    private $fkTcmgoBalancoComaaaa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\BalancoPfdaaaa
     */
    private $fkTcmgoBalancoPfdaaaa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\BalancoPpdaaaa
     */
    private $fkTcmgoBalancoPpdaaaa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\BalancoApcaaaa
     */
    private $fkTcmgoBalancoApcaaaa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\ConvenioPlanoBanco
     */
    private $fkTcemgConvenioPlanoBanco;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcepb\PlanoAnaliticaTipoRetencao
     */
    private $fkTcepbPlanoAnaliticaTipoRetencao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tceto\PlanoAnaliticaClassificacao
     */
    private $fkTcetoPlanoAnaliticaClassificacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    private $fkContabilidadePlanoConta;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ContaCredito
     */
    private $fkContabilidadeContaCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ContaDebito
     */
    private $fkContabilidadeContaDebitos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp
     */
    private $fkContabilidadeContaLancamentoRps;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCreditoAcrescimo
     */
    private $fkContabilidadePlanoAnaliticaCreditoAcrescimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCredito
     */
    private $fkContabilidadePlanoAnaliticaCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\IncorporacaoPatrimonio
     */
    private $fkEmpenhoIncorporacaoPatrimonios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\IncorporacaoPatrimonio
     */
    private $fkEmpenhoIncorporacaoPatrimonios1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao
     */
    private $fkEmpenhoOrdemPagamentoRetencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento
     */
    private $fkEmpenhoResponsavelAdiantamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica
     */
    private $fkPatrimonioGrupoPlanoAnaliticas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica
     */
    private $fkPatrimonioGrupoPlanoAnaliticas1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica
     */
    private $fkPatrimonioGrupoPlanoAnaliticas2;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica
     */
    private $fkPatrimonioGrupoPlanoAnaliticas3;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica
     */
    private $fkPatrimonioGrupoPlanoAnaliticas4;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica
     */
    private $fkPatrimonioGrupoPlanoAnaliticas5;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemPlanoAnalitica
     */
    private $fkPatrimonioBemPlanoAnaliticas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemPlanoDepreciacao
     */
    private $fkPatrimonioBemPlanoDepreciacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoDepreciacao
     */
    private $fkPatrimonioGrupoPlanoDepreciacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoFundeb
     */
    private $fkStnVinculoFundebs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\PlanoAnaliticaRelacionamento
     */
    private $fkTcepbPlanoAnaliticaRelacionamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\PlanoAnaliticaRelacionamento
     */
    private $fkTcepePlanoAnaliticaRelacionamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\DeParaTipoRetencao
     */
    private $fkTcmgoDeParaTipoRetencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    private $fkTesourariaArrecadacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraBanco
     */
    private $fkTesourariaReciboExtraBancos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    private $fkTesourariaTransferencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    private $fkTesourariaTransferencias1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoContaPagadora
     */
    private $fkEmpenhoNotaLiquidacaoContaPagadoras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra
     */
    private $fkTesourariaReciboExtras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Pagamento
     */
    private $fkTesourariaPagamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoContasRgf2
     */
    private $fkStnVinculoContasRgf2s;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ArquivoExt
     */
    private $fkTcmgoArquivoExts;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote
     */
    private $fkTesourariaTransferenciasDotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote
     */
    private $fkTesourariaTransferenciasDotes1;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadeContaCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeContaDebitos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeContaLancamentoRps = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadePlanoAnaliticaCreditoAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadePlanoAnaliticaCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoIncorporacaoPatrimonios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoIncorporacaoPatrimonios1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoOrdemPagamentoRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoResponsavelAdiantamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioGrupoPlanoAnaliticas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioGrupoPlanoAnaliticas1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioGrupoPlanoAnaliticas2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioGrupoPlanoAnaliticas3 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioGrupoPlanoAnaliticas4 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioGrupoPlanoAnaliticas5 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioBemPlanoAnaliticas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioBemPlanoDepreciacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioGrupoPlanoDepreciacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkStnVinculoFundebs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepbPlanoAnaliticaRelacionamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepePlanoAnaliticaRelacionamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoDeParaTipoRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaArrecadacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaReciboExtraBancos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferencias1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoNotaLiquidacaoContaPagadoras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaReciboExtras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkStnVinculoContasRgf2s = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoArquivoExts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferenciasDotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferenciasDotes1 = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return PlanoAnalitica
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PlanoAnalitica
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
     * Set codConta
     *
     * @param integer $codConta
     * @return PlanoAnalitica
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * Set naturezaSaldo
     *
     * @param string $naturezaSaldo
     * @return PlanoAnalitica
     */
    public function setNaturezaSaldo($naturezaSaldo)
    {
        $this->naturezaSaldo = $naturezaSaldo;
        return $this;
    }

    /**
     * Get naturezaSaldo
     *
     * @return string
     */
    public function getNaturezaSaldo()
    {
        return $this->naturezaSaldo;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeContaCredito
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ContaCredito $fkContabilidadeContaCredito
     * @return PlanoAnalitica
     */
    public function addFkContabilidadeContaCreditos(\Urbem\CoreBundle\Entity\Contabilidade\ContaCredito $fkContabilidadeContaCredito)
    {
        if (false === $this->fkContabilidadeContaCreditos->contains($fkContabilidadeContaCredito)) {
            $fkContabilidadeContaCredito->setFkContabilidadePlanoAnalitica($this);
            $this->fkContabilidadeContaCreditos->add($fkContabilidadeContaCredito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeContaCredito
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ContaCredito $fkContabilidadeContaCredito
     */
    public function removeFkContabilidadeContaCreditos(\Urbem\CoreBundle\Entity\Contabilidade\ContaCredito $fkContabilidadeContaCredito)
    {
        $this->fkContabilidadeContaCreditos->removeElement($fkContabilidadeContaCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeContaCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ContaCredito
     */
    public function getFkContabilidadeContaCreditos()
    {
        return $this->fkContabilidadeContaCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeContaDebito
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ContaDebito $fkContabilidadeContaDebito
     * @return PlanoAnalitica
     */
    public function addFkContabilidadeContaDebitos(\Urbem\CoreBundle\Entity\Contabilidade\ContaDebito $fkContabilidadeContaDebito)
    {
        if (false === $this->fkContabilidadeContaDebitos->contains($fkContabilidadeContaDebito)) {
            $fkContabilidadeContaDebito->setFkContabilidadePlanoAnalitica($this);
            $this->fkContabilidadeContaDebitos->add($fkContabilidadeContaDebito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeContaDebito
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ContaDebito $fkContabilidadeContaDebito
     */
    public function removeFkContabilidadeContaDebitos(\Urbem\CoreBundle\Entity\Contabilidade\ContaDebito $fkContabilidadeContaDebito)
    {
        $this->fkContabilidadeContaDebitos->removeElement($fkContabilidadeContaDebito);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeContaDebitos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ContaDebito
     */
    public function getFkContabilidadeContaDebitos()
    {
        return $this->fkContabilidadeContaDebitos;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeContaLancamentoRp
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp $fkContabilidadeContaLancamentoRp
     * @return PlanoAnalitica
     */
    public function addFkContabilidadeContaLancamentoRps(\Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp $fkContabilidadeContaLancamentoRp)
    {
        if (false === $this->fkContabilidadeContaLancamentoRps->contains($fkContabilidadeContaLancamentoRp)) {
            $fkContabilidadeContaLancamentoRp->setFkContabilidadePlanoAnalitica($this);
            $this->fkContabilidadeContaLancamentoRps->add($fkContabilidadeContaLancamentoRp);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeContaLancamentoRp
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp $fkContabilidadeContaLancamentoRp
     */
    public function removeFkContabilidadeContaLancamentoRps(\Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp $fkContabilidadeContaLancamentoRp)
    {
        $this->fkContabilidadeContaLancamentoRps->removeElement($fkContabilidadeContaLancamentoRp);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeContaLancamentoRps
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp
     */
    public function getFkContabilidadeContaLancamentoRps()
    {
        return $this->fkContabilidadeContaLancamentoRps;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadePlanoAnaliticaCreditoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCreditoAcrescimo $fkContabilidadePlanoAnaliticaCreditoAcrescimo
     * @return PlanoAnalitica
     */
    public function addFkContabilidadePlanoAnaliticaCreditoAcrescimos(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCreditoAcrescimo $fkContabilidadePlanoAnaliticaCreditoAcrescimo)
    {
        if (false === $this->fkContabilidadePlanoAnaliticaCreditoAcrescimos->contains($fkContabilidadePlanoAnaliticaCreditoAcrescimo)) {
            $fkContabilidadePlanoAnaliticaCreditoAcrescimo->setFkContabilidadePlanoAnalitica($this);
            $this->fkContabilidadePlanoAnaliticaCreditoAcrescimos->add($fkContabilidadePlanoAnaliticaCreditoAcrescimo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadePlanoAnaliticaCreditoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCreditoAcrescimo $fkContabilidadePlanoAnaliticaCreditoAcrescimo
     */
    public function removeFkContabilidadePlanoAnaliticaCreditoAcrescimos(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCreditoAcrescimo $fkContabilidadePlanoAnaliticaCreditoAcrescimo)
    {
        $this->fkContabilidadePlanoAnaliticaCreditoAcrescimos->removeElement($fkContabilidadePlanoAnaliticaCreditoAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadePlanoAnaliticaCreditoAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCreditoAcrescimo
     */
    public function getFkContabilidadePlanoAnaliticaCreditoAcrescimos()
    {
        return $this->fkContabilidadePlanoAnaliticaCreditoAcrescimos;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadePlanoAnaliticaCredito
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCredito $fkContabilidadePlanoAnaliticaCredito
     * @return PlanoAnalitica
     */
    public function addFkContabilidadePlanoAnaliticaCreditos(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCredito $fkContabilidadePlanoAnaliticaCredito)
    {
        if (false === $this->fkContabilidadePlanoAnaliticaCreditos->contains($fkContabilidadePlanoAnaliticaCredito)) {
            $fkContabilidadePlanoAnaliticaCredito->setFkContabilidadePlanoAnalitica($this);
            $this->fkContabilidadePlanoAnaliticaCreditos->add($fkContabilidadePlanoAnaliticaCredito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadePlanoAnaliticaCredito
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCredito $fkContabilidadePlanoAnaliticaCredito
     */
    public function removeFkContabilidadePlanoAnaliticaCreditos(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCredito $fkContabilidadePlanoAnaliticaCredito)
    {
        $this->fkContabilidadePlanoAnaliticaCreditos->removeElement($fkContabilidadePlanoAnaliticaCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadePlanoAnaliticaCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCredito
     */
    public function getFkContabilidadePlanoAnaliticaCreditos()
    {
        return $this->fkContabilidadePlanoAnaliticaCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoIncorporacaoPatrimonio
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\IncorporacaoPatrimonio $fkEmpenhoIncorporacaoPatrimonio
     * @return PlanoAnalitica
     */
    public function addFkEmpenhoIncorporacaoPatrimonios(\Urbem\CoreBundle\Entity\Empenho\IncorporacaoPatrimonio $fkEmpenhoIncorporacaoPatrimonio)
    {
        if (false === $this->fkEmpenhoIncorporacaoPatrimonios->contains($fkEmpenhoIncorporacaoPatrimonio)) {
            $fkEmpenhoIncorporacaoPatrimonio->setFkContabilidadePlanoAnalitica($this);
            $this->fkEmpenhoIncorporacaoPatrimonios->add($fkEmpenhoIncorporacaoPatrimonio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoIncorporacaoPatrimonio
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\IncorporacaoPatrimonio $fkEmpenhoIncorporacaoPatrimonio
     */
    public function removeFkEmpenhoIncorporacaoPatrimonios(\Urbem\CoreBundle\Entity\Empenho\IncorporacaoPatrimonio $fkEmpenhoIncorporacaoPatrimonio)
    {
        $this->fkEmpenhoIncorporacaoPatrimonios->removeElement($fkEmpenhoIncorporacaoPatrimonio);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoIncorporacaoPatrimonios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\IncorporacaoPatrimonio
     */
    public function getFkEmpenhoIncorporacaoPatrimonios()
    {
        return $this->fkEmpenhoIncorporacaoPatrimonios;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoIncorporacaoPatrimonio
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\IncorporacaoPatrimonio $fkEmpenhoIncorporacaoPatrimonio
     * @return PlanoAnalitica
     */
    public function addFkEmpenhoIncorporacaoPatrimonios1(\Urbem\CoreBundle\Entity\Empenho\IncorporacaoPatrimonio $fkEmpenhoIncorporacaoPatrimonio)
    {
        if (false === $this->fkEmpenhoIncorporacaoPatrimonios1->contains($fkEmpenhoIncorporacaoPatrimonio)) {
            $fkEmpenhoIncorporacaoPatrimonio->setFkContabilidadePlanoAnalitica1($this);
            $this->fkEmpenhoIncorporacaoPatrimonios1->add($fkEmpenhoIncorporacaoPatrimonio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoIncorporacaoPatrimonio
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\IncorporacaoPatrimonio $fkEmpenhoIncorporacaoPatrimonio
     */
    public function removeFkEmpenhoIncorporacaoPatrimonios1(\Urbem\CoreBundle\Entity\Empenho\IncorporacaoPatrimonio $fkEmpenhoIncorporacaoPatrimonio)
    {
        $this->fkEmpenhoIncorporacaoPatrimonios1->removeElement($fkEmpenhoIncorporacaoPatrimonio);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoIncorporacaoPatrimonios1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\IncorporacaoPatrimonio
     */
    public function getFkEmpenhoIncorporacaoPatrimonios1()
    {
        return $this->fkEmpenhoIncorporacaoPatrimonios1;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao
     * @return PlanoAnalitica
     */
    public function addFkEmpenhoOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao)
    {
        if (false === $this->fkEmpenhoOrdemPagamentoRetencoes->contains($fkEmpenhoOrdemPagamentoRetencao)) {
            $fkEmpenhoOrdemPagamentoRetencao->setFkContabilidadePlanoAnalitica($this);
            $this->fkEmpenhoOrdemPagamentoRetencoes->add($fkEmpenhoOrdemPagamentoRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao
     */
    public function removeFkEmpenhoOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao)
    {
        $this->fkEmpenhoOrdemPagamentoRetencoes->removeElement($fkEmpenhoOrdemPagamentoRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoOrdemPagamentoRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao
     */
    public function getFkEmpenhoOrdemPagamentoRetencoes()
    {
        return $this->fkEmpenhoOrdemPagamentoRetencoes;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoResponsavelAdiantamento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento $fkEmpenhoResponsavelAdiantamento
     * @return PlanoAnalitica
     */
    public function addFkEmpenhoResponsavelAdiantamentos(\Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento $fkEmpenhoResponsavelAdiantamento)
    {
        if (false === $this->fkEmpenhoResponsavelAdiantamentos->contains($fkEmpenhoResponsavelAdiantamento)) {
            $fkEmpenhoResponsavelAdiantamento->setFkContabilidadePlanoAnalitica($this);
            $this->fkEmpenhoResponsavelAdiantamentos->add($fkEmpenhoResponsavelAdiantamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoResponsavelAdiantamento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento $fkEmpenhoResponsavelAdiantamento
     */
    public function removeFkEmpenhoResponsavelAdiantamentos(\Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento $fkEmpenhoResponsavelAdiantamento)
    {
        $this->fkEmpenhoResponsavelAdiantamentos->removeElement($fkEmpenhoResponsavelAdiantamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoResponsavelAdiantamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento
     */
    public function getFkEmpenhoResponsavelAdiantamentos()
    {
        return $this->fkEmpenhoResponsavelAdiantamentos;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioGrupoPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica
     * @return PlanoAnalitica
     */
    public function addFkPatrimonioGrupoPlanoAnaliticas(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica)
    {
        if (false === $this->fkPatrimonioGrupoPlanoAnaliticas->contains($fkPatrimonioGrupoPlanoAnalitica)) {
            $fkPatrimonioGrupoPlanoAnalitica->setFkContabilidadePlanoAnalitica($this);
            $this->fkPatrimonioGrupoPlanoAnaliticas->add($fkPatrimonioGrupoPlanoAnalitica);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioGrupoPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica
     */
    public function removeFkPatrimonioGrupoPlanoAnaliticas(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica)
    {
        $this->fkPatrimonioGrupoPlanoAnaliticas->removeElement($fkPatrimonioGrupoPlanoAnalitica);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioGrupoPlanoAnaliticas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica
     */
    public function getFkPatrimonioGrupoPlanoAnaliticas()
    {
        return $this->fkPatrimonioGrupoPlanoAnaliticas;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioGrupoPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica
     * @return PlanoAnalitica
     */
    public function addFkPatrimonioGrupoPlanoAnaliticas1(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica)
    {
        if (false === $this->fkPatrimonioGrupoPlanoAnaliticas1->contains($fkPatrimonioGrupoPlanoAnalitica)) {
            $fkPatrimonioGrupoPlanoAnalitica->setFkContabilidadePlanoAnalitica1($this);
            $this->fkPatrimonioGrupoPlanoAnaliticas1->add($fkPatrimonioGrupoPlanoAnalitica);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioGrupoPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica
     */
    public function removeFkPatrimonioGrupoPlanoAnaliticas1(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica)
    {
        $this->fkPatrimonioGrupoPlanoAnaliticas1->removeElement($fkPatrimonioGrupoPlanoAnalitica);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioGrupoPlanoAnaliticas1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica
     */
    public function getFkPatrimonioGrupoPlanoAnaliticas1()
    {
        return $this->fkPatrimonioGrupoPlanoAnaliticas1;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioGrupoPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica
     * @return PlanoAnalitica
     */
    public function addFkPatrimonioGrupoPlanoAnaliticas2(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica)
    {
        if (false === $this->fkPatrimonioGrupoPlanoAnaliticas2->contains($fkPatrimonioGrupoPlanoAnalitica)) {
            $fkPatrimonioGrupoPlanoAnalitica->setFkContabilidadePlanoAnalitica2($this);
            $this->fkPatrimonioGrupoPlanoAnaliticas2->add($fkPatrimonioGrupoPlanoAnalitica);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioGrupoPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica
     */
    public function removeFkPatrimonioGrupoPlanoAnaliticas2(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica)
    {
        $this->fkPatrimonioGrupoPlanoAnaliticas2->removeElement($fkPatrimonioGrupoPlanoAnalitica);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioGrupoPlanoAnaliticas2
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica
     */
    public function getFkPatrimonioGrupoPlanoAnaliticas2()
    {
        return $this->fkPatrimonioGrupoPlanoAnaliticas2;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioGrupoPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica
     * @return PlanoAnalitica
     */
    public function addFkPatrimonioGrupoPlanoAnaliticas3(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica)
    {
        if (false === $this->fkPatrimonioGrupoPlanoAnaliticas3->contains($fkPatrimonioGrupoPlanoAnalitica)) {
            $fkPatrimonioGrupoPlanoAnalitica->setFkContabilidadePlanoAnalitica3($this);
            $this->fkPatrimonioGrupoPlanoAnaliticas3->add($fkPatrimonioGrupoPlanoAnalitica);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioGrupoPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica
     */
    public function removeFkPatrimonioGrupoPlanoAnaliticas3(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica)
    {
        $this->fkPatrimonioGrupoPlanoAnaliticas3->removeElement($fkPatrimonioGrupoPlanoAnalitica);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioGrupoPlanoAnaliticas3
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica
     */
    public function getFkPatrimonioGrupoPlanoAnaliticas3()
    {
        return $this->fkPatrimonioGrupoPlanoAnaliticas3;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioGrupoPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica
     * @return PlanoAnalitica
     */
    public function addFkPatrimonioGrupoPlanoAnaliticas4(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica)
    {
        if (false === $this->fkPatrimonioGrupoPlanoAnaliticas4->contains($fkPatrimonioGrupoPlanoAnalitica)) {
            $fkPatrimonioGrupoPlanoAnalitica->setFkContabilidadePlanoAnalitica4($this);
            $this->fkPatrimonioGrupoPlanoAnaliticas4->add($fkPatrimonioGrupoPlanoAnalitica);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioGrupoPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica
     */
    public function removeFkPatrimonioGrupoPlanoAnaliticas4(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica)
    {
        $this->fkPatrimonioGrupoPlanoAnaliticas4->removeElement($fkPatrimonioGrupoPlanoAnalitica);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioGrupoPlanoAnaliticas4
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica
     */
    public function getFkPatrimonioGrupoPlanoAnaliticas4()
    {
        return $this->fkPatrimonioGrupoPlanoAnaliticas4;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioGrupoPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica
     * @return PlanoAnalitica
     */
    public function addFkPatrimonioGrupoPlanoAnaliticas5(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica)
    {
        if (false === $this->fkPatrimonioGrupoPlanoAnaliticas5->contains($fkPatrimonioGrupoPlanoAnalitica)) {
            $fkPatrimonioGrupoPlanoAnalitica->setFkContabilidadePlanoAnalitica5($this);
            $this->fkPatrimonioGrupoPlanoAnaliticas5->add($fkPatrimonioGrupoPlanoAnalitica);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioGrupoPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica
     */
    public function removeFkPatrimonioGrupoPlanoAnaliticas5(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica)
    {
        $this->fkPatrimonioGrupoPlanoAnaliticas5->removeElement($fkPatrimonioGrupoPlanoAnalitica);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioGrupoPlanoAnaliticas5
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica
     */
    public function getFkPatrimonioGrupoPlanoAnaliticas5()
    {
        return $this->fkPatrimonioGrupoPlanoAnaliticas5;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioBemPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemPlanoAnalitica $fkPatrimonioBemPlanoAnalitica
     * @return PlanoAnalitica
     */
    public function addFkPatrimonioBemPlanoAnaliticas(\Urbem\CoreBundle\Entity\Patrimonio\BemPlanoAnalitica $fkPatrimonioBemPlanoAnalitica)
    {
        if (false === $this->fkPatrimonioBemPlanoAnaliticas->contains($fkPatrimonioBemPlanoAnalitica)) {
            $fkPatrimonioBemPlanoAnalitica->setFkContabilidadePlanoAnalitica($this);
            $this->fkPatrimonioBemPlanoAnaliticas->add($fkPatrimonioBemPlanoAnalitica);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioBemPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemPlanoAnalitica $fkPatrimonioBemPlanoAnalitica
     */
    public function removeFkPatrimonioBemPlanoAnaliticas(\Urbem\CoreBundle\Entity\Patrimonio\BemPlanoAnalitica $fkPatrimonioBemPlanoAnalitica)
    {
        $this->fkPatrimonioBemPlanoAnaliticas->removeElement($fkPatrimonioBemPlanoAnalitica);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioBemPlanoAnaliticas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemPlanoAnalitica
     */
    public function getFkPatrimonioBemPlanoAnaliticas()
    {
        return $this->fkPatrimonioBemPlanoAnaliticas;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioBemPlanoDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemPlanoDepreciacao $fkPatrimonioBemPlanoDepreciacao
     * @return PlanoAnalitica
     */
    public function addFkPatrimonioBemPlanoDepreciacoes(\Urbem\CoreBundle\Entity\Patrimonio\BemPlanoDepreciacao $fkPatrimonioBemPlanoDepreciacao)
    {
        if (false === $this->fkPatrimonioBemPlanoDepreciacoes->contains($fkPatrimonioBemPlanoDepreciacao)) {
            $fkPatrimonioBemPlanoDepreciacao->setFkContabilidadePlanoAnalitica($this);
            $this->fkPatrimonioBemPlanoDepreciacoes->add($fkPatrimonioBemPlanoDepreciacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioBemPlanoDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemPlanoDepreciacao $fkPatrimonioBemPlanoDepreciacao
     */
    public function removeFkPatrimonioBemPlanoDepreciacoes(\Urbem\CoreBundle\Entity\Patrimonio\BemPlanoDepreciacao $fkPatrimonioBemPlanoDepreciacao)
    {
        $this->fkPatrimonioBemPlanoDepreciacoes->removeElement($fkPatrimonioBemPlanoDepreciacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioBemPlanoDepreciacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemPlanoDepreciacao
     */
    public function getFkPatrimonioBemPlanoDepreciacoes()
    {
        return $this->fkPatrimonioBemPlanoDepreciacoes;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioGrupoPlanoDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoDepreciacao $fkPatrimonioGrupoPlanoDepreciacao
     * @return PlanoAnalitica
     */
    public function addFkPatrimonioGrupoPlanoDepreciacoes(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoDepreciacao $fkPatrimonioGrupoPlanoDepreciacao)
    {
        if (false === $this->fkPatrimonioGrupoPlanoDepreciacoes->contains($fkPatrimonioGrupoPlanoDepreciacao)) {
            $fkPatrimonioGrupoPlanoDepreciacao->setFkContabilidadePlanoAnalitica($this);
            $this->fkPatrimonioGrupoPlanoDepreciacoes->add($fkPatrimonioGrupoPlanoDepreciacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioGrupoPlanoDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoDepreciacao $fkPatrimonioGrupoPlanoDepreciacao
     */
    public function removeFkPatrimonioGrupoPlanoDepreciacoes(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoDepreciacao $fkPatrimonioGrupoPlanoDepreciacao)
    {
        $this->fkPatrimonioGrupoPlanoDepreciacoes->removeElement($fkPatrimonioGrupoPlanoDepreciacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioGrupoPlanoDepreciacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoDepreciacao
     */
    public function getFkPatrimonioGrupoPlanoDepreciacoes()
    {
        return $this->fkPatrimonioGrupoPlanoDepreciacoes;
    }

    /**
     * OneToMany (owning side)
     * Add StnVinculoFundeb
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoFundeb $fkStnVinculoFundeb
     * @return PlanoAnalitica
     */
    public function addFkStnVinculoFundebs(\Urbem\CoreBundle\Entity\Stn\VinculoFundeb $fkStnVinculoFundeb)
    {
        if (false === $this->fkStnVinculoFundebs->contains($fkStnVinculoFundeb)) {
            $fkStnVinculoFundeb->setFkContabilidadePlanoAnalitica($this);
            $this->fkStnVinculoFundebs->add($fkStnVinculoFundeb);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnVinculoFundeb
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoFundeb $fkStnVinculoFundeb
     */
    public function removeFkStnVinculoFundebs(\Urbem\CoreBundle\Entity\Stn\VinculoFundeb $fkStnVinculoFundeb)
    {
        $this->fkStnVinculoFundebs->removeElement($fkStnVinculoFundeb);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnVinculoFundebs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoFundeb
     */
    public function getFkStnVinculoFundebs()
    {
        return $this->fkStnVinculoFundebs;
    }

    /**
     * OneToMany (owning side)
     * Add TcepbPlanoAnaliticaRelacionamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\PlanoAnaliticaRelacionamento $fkTcepbPlanoAnaliticaRelacionamento
     * @return PlanoAnalitica
     */
    public function addFkTcepbPlanoAnaliticaRelacionamentos(\Urbem\CoreBundle\Entity\Tcepb\PlanoAnaliticaRelacionamento $fkTcepbPlanoAnaliticaRelacionamento)
    {
        if (false === $this->fkTcepbPlanoAnaliticaRelacionamentos->contains($fkTcepbPlanoAnaliticaRelacionamento)) {
            $fkTcepbPlanoAnaliticaRelacionamento->setFkContabilidadePlanoAnalitica($this);
            $this->fkTcepbPlanoAnaliticaRelacionamentos->add($fkTcepbPlanoAnaliticaRelacionamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepbPlanoAnaliticaRelacionamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\PlanoAnaliticaRelacionamento $fkTcepbPlanoAnaliticaRelacionamento
     */
    public function removeFkTcepbPlanoAnaliticaRelacionamentos(\Urbem\CoreBundle\Entity\Tcepb\PlanoAnaliticaRelacionamento $fkTcepbPlanoAnaliticaRelacionamento)
    {
        $this->fkTcepbPlanoAnaliticaRelacionamentos->removeElement($fkTcepbPlanoAnaliticaRelacionamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepbPlanoAnaliticaRelacionamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\PlanoAnaliticaRelacionamento
     */
    public function getFkTcepbPlanoAnaliticaRelacionamentos()
    {
        return $this->fkTcepbPlanoAnaliticaRelacionamentos;
    }

    /**
     * OneToMany (owning side)
     * Add TcepePlanoAnaliticaRelacionamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\PlanoAnaliticaRelacionamento $fkTcepePlanoAnaliticaRelacionamento
     * @return PlanoAnalitica
     */
    public function addFkTcepePlanoAnaliticaRelacionamentos(\Urbem\CoreBundle\Entity\Tcepe\PlanoAnaliticaRelacionamento $fkTcepePlanoAnaliticaRelacionamento)
    {
        if (false === $this->fkTcepePlanoAnaliticaRelacionamentos->contains($fkTcepePlanoAnaliticaRelacionamento)) {
            $fkTcepePlanoAnaliticaRelacionamento->setFkContabilidadePlanoAnalitica($this);
            $this->fkTcepePlanoAnaliticaRelacionamentos->add($fkTcepePlanoAnaliticaRelacionamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepePlanoAnaliticaRelacionamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\PlanoAnaliticaRelacionamento $fkTcepePlanoAnaliticaRelacionamento
     */
    public function removeFkTcepePlanoAnaliticaRelacionamentos(\Urbem\CoreBundle\Entity\Tcepe\PlanoAnaliticaRelacionamento $fkTcepePlanoAnaliticaRelacionamento)
    {
        $this->fkTcepePlanoAnaliticaRelacionamentos->removeElement($fkTcepePlanoAnaliticaRelacionamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepePlanoAnaliticaRelacionamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\PlanoAnaliticaRelacionamento
     */
    public function getFkTcepePlanoAnaliticaRelacionamentos()
    {
        return $this->fkTcepePlanoAnaliticaRelacionamentos;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoDeParaTipoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\DeParaTipoRetencao $fkTcmgoDeParaTipoRetencao
     * @return PlanoAnalitica
     */
    public function addFkTcmgoDeParaTipoRetencoes(\Urbem\CoreBundle\Entity\Tcmgo\DeParaTipoRetencao $fkTcmgoDeParaTipoRetencao)
    {
        if (false === $this->fkTcmgoDeParaTipoRetencoes->contains($fkTcmgoDeParaTipoRetencao)) {
            $fkTcmgoDeParaTipoRetencao->setFkContabilidadePlanoAnalitica($this);
            $this->fkTcmgoDeParaTipoRetencoes->add($fkTcmgoDeParaTipoRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoDeParaTipoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\DeParaTipoRetencao $fkTcmgoDeParaTipoRetencao
     */
    public function removeFkTcmgoDeParaTipoRetencoes(\Urbem\CoreBundle\Entity\Tcmgo\DeParaTipoRetencao $fkTcmgoDeParaTipoRetencao)
    {
        $this->fkTcmgoDeParaTipoRetencoes->removeElement($fkTcmgoDeParaTipoRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoDeParaTipoRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\DeParaTipoRetencao
     */
    public function getFkTcmgoDeParaTipoRetencoes()
    {
        return $this->fkTcmgoDeParaTipoRetencoes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao
     * @return PlanoAnalitica
     */
    public function addFkTesourariaArrecadacoes(\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao)
    {
        if (false === $this->fkTesourariaArrecadacoes->contains($fkTesourariaArrecadacao)) {
            $fkTesourariaArrecadacao->setFkContabilidadePlanoAnalitica($this);
            $this->fkTesourariaArrecadacoes->add($fkTesourariaArrecadacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao
     */
    public function removeFkTesourariaArrecadacoes(\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao)
    {
        $this->fkTesourariaArrecadacoes->removeElement($fkTesourariaArrecadacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaArrecadacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    public function getFkTesourariaArrecadacoes()
    {
        return $this->fkTesourariaArrecadacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaReciboExtraBanco
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraBanco $fkTesourariaReciboExtraBanco
     * @return PlanoAnalitica
     */
    public function addFkTesourariaReciboExtraBancos(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraBanco $fkTesourariaReciboExtraBanco)
    {
        if (false === $this->fkTesourariaReciboExtraBancos->contains($fkTesourariaReciboExtraBanco)) {
            $fkTesourariaReciboExtraBanco->setFkContabilidadePlanoAnalitica($this);
            $this->fkTesourariaReciboExtraBancos->add($fkTesourariaReciboExtraBanco);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaReciboExtraBanco
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraBanco $fkTesourariaReciboExtraBanco
     */
    public function removeFkTesourariaReciboExtraBancos(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraBanco $fkTesourariaReciboExtraBanco)
    {
        $this->fkTesourariaReciboExtraBancos->removeElement($fkTesourariaReciboExtraBanco);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaReciboExtraBancos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraBanco
     */
    public function getFkTesourariaReciboExtraBancos()
    {
        return $this->fkTesourariaReciboExtraBancos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return PlanoAnalitica
     */
    public function addFkTesourariaTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia)
    {
        if (false === $this->fkTesourariaTransferencias->contains($fkTesourariaTransferencia)) {
            $fkTesourariaTransferencia->setFkContabilidadePlanoAnalitica($this);
            $this->fkTesourariaTransferencias->add($fkTesourariaTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     */
    public function removeFkTesourariaTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia)
    {
        $this->fkTesourariaTransferencias->removeElement($fkTesourariaTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    public function getFkTesourariaTransferencias()
    {
        return $this->fkTesourariaTransferencias;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return PlanoAnalitica
     */
    public function addFkTesourariaTransferencias1(\Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia)
    {
        if (false === $this->fkTesourariaTransferencias1->contains($fkTesourariaTransferencia)) {
            $fkTesourariaTransferencia->setFkContabilidadePlanoAnalitica1($this);
            $this->fkTesourariaTransferencias1->add($fkTesourariaTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     */
    public function removeFkTesourariaTransferencias1(\Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia)
    {
        $this->fkTesourariaTransferencias1->removeElement($fkTesourariaTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransferencias1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    public function getFkTesourariaTransferencias1()
    {
        return $this->fkTesourariaTransferencias1;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoNotaLiquidacaoContaPagadora
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoContaPagadora $fkEmpenhoNotaLiquidacaoContaPagadora
     * @return PlanoAnalitica
     */
    public function addFkEmpenhoNotaLiquidacaoContaPagadoras(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoContaPagadora $fkEmpenhoNotaLiquidacaoContaPagadora)
    {
        if (false === $this->fkEmpenhoNotaLiquidacaoContaPagadoras->contains($fkEmpenhoNotaLiquidacaoContaPagadora)) {
            $fkEmpenhoNotaLiquidacaoContaPagadora->setFkContabilidadePlanoAnalitica($this);
            $this->fkEmpenhoNotaLiquidacaoContaPagadoras->add($fkEmpenhoNotaLiquidacaoContaPagadora);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoNotaLiquidacaoContaPagadora
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoContaPagadora $fkEmpenhoNotaLiquidacaoContaPagadora
     */
    public function removeFkEmpenhoNotaLiquidacaoContaPagadoras(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoContaPagadora $fkEmpenhoNotaLiquidacaoContaPagadora)
    {
        $this->fkEmpenhoNotaLiquidacaoContaPagadoras->removeElement($fkEmpenhoNotaLiquidacaoContaPagadora);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoNotaLiquidacaoContaPagadoras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoContaPagadora
     */
    public function getFkEmpenhoNotaLiquidacaoContaPagadoras()
    {
        return $this->fkEmpenhoNotaLiquidacaoContaPagadoras;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra
     * @return PlanoAnalitica
     */
    public function addFkTesourariaReciboExtras(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra)
    {
        if (false === $this->fkTesourariaReciboExtras->contains($fkTesourariaReciboExtra)) {
            $fkTesourariaReciboExtra->setFkContabilidadePlanoAnalitica($this);
            $this->fkTesourariaReciboExtras->add($fkTesourariaReciboExtra);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra
     */
    public function removeFkTesourariaReciboExtras(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra)
    {
        $this->fkTesourariaReciboExtras->removeElement($fkTesourariaReciboExtra);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaReciboExtras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra
     */
    public function getFkTesourariaReciboExtras()
    {
        return $this->fkTesourariaReciboExtras;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento
     * @return PlanoAnalitica
     */
    public function addFkTesourariaPagamentos(\Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento)
    {
        if (false === $this->fkTesourariaPagamentos->contains($fkTesourariaPagamento)) {
            $fkTesourariaPagamento->setFkContabilidadePlanoAnalitica($this);
            $this->fkTesourariaPagamentos->add($fkTesourariaPagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento
     */
    public function removeFkTesourariaPagamentos(\Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento)
    {
        $this->fkTesourariaPagamentos->removeElement($fkTesourariaPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Pagamento
     */
    public function getFkTesourariaPagamentos()
    {
        return $this->fkTesourariaPagamentos;
    }

    /**
     * OneToMany (owning side)
     * Add StnVinculoContasRgf2
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoContasRgf2 $fkStnVinculoContasRgf2
     * @return PlanoAnalitica
     */
    public function addFkStnVinculoContasRgf2s(\Urbem\CoreBundle\Entity\Stn\VinculoContasRgf2 $fkStnVinculoContasRgf2)
    {
        if (false === $this->fkStnVinculoContasRgf2s->contains($fkStnVinculoContasRgf2)) {
            $fkStnVinculoContasRgf2->setFkContabilidadePlanoAnalitica($this);
            $this->fkStnVinculoContasRgf2s->add($fkStnVinculoContasRgf2);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnVinculoContasRgf2
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoContasRgf2 $fkStnVinculoContasRgf2
     */
    public function removeFkStnVinculoContasRgf2s(\Urbem\CoreBundle\Entity\Stn\VinculoContasRgf2 $fkStnVinculoContasRgf2)
    {
        $this->fkStnVinculoContasRgf2s->removeElement($fkStnVinculoContasRgf2);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnVinculoContasRgf2s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoContasRgf2
     */
    public function getFkStnVinculoContasRgf2s()
    {
        return $this->fkStnVinculoContasRgf2s;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoArquivoExt
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ArquivoExt $fkTcmgoArquivoExt
     * @return PlanoAnalitica
     */
    public function addFkTcmgoArquivoExts(\Urbem\CoreBundle\Entity\Tcmgo\ArquivoExt $fkTcmgoArquivoExt)
    {
        if (false === $this->fkTcmgoArquivoExts->contains($fkTcmgoArquivoExt)) {
            $fkTcmgoArquivoExt->setFkContabilidadePlanoAnalitica($this);
            $this->fkTcmgoArquivoExts->add($fkTcmgoArquivoExt);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoArquivoExt
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ArquivoExt $fkTcmgoArquivoExt
     */
    public function removeFkTcmgoArquivoExts(\Urbem\CoreBundle\Entity\Tcmgo\ArquivoExt $fkTcmgoArquivoExt)
    {
        $this->fkTcmgoArquivoExts->removeElement($fkTcmgoArquivoExt);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoArquivoExts
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ArquivoExt
     */
    public function getFkTcmgoArquivoExts()
    {
        return $this->fkTcmgoArquivoExts;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransferenciasDote
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote $fkTesourariaTransferenciasDote
     * @return PlanoAnalitica
     */
    public function addFkTesourariaTransferenciasDotes(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote $fkTesourariaTransferenciasDote)
    {
        if (false === $this->fkTesourariaTransferenciasDotes->contains($fkTesourariaTransferenciasDote)) {
            $fkTesourariaTransferenciasDote->setFkContabilidadePlanoAnalitica($this);
            $this->fkTesourariaTransferenciasDotes->add($fkTesourariaTransferenciasDote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransferenciasDote
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote $fkTesourariaTransferenciasDote
     */
    public function removeFkTesourariaTransferenciasDotes(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote $fkTesourariaTransferenciasDote)
    {
        $this->fkTesourariaTransferenciasDotes->removeElement($fkTesourariaTransferenciasDote);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransferenciasDotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote
     */
    public function getFkTesourariaTransferenciasDotes()
    {
        return $this->fkTesourariaTransferenciasDotes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransferenciasDote
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote $fkTesourariaTransferenciasDote
     * @return PlanoAnalitica
     */
    public function addFkTesourariaTransferenciasDotes1(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote $fkTesourariaTransferenciasDote)
    {
        if (false === $this->fkTesourariaTransferenciasDotes1->contains($fkTesourariaTransferenciasDote)) {
            $fkTesourariaTransferenciasDote->setFkContabilidadePlanoAnalitica1($this);
            $this->fkTesourariaTransferenciasDotes1->add($fkTesourariaTransferenciasDote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransferenciasDote
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote $fkTesourariaTransferenciasDote
     */
    public function removeFkTesourariaTransferenciasDotes1(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote $fkTesourariaTransferenciasDote)
    {
        $this->fkTesourariaTransferenciasDotes1->removeElement($fkTesourariaTransferenciasDote);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransferenciasDotes1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciasDote
     */
    public function getFkTesourariaTransferenciasDotes1()
    {
        return $this->fkTesourariaTransferenciasDotes1;
    }

    /**
     * OneToOne (inverse side)
     * Set ContabilidadePlanoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco $fkContabilidadePlanoBanco
     * @return PlanoAnalitica
     */
    public function setFkContabilidadePlanoBanco(\Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco $fkContabilidadePlanoBanco)
    {
        $fkContabilidadePlanoBanco->setFkContabilidadePlanoAnalitica($this);
        $this->fkContabilidadePlanoBanco = $fkContabilidadePlanoBanco;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkContabilidadePlanoBanco
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco
     */
    public function getFkContabilidadePlanoBanco()
    {
        return $this->fkContabilidadePlanoBanco;
    }

    /**
     * OneToOne (inverse side)
     * Set ContabilidadePlanoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso $fkContabilidadePlanoRecurso
     * @return PlanoAnalitica
     */
    public function setFkContabilidadePlanoRecurso(\Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso $fkContabilidadePlanoRecurso)
    {
        $fkContabilidadePlanoRecurso->setFkContabilidadePlanoAnalitica($this);
        $this->fkContabilidadePlanoRecurso = $fkContabilidadePlanoRecurso;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkContabilidadePlanoRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso
     */
    public function getFkContabilidadePlanoRecurso()
    {
        return $this->fkContabilidadePlanoRecurso;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoContrapartidaResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel $fkEmpenhoContrapartidaResponsavel
     * @return PlanoAnalitica
     */
    public function setFkEmpenhoContrapartidaResponsavel(\Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel $fkEmpenhoContrapartidaResponsavel)
    {
        $fkEmpenhoContrapartidaResponsavel->setFkContabilidadePlanoAnalitica($this);
        $this->fkEmpenhoContrapartidaResponsavel = $fkEmpenhoContrapartidaResponsavel;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoContrapartidaResponsavel
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel
     */
    public function getFkEmpenhoContrapartidaResponsavel()
    {
        return $this->fkEmpenhoContrapartidaResponsavel;
    }

    /**
     * OneToOne (inverse side)
     * Set TcealDespesaReceitaExtra
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\DespesaReceitaExtra $fkTcealDespesaReceitaExtra
     * @return PlanoAnalitica
     */
    public function setFkTcealDespesaReceitaExtra(\Urbem\CoreBundle\Entity\Tceal\DespesaReceitaExtra $fkTcealDespesaReceitaExtra)
    {
        $fkTcealDespesaReceitaExtra->setFkContabilidadePlanoAnalitica($this);
        $this->fkTcealDespesaReceitaExtra = $fkTcealDespesaReceitaExtra;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcealDespesaReceitaExtra
     *
     * @return \Urbem\CoreBundle\Entity\Tceal\DespesaReceitaExtra
     */
    public function getFkTcealDespesaReceitaExtra()
    {
        return $this->fkTcealDespesaReceitaExtra;
    }

    /**
     * OneToOne (inverse side)
     * Set TceamVinculoElencoPlanoContas
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\VinculoElencoPlanoContas $fkTceamVinculoElencoPlanoContas
     * @return PlanoAnalitica
     */
    public function setFkTceamVinculoElencoPlanoContas(\Urbem\CoreBundle\Entity\Tceam\VinculoElencoPlanoContas $fkTceamVinculoElencoPlanoContas)
    {
        $fkTceamVinculoElencoPlanoContas->setFkContabilidadePlanoAnalitica($this);
        $this->fkTceamVinculoElencoPlanoContas = $fkTceamVinculoElencoPlanoContas;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTceamVinculoElencoPlanoContas
     *
     * @return \Urbem\CoreBundle\Entity\Tceam\VinculoElencoPlanoContas
     */
    public function getFkTceamVinculoElencoPlanoContas()
    {
        return $this->fkTceamVinculoElencoPlanoContas;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgArquivoExt
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoExt $fkTcemgArquivoExt
     * @return PlanoAnalitica
     */
    public function setFkTcemgArquivoExt(\Urbem\CoreBundle\Entity\Tcemg\ArquivoExt $fkTcemgArquivoExt)
    {
        $fkTcemgArquivoExt->setFkContabilidadePlanoAnalitica($this);
        $this->fkTcemgArquivoExt = $fkTcemgArquivoExt;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgArquivoExt
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ArquivoExt
     */
    public function getFkTcemgArquivoExt()
    {
        return $this->fkTcemgArquivoExt;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgBalanceteExtmmaa
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\BalanceteExtmmaa $fkTcemgBalanceteExtmmaa
     * @return PlanoAnalitica
     */
    public function setFkTcemgBalanceteExtmmaa(\Urbem\CoreBundle\Entity\Tcemg\BalanceteExtmmaa $fkTcemgBalanceteExtmmaa)
    {
        $fkTcemgBalanceteExtmmaa->setFkContabilidadePlanoAnalitica($this);
        $this->fkTcemgBalanceteExtmmaa = $fkTcemgBalanceteExtmmaa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgBalanceteExtmmaa
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\BalanceteExtmmaa
     */
    public function getFkTcemgBalanceteExtmmaa()
    {
        return $this->fkTcemgBalanceteExtmmaa;
    }

    /**
     * OneToOne (inverse side)
     * Set TcepePlanoAnaliticaTipoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\PlanoAnaliticaTipoRetencao $fkTcepePlanoAnaliticaTipoRetencao
     * @return PlanoAnalitica
     */
    public function setFkTcepePlanoAnaliticaTipoRetencao(\Urbem\CoreBundle\Entity\Tcepe\PlanoAnaliticaTipoRetencao $fkTcepePlanoAnaliticaTipoRetencao)
    {
        $fkTcepePlanoAnaliticaTipoRetencao->setFkContabilidadePlanoAnalitica($this);
        $this->fkTcepePlanoAnaliticaTipoRetencao = $fkTcepePlanoAnaliticaTipoRetencao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcepePlanoAnaliticaTipoRetencao
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\PlanoAnaliticaTipoRetencao
     */
    public function getFkTcepePlanoAnaliticaTipoRetencao()
    {
        return $this->fkTcepePlanoAnaliticaTipoRetencao;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoBalanceteExtmmaa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\BalanceteExtmmaa $fkTcmgoBalanceteExtmmaa
     * @return PlanoAnalitica
     */
    public function setFkTcmgoBalanceteExtmmaa(\Urbem\CoreBundle\Entity\Tcmgo\BalanceteExtmmaa $fkTcmgoBalanceteExtmmaa)
    {
        $fkTcmgoBalanceteExtmmaa->setFkContabilidadePlanoAnalitica($this);
        $this->fkTcmgoBalanceteExtmmaa = $fkTcmgoBalanceteExtmmaa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoBalanceteExtmmaa
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\BalanceteExtmmaa
     */
    public function getFkTcmgoBalanceteExtmmaa()
    {
        return $this->fkTcmgoBalanceteExtmmaa;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoBalancoAfraaaa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\BalancoAfraaaa $fkTcmgoBalancoAfraaaa
     * @return PlanoAnalitica
     */
    public function setFkTcmgoBalancoAfraaaa(\Urbem\CoreBundle\Entity\Tcmgo\BalancoAfraaaa $fkTcmgoBalancoAfraaaa)
    {
        $fkTcmgoBalancoAfraaaa->setFkContabilidadePlanoAnalitica($this);
        $this->fkTcmgoBalancoAfraaaa = $fkTcmgoBalancoAfraaaa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoBalancoAfraaaa
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\BalancoAfraaaa
     */
    public function getFkTcmgoBalancoAfraaaa()
    {
        return $this->fkTcmgoBalancoAfraaaa;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoBalancoComaaaa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\BalancoComaaaa $fkTcmgoBalancoComaaaa
     * @return PlanoAnalitica
     */
    public function setFkTcmgoBalancoComaaaa(\Urbem\CoreBundle\Entity\Tcmgo\BalancoComaaaa $fkTcmgoBalancoComaaaa)
    {
        $fkTcmgoBalancoComaaaa->setFkContabilidadePlanoAnalitica($this);
        $this->fkTcmgoBalancoComaaaa = $fkTcmgoBalancoComaaaa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoBalancoComaaaa
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\BalancoComaaaa
     */
    public function getFkTcmgoBalancoComaaaa()
    {
        return $this->fkTcmgoBalancoComaaaa;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoBalancoPfdaaaa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\BalancoPfdaaaa $fkTcmgoBalancoPfdaaaa
     * @return PlanoAnalitica
     */
    public function setFkTcmgoBalancoPfdaaaa(\Urbem\CoreBundle\Entity\Tcmgo\BalancoPfdaaaa $fkTcmgoBalancoPfdaaaa)
    {
        $fkTcmgoBalancoPfdaaaa->setFkContabilidadePlanoAnalitica($this);
        $this->fkTcmgoBalancoPfdaaaa = $fkTcmgoBalancoPfdaaaa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoBalancoPfdaaaa
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\BalancoPfdaaaa
     */
    public function getFkTcmgoBalancoPfdaaaa()
    {
        return $this->fkTcmgoBalancoPfdaaaa;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoBalancoPpdaaaa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\BalancoPpdaaaa $fkTcmgoBalancoPpdaaaa
     * @return PlanoAnalitica
     */
    public function setFkTcmgoBalancoPpdaaaa(\Urbem\CoreBundle\Entity\Tcmgo\BalancoPpdaaaa $fkTcmgoBalancoPpdaaaa)
    {
        $fkTcmgoBalancoPpdaaaa->setFkContabilidadePlanoAnalitica($this);
        $this->fkTcmgoBalancoPpdaaaa = $fkTcmgoBalancoPpdaaaa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoBalancoPpdaaaa
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\BalancoPpdaaaa
     */
    public function getFkTcmgoBalancoPpdaaaa()
    {
        return $this->fkTcmgoBalancoPpdaaaa;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoBalancoApcaaaa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\BalancoApcaaaa $fkTcmgoBalancoApcaaaa
     * @return PlanoAnalitica
     */
    public function setFkTcmgoBalancoApcaaaa(\Urbem\CoreBundle\Entity\Tcmgo\BalancoApcaaaa $fkTcmgoBalancoApcaaaa)
    {
        $fkTcmgoBalancoApcaaaa->setFkContabilidadePlanoAnalitica($this);
        $this->fkTcmgoBalancoApcaaaa = $fkTcmgoBalancoApcaaaa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoBalancoApcaaaa
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\BalancoApcaaaa
     */
    public function getFkTcmgoBalancoApcaaaa()
    {
        return $this->fkTcmgoBalancoApcaaaa;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgConvenioPlanoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConvenioPlanoBanco $fkTcemgConvenioPlanoBanco
     * @return PlanoAnalitica
     */
    public function setFkTcemgConvenioPlanoBanco(\Urbem\CoreBundle\Entity\Tcemg\ConvenioPlanoBanco $fkTcemgConvenioPlanoBanco)
    {
        $fkTcemgConvenioPlanoBanco->setFkContabilidadePlanoAnalitica($this);
        $this->fkTcemgConvenioPlanoBanco = $fkTcemgConvenioPlanoBanco;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgConvenioPlanoBanco
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ConvenioPlanoBanco
     */
    public function getFkTcemgConvenioPlanoBanco()
    {
        return $this->fkTcemgConvenioPlanoBanco;
    }

    /**
     * OneToOne (inverse side)
     * Set TcepbPlanoAnaliticaTipoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\PlanoAnaliticaTipoRetencao $fkTcepbPlanoAnaliticaTipoRetencao
     * @return PlanoAnalitica
     */
    public function setFkTcepbPlanoAnaliticaTipoRetencao(\Urbem\CoreBundle\Entity\Tcepb\PlanoAnaliticaTipoRetencao $fkTcepbPlanoAnaliticaTipoRetencao)
    {
        $fkTcepbPlanoAnaliticaTipoRetencao->setFkContabilidadePlanoAnalitica($this);
        $this->fkTcepbPlanoAnaliticaTipoRetencao = $fkTcepbPlanoAnaliticaTipoRetencao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcepbPlanoAnaliticaTipoRetencao
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\PlanoAnaliticaTipoRetencao
     */
    public function getFkTcepbPlanoAnaliticaTipoRetencao()
    {
        return $this->fkTcepbPlanoAnaliticaTipoRetencao;
    }

    /**
     * OneToOne (inverse side)
     * Set TcetoPlanoAnaliticaClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\PlanoAnaliticaClassificacao $fkTcetoPlanoAnaliticaClassificacao
     * @return PlanoAnalitica
     */
    public function setFkTcetoPlanoAnaliticaClassificacao(\Urbem\CoreBundle\Entity\Tceto\PlanoAnaliticaClassificacao $fkTcetoPlanoAnaliticaClassificacao)
    {
        $fkTcetoPlanoAnaliticaClassificacao->setFkContabilidadePlanoAnalitica($this);
        $this->fkTcetoPlanoAnaliticaClassificacao = $fkTcetoPlanoAnaliticaClassificacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcetoPlanoAnaliticaClassificacao
     *
     * @return \Urbem\CoreBundle\Entity\Tceto\PlanoAnaliticaClassificacao
     */
    public function getFkTcetoPlanoAnaliticaClassificacao()
    {
        return $this->fkTcetoPlanoAnaliticaClassificacao;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadePlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta
     * @return PlanoAnalitica
     */
    public function setFkContabilidadePlanoConta(\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta)
    {
        $this->codConta = $fkContabilidadePlanoConta->getCodConta();
        $this->exercicio = $fkContabilidadePlanoConta->getExercicio();
        $this->fkContabilidadePlanoConta = $fkContabilidadePlanoConta;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkContabilidadePlanoConta
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    public function getFkContabilidadePlanoConta()
    {
        return $this->fkContabilidadePlanoConta;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s/%s - %s',
            $this->codPlano,
            $this->exercicio,
            $this->fkContabilidadePlanoConta->getNomConta()
        );
    }
}
