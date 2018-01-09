<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Contrato
 */
class Contrato
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $registro;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista
     */
    private $fkPessoalContratoPensionista;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\DadosRelogioPonto
     */
    private $fkPontoDadosRelogioPonto;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\Autoridade
     */
    private $fkDividaAutoridades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal
     */
    private $fkFiscalizacaoFiscais;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidencia
     */
    private $fkFolhapagamentoDescontoExternoPrevidencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\Conferencia910
     */
    private $fkImaConferencia910s;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoContratoServidor
     */
    private $fkPessoalAssentamentoGeradoContratoServidores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\CompensacaoHoras
     */
    private $fkPontoCompensacaoHoras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\EscalaContrato
     */
    private $fkPontoEscalaContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ExportacaoPonto
     */
    private $fkPontoExportacaoPontos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ImportacaoPonto
     */
    private $fkPontoImportacaoPontos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\RelatorioEspelhoPonto
     */
    private $fkPontoRelatorioEspelhoPontos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Diarias\Diaria
     */
    private $fkDiariasDiarias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Beneficiario
     */
    private $fkBeneficioBeneficiarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar
     */
    private $fkFolhapagamentoContratoServidorComplementares;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrf
     */
    private $fkFolhapagamentoDescontoExternoIrrfs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConcessaoDecimo
     */
    private $fkFolhapagamentoConcessaoDecimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasContrato
     */
    private $fkPessoalLoteFeriasContratos;

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
        $this->fkDividaAutoridades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoFiscais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoContratoServidorPeriodos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoDeducaoDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoDescontoExternoPrevidencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConferencia910s = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAssentamentoGeradoContratoServidores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoCompensacaoHoras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoEscalaContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoExportacaoPontos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoImportacaoPontos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoRelatorioEspelhoPontos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDiariasDiarias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkBeneficioBeneficiarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoContratoServidorComplementares = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoDescontoExternoIrrfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConcessaoDecimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalLoteFeriasContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorSituacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return Contrato
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set registro
     *
     * @param integer $registro
     * @return Contrato
     */
    public function setRegistro($registro)
    {
        $this->registro = $registro;
        return $this;
    }

    /**
     * Get registro
     *
     * @return integer
     */
    public function getRegistro()
    {
        return $this->registro;
    }

    /**
     * OneToMany (owning side)
     * Add DividaAutoridade
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Autoridade $fkDividaAutoridade
     * @return Contrato
     */
    public function addFkDividaAutoridades(\Urbem\CoreBundle\Entity\Divida\Autoridade $fkDividaAutoridade)
    {
        if (false === $this->fkDividaAutoridades->contains($fkDividaAutoridade)) {
            $fkDividaAutoridade->setFkPessoalContrato($this);
            $this->fkDividaAutoridades->add($fkDividaAutoridade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaAutoridade
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Autoridade $fkDividaAutoridade
     */
    public function removeFkDividaAutoridades(\Urbem\CoreBundle\Entity\Divida\Autoridade $fkDividaAutoridade)
    {
        $this->fkDividaAutoridades->removeElement($fkDividaAutoridade);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaAutoridades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\Autoridade
     */
    public function getFkDividaAutoridades()
    {
        return $this->fkDividaAutoridades;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal $fkFiscalizacaoFiscal
     * @return Contrato
     */
    public function addFkFiscalizacaoFiscais(\Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal $fkFiscalizacaoFiscal)
    {
        if (false === $this->fkFiscalizacaoFiscais->contains($fkFiscalizacaoFiscal)) {
            $fkFiscalizacaoFiscal->setFkPessoalContrato($this);
            $this->fkFiscalizacaoFiscais->add($fkFiscalizacaoFiscal);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal $fkFiscalizacaoFiscal
     */
    public function removeFkFiscalizacaoFiscais(\Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal $fkFiscalizacaoFiscal)
    {
        $this->fkFiscalizacaoFiscais->removeElement($fkFiscalizacaoFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal
     */
    public function getFkFiscalizacaoFiscais()
    {
        return $this->fkFiscalizacaoFiscais;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoContratoServidorPeriodo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo $fkFolhapagamentoContratoServidorPeriodo
     * @return Contrato
     */
    public function addFkFolhapagamentoContratoServidorPeriodos(\Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo $fkFolhapagamentoContratoServidorPeriodo)
    {
        if (false === $this->fkFolhapagamentoContratoServidorPeriodos->contains($fkFolhapagamentoContratoServidorPeriodo)) {
            $fkFolhapagamentoContratoServidorPeriodo->setFkPessoalContrato($this);
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
     * @return Contrato
     */
    public function addFkFolhapagamentoDeducaoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente $fkFolhapagamentoDeducaoDependente)
    {
        if (false === $this->fkFolhapagamentoDeducaoDependentes->contains($fkFolhapagamentoDeducaoDependente)) {
            $fkFolhapagamentoDeducaoDependente->setFkPessoalContrato($this);
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
     * Add FolhapagamentoDescontoExternoPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidencia $fkFolhapagamentoDescontoExternoPrevidencia
     * @return Contrato
     */
    public function addFkFolhapagamentoDescontoExternoPrevidencias(\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidencia $fkFolhapagamentoDescontoExternoPrevidencia)
    {
        if (false === $this->fkFolhapagamentoDescontoExternoPrevidencias->contains($fkFolhapagamentoDescontoExternoPrevidencia)) {
            $fkFolhapagamentoDescontoExternoPrevidencia->setFkPessoalContrato($this);
            $this->fkFolhapagamentoDescontoExternoPrevidencias->add($fkFolhapagamentoDescontoExternoPrevidencia);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoDescontoExternoPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidencia $fkFolhapagamentoDescontoExternoPrevidencia
     */
    public function removeFkFolhapagamentoDescontoExternoPrevidencias(\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidencia $fkFolhapagamentoDescontoExternoPrevidencia)
    {
        $this->fkFolhapagamentoDescontoExternoPrevidencias->removeElement($fkFolhapagamentoDescontoExternoPrevidencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoDescontoExternoPrevidencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidencia
     */
    public function getFkFolhapagamentoDescontoExternoPrevidencias()
    {
        return $this->fkFolhapagamentoDescontoExternoPrevidencias;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConferencia910
     *
     * @param \Urbem\CoreBundle\Entity\Ima\Conferencia910 $fkImaConferencia910
     * @return Contrato
     */
    public function addFkImaConferencia910s(\Urbem\CoreBundle\Entity\Ima\Conferencia910 $fkImaConferencia910)
    {
        if (false === $this->fkImaConferencia910s->contains($fkImaConferencia910)) {
            $fkImaConferencia910->setFkPessoalContrato($this);
            $this->fkImaConferencia910s->add($fkImaConferencia910);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConferencia910
     *
     * @param \Urbem\CoreBundle\Entity\Ima\Conferencia910 $fkImaConferencia910
     */
    public function removeFkImaConferencia910s(\Urbem\CoreBundle\Entity\Ima\Conferencia910 $fkImaConferencia910)
    {
        $this->fkImaConferencia910s->removeElement($fkImaConferencia910);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConferencia910s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\Conferencia910
     */
    public function getFkImaConferencia910s()
    {
        return $this->fkImaConferencia910s;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoGeradoContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoContratoServidor $fkPessoalAssentamentoGeradoContratoServidor
     * @return Contrato
     */
    public function addFkPessoalAssentamentoGeradoContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoContratoServidor $fkPessoalAssentamentoGeradoContratoServidor)
    {
        if (false === $this->fkPessoalAssentamentoGeradoContratoServidores->contains($fkPessoalAssentamentoGeradoContratoServidor)) {
            $fkPessoalAssentamentoGeradoContratoServidor->setFkPessoalContrato($this);
            $this->fkPessoalAssentamentoGeradoContratoServidores->add($fkPessoalAssentamentoGeradoContratoServidor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoGeradoContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoContratoServidor $fkPessoalAssentamentoGeradoContratoServidor
     */
    public function removeFkPessoalAssentamentoGeradoContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoContratoServidor $fkPessoalAssentamentoGeradoContratoServidor)
    {
        $this->fkPessoalAssentamentoGeradoContratoServidores->removeElement($fkPessoalAssentamentoGeradoContratoServidor);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoGeradoContratoServidores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoContratoServidor
     */
    public function getFkPessoalAssentamentoGeradoContratoServidores()
    {
        return $this->fkPessoalAssentamentoGeradoContratoServidores;
    }

    /**
     * OneToMany (owning side)
     * Add PontoCompensacaoHoras
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\CompensacaoHoras $fkPontoCompensacaoHoras
     * @return Contrato
     */
    public function addFkPontoCompensacaoHoras(\Urbem\CoreBundle\Entity\Ponto\CompensacaoHoras $fkPontoCompensacaoHoras)
    {
        if (false === $this->fkPontoCompensacaoHoras->contains($fkPontoCompensacaoHoras)) {
            $fkPontoCompensacaoHoras->setFkPessoalContrato($this);
            $this->fkPontoCompensacaoHoras->add($fkPontoCompensacaoHoras);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoCompensacaoHoras
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\CompensacaoHoras $fkPontoCompensacaoHoras
     */
    public function removeFkPontoCompensacaoHoras(\Urbem\CoreBundle\Entity\Ponto\CompensacaoHoras $fkPontoCompensacaoHoras)
    {
        $this->fkPontoCompensacaoHoras->removeElement($fkPontoCompensacaoHoras);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoCompensacaoHoras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\CompensacaoHoras
     */
    public function getFkPontoCompensacaoHoras()
    {
        return $this->fkPontoCompensacaoHoras;
    }

    /**
     * OneToMany (owning side)
     * Add PontoEscalaContrato
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\EscalaContrato $fkPontoEscalaContrato
     * @return Contrato
     */
    public function addFkPontoEscalaContratos(\Urbem\CoreBundle\Entity\Ponto\EscalaContrato $fkPontoEscalaContrato)
    {
        if (false === $this->fkPontoEscalaContratos->contains($fkPontoEscalaContrato)) {
            $fkPontoEscalaContrato->setFkPessoalContrato($this);
            $this->fkPontoEscalaContratos->add($fkPontoEscalaContrato);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoEscalaContrato
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\EscalaContrato $fkPontoEscalaContrato
     */
    public function removeFkPontoEscalaContratos(\Urbem\CoreBundle\Entity\Ponto\EscalaContrato $fkPontoEscalaContrato)
    {
        $this->fkPontoEscalaContratos->removeElement($fkPontoEscalaContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoEscalaContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\EscalaContrato
     */
    public function getFkPontoEscalaContratos()
    {
        return $this->fkPontoEscalaContratos;
    }

    /**
     * OneToMany (owning side)
     * Add PontoExportacaoPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ExportacaoPonto $fkPontoExportacaoPonto
     * @return Contrato
     */
    public function addFkPontoExportacaoPontos(\Urbem\CoreBundle\Entity\Ponto\ExportacaoPonto $fkPontoExportacaoPonto)
    {
        if (false === $this->fkPontoExportacaoPontos->contains($fkPontoExportacaoPonto)) {
            $fkPontoExportacaoPonto->setFkPessoalContrato($this);
            $this->fkPontoExportacaoPontos->add($fkPontoExportacaoPonto);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoExportacaoPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ExportacaoPonto $fkPontoExportacaoPonto
     */
    public function removeFkPontoExportacaoPontos(\Urbem\CoreBundle\Entity\Ponto\ExportacaoPonto $fkPontoExportacaoPonto)
    {
        $this->fkPontoExportacaoPontos->removeElement($fkPontoExportacaoPonto);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoExportacaoPontos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ExportacaoPonto
     */
    public function getFkPontoExportacaoPontos()
    {
        return $this->fkPontoExportacaoPontos;
    }

    /**
     * OneToMany (owning side)
     * Add PontoImportacaoPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ImportacaoPonto $fkPontoImportacaoPonto
     * @return Contrato
     */
    public function addFkPontoImportacaoPontos(\Urbem\CoreBundle\Entity\Ponto\ImportacaoPonto $fkPontoImportacaoPonto)
    {
        if (false === $this->fkPontoImportacaoPontos->contains($fkPontoImportacaoPonto)) {
            $fkPontoImportacaoPonto->setFkPessoalContrato($this);
            $this->fkPontoImportacaoPontos->add($fkPontoImportacaoPonto);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoImportacaoPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ImportacaoPonto $fkPontoImportacaoPonto
     */
    public function removeFkPontoImportacaoPontos(\Urbem\CoreBundle\Entity\Ponto\ImportacaoPonto $fkPontoImportacaoPonto)
    {
        $this->fkPontoImportacaoPontos->removeElement($fkPontoImportacaoPonto);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoImportacaoPontos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ImportacaoPonto
     */
    public function getFkPontoImportacaoPontos()
    {
        return $this->fkPontoImportacaoPontos;
    }

    /**
     * OneToMany (owning side)
     * Add PontoRelatorioEspelhoPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\RelatorioEspelhoPonto $fkPontoRelatorioEspelhoPonto
     * @return Contrato
     */
    public function addFkPontoRelatorioEspelhoPontos(\Urbem\CoreBundle\Entity\Ponto\RelatorioEspelhoPonto $fkPontoRelatorioEspelhoPonto)
    {
        if (false === $this->fkPontoRelatorioEspelhoPontos->contains($fkPontoRelatorioEspelhoPonto)) {
            $fkPontoRelatorioEspelhoPonto->setFkPessoalContrato($this);
            $this->fkPontoRelatorioEspelhoPontos->add($fkPontoRelatorioEspelhoPonto);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoRelatorioEspelhoPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\RelatorioEspelhoPonto $fkPontoRelatorioEspelhoPonto
     */
    public function removeFkPontoRelatorioEspelhoPontos(\Urbem\CoreBundle\Entity\Ponto\RelatorioEspelhoPonto $fkPontoRelatorioEspelhoPonto)
    {
        $this->fkPontoRelatorioEspelhoPontos->removeElement($fkPontoRelatorioEspelhoPonto);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoRelatorioEspelhoPontos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\RelatorioEspelhoPonto
     */
    public function getFkPontoRelatorioEspelhoPontos()
    {
        return $this->fkPontoRelatorioEspelhoPontos;
    }

    /**
     * OneToMany (owning side)
     * Add DiariasDiaria
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria
     * @return Contrato
     */
    public function addFkDiariasDiarias(\Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria)
    {
        if (false === $this->fkDiariasDiarias->contains($fkDiariasDiaria)) {
            $fkDiariasDiaria->setFkPessoalContrato($this);
            $this->fkDiariasDiarias->add($fkDiariasDiaria);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DiariasDiaria
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria
     */
    public function removeFkDiariasDiarias(\Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria)
    {
        $this->fkDiariasDiarias->removeElement($fkDiariasDiaria);
    }

    /**
     * OneToMany (owning side)
     * Get fkDiariasDiarias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Diarias\Diaria
     */
    public function getFkDiariasDiarias()
    {
        return $this->fkDiariasDiarias;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioBeneficiario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario
     * @return Contrato
     */
    public function addFkBeneficioBeneficiarios(\Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario)
    {
        if (false === $this->fkBeneficioBeneficiarios->contains($fkBeneficioBeneficiario)) {
            $fkBeneficioBeneficiario->setFkPessoalContrato($this);
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
     * Add FolhapagamentoContratoServidorComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar $fkFolhapagamentoContratoServidorComplementar
     * @return Contrato
     */
    public function addFkFolhapagamentoContratoServidorComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar $fkFolhapagamentoContratoServidorComplementar)
    {
        if (false === $this->fkFolhapagamentoContratoServidorComplementares->contains($fkFolhapagamentoContratoServidorComplementar)) {
            $fkFolhapagamentoContratoServidorComplementar->setFkPessoalContrato($this);
            $this->fkFolhapagamentoContratoServidorComplementares->add($fkFolhapagamentoContratoServidorComplementar);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoContratoServidorComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar $fkFolhapagamentoContratoServidorComplementar
     */
    public function removeFkFolhapagamentoContratoServidorComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar $fkFolhapagamentoContratoServidorComplementar)
    {
        $this->fkFolhapagamentoContratoServidorComplementares->removeElement($fkFolhapagamentoContratoServidorComplementar);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoContratoServidorComplementares
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar
     */
    public function getFkFolhapagamentoContratoServidorComplementares()
    {
        return $this->fkFolhapagamentoContratoServidorComplementares;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoDescontoExternoIrrf
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrf $fkFolhapagamentoDescontoExternoIrrf
     * @return Contrato
     */
    public function addFkFolhapagamentoDescontoExternoIrrfs(\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrf $fkFolhapagamentoDescontoExternoIrrf)
    {
        if (false === $this->fkFolhapagamentoDescontoExternoIrrfs->contains($fkFolhapagamentoDescontoExternoIrrf)) {
            $fkFolhapagamentoDescontoExternoIrrf->setFkPessoalContrato($this);
            $this->fkFolhapagamentoDescontoExternoIrrfs->add($fkFolhapagamentoDescontoExternoIrrf);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoDescontoExternoIrrf
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrf $fkFolhapagamentoDescontoExternoIrrf
     */
    public function removeFkFolhapagamentoDescontoExternoIrrfs(\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrf $fkFolhapagamentoDescontoExternoIrrf)
    {
        $this->fkFolhapagamentoDescontoExternoIrrfs->removeElement($fkFolhapagamentoDescontoExternoIrrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoDescontoExternoIrrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrf
     */
    public function getFkFolhapagamentoDescontoExternoIrrfs()
    {
        return $this->fkFolhapagamentoDescontoExternoIrrfs;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConcessaoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConcessaoDecimo $fkFolhapagamentoConcessaoDecimo
     * @return Contrato
     */
    public function addFkFolhapagamentoConcessaoDecimos(\Urbem\CoreBundle\Entity\Folhapagamento\ConcessaoDecimo $fkFolhapagamentoConcessaoDecimo)
    {
        if (false === $this->fkFolhapagamentoConcessaoDecimos->contains($fkFolhapagamentoConcessaoDecimo)) {
            $fkFolhapagamentoConcessaoDecimo->setFkPessoalContrato($this);
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
     * Add PessoalLoteFeriasContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasContrato $fkPessoalLoteFeriasContrato
     * @return Contrato
     */
    public function addFkPessoalLoteFeriasContratos(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasContrato $fkPessoalLoteFeriasContrato)
    {
        if (false === $this->fkPessoalLoteFeriasContratos->contains($fkPessoalLoteFeriasContrato)) {
            $fkPessoalLoteFeriasContrato->setFkPessoalContrato($this);
            $this->fkPessoalLoteFeriasContratos->add($fkPessoalLoteFeriasContrato);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalLoteFeriasContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasContrato $fkPessoalLoteFeriasContrato
     */
    public function removeFkPessoalLoteFeriasContratos(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasContrato $fkPessoalLoteFeriasContrato)
    {
        $this->fkPessoalLoteFeriasContratos->removeElement($fkPessoalLoteFeriasContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalLoteFeriasContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasContrato
     */
    public function getFkPessoalLoteFeriasContratos()
    {
        return $this->fkPessoalLoteFeriasContratos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorSituacao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSituacao $fkPessoalContratoServidorSituacao
     * @return Contrato
     */
    public function addFkPessoalContratoServidorSituacoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSituacao $fkPessoalContratoServidorSituacao)
    {
        if (false === $this->fkPessoalContratoServidorSituacoes->contains($fkPessoalContratoServidorSituacao)) {
            $fkPessoalContratoServidorSituacao->setFkPessoalContrato($this);
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
     * Set PessoalContratoPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista
     * @return Contrato
     */
    public function setFkPessoalContratoPensionista(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista)
    {
        $fkPessoalContratoPensionista->setFkPessoalContrato($this);
        $this->fkPessoalContratoPensionista = $fkPessoalContratoPensionista;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalContratoPensionista
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista
     */
    public function getFkPessoalContratoPensionista()
    {
        return $this->fkPessoalContratoPensionista;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoDadosRelogioPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DadosRelogioPonto $fkPontoDadosRelogioPonto
     * @return Contrato
     */
    public function setFkPontoDadosRelogioPonto(\Urbem\CoreBundle\Entity\Ponto\DadosRelogioPonto $fkPontoDadosRelogioPonto)
    {
        $fkPontoDadosRelogioPonto->setFkPessoalContrato($this);
        $this->fkPontoDadosRelogioPonto = $fkPontoDadosRelogioPonto;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoDadosRelogioPonto
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\DadosRelogioPonto
     */
    public function getFkPontoDadosRelogioPonto()
    {
        return $this->fkPontoDadosRelogioPonto;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return Contrato
     */
    public function setFkPessoalContratoServidor(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $fkPessoalContratoServidor->setFkPessoalContrato($this);
        $this->fkPessoalContratoServidor = $fkPessoalContratoServidor;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalContratoServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidor()
    {
        return $this->fkPessoalContratoServidor;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->codContrato;
    }

    public function __invoke()
    {
        return $this;
    }
}
