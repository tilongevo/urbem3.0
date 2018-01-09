<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * Empenho
 */
class Empenho
{
    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

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
    private $codPreEmpenho;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $dtEmpenho;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $dtVencimento;

    /**
     * @var integer
     */
    private $vlSaldoAnterior;

    /**
     * @var \Urbem\CoreBundle\Helper\TimeMicrosecondPK
     */
    private $hora;

    /**
     * @var integer
     */
    private $codCategoria = 1;

    /**
     * @var string
     */
    private $restosPagar;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\EmpenhoContrato
     */
    private $fkEmpenhoEmpenhoContrato;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio
     */
    private $fkEmpenhoEmpenhoConvenio;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\PrestacaoContas
     */
    private $fkEmpenhoPrestacaoContas;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tceam\EmpenhoIncorporacao
     */
    private $fkTceamEmpenhoIncorporacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\ArquivoEmp
     */
    private $fkTcemgArquivoEmp;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\ContratoEmpenho
     */
    private $fkTcemgContratoEmpenho;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\ConvenioEmpenho
     */
    private $fkTcemgConvenioEmpenho;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcepb\EmpenhoObras
     */
    private $fkTcepbEmpenhoObras;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\ContratoEmpenho
     */
    private $fkTcmgoContratoEmpenho;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\Processos
     */
    private $fkTcmgoProcessos;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\EmpenhoComplementar
     */
    private $fkEmpenhoEmpenhoComplementar;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    private $fkEmpenhoPreEmpenho;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Ordem
     */
    private $fkComprasOrdens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoAutorizacao
     */
    private $fkEmpenhoEmpenhoAutorizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoAnulado
     */
    private $fkEmpenhoEmpenhoAnulados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoAssinatura
     */
    private $fkEmpenhoEmpenhoAssinaturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\ManutencaoEmpenho
     */
    private $fkFrotaManutencaoEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoLocacao
     */
    private $fkFrotaVeiculoLocacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemCompradoEmpenho
     */
    private $fkPatrimonioBemCompradoEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem
     */
    private $fkTcemgContratoAditivoItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenho
     */
    private $fkTcemgNotaFiscalEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenhoLiquidacao
     */
    private $fkTcemgNotaFiscalEmpenhoLiquidacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\RoyaltiesEmpenho
     */
    private $fkTcernRoyaltiesEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\FundebEmpenho
     */
    private $fkTcernFundebEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoTransferencia
     */
    private $fkTcetoTransferenciaTipoTransferencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade
     */
    private $fkTcmgoEmpenhoModalidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenhoLiquidacao
     */
    private $fkTcmgoNotaFiscalEmpenhoLiquidacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ObraEmpenho
     */
    private $fkTcmgoObraEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\Empenhamento
     */
    private $fkContabilidadeEmpenhamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenho
     */
    private $fkTcmgoNotaFiscalEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoComplementar
     */
    private $fkEmpenhoEmpenhoComplementares1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    private $fkEmpenhoNotaLiquidacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\EmpenhoRegistroPrecos
     */
    private $fkTcemgEmpenhoRegistroPrecos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\CategoriaEmpenho
     */
    private $fkEmpenhoCategoriaEmpenho;

    const CODMODULO = 10;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasOrdens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoEmpenhoAutorizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoEmpenhoAnulados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoEmpenhoAssinaturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaManutencaoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaVeiculoLocacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioBemCompradoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgContratoAditivoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgNotaFiscalEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgNotaFiscalEmpenhoLiquidacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernRoyaltiesEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernFundebEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcetoTransferenciaTipoTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoEmpenhoModalidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoNotaFiscalEmpenhoLiquidacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoObraEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeEmpenhamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoNotaFiscalEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoEmpenhoComplementares1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoNotaLiquidacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgEmpenhoRegistroPrecos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->hora = new \Urbem\CoreBundle\Helper\TimeMicrosecondPK;
        $this->dtEmpenho = new DateTimeMicrosecondPK();
        $this->dtVencimento = new DateTimeMicrosecondPK();
    }

    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return Empenho
     */
    public function setCodEmpenho($codEmpenho)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Empenho
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
     * @return Empenho
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
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return Empenho
     */
    public function setCodPreEmpenho($codPreEmpenho)
    {
        $this->codPreEmpenho = $codPreEmpenho;
        return $this;
    }

    /**
     * Get codPreEmpenho
     *
     * @return integer
     */
    public function getCodPreEmpenho()
    {
        return $this->codPreEmpenho;
    }

    /**
     * Set dtEmpenho
     *
     * @param DateTimeMicrosecondPK $dtEmpenho
     * @return Empenho
     */
    public function setDtEmpenho(DateTimeMicrosecondPK $dtEmpenho)
    {
        $this->dtEmpenho = $dtEmpenho;
        return $this;
    }

    /**
     * Get dtEmpenho
     *
     * @return DateTimeMicrosecondPK
     */
    public function getDtEmpenho()
    {
        return $this->dtEmpenho;
    }

    /**
     * Set dtVencimento
     *
     * @param DateTimeMicrosecondPK $dtVencimento
     * @return Empenho
     */
    public function setDtVencimento(DateTimeMicrosecondPK $dtVencimento)
    {
        $this->dtVencimento = $dtVencimento;
        return $this;
    }

    /**
     * Get dtVencimento
     *
     * @return DateTimeMicrosecondPK
     */
    public function getDtVencimento()
    {
        return $this->dtVencimento;
    }

    /**
     * Set vlSaldoAnterior
     *
     * @param integer $vlSaldoAnterior
     * @return Empenho
     */
    public function setVlSaldoAnterior($vlSaldoAnterior)
    {
        $this->vlSaldoAnterior = $vlSaldoAnterior;
        return $this;
    }

    /**
     * Get vlSaldoAnterior
     *
     * @return integer
     */
    public function getVlSaldoAnterior()
    {
        return $this->vlSaldoAnterior;
    }

    /**
     * Set hora
     *
     * @param \Urbem\CoreBundle\Helper\TimeMicrosecondPK $hora
     * @return Empenho
     */
    public function setHora(\Urbem\CoreBundle\Helper\TimeMicrosecondPK $hora)
    {
        $this->hora = $hora;
        return $this;
    }

    /**
     * Get hora
     *
     * @return \Urbem\CoreBundle\Helper\TimeMicrosecondPK
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set codCategoria
     *
     * @param integer $codCategoria
     * @return Empenho
     */
    public function setCodCategoria($codCategoria)
    {
        $this->codCategoria = $codCategoria;
        return $this;
    }

    /**
     * Get codCategoria
     *
     * @return integer
     */
    public function getCodCategoria()
    {
        return $this->codCategoria;
    }

    /**
     * Set restosPagar
     *
     * @param string $restosPagar
     * @return Empenho
     */
    public function setRestosPagar($restosPagar = null)
    {
        $this->restosPagar = $restosPagar;
        return $this;
    }

    /**
     * Get restosPagar
     *
     * @return string
     */
    public function getRestosPagar()
    {
        return $this->restosPagar;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasOrdem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Ordem $fkComprasOrdem
     * @return Empenho
     */
    public function addFkComprasOrdens(\Urbem\CoreBundle\Entity\Compras\Ordem $fkComprasOrdem)
    {
        if (false === $this->fkComprasOrdens->contains($fkComprasOrdem)) {
            $fkComprasOrdem->setFkEmpenhoEmpenho($this);
            $this->fkComprasOrdens->add($fkComprasOrdem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasOrdem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Ordem $fkComprasOrdem
     */
    public function removeFkComprasOrdens(\Urbem\CoreBundle\Entity\Compras\Ordem $fkComprasOrdem)
    {
        $this->fkComprasOrdens->removeElement($fkComprasOrdem);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasOrdens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Ordem
     */
    public function getFkComprasOrdens()
    {
        return $this->fkComprasOrdens;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoEmpenhoAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoAutorizacao $fkEmpenhoEmpenhoAutorizacao
     * @return Empenho
     */
    public function addFkEmpenhoEmpenhoAutorizacoes(\Urbem\CoreBundle\Entity\Empenho\EmpenhoAutorizacao $fkEmpenhoEmpenhoAutorizacao)
    {
        if (false === $this->fkEmpenhoEmpenhoAutorizacoes->contains($fkEmpenhoEmpenhoAutorizacao)) {
            $fkEmpenhoEmpenhoAutorizacao->setFkEmpenhoEmpenho($this);
            $this->fkEmpenhoEmpenhoAutorizacoes->add($fkEmpenhoEmpenhoAutorizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoEmpenhoAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoAutorizacao $fkEmpenhoEmpenhoAutorizacao
     */
    public function removeFkEmpenhoEmpenhoAutorizacoes(\Urbem\CoreBundle\Entity\Empenho\EmpenhoAutorizacao $fkEmpenhoEmpenhoAutorizacao)
    {
        $this->fkEmpenhoEmpenhoAutorizacoes->removeElement($fkEmpenhoEmpenhoAutorizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoEmpenhoAutorizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoAutorizacao
     */
    public function getFkEmpenhoEmpenhoAutorizacoes()
    {
        return $this->fkEmpenhoEmpenhoAutorizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoEmpenhoAnulado
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoAnulado $fkEmpenhoEmpenhoAnulado
     * @return Empenho
     */
    public function addFkEmpenhoEmpenhoAnulados(\Urbem\CoreBundle\Entity\Empenho\EmpenhoAnulado $fkEmpenhoEmpenhoAnulado)
    {
        if (false === $this->fkEmpenhoEmpenhoAnulados->contains($fkEmpenhoEmpenhoAnulado)) {
            $fkEmpenhoEmpenhoAnulado->setFkEmpenhoEmpenho($this);
            $this->fkEmpenhoEmpenhoAnulados->add($fkEmpenhoEmpenhoAnulado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoEmpenhoAnulado
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoAnulado $fkEmpenhoEmpenhoAnulado
     */
    public function removeFkEmpenhoEmpenhoAnulados(\Urbem\CoreBundle\Entity\Empenho\EmpenhoAnulado $fkEmpenhoEmpenhoAnulado)
    {
        $this->fkEmpenhoEmpenhoAnulados->removeElement($fkEmpenhoEmpenhoAnulado);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoEmpenhoAnulados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoAnulado
     */
    public function getFkEmpenhoEmpenhoAnulados()
    {
        return $this->fkEmpenhoEmpenhoAnulados;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoEmpenhoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoAssinatura $fkEmpenhoEmpenhoAssinatura
     * @return Empenho
     */
    public function addFkEmpenhoEmpenhoAssinaturas(\Urbem\CoreBundle\Entity\Empenho\EmpenhoAssinatura $fkEmpenhoEmpenhoAssinatura)
    {
        if (false === $this->fkEmpenhoEmpenhoAssinaturas->contains($fkEmpenhoEmpenhoAssinatura)) {
            $fkEmpenhoEmpenhoAssinatura->setFkEmpenhoEmpenho($this);
            $this->fkEmpenhoEmpenhoAssinaturas->add($fkEmpenhoEmpenhoAssinatura);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoEmpenhoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoAssinatura $fkEmpenhoEmpenhoAssinatura
     */
    public function removeFkEmpenhoEmpenhoAssinaturas(\Urbem\CoreBundle\Entity\Empenho\EmpenhoAssinatura $fkEmpenhoEmpenhoAssinatura)
    {
        $this->fkEmpenhoEmpenhoAssinaturas->removeElement($fkEmpenhoEmpenhoAssinatura);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoEmpenhoAssinaturas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoAssinatura
     */
    public function getFkEmpenhoEmpenhoAssinaturas()
    {
        return $this->fkEmpenhoEmpenhoAssinaturas;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaManutencaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Frota\ManutencaoEmpenho $fkFrotaManutencaoEmpenho
     * @return Empenho
     */
    public function addFkFrotaManutencaoEmpenhos(\Urbem\CoreBundle\Entity\Frota\ManutencaoEmpenho $fkFrotaManutencaoEmpenho)
    {
        if (false === $this->fkFrotaManutencaoEmpenhos->contains($fkFrotaManutencaoEmpenho)) {
            $fkFrotaManutencaoEmpenho->setFkEmpenhoEmpenho($this);
            $this->fkFrotaManutencaoEmpenhos->add($fkFrotaManutencaoEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaManutencaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Frota\ManutencaoEmpenho $fkFrotaManutencaoEmpenho
     */
    public function removeFkFrotaManutencaoEmpenhos(\Urbem\CoreBundle\Entity\Frota\ManutencaoEmpenho $fkFrotaManutencaoEmpenho)
    {
        $this->fkFrotaManutencaoEmpenhos->removeElement($fkFrotaManutencaoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaManutencaoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\ManutencaoEmpenho
     */
    public function getFkFrotaManutencaoEmpenhos()
    {
        return $this->fkFrotaManutencaoEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaVeiculoLocacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoLocacao $fkFrotaVeiculoLocacao
     * @return Empenho
     */
    public function addFkFrotaVeiculoLocacoes(\Urbem\CoreBundle\Entity\Frota\VeiculoLocacao $fkFrotaVeiculoLocacao)
    {
        if (false === $this->fkFrotaVeiculoLocacoes->contains($fkFrotaVeiculoLocacao)) {
            $fkFrotaVeiculoLocacao->setFkEmpenhoEmpenho($this);
            $this->fkFrotaVeiculoLocacoes->add($fkFrotaVeiculoLocacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculoLocacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoLocacao $fkFrotaVeiculoLocacao
     */
    public function removeFkFrotaVeiculoLocacoes(\Urbem\CoreBundle\Entity\Frota\VeiculoLocacao $fkFrotaVeiculoLocacao)
    {
        $this->fkFrotaVeiculoLocacoes->removeElement($fkFrotaVeiculoLocacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculoLocacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoLocacao
     */
    public function getFkFrotaVeiculoLocacoes()
    {
        return $this->fkFrotaVeiculoLocacoes;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioBemCompradoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemCompradoEmpenho $fkPatrimonioBemCompradoEmpenho
     * @return Empenho
     */
    public function addFkPatrimonioBemCompradoEmpenhos(\Urbem\CoreBundle\Entity\Patrimonio\BemCompradoEmpenho $fkPatrimonioBemCompradoEmpenho)
    {
        if (false === $this->fkPatrimonioBemCompradoEmpenhos->contains($fkPatrimonioBemCompradoEmpenho)) {
            $fkPatrimonioBemCompradoEmpenho->setFkEmpenhoEmpenho($this);
            $this->fkPatrimonioBemCompradoEmpenhos->add($fkPatrimonioBemCompradoEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioBemCompradoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemCompradoEmpenho $fkPatrimonioBemCompradoEmpenho
     */
    public function removeFkPatrimonioBemCompradoEmpenhos(\Urbem\CoreBundle\Entity\Patrimonio\BemCompradoEmpenho $fkPatrimonioBemCompradoEmpenho)
    {
        $this->fkPatrimonioBemCompradoEmpenhos->removeElement($fkPatrimonioBemCompradoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioBemCompradoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemCompradoEmpenho
     */
    public function getFkPatrimonioBemCompradoEmpenhos()
    {
        return $this->fkPatrimonioBemCompradoEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgContratoAditivoItem
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem $fkTcemgContratoAditivoItem
     * @return Empenho
     */
    public function addFkTcemgContratoAditivoItens(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem $fkTcemgContratoAditivoItem)
    {
        if (false === $this->fkTcemgContratoAditivoItens->contains($fkTcemgContratoAditivoItem)) {
            $fkTcemgContratoAditivoItem->setFkEmpenhoEmpenho($this);
            $this->fkTcemgContratoAditivoItens->add($fkTcemgContratoAditivoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContratoAditivoItem
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem $fkTcemgContratoAditivoItem
     */
    public function removeFkTcemgContratoAditivoItens(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem $fkTcemgContratoAditivoItem)
    {
        $this->fkTcemgContratoAditivoItens->removeElement($fkTcemgContratoAditivoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratoAditivoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem
     */
    public function getFkTcemgContratoAditivoItens()
    {
        return $this->fkTcemgContratoAditivoItens;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgNotaFiscalEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenho $fkTcemgNotaFiscalEmpenho
     * @return Empenho
     */
    public function addFkTcemgNotaFiscalEmpenhos(\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenho $fkTcemgNotaFiscalEmpenho)
    {
        if (false === $this->fkTcemgNotaFiscalEmpenhos->contains($fkTcemgNotaFiscalEmpenho)) {
            $fkTcemgNotaFiscalEmpenho->setFkEmpenhoEmpenho($this);
            $this->fkTcemgNotaFiscalEmpenhos->add($fkTcemgNotaFiscalEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgNotaFiscalEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenho $fkTcemgNotaFiscalEmpenho
     */
    public function removeFkTcemgNotaFiscalEmpenhos(\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenho $fkTcemgNotaFiscalEmpenho)
    {
        $this->fkTcemgNotaFiscalEmpenhos->removeElement($fkTcemgNotaFiscalEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgNotaFiscalEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenho
     */
    public function getFkTcemgNotaFiscalEmpenhos()
    {
        return $this->fkTcemgNotaFiscalEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgNotaFiscalEmpenhoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenhoLiquidacao $fkTcemgNotaFiscalEmpenhoLiquidacao
     * @return Empenho
     */
    public function addFkTcemgNotaFiscalEmpenhoLiquidacoes(\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenhoLiquidacao $fkTcemgNotaFiscalEmpenhoLiquidacao)
    {
        if (false === $this->fkTcemgNotaFiscalEmpenhoLiquidacoes->contains($fkTcemgNotaFiscalEmpenhoLiquidacao)) {
            $fkTcemgNotaFiscalEmpenhoLiquidacao->setFkEmpenhoEmpenho($this);
            $this->fkTcemgNotaFiscalEmpenhoLiquidacoes->add($fkTcemgNotaFiscalEmpenhoLiquidacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgNotaFiscalEmpenhoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenhoLiquidacao $fkTcemgNotaFiscalEmpenhoLiquidacao
     */
    public function removeFkTcemgNotaFiscalEmpenhoLiquidacoes(\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenhoLiquidacao $fkTcemgNotaFiscalEmpenhoLiquidacao)
    {
        $this->fkTcemgNotaFiscalEmpenhoLiquidacoes->removeElement($fkTcemgNotaFiscalEmpenhoLiquidacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgNotaFiscalEmpenhoLiquidacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenhoLiquidacao
     */
    public function getFkTcemgNotaFiscalEmpenhoLiquidacoes()
    {
        return $this->fkTcemgNotaFiscalEmpenhoLiquidacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcernRoyaltiesEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\RoyaltiesEmpenho $fkTcernRoyaltiesEmpenho
     * @return Empenho
     */
    public function addFkTcernRoyaltiesEmpenhos(\Urbem\CoreBundle\Entity\Tcern\RoyaltiesEmpenho $fkTcernRoyaltiesEmpenho)
    {
        if (false === $this->fkTcernRoyaltiesEmpenhos->contains($fkTcernRoyaltiesEmpenho)) {
            $fkTcernRoyaltiesEmpenho->setFkEmpenhoEmpenho($this);
            $this->fkTcernRoyaltiesEmpenhos->add($fkTcernRoyaltiesEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernRoyaltiesEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\RoyaltiesEmpenho $fkTcernRoyaltiesEmpenho
     */
    public function removeFkTcernRoyaltiesEmpenhos(\Urbem\CoreBundle\Entity\Tcern\RoyaltiesEmpenho $fkTcernRoyaltiesEmpenho)
    {
        $this->fkTcernRoyaltiesEmpenhos->removeElement($fkTcernRoyaltiesEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernRoyaltiesEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\RoyaltiesEmpenho
     */
    public function getFkTcernRoyaltiesEmpenhos()
    {
        return $this->fkTcernRoyaltiesEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add TcernFundebEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\FundebEmpenho $fkTcernFundebEmpenho
     * @return Empenho
     */
    public function addFkTcernFundebEmpenhos(\Urbem\CoreBundle\Entity\Tcern\FundebEmpenho $fkTcernFundebEmpenho)
    {
        if (false === $this->fkTcernFundebEmpenhos->contains($fkTcernFundebEmpenho)) {
            $fkTcernFundebEmpenho->setFkEmpenhoEmpenho($this);
            $this->fkTcernFundebEmpenhos->add($fkTcernFundebEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernFundebEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\FundebEmpenho $fkTcernFundebEmpenho
     */
    public function removeFkTcernFundebEmpenhos(\Urbem\CoreBundle\Entity\Tcern\FundebEmpenho $fkTcernFundebEmpenho)
    {
        $this->fkTcernFundebEmpenhos->removeElement($fkTcernFundebEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernFundebEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\FundebEmpenho
     */
    public function getFkTcernFundebEmpenhos()
    {
        return $this->fkTcernFundebEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add TcetoTransferenciaTipoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoTransferencia $fkTcetoTransferenciaTipoTransferencia
     * @return Empenho
     */
    public function addFkTcetoTransferenciaTipoTransferencias(\Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoTransferencia $fkTcetoTransferenciaTipoTransferencia)
    {
        if (false === $this->fkTcetoTransferenciaTipoTransferencias->contains($fkTcetoTransferenciaTipoTransferencia)) {
            $fkTcetoTransferenciaTipoTransferencia->setFkEmpenhoEmpenho($this);
            $this->fkTcetoTransferenciaTipoTransferencias->add($fkTcetoTransferenciaTipoTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcetoTransferenciaTipoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoTransferencia $fkTcetoTransferenciaTipoTransferencia
     */
    public function removeFkTcetoTransferenciaTipoTransferencias(\Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoTransferencia $fkTcetoTransferenciaTipoTransferencia)
    {
        $this->fkTcetoTransferenciaTipoTransferencias->removeElement($fkTcetoTransferenciaTipoTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcetoTransferenciaTipoTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoTransferencia
     */
    public function getFkTcetoTransferenciaTipoTransferencias()
    {
        return $this->fkTcetoTransferenciaTipoTransferencias;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoEmpenhoModalidade
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade $fkTcmgoEmpenhoModalidade
     * @return Empenho
     */
    public function addFkTcmgoEmpenhoModalidades(\Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade $fkTcmgoEmpenhoModalidade)
    {
        if (false === $this->fkTcmgoEmpenhoModalidades->contains($fkTcmgoEmpenhoModalidade)) {
            $fkTcmgoEmpenhoModalidade->setFkEmpenhoEmpenho($this);
            $this->fkTcmgoEmpenhoModalidades->add($fkTcmgoEmpenhoModalidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoEmpenhoModalidade
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade $fkTcmgoEmpenhoModalidade
     */
    public function removeFkTcmgoEmpenhoModalidades(\Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade $fkTcmgoEmpenhoModalidade)
    {
        $this->fkTcmgoEmpenhoModalidades->removeElement($fkTcmgoEmpenhoModalidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoEmpenhoModalidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\EmpenhoModalidade
     */
    public function getFkTcmgoEmpenhoModalidades()
    {
        return $this->fkTcmgoEmpenhoModalidades;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoNotaFiscalEmpenhoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenhoLiquidacao $fkTcmgoNotaFiscalEmpenhoLiquidacao
     * @return Empenho
     */
    public function addFkTcmgoNotaFiscalEmpenhoLiquidacoes(\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenhoLiquidacao $fkTcmgoNotaFiscalEmpenhoLiquidacao)
    {
        if (false === $this->fkTcmgoNotaFiscalEmpenhoLiquidacoes->contains($fkTcmgoNotaFiscalEmpenhoLiquidacao)) {
            $fkTcmgoNotaFiscalEmpenhoLiquidacao->setFkEmpenhoEmpenho($this);
            $this->fkTcmgoNotaFiscalEmpenhoLiquidacoes->add($fkTcmgoNotaFiscalEmpenhoLiquidacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoNotaFiscalEmpenhoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenhoLiquidacao $fkTcmgoNotaFiscalEmpenhoLiquidacao
     */
    public function removeFkTcmgoNotaFiscalEmpenhoLiquidacoes(\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenhoLiquidacao $fkTcmgoNotaFiscalEmpenhoLiquidacao)
    {
        $this->fkTcmgoNotaFiscalEmpenhoLiquidacoes->removeElement($fkTcmgoNotaFiscalEmpenhoLiquidacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoNotaFiscalEmpenhoLiquidacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenhoLiquidacao
     */
    public function getFkTcmgoNotaFiscalEmpenhoLiquidacoes()
    {
        return $this->fkTcmgoNotaFiscalEmpenhoLiquidacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoObraEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ObraEmpenho $fkTcmgoObraEmpenho
     * @return Empenho
     */
    public function addFkTcmgoObraEmpenhos(\Urbem\CoreBundle\Entity\Tcmgo\ObraEmpenho $fkTcmgoObraEmpenho)
    {
        if (false === $this->fkTcmgoObraEmpenhos->contains($fkTcmgoObraEmpenho)) {
            $fkTcmgoObraEmpenho->setFkEmpenhoEmpenho($this);
            $this->fkTcmgoObraEmpenhos->add($fkTcmgoObraEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoObraEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ObraEmpenho $fkTcmgoObraEmpenho
     */
    public function removeFkTcmgoObraEmpenhos(\Urbem\CoreBundle\Entity\Tcmgo\ObraEmpenho $fkTcmgoObraEmpenho)
    {
        $this->fkTcmgoObraEmpenhos->removeElement($fkTcmgoObraEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoObraEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ObraEmpenho
     */
    public function getFkTcmgoObraEmpenhos()
    {
        return $this->fkTcmgoObraEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeEmpenhamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Empenhamento $fkContabilidadeEmpenhamento
     * @return Empenho
     */
    public function addFkContabilidadeEmpenhamentos(\Urbem\CoreBundle\Entity\Contabilidade\Empenhamento $fkContabilidadeEmpenhamento)
    {
        if (false === $this->fkContabilidadeEmpenhamentos->contains($fkContabilidadeEmpenhamento)) {
            $fkContabilidadeEmpenhamento->setFkEmpenhoEmpenho($this);
            $this->fkContabilidadeEmpenhamentos->add($fkContabilidadeEmpenhamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeEmpenhamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Empenhamento $fkContabilidadeEmpenhamento
     */
    public function removeFkContabilidadeEmpenhamentos(\Urbem\CoreBundle\Entity\Contabilidade\Empenhamento $fkContabilidadeEmpenhamento)
    {
        $this->fkContabilidadeEmpenhamentos->removeElement($fkContabilidadeEmpenhamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeEmpenhamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\Empenhamento
     */
    public function getFkContabilidadeEmpenhamentos()
    {
        return $this->fkContabilidadeEmpenhamentos;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoNotaFiscalEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenho $fkTcmgoNotaFiscalEmpenho
     * @return Empenho
     */
    public function addFkTcmgoNotaFiscalEmpenhos(\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenho $fkTcmgoNotaFiscalEmpenho)
    {
        if (false === $this->fkTcmgoNotaFiscalEmpenhos->contains($fkTcmgoNotaFiscalEmpenho)) {
            $fkTcmgoNotaFiscalEmpenho->setFkEmpenhoEmpenho($this);
            $this->fkTcmgoNotaFiscalEmpenhos->add($fkTcmgoNotaFiscalEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoNotaFiscalEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenho $fkTcmgoNotaFiscalEmpenho
     */
    public function removeFkTcmgoNotaFiscalEmpenhos(\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenho $fkTcmgoNotaFiscalEmpenho)
    {
        $this->fkTcmgoNotaFiscalEmpenhos->removeElement($fkTcmgoNotaFiscalEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoNotaFiscalEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenho
     */
    public function getFkTcmgoNotaFiscalEmpenhos()
    {
        return $this->fkTcmgoNotaFiscalEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoEmpenhoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoComplementar $fkEmpenhoEmpenhoComplementar
     * @return Empenho
     */
    public function addFkEmpenhoEmpenhoComplementares1(\Urbem\CoreBundle\Entity\Empenho\EmpenhoComplementar $fkEmpenhoEmpenhoComplementar)
    {
        if (false === $this->fkEmpenhoEmpenhoComplementares1->contains($fkEmpenhoEmpenhoComplementar)) {
            $fkEmpenhoEmpenhoComplementar->setFkEmpenhoEmpenho1($this);
            $this->fkEmpenhoEmpenhoComplementares1->add($fkEmpenhoEmpenhoComplementar);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoEmpenhoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoComplementar $fkEmpenhoEmpenhoComplementar
     */
    public function removeFkEmpenhoEmpenhoComplementares1(\Urbem\CoreBundle\Entity\Empenho\EmpenhoComplementar $fkEmpenhoEmpenhoComplementar)
    {
        $this->fkEmpenhoEmpenhoComplementares1->removeElement($fkEmpenhoEmpenhoComplementar);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoEmpenhoComplementares1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoComplementar
     */
    public function getFkEmpenhoEmpenhoComplementares1()
    {
        return $this->fkEmpenhoEmpenhoComplementares1;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao
     * @return Empenho
     */
    public function addFkEmpenhoNotaLiquidacoes(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao)
    {
        if (false === $this->fkEmpenhoNotaLiquidacoes->contains($fkEmpenhoNotaLiquidacao)) {
            $fkEmpenhoNotaLiquidacao->setFkEmpenhoEmpenho($this);
            $this->fkEmpenhoNotaLiquidacoes->add($fkEmpenhoNotaLiquidacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao
     */
    public function removeFkEmpenhoNotaLiquidacoes(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao)
    {
        $this->fkEmpenhoNotaLiquidacoes->removeElement($fkEmpenhoNotaLiquidacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoNotaLiquidacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    public function getFkEmpenhoNotaLiquidacoes()
    {
        return $this->fkEmpenhoNotaLiquidacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgEmpenhoRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\EmpenhoRegistroPrecos $fkTcemgEmpenhoRegistroPrecos
     * @return Empenho
     */
    public function addFkTcemgEmpenhoRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\EmpenhoRegistroPrecos $fkTcemgEmpenhoRegistroPrecos)
    {
        if (false === $this->fkTcemgEmpenhoRegistroPrecos->contains($fkTcemgEmpenhoRegistroPrecos)) {
            $fkTcemgEmpenhoRegistroPrecos->setFkEmpenhoEmpenho($this);
            $this->fkTcemgEmpenhoRegistroPrecos->add($fkTcemgEmpenhoRegistroPrecos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgEmpenhoRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\EmpenhoRegistroPrecos $fkTcemgEmpenhoRegistroPrecos
     */
    public function removeFkTcemgEmpenhoRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\EmpenhoRegistroPrecos $fkTcemgEmpenhoRegistroPrecos)
    {
        $this->fkTcemgEmpenhoRegistroPrecos->removeElement($fkTcemgEmpenhoRegistroPrecos);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgEmpenhoRegistroPrecos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\EmpenhoRegistroPrecos
     */
    public function getFkTcemgEmpenhoRegistroPrecos()
    {
        return $this->fkTcemgEmpenhoRegistroPrecos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return Empenho
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
     * Set fkEmpenhoCategoriaEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\CategoriaEmpenho $fkEmpenhoCategoriaEmpenho
     * @return Empenho
     */
    public function setFkEmpenhoCategoriaEmpenho(\Urbem\CoreBundle\Entity\Empenho\CategoriaEmpenho $fkEmpenhoCategoriaEmpenho)
    {
        $this->codCategoria = $fkEmpenhoCategoriaEmpenho->getCodCategoria();
        $this->fkEmpenhoCategoriaEmpenho = $fkEmpenhoCategoriaEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoCategoriaEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\CategoriaEmpenho
     */
    public function getFkEmpenhoCategoriaEmpenho()
    {
        return $this->fkEmpenhoCategoriaEmpenho;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoEmpenhoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoContrato $fkEmpenhoEmpenhoContrato
     * @return Empenho
     */
    public function setFkEmpenhoEmpenhoContrato(\Urbem\CoreBundle\Entity\Empenho\EmpenhoContrato $fkEmpenhoEmpenhoContrato)
    {
        $fkEmpenhoEmpenhoContrato->setFkEmpenhoEmpenho($this);
        $this->fkEmpenhoEmpenhoContrato = $fkEmpenhoEmpenhoContrato;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoEmpenhoContrato
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\EmpenhoContrato
     */
    public function getFkEmpenhoEmpenhoContrato()
    {
        return $this->fkEmpenhoEmpenhoContrato;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoEmpenhoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio $fkEmpenhoEmpenhoConvenio
     * @return Empenho
     */
    public function setFkEmpenhoEmpenhoConvenio(\Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio $fkEmpenhoEmpenhoConvenio)
    {
        $fkEmpenhoEmpenhoConvenio->setFkEmpenhoEmpenho($this);
        $this->fkEmpenhoEmpenhoConvenio = $fkEmpenhoEmpenhoConvenio;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoEmpenhoConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\EmpenhoConvenio
     */
    public function getFkEmpenhoEmpenhoConvenio()
    {
        return $this->fkEmpenhoEmpenhoConvenio;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoPrestacaoContas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PrestacaoContas $fkEmpenhoPrestacaoContas
     * @return Empenho
     */
    public function setFkEmpenhoPrestacaoContas(\Urbem\CoreBundle\Entity\Empenho\PrestacaoContas $fkEmpenhoPrestacaoContas)
    {
        $fkEmpenhoPrestacaoContas->setFkEmpenhoEmpenho($this);
        $this->fkEmpenhoPrestacaoContas = $fkEmpenhoPrestacaoContas;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoPrestacaoContas
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\PrestacaoContas
     */
    public function getFkEmpenhoPrestacaoContas()
    {
        return $this->fkEmpenhoPrestacaoContas;
    }

    /**
     * OneToOne (inverse side)
     * Set TceamEmpenhoIncorporacao
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\EmpenhoIncorporacao $fkTceamEmpenhoIncorporacao
     * @return Empenho
     */
    public function setFkTceamEmpenhoIncorporacao(\Urbem\CoreBundle\Entity\Tceam\EmpenhoIncorporacao $fkTceamEmpenhoIncorporacao)
    {
        $fkTceamEmpenhoIncorporacao->setFkEmpenhoEmpenho($this);
        $this->fkTceamEmpenhoIncorporacao = $fkTceamEmpenhoIncorporacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTceamEmpenhoIncorporacao
     *
     * @return \Urbem\CoreBundle\Entity\Tceam\EmpenhoIncorporacao
     */
    public function getFkTceamEmpenhoIncorporacao()
    {
        return $this->fkTceamEmpenhoIncorporacao;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgArquivoEmp
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoEmp $fkTcemgArquivoEmp
     * @return Empenho
     */
    public function setFkTcemgArquivoEmp(\Urbem\CoreBundle\Entity\Tcemg\ArquivoEmp $fkTcemgArquivoEmp)
    {
        $fkTcemgArquivoEmp->setFkEmpenhoEmpenho($this);
        $this->fkTcemgArquivoEmp = $fkTcemgArquivoEmp;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgArquivoEmp
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ArquivoEmp
     */
    public function getFkTcemgArquivoEmp()
    {
        return $this->fkTcemgArquivoEmp;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgContratoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoEmpenho $fkTcemgContratoEmpenho
     * @return Empenho
     */
    public function setFkTcemgContratoEmpenho(\Urbem\CoreBundle\Entity\Tcemg\ContratoEmpenho $fkTcemgContratoEmpenho)
    {
        $fkTcemgContratoEmpenho->setFkEmpenhoEmpenho($this);
        $this->fkTcemgContratoEmpenho = $fkTcemgContratoEmpenho;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgContratoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ContratoEmpenho
     */
    public function getFkTcemgContratoEmpenho()
    {
        return $this->fkTcemgContratoEmpenho;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgConvenioEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConvenioEmpenho $fkTcemgConvenioEmpenho
     * @return Empenho
     */
    public function setFkTcemgConvenioEmpenho(\Urbem\CoreBundle\Entity\Tcemg\ConvenioEmpenho $fkTcemgConvenioEmpenho)
    {
        $fkTcemgConvenioEmpenho->setFkEmpenhoEmpenho($this);
        $this->fkTcemgConvenioEmpenho = $fkTcemgConvenioEmpenho;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgConvenioEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ConvenioEmpenho
     */
    public function getFkTcemgConvenioEmpenho()
    {
        return $this->fkTcemgConvenioEmpenho;
    }

    /**
     * OneToOne (inverse side)
     * Set TcepbEmpenhoObras
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\EmpenhoObras $fkTcepbEmpenhoObras
     * @return Empenho
     */
    public function setFkTcepbEmpenhoObras(\Urbem\CoreBundle\Entity\Tcepb\EmpenhoObras $fkTcepbEmpenhoObras)
    {
        $fkTcepbEmpenhoObras->setFkEmpenhoEmpenho($this);
        $this->fkTcepbEmpenhoObras = $fkTcepbEmpenhoObras;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcepbEmpenhoObras
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\EmpenhoObras
     */
    public function getFkTcepbEmpenhoObras()
    {
        return $this->fkTcepbEmpenhoObras;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoContratoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ContratoEmpenho $fkTcmgoContratoEmpenho
     * @return Empenho
     */
    public function setFkTcmgoContratoEmpenho(\Urbem\CoreBundle\Entity\Tcmgo\ContratoEmpenho $fkTcmgoContratoEmpenho)
    {
        $fkTcmgoContratoEmpenho->setFkEmpenhoEmpenho($this);
        $this->fkTcmgoContratoEmpenho = $fkTcmgoContratoEmpenho;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoContratoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\ContratoEmpenho
     */
    public function getFkTcmgoContratoEmpenho()
    {
        return $this->fkTcmgoContratoEmpenho;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmgoProcessos
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Processos $fkTcmgoProcessos
     * @return Empenho
     */
    public function setFkTcmgoProcessos(\Urbem\CoreBundle\Entity\Tcmgo\Processos $fkTcmgoProcessos)
    {
        $fkTcmgoProcessos->setFkEmpenhoEmpenho($this);
        $this->fkTcmgoProcessos = $fkTcmgoProcessos;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoProcessos
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\Processos
     */
    public function getFkTcmgoProcessos()
    {
        return $this->fkTcmgoProcessos;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoEmpenhoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoComplementar $fkEmpenhoEmpenhoComplementar
     * @return Empenho
     */
    public function setFkEmpenhoEmpenhoComplementar(\Urbem\CoreBundle\Entity\Empenho\EmpenhoComplementar $fkEmpenhoEmpenhoComplementar)
    {
        $fkEmpenhoEmpenhoComplementar->setFkEmpenhoEmpenho($this);
        $this->fkEmpenhoEmpenhoComplementar = $fkEmpenhoEmpenhoComplementar;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoEmpenhoComplementar
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\EmpenhoComplementar
     */
    public function getFkEmpenhoEmpenhoComplementar()
    {
        return $this->fkEmpenhoEmpenhoComplementar;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho
     * @return Empenho
     */
    public function setFkEmpenhoPreEmpenho(\Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho)
    {
        $this->exercicio = $fkEmpenhoPreEmpenho->getExercicio();
        $this->codPreEmpenho = $fkEmpenhoPreEmpenho->getCodPreEmpenho();
        $this->fkEmpenhoPreEmpenho = $fkEmpenhoPreEmpenho;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoPreEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    public function getFkEmpenhoPreEmpenho()
    {
        return $this->fkEmpenhoPreEmpenho;
    }

    /**
     * @return string
     */
    public function getCredor()
    {
        return (string) $this->getFkEmpenhoPreEmpenho()->getFkSwCgm()->getNomCgm();
    }

    /**
     * @return string
     */
    public function getEmpenho()
    {
        return sprintf('%s/%s', $this->codEmpenho, $this->exercicio);
    }

    /**
     * @return string
     */
    public function getNomEntidade()
    {
        return (string) $this->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm();
    }

    /**
     * @return string
     */
    public function getNomBeneficiario()
    {
        return (string) $this->getFkEmpenhoPreEmpenho()->getFkSwCgm()->getNomCgm();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->codEmpenho, $this->exercicio);
    }
}
