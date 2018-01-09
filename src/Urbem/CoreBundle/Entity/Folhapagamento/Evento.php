<?php

namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * Evento
 */
class Evento
{
    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * @var string
     */
    private $codigo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $natureza;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $fixado;

    /**
     * @var boolean
     */
    private $limiteCalculo = false;

    /**
     * @var boolean
     */
    private $apresentaParcela = false;

    /**
     * @var boolean
     */
    private $eventoSistema = false;

    /**
     * @var string
     */
    private $sigla = '';

    /**
     * @var boolean
     */
    private $apresentarContracheque = false;

    /**
     * @var string
     */
    private $codVerba;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ima\ConsignacaoBanrisulRemuneracao
     */
    private $fkImaConsignacaoBanrisulRemuneracao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ArquivoCodigoVantagensDescontos
     */
    private $fkPessoalArquivoCodigoVantagensDescontos;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ima\ConsignacaoBanrisulLiquido
     */
    private $fkImaConsignacaoBanrisulLiquido;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento
     */
    private $fkFolhapagamentoBeneficioEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\BasesEvento
     */
    private $fkFolhapagamentoBasesEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoEvento
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno
     */
    private $fkFolhapagamentoConfiguracaoEventosDescontoExternos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno
     */
    private $fkFolhapagamentoConfiguracaoEventosDescontoExternos1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno
     */
    private $fkFolhapagamentoConfiguracaoEventosDescontoExternos2;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno
     */
    private $fkFolhapagamentoConfiguracaoEventosDescontoExternos3;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe
     */
    private $fkFolhapagamentoConfiguracaoIpes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe
     */
    private $fkFolhapagamentoConfiguracaoIpes1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DecimoEvento
     */
    private $fkFolhapagamentoDecimoEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento
     */
    private $fkFolhapagamentoEventoEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento
     */
    private $fkFolhapagamentoFeriasEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento
     */
    private $fkFolhapagamentoFgtsEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento
     */
    private $fkFolhapagamentoPrevidenciaEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento
     */
    private $fkFolhapagamentoPensaoEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo
     */
    private $fkFolhapagamentoRegistroEventoDecimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisao
     */
    private $fkFolhapagamentoRegistroEventoRescisoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculoEvento
     */
    private $fkFolhapagamentoSequenciaCalculoEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\Sindicato
     */
    private $fkFolhapagamentoSindicatos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento
     */
    private $fkFolhapagamentoTabelaIrrfEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento
     */
    private $fkFolhapagamentoRegistroEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRemuneracao
     */
    private $fkFolhapagamentoTcemgEntidadeRemuneracoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar
     */
    private $fkFolhapagamentoRegistroEventoComplementares;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado
     */
    private $fkFolhapagamentoTcmbaEmprestimoConsignados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaGratificacaoFuncao
     */
    private $fkFolhapagamentoTcmbaGratificacaoFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaPlanoSaude
     */
    private $fkFolhapagamentoTcmbaPlanoSaudes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioDescontos
     */
    private $fkFolhapagamentoTcmbaSalarioDescontos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioFamilia
     */
    private $fkFolhapagamentoTcmbaSalarioFamilias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioHorasExtras
     */
    private $fkFolhapagamentoTcmbaSalarioHorasExtras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaVantagensSalariais
     */
    private $fkFolhapagamentoTcmbaVantagensSalariais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TotaisFolhaEventos
     */
    private $fkFolhapagamentoTotaisFolhaEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\CagedEvento
     */
    private $fkImaCagedEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulEmprestimo
     */
    private $fkImaConfiguracaoBanrisulEmprestimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano
     */
    private $fkImaConfiguracaoDirfPlanos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoPasep
     */
    private $fkImaConfiguracaoPaseps;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf
     */
    private $fkImaConfiguracaoDirfs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\EventoHorasExtras
     */
    private $fkImaEventoHorasExtras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoEventoProporcional
     */
    private $fkPessoalAssentamentoEventoProporcionais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoEvento
     */
    private $fkPessoalAssentamentoEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ExportacaoPonto
     */
    private $fkPontoExportacaoPontos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorio
     */
    private $fkTcemgTetoRemuneratorios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfComprovanteRendimento
     */
    private $fkFolhapagamentoTabelaIrrfComprovanteRendimentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\BasesEventoCriado
     */
    private $fkFolhapagamentoBasesEventoCriados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias
     */
    private $fkFolhapagamentoRegistroEventoFerias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento
     */
    private $fkFolhapagamentoSalarioFamiliaEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioBase
     */
    private $fkFolhapagamentoTcmbaSalarioBases;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\EventoComposicaoRemuneracao
     */
    private $fkImaEventoComposicaoRemuneracoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\DadosExportacao
     */
    private $fkPontoDadosExportacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\VerbaRescisoriaMte
     */
    private $fkFolhapagamentoVerbaRescisoriaMte;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoBeneficioEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoBasesEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos3 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoIpes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoIpes1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoDecimoEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoEventoEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoFeriasEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoFgtsEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoPrevidenciaEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoPensaoEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoRegistroEventoDecimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoRegistroEventoRescisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoSequenciaCalculoEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoSindicatos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTabelaIrrfEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoRegistroEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcemgEntidadeRemuneracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoRegistroEventoComplementares = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaEmprestimoConsignados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaGratificacaoFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaPlanoSaudes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaSalarioDescontos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaSalarioFamilias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaSalarioHorasExtras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaVantagensSalariais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTotaisFolhaEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaCagedEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoBanrisulEmprestimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoDirfPlanos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoPaseps = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoDirfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaEventoHorasExtras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAssentamentoEventoProporcionais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAssentamentoEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoExportacaoPontos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgTetoRemuneratorios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTabelaIrrfComprovanteRendimentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoBasesEventoCriados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoRegistroEventoFerias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoSalarioFamiliaEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaSalarioBases = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaEventoComposicaoRemuneracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoDadosExportacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return Evento
     */
    public function setCodEvento($codEvento)
    {
        $this->codEvento = $codEvento;
        return $this;
    }

    /**
     * Get codEvento
     *
     * @return integer
     */
    public function getCodEvento()
    {
        return $this->codEvento;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Evento
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Evento
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set natureza
     *
     * @param string $natureza
     * @return Evento
     */
    public function setNatureza($natureza)
    {
        $this->natureza = $natureza;
        return $this;
    }

    /**
     * Get natureza
     *
     * @return string
     */
    public function getNatureza()
    {
        return $this->natureza;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Evento
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set fixado
     *
     * @param string $fixado
     * @return Evento
     */
    public function setFixado($fixado)
    {
        $this->fixado = $fixado;
        return $this;
    }

    /**
     * Get fixado
     *
     * @return string
     */
    public function getFixado()
    {
        return $this->fixado;
    }

    /**
     * Set limiteCalculo
     *
     * @param boolean $limiteCalculo
     * @return Evento
     */
    public function setLimiteCalculo($limiteCalculo)
    {
        $this->limiteCalculo = $limiteCalculo;
        return $this;
    }

    /**
     * Get limiteCalculo
     *
     * @return boolean
     */
    public function getLimiteCalculo()
    {
        return $this->limiteCalculo;
    }

    /**
     * Set apresentaParcela
     *
     * @param boolean $apresentaParcela
     * @return Evento
     */
    public function setApresentaParcela($apresentaParcela)
    {
        $this->apresentaParcela = $apresentaParcela;
        return $this;
    }

    /**
     * Get apresentaParcela
     *
     * @return boolean
     */
    public function getApresentaParcela()
    {
        return $this->apresentaParcela;
    }

    /**
     * Set eventoSistema
     *
     * @param boolean $eventoSistema
     * @return Evento
     */
    public function setEventoSistema($eventoSistema = null)
    {
        $this->eventoSistema = $eventoSistema;
        return $this;
    }

    /**
     * Get eventoSistema
     *
     * @return boolean
     */
    public function getEventoSistema()
    {
        return $this->eventoSistema;
    }

    /**
     * Set sigla
     *
     * @param string $sigla
     * @return Evento
     */
    public function setSigla($sigla = null)
    {
        $this->sigla = $sigla;
        return $this;
    }

    /**
     * Get sigla
     *
     * @return string
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Set apresentarContracheque
     *
     * @param boolean $apresentarContracheque
     * @return Evento
     */
    public function setApresentarContracheque($apresentarContracheque)
    {
        $this->apresentarContracheque = $apresentarContracheque;
        return $this;
    }

    /**
     * Get apresentarContracheque
     *
     * @return boolean
     */
    public function getApresentarContracheque()
    {
        return $this->apresentarContracheque;
    }

    /**
     * Set codVerba
     *
     * @param string $codVerba
     * @return Evento
     */
    public function setCodVerba($codVerba = null)
    {
        $this->codVerba = $codVerba;
        return $this;
    }

    /**
     * Get codVerba
     *
     * @return string
     */
    public function getCodVerba()
    {
        return $this->codVerba;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoBeneficioEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento $fkFolhapagamentoBeneficioEvento
     * @return Evento
     */
    public function addFkFolhapagamentoBeneficioEventos(\Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento $fkFolhapagamentoBeneficioEvento)
    {
        if (false === $this->fkFolhapagamentoBeneficioEventos->contains($fkFolhapagamentoBeneficioEvento)) {
            $fkFolhapagamentoBeneficioEvento->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoBeneficioEventos->add($fkFolhapagamentoBeneficioEvento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoBeneficioEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento $fkFolhapagamentoBeneficioEvento
     */
    public function removeFkFolhapagamentoBeneficioEventos(\Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento $fkFolhapagamentoBeneficioEvento)
    {
        $this->fkFolhapagamentoBeneficioEventos->removeElement($fkFolhapagamentoBeneficioEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoBeneficioEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento
     */
    public function getFkFolhapagamentoBeneficioEventos()
    {
        return $this->fkFolhapagamentoBeneficioEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoBasesEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\BasesEvento $fkFolhapagamentoBasesEvento
     * @return Evento
     */
    public function addFkFolhapagamentoBasesEventos(\Urbem\CoreBundle\Entity\Folhapagamento\BasesEvento $fkFolhapagamentoBasesEvento)
    {
        if (false === $this->fkFolhapagamentoBasesEventos->contains($fkFolhapagamentoBasesEvento)) {
            $fkFolhapagamentoBasesEvento->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoBasesEventos->add($fkFolhapagamentoBasesEvento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoBasesEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\BasesEvento $fkFolhapagamentoBasesEvento
     */
    public function removeFkFolhapagamentoBasesEventos(\Urbem\CoreBundle\Entity\Folhapagamento\BasesEvento $fkFolhapagamentoBasesEvento)
    {
        $this->fkFolhapagamentoBasesEventos->removeElement($fkFolhapagamentoBasesEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoBasesEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\BasesEvento
     */
    public function getFkFolhapagamentoBasesEventos()
    {
        return $this->fkFolhapagamentoBasesEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoEvento $fkFolhapagamentoConfiguracaoEmpenhoEvento
     * @return Evento
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoEvento $fkFolhapagamentoConfiguracaoEmpenhoEvento)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoEventos->contains($fkFolhapagamentoConfiguracaoEmpenhoEvento)) {
            $fkFolhapagamentoConfiguracaoEmpenhoEvento->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoEventos->add($fkFolhapagamentoConfiguracaoEmpenhoEvento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoEvento $fkFolhapagamentoConfiguracaoEmpenhoEvento
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoEvento $fkFolhapagamentoConfiguracaoEmpenhoEvento)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoEventos->removeElement($fkFolhapagamentoConfiguracaoEmpenhoEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoEvento
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoEventos()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEventosDescontoExterno
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno $fkFolhapagamentoConfiguracaoEventosDescontoExterno
     * @return Evento
     */
    public function addFkFolhapagamentoConfiguracaoEventosDescontoExternos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno $fkFolhapagamentoConfiguracaoEventosDescontoExterno)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos->contains($fkFolhapagamentoConfiguracaoEventosDescontoExterno)) {
            $fkFolhapagamentoConfiguracaoEventosDescontoExterno->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos->add($fkFolhapagamentoConfiguracaoEventosDescontoExterno);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEventosDescontoExterno
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno $fkFolhapagamentoConfiguracaoEventosDescontoExterno
     */
    public function removeFkFolhapagamentoConfiguracaoEventosDescontoExternos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno $fkFolhapagamentoConfiguracaoEventosDescontoExterno)
    {
        $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos->removeElement($fkFolhapagamentoConfiguracaoEventosDescontoExterno);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEventosDescontoExternos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno
     */
    public function getFkFolhapagamentoConfiguracaoEventosDescontoExternos()
    {
        return $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEventosDescontoExterno
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno $fkFolhapagamentoConfiguracaoEventosDescontoExterno
     * @return Evento
     */
    public function addFkFolhapagamentoConfiguracaoEventosDescontoExternos1(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno $fkFolhapagamentoConfiguracaoEventosDescontoExterno)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos1->contains($fkFolhapagamentoConfiguracaoEventosDescontoExterno)) {
            $fkFolhapagamentoConfiguracaoEventosDescontoExterno->setFkFolhapagamentoEvento1($this);
            $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos1->add($fkFolhapagamentoConfiguracaoEventosDescontoExterno);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEventosDescontoExterno
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno $fkFolhapagamentoConfiguracaoEventosDescontoExterno
     */
    public function removeFkFolhapagamentoConfiguracaoEventosDescontoExternos1(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno $fkFolhapagamentoConfiguracaoEventosDescontoExterno)
    {
        $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos1->removeElement($fkFolhapagamentoConfiguracaoEventosDescontoExterno);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEventosDescontoExternos1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno
     */
    public function getFkFolhapagamentoConfiguracaoEventosDescontoExternos1()
    {
        return $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos1;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEventosDescontoExterno
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno $fkFolhapagamentoConfiguracaoEventosDescontoExterno
     * @return Evento
     */
    public function addFkFolhapagamentoConfiguracaoEventosDescontoExternos2(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno $fkFolhapagamentoConfiguracaoEventosDescontoExterno)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos2->contains($fkFolhapagamentoConfiguracaoEventosDescontoExterno)) {
            $fkFolhapagamentoConfiguracaoEventosDescontoExterno->setFkFolhapagamentoEvento2($this);
            $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos2->add($fkFolhapagamentoConfiguracaoEventosDescontoExterno);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEventosDescontoExterno
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno $fkFolhapagamentoConfiguracaoEventosDescontoExterno
     */
    public function removeFkFolhapagamentoConfiguracaoEventosDescontoExternos2(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno $fkFolhapagamentoConfiguracaoEventosDescontoExterno)
    {
        $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos2->removeElement($fkFolhapagamentoConfiguracaoEventosDescontoExterno);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEventosDescontoExternos2
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno
     */
    public function getFkFolhapagamentoConfiguracaoEventosDescontoExternos2()
    {
        return $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos2;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEventosDescontoExterno
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno $fkFolhapagamentoConfiguracaoEventosDescontoExterno
     * @return Evento
     */
    public function addFkFolhapagamentoConfiguracaoEventosDescontoExternos3(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno $fkFolhapagamentoConfiguracaoEventosDescontoExterno)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos3->contains($fkFolhapagamentoConfiguracaoEventosDescontoExterno)) {
            $fkFolhapagamentoConfiguracaoEventosDescontoExterno->setFkFolhapagamentoEvento3($this);
            $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos3->add($fkFolhapagamentoConfiguracaoEventosDescontoExterno);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEventosDescontoExterno
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno $fkFolhapagamentoConfiguracaoEventosDescontoExterno
     */
    public function removeFkFolhapagamentoConfiguracaoEventosDescontoExternos3(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno $fkFolhapagamentoConfiguracaoEventosDescontoExterno)
    {
        $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos3->removeElement($fkFolhapagamentoConfiguracaoEventosDescontoExterno);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEventosDescontoExternos3
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventosDescontoExterno
     */
    public function getFkFolhapagamentoConfiguracaoEventosDescontoExternos3()
    {
        return $this->fkFolhapagamentoConfiguracaoEventosDescontoExternos3;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoIpe
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe $fkFolhapagamentoConfiguracaoIpe
     * @return Evento
     */
    public function addFkFolhapagamentoConfiguracaoIpes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe $fkFolhapagamentoConfiguracaoIpe)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoIpes->contains($fkFolhapagamentoConfiguracaoIpe)) {
            $fkFolhapagamentoConfiguracaoIpe->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoConfiguracaoIpes->add($fkFolhapagamentoConfiguracaoIpe);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoIpe
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe $fkFolhapagamentoConfiguracaoIpe
     */
    public function removeFkFolhapagamentoConfiguracaoIpes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe $fkFolhapagamentoConfiguracaoIpe)
    {
        $this->fkFolhapagamentoConfiguracaoIpes->removeElement($fkFolhapagamentoConfiguracaoIpe);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoIpes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe
     */
    public function getFkFolhapagamentoConfiguracaoIpes()
    {
        return $this->fkFolhapagamentoConfiguracaoIpes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoIpe
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe $fkFolhapagamentoConfiguracaoIpe
     * @return Evento
     */
    public function addFkFolhapagamentoConfiguracaoIpes1(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe $fkFolhapagamentoConfiguracaoIpe)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoIpes1->contains($fkFolhapagamentoConfiguracaoIpe)) {
            $fkFolhapagamentoConfiguracaoIpe->setFkFolhapagamentoEvento1($this);
            $this->fkFolhapagamentoConfiguracaoIpes1->add($fkFolhapagamentoConfiguracaoIpe);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoIpe
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe $fkFolhapagamentoConfiguracaoIpe
     */
    public function removeFkFolhapagamentoConfiguracaoIpes1(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe $fkFolhapagamentoConfiguracaoIpe)
    {
        $this->fkFolhapagamentoConfiguracaoIpes1->removeElement($fkFolhapagamentoConfiguracaoIpe);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoIpes1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe
     */
    public function getFkFolhapagamentoConfiguracaoIpes1()
    {
        return $this->fkFolhapagamentoConfiguracaoIpes1;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoDecimoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DecimoEvento $fkFolhapagamentoDecimoEvento
     * @return Evento
     */
    public function addFkFolhapagamentoDecimoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\DecimoEvento $fkFolhapagamentoDecimoEvento)
    {
        if (false === $this->fkFolhapagamentoDecimoEventos->contains($fkFolhapagamentoDecimoEvento)) {
            $fkFolhapagamentoDecimoEvento->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoDecimoEventos->add($fkFolhapagamentoDecimoEvento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoDecimoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DecimoEvento $fkFolhapagamentoDecimoEvento
     */
    public function removeFkFolhapagamentoDecimoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\DecimoEvento $fkFolhapagamentoDecimoEvento)
    {
        $this->fkFolhapagamentoDecimoEventos->removeElement($fkFolhapagamentoDecimoEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoDecimoEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DecimoEvento
     */
    public function getFkFolhapagamentoDecimoEventos()
    {
        return $this->fkFolhapagamentoDecimoEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoEventoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento $fkFolhapagamentoEventoEvento
     * @return Evento
     */
    public function addFkFolhapagamentoEventoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento $fkFolhapagamentoEventoEvento)
    {
        if (false === $this->fkFolhapagamentoEventoEventos->contains($fkFolhapagamentoEventoEvento)) {
            $fkFolhapagamentoEventoEvento->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoEventoEventos->add($fkFolhapagamentoEventoEvento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoEventoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento $fkFolhapagamentoEventoEvento
     */
    public function removeFkFolhapagamentoEventoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento $fkFolhapagamentoEventoEvento)
    {
        $this->fkFolhapagamentoEventoEventos->removeElement($fkFolhapagamentoEventoEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoEventoEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento
     */
    public function getFkFolhapagamentoEventoEventos()
    {
        return $this->fkFolhapagamentoEventoEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoFeriasEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento $fkFolhapagamentoFeriasEvento
     * @return Evento
     */
    public function addFkFolhapagamentoFeriasEventos(\Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento $fkFolhapagamentoFeriasEvento)
    {
        if (false === $this->fkFolhapagamentoFeriasEventos->contains($fkFolhapagamentoFeriasEvento)) {
            $fkFolhapagamentoFeriasEvento->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoFeriasEventos->add($fkFolhapagamentoFeriasEvento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoFeriasEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento $fkFolhapagamentoFeriasEvento
     */
    public function removeFkFolhapagamentoFeriasEventos(\Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento $fkFolhapagamentoFeriasEvento)
    {
        $this->fkFolhapagamentoFeriasEventos->removeElement($fkFolhapagamentoFeriasEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoFeriasEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento
     */
    public function getFkFolhapagamentoFeriasEventos()
    {
        return $this->fkFolhapagamentoFeriasEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoFgtsEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento $fkFolhapagamentoFgtsEvento
     * @return Evento
     */
    public function addFkFolhapagamentoFgtsEventos(\Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento $fkFolhapagamentoFgtsEvento)
    {
        if (false === $this->fkFolhapagamentoFgtsEventos->contains($fkFolhapagamentoFgtsEvento)) {
            $fkFolhapagamentoFgtsEvento->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoFgtsEventos->add($fkFolhapagamentoFgtsEvento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoFgtsEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento $fkFolhapagamentoFgtsEvento
     */
    public function removeFkFolhapagamentoFgtsEventos(\Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento $fkFolhapagamentoFgtsEvento)
    {
        $this->fkFolhapagamentoFgtsEventos->removeElement($fkFolhapagamentoFgtsEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoFgtsEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento
     */
    public function getFkFolhapagamentoFgtsEventos()
    {
        return $this->fkFolhapagamentoFgtsEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoPrevidenciaEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento $fkFolhapagamentoPrevidenciaEvento
     * @return Evento
     */
    public function addFkFolhapagamentoPrevidenciaEventos(\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento $fkFolhapagamentoPrevidenciaEvento)
    {
        if (false === $this->fkFolhapagamentoPrevidenciaEventos->contains($fkFolhapagamentoPrevidenciaEvento)) {
            $fkFolhapagamentoPrevidenciaEvento->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoPrevidenciaEventos->add($fkFolhapagamentoPrevidenciaEvento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoPrevidenciaEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento $fkFolhapagamentoPrevidenciaEvento
     */
    public function removeFkFolhapagamentoPrevidenciaEventos(\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento $fkFolhapagamentoPrevidenciaEvento)
    {
        $this->fkFolhapagamentoPrevidenciaEventos->removeElement($fkFolhapagamentoPrevidenciaEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoPrevidenciaEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento
     */
    public function getFkFolhapagamentoPrevidenciaEventos()
    {
        return $this->fkFolhapagamentoPrevidenciaEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoPensaoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento $fkFolhapagamentoPensaoEvento
     * @return Evento
     */
    public function addFkFolhapagamentoPensaoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento $fkFolhapagamentoPensaoEvento)
    {
        if (false === $this->fkFolhapagamentoPensaoEventos->contains($fkFolhapagamentoPensaoEvento)) {
            $fkFolhapagamentoPensaoEvento->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoPensaoEventos->add($fkFolhapagamentoPensaoEvento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoPensaoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento $fkFolhapagamentoPensaoEvento
     */
    public function removeFkFolhapagamentoPensaoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento $fkFolhapagamentoPensaoEvento)
    {
        $this->fkFolhapagamentoPensaoEventos->removeElement($fkFolhapagamentoPensaoEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoPensaoEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento
     */
    public function getFkFolhapagamentoPensaoEventos()
    {
        return $this->fkFolhapagamentoPensaoEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoRegistroEventoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo $fkFolhapagamentoRegistroEventoDecimo
     * @return Evento
     */
    public function addFkFolhapagamentoRegistroEventoDecimos(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo $fkFolhapagamentoRegistroEventoDecimo)
    {
        if (false === $this->fkFolhapagamentoRegistroEventoDecimos->contains($fkFolhapagamentoRegistroEventoDecimo)) {
            $fkFolhapagamentoRegistroEventoDecimo->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoRegistroEventoDecimos->add($fkFolhapagamentoRegistroEventoDecimo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoRegistroEventoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo $fkFolhapagamentoRegistroEventoDecimo
     */
    public function removeFkFolhapagamentoRegistroEventoDecimos(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo $fkFolhapagamentoRegistroEventoDecimo)
    {
        $this->fkFolhapagamentoRegistroEventoDecimos->removeElement($fkFolhapagamentoRegistroEventoDecimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoRegistroEventoDecimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo
     */
    public function getFkFolhapagamentoRegistroEventoDecimos()
    {
        return $this->fkFolhapagamentoRegistroEventoDecimos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoRegistroEventoRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisao $fkFolhapagamentoRegistroEventoRescisao
     * @return Evento
     */
    public function addFkFolhapagamentoRegistroEventoRescisoes(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisao $fkFolhapagamentoRegistroEventoRescisao)
    {
        if (false === $this->fkFolhapagamentoRegistroEventoRescisoes->contains($fkFolhapagamentoRegistroEventoRescisao)) {
            $fkFolhapagamentoRegistroEventoRescisao->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoRegistroEventoRescisoes->add($fkFolhapagamentoRegistroEventoRescisao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoRegistroEventoRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisao $fkFolhapagamentoRegistroEventoRescisao
     */
    public function removeFkFolhapagamentoRegistroEventoRescisoes(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisao $fkFolhapagamentoRegistroEventoRescisao)
    {
        $this->fkFolhapagamentoRegistroEventoRescisoes->removeElement($fkFolhapagamentoRegistroEventoRescisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoRegistroEventoRescisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisao
     */
    public function getFkFolhapagamentoRegistroEventoRescisoes()
    {
        return $this->fkFolhapagamentoRegistroEventoRescisoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoSequenciaCalculoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculoEvento $fkFolhapagamentoSequenciaCalculoEvento
     * @return Evento
     */
    public function addFkFolhapagamentoSequenciaCalculoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculoEvento $fkFolhapagamentoSequenciaCalculoEvento)
    {
        if (false === $this->fkFolhapagamentoSequenciaCalculoEventos->contains($fkFolhapagamentoSequenciaCalculoEvento)) {
            $fkFolhapagamentoSequenciaCalculoEvento->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoSequenciaCalculoEventos->add($fkFolhapagamentoSequenciaCalculoEvento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoSequenciaCalculoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculoEvento $fkFolhapagamentoSequenciaCalculoEvento
     */
    public function removeFkFolhapagamentoSequenciaCalculoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculoEvento $fkFolhapagamentoSequenciaCalculoEvento)
    {
        $this->fkFolhapagamentoSequenciaCalculoEventos->removeElement($fkFolhapagamentoSequenciaCalculoEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoSequenciaCalculoEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculoEvento
     */
    public function getFkFolhapagamentoSequenciaCalculoEventos()
    {
        return $this->fkFolhapagamentoSequenciaCalculoEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoSindicato
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Sindicato $fkFolhapagamentoSindicato
     * @return Evento
     */
    public function addFkFolhapagamentoSindicatos(\Urbem\CoreBundle\Entity\Folhapagamento\Sindicato $fkFolhapagamentoSindicato)
    {
        if (false === $this->fkFolhapagamentoSindicatos->contains($fkFolhapagamentoSindicato)) {
            $fkFolhapagamentoSindicato->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoSindicatos->add($fkFolhapagamentoSindicato);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoSindicato
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Sindicato $fkFolhapagamentoSindicato
     */
    public function removeFkFolhapagamentoSindicatos(\Urbem\CoreBundle\Entity\Folhapagamento\Sindicato $fkFolhapagamentoSindicato)
    {
        $this->fkFolhapagamentoSindicatos->removeElement($fkFolhapagamentoSindicato);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoSindicatos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\Sindicato
     */
    public function getFkFolhapagamentoSindicatos()
    {
        return $this->fkFolhapagamentoSindicatos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTabelaIrrfEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento $fkFolhapagamentoTabelaIrrfEvento
     * @return Evento
     */
    public function addFkFolhapagamentoTabelaIrrfEventos(\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento $fkFolhapagamentoTabelaIrrfEvento)
    {
        if (false === $this->fkFolhapagamentoTabelaIrrfEventos->contains($fkFolhapagamentoTabelaIrrfEvento)) {
            $fkFolhapagamentoTabelaIrrfEvento->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoTabelaIrrfEventos->add($fkFolhapagamentoTabelaIrrfEvento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTabelaIrrfEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento $fkFolhapagamentoTabelaIrrfEvento
     */
    public function removeFkFolhapagamentoTabelaIrrfEventos(\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento $fkFolhapagamentoTabelaIrrfEvento)
    {
        $this->fkFolhapagamentoTabelaIrrfEventos->removeElement($fkFolhapagamentoTabelaIrrfEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTabelaIrrfEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento
     */
    public function getFkFolhapagamentoTabelaIrrfEventos()
    {
        return $this->fkFolhapagamentoTabelaIrrfEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoRegistroEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento $fkFolhapagamentoRegistroEvento
     * @return Evento
     */
    public function addFkFolhapagamentoRegistroEventos(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento $fkFolhapagamentoRegistroEvento)
    {
        if (false === $this->fkFolhapagamentoRegistroEventos->contains($fkFolhapagamentoRegistroEvento)) {
            $fkFolhapagamentoRegistroEvento->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoRegistroEventos->add($fkFolhapagamentoRegistroEvento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoRegistroEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento $fkFolhapagamentoRegistroEvento
     */
    public function removeFkFolhapagamentoRegistroEventos(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento $fkFolhapagamentoRegistroEvento)
    {
        $this->fkFolhapagamentoRegistroEventos->removeElement($fkFolhapagamentoRegistroEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoRegistroEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento
     */
    public function getFkFolhapagamentoRegistroEventos()
    {
        return $this->fkFolhapagamentoRegistroEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcemgEntidadeRemuneracao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRemuneracao $fkFolhapagamentoTcemgEntidadeRemuneracao
     * @return Evento
     */
    public function addFkFolhapagamentoTcemgEntidadeRemuneracoes(\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRemuneracao $fkFolhapagamentoTcemgEntidadeRemuneracao)
    {
        if (false === $this->fkFolhapagamentoTcemgEntidadeRemuneracoes->contains($fkFolhapagamentoTcemgEntidadeRemuneracao)) {
            $fkFolhapagamentoTcemgEntidadeRemuneracao->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoTcemgEntidadeRemuneracoes->add($fkFolhapagamentoTcemgEntidadeRemuneracao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcemgEntidadeRemuneracao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRemuneracao $fkFolhapagamentoTcemgEntidadeRemuneracao
     */
    public function removeFkFolhapagamentoTcemgEntidadeRemuneracoes(\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRemuneracao $fkFolhapagamentoTcemgEntidadeRemuneracao)
    {
        $this->fkFolhapagamentoTcemgEntidadeRemuneracoes->removeElement($fkFolhapagamentoTcemgEntidadeRemuneracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcemgEntidadeRemuneracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRemuneracao
     */
    public function getFkFolhapagamentoTcemgEntidadeRemuneracoes()
    {
        return $this->fkFolhapagamentoTcemgEntidadeRemuneracoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoRegistroEventoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar $fkFolhapagamentoRegistroEventoComplementar
     * @return Evento
     */
    public function addFkFolhapagamentoRegistroEventoComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar $fkFolhapagamentoRegistroEventoComplementar)
    {
        if (false === $this->fkFolhapagamentoRegistroEventoComplementares->contains($fkFolhapagamentoRegistroEventoComplementar)) {
            $fkFolhapagamentoRegistroEventoComplementar->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoRegistroEventoComplementares->add($fkFolhapagamentoRegistroEventoComplementar);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoRegistroEventoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar $fkFolhapagamentoRegistroEventoComplementar
     */
    public function removeFkFolhapagamentoRegistroEventoComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar $fkFolhapagamentoRegistroEventoComplementar)
    {
        $this->fkFolhapagamentoRegistroEventoComplementares->removeElement($fkFolhapagamentoRegistroEventoComplementar);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoRegistroEventoComplementares
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar
     */
    public function getFkFolhapagamentoRegistroEventoComplementares()
    {
        return $this->fkFolhapagamentoRegistroEventoComplementares;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaEmprestimoConsignado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado $fkFolhapagamentoTcmbaEmprestimoConsignado
     * @return Evento
     */
    public function addFkFolhapagamentoTcmbaEmprestimoConsignados(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado $fkFolhapagamentoTcmbaEmprestimoConsignado)
    {
        if (false === $this->fkFolhapagamentoTcmbaEmprestimoConsignados->contains($fkFolhapagamentoTcmbaEmprestimoConsignado)) {
            $fkFolhapagamentoTcmbaEmprestimoConsignado->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoTcmbaEmprestimoConsignados->add($fkFolhapagamentoTcmbaEmprestimoConsignado);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaEmprestimoConsignado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado $fkFolhapagamentoTcmbaEmprestimoConsignado
     */
    public function removeFkFolhapagamentoTcmbaEmprestimoConsignados(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado $fkFolhapagamentoTcmbaEmprestimoConsignado)
    {
        $this->fkFolhapagamentoTcmbaEmprestimoConsignados->removeElement($fkFolhapagamentoTcmbaEmprestimoConsignado);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaEmprestimoConsignados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado
     */
    public function getFkFolhapagamentoTcmbaEmprestimoConsignados()
    {
        return $this->fkFolhapagamentoTcmbaEmprestimoConsignados;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaGratificacaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaGratificacaoFuncao $fkFolhapagamentoTcmbaGratificacaoFuncao
     * @return Evento
     */
    public function addFkFolhapagamentoTcmbaGratificacaoFuncoes(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaGratificacaoFuncao $fkFolhapagamentoTcmbaGratificacaoFuncao)
    {
        if (false === $this->fkFolhapagamentoTcmbaGratificacaoFuncoes->contains($fkFolhapagamentoTcmbaGratificacaoFuncao)) {
            $fkFolhapagamentoTcmbaGratificacaoFuncao->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoTcmbaGratificacaoFuncoes->add($fkFolhapagamentoTcmbaGratificacaoFuncao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaGratificacaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaGratificacaoFuncao $fkFolhapagamentoTcmbaGratificacaoFuncao
     */
    public function removeFkFolhapagamentoTcmbaGratificacaoFuncoes(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaGratificacaoFuncao $fkFolhapagamentoTcmbaGratificacaoFuncao)
    {
        $this->fkFolhapagamentoTcmbaGratificacaoFuncoes->removeElement($fkFolhapagamentoTcmbaGratificacaoFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaGratificacaoFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaGratificacaoFuncao
     */
    public function getFkFolhapagamentoTcmbaGratificacaoFuncoes()
    {
        return $this->fkFolhapagamentoTcmbaGratificacaoFuncoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaPlanoSaude
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaPlanoSaude $fkFolhapagamentoTcmbaPlanoSaude
     * @return Evento
     */
    public function addFkFolhapagamentoTcmbaPlanoSaudes(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaPlanoSaude $fkFolhapagamentoTcmbaPlanoSaude)
    {
        if (false === $this->fkFolhapagamentoTcmbaPlanoSaudes->contains($fkFolhapagamentoTcmbaPlanoSaude)) {
            $fkFolhapagamentoTcmbaPlanoSaude->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoTcmbaPlanoSaudes->add($fkFolhapagamentoTcmbaPlanoSaude);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaPlanoSaude
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaPlanoSaude $fkFolhapagamentoTcmbaPlanoSaude
     */
    public function removeFkFolhapagamentoTcmbaPlanoSaudes(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaPlanoSaude $fkFolhapagamentoTcmbaPlanoSaude)
    {
        $this->fkFolhapagamentoTcmbaPlanoSaudes->removeElement($fkFolhapagamentoTcmbaPlanoSaude);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaPlanoSaudes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaPlanoSaude
     */
    public function getFkFolhapagamentoTcmbaPlanoSaudes()
    {
        return $this->fkFolhapagamentoTcmbaPlanoSaudes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaSalarioDescontos
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioDescontos $fkFolhapagamentoTcmbaSalarioDescontos
     * @return Evento
     */
    public function addFkFolhapagamentoTcmbaSalarioDescontos(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioDescontos $fkFolhapagamentoTcmbaSalarioDescontos)
    {
        if (false === $this->fkFolhapagamentoTcmbaSalarioDescontos->contains($fkFolhapagamentoTcmbaSalarioDescontos)) {
            $fkFolhapagamentoTcmbaSalarioDescontos->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoTcmbaSalarioDescontos->add($fkFolhapagamentoTcmbaSalarioDescontos);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaSalarioDescontos
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioDescontos $fkFolhapagamentoTcmbaSalarioDescontos
     */
    public function removeFkFolhapagamentoTcmbaSalarioDescontos(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioDescontos $fkFolhapagamentoTcmbaSalarioDescontos)
    {
        $this->fkFolhapagamentoTcmbaSalarioDescontos->removeElement($fkFolhapagamentoTcmbaSalarioDescontos);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaSalarioDescontos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioDescontos
     */
    public function getFkFolhapagamentoTcmbaSalarioDescontos()
    {
        return $this->fkFolhapagamentoTcmbaSalarioDescontos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaSalarioFamilia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioFamilia $fkFolhapagamentoTcmbaSalarioFamilia
     * @return Evento
     */
    public function addFkFolhapagamentoTcmbaSalarioFamilias(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioFamilia $fkFolhapagamentoTcmbaSalarioFamilia)
    {
        if (false === $this->fkFolhapagamentoTcmbaSalarioFamilias->contains($fkFolhapagamentoTcmbaSalarioFamilia)) {
            $fkFolhapagamentoTcmbaSalarioFamilia->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoTcmbaSalarioFamilias->add($fkFolhapagamentoTcmbaSalarioFamilia);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaSalarioFamilia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioFamilia $fkFolhapagamentoTcmbaSalarioFamilia
     */
    public function removeFkFolhapagamentoTcmbaSalarioFamilias(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioFamilia $fkFolhapagamentoTcmbaSalarioFamilia)
    {
        $this->fkFolhapagamentoTcmbaSalarioFamilias->removeElement($fkFolhapagamentoTcmbaSalarioFamilia);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaSalarioFamilias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioFamilia
     */
    public function getFkFolhapagamentoTcmbaSalarioFamilias()
    {
        return $this->fkFolhapagamentoTcmbaSalarioFamilias;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaSalarioHorasExtras
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioHorasExtras $fkFolhapagamentoTcmbaSalarioHorasExtras
     * @return Evento
     */
    public function addFkFolhapagamentoTcmbaSalarioHorasExtras(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioHorasExtras $fkFolhapagamentoTcmbaSalarioHorasExtras)
    {
        if (false === $this->fkFolhapagamentoTcmbaSalarioHorasExtras->contains($fkFolhapagamentoTcmbaSalarioHorasExtras)) {
            $fkFolhapagamentoTcmbaSalarioHorasExtras->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoTcmbaSalarioHorasExtras->add($fkFolhapagamentoTcmbaSalarioHorasExtras);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaSalarioHorasExtras
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioHorasExtras $fkFolhapagamentoTcmbaSalarioHorasExtras
     */
    public function removeFkFolhapagamentoTcmbaSalarioHorasExtras(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioHorasExtras $fkFolhapagamentoTcmbaSalarioHorasExtras)
    {
        $this->fkFolhapagamentoTcmbaSalarioHorasExtras->removeElement($fkFolhapagamentoTcmbaSalarioHorasExtras);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaSalarioHorasExtras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioHorasExtras
     */
    public function getFkFolhapagamentoTcmbaSalarioHorasExtras()
    {
        return $this->fkFolhapagamentoTcmbaSalarioHorasExtras;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaVantagensSalariais
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaVantagensSalariais $fkFolhapagamentoTcmbaVantagensSalariais
     * @return Evento
     */
    public function addFkFolhapagamentoTcmbaVantagensSalariais(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaVantagensSalariais $fkFolhapagamentoTcmbaVantagensSalariais)
    {
        if (false === $this->fkFolhapagamentoTcmbaVantagensSalariais->contains($fkFolhapagamentoTcmbaVantagensSalariais)) {
            $fkFolhapagamentoTcmbaVantagensSalariais->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoTcmbaVantagensSalariais->add($fkFolhapagamentoTcmbaVantagensSalariais);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaVantagensSalariais
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaVantagensSalariais $fkFolhapagamentoTcmbaVantagensSalariais
     */
    public function removeFkFolhapagamentoTcmbaVantagensSalariais(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaVantagensSalariais $fkFolhapagamentoTcmbaVantagensSalariais)
    {
        $this->fkFolhapagamentoTcmbaVantagensSalariais->removeElement($fkFolhapagamentoTcmbaVantagensSalariais);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaVantagensSalariais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaVantagensSalariais
     */
    public function getFkFolhapagamentoTcmbaVantagensSalariais()
    {
        return $this->fkFolhapagamentoTcmbaVantagensSalariais;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTotaisFolhaEventos
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TotaisFolhaEventos $fkFolhapagamentoTotaisFolhaEventos
     * @return Evento
     */
    public function addFkFolhapagamentoTotaisFolhaEventos(\Urbem\CoreBundle\Entity\Folhapagamento\TotaisFolhaEventos $fkFolhapagamentoTotaisFolhaEventos)
    {
        if (false === $this->fkFolhapagamentoTotaisFolhaEventos->contains($fkFolhapagamentoTotaisFolhaEventos)) {
            $fkFolhapagamentoTotaisFolhaEventos->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoTotaisFolhaEventos->add($fkFolhapagamentoTotaisFolhaEventos);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTotaisFolhaEventos
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TotaisFolhaEventos $fkFolhapagamentoTotaisFolhaEventos
     */
    public function removeFkFolhapagamentoTotaisFolhaEventos(\Urbem\CoreBundle\Entity\Folhapagamento\TotaisFolhaEventos $fkFolhapagamentoTotaisFolhaEventos)
    {
        $this->fkFolhapagamentoTotaisFolhaEventos->removeElement($fkFolhapagamentoTotaisFolhaEventos);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTotaisFolhaEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TotaisFolhaEventos
     */
    public function getFkFolhapagamentoTotaisFolhaEventos()
    {
        return $this->fkFolhapagamentoTotaisFolhaEventos;
    }

    /**
     * OneToMany (owning side)
     * Add ImaCagedEvento
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CagedEvento $fkImaCagedEvento
     * @return Evento
     */
    public function addFkImaCagedEventos(\Urbem\CoreBundle\Entity\Ima\CagedEvento $fkImaCagedEvento)
    {
        if (false === $this->fkImaCagedEventos->contains($fkImaCagedEvento)) {
            $fkImaCagedEvento->setFkFolhapagamentoEvento($this);
            $this->fkImaCagedEventos->add($fkImaCagedEvento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaCagedEvento
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CagedEvento $fkImaCagedEvento
     */
    public function removeFkImaCagedEventos(\Urbem\CoreBundle\Entity\Ima\CagedEvento $fkImaCagedEvento)
    {
        $this->fkImaCagedEventos->removeElement($fkImaCagedEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaCagedEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\CagedEvento
     */
    public function getFkImaCagedEventos()
    {
        return $this->fkImaCagedEventos;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBanrisulEmprestimo
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulEmprestimo $fkImaConfiguracaoBanrisulEmprestimo
     * @return Evento
     */
    public function addFkImaConfiguracaoBanrisulEmprestimos(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulEmprestimo $fkImaConfiguracaoBanrisulEmprestimo)
    {
        if (false === $this->fkImaConfiguracaoBanrisulEmprestimos->contains($fkImaConfiguracaoBanrisulEmprestimo)) {
            $fkImaConfiguracaoBanrisulEmprestimo->setFkFolhapagamentoEvento($this);
            $this->fkImaConfiguracaoBanrisulEmprestimos->add($fkImaConfiguracaoBanrisulEmprestimo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBanrisulEmprestimo
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulEmprestimo $fkImaConfiguracaoBanrisulEmprestimo
     */
    public function removeFkImaConfiguracaoBanrisulEmprestimos(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulEmprestimo $fkImaConfiguracaoBanrisulEmprestimo)
    {
        $this->fkImaConfiguracaoBanrisulEmprestimos->removeElement($fkImaConfiguracaoBanrisulEmprestimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBanrisulEmprestimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulEmprestimo
     */
    public function getFkImaConfiguracaoBanrisulEmprestimos()
    {
        return $this->fkImaConfiguracaoBanrisulEmprestimos;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoDirfPlano
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano $fkImaConfiguracaoDirfPlano
     * @return Evento
     */
    public function addFkImaConfiguracaoDirfPlanos(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano $fkImaConfiguracaoDirfPlano)
    {
        if (false === $this->fkImaConfiguracaoDirfPlanos->contains($fkImaConfiguracaoDirfPlano)) {
            $fkImaConfiguracaoDirfPlano->setFkFolhapagamentoEvento($this);
            $this->fkImaConfiguracaoDirfPlanos->add($fkImaConfiguracaoDirfPlano);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoDirfPlano
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano $fkImaConfiguracaoDirfPlano
     */
    public function removeFkImaConfiguracaoDirfPlanos(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano $fkImaConfiguracaoDirfPlano)
    {
        $this->fkImaConfiguracaoDirfPlanos->removeElement($fkImaConfiguracaoDirfPlano);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoDirfPlanos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano
     */
    public function getFkImaConfiguracaoDirfPlanos()
    {
        return $this->fkImaConfiguracaoDirfPlanos;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoPasep
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoPasep $fkImaConfiguracaoPasep
     * @return Evento
     */
    public function addFkImaConfiguracaoPaseps(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoPasep $fkImaConfiguracaoPasep)
    {
        if (false === $this->fkImaConfiguracaoPaseps->contains($fkImaConfiguracaoPasep)) {
            $fkImaConfiguracaoPasep->setFkFolhapagamentoEvento($this);
            $this->fkImaConfiguracaoPaseps->add($fkImaConfiguracaoPasep);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoPasep
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoPasep $fkImaConfiguracaoPasep
     */
    public function removeFkImaConfiguracaoPaseps(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoPasep $fkImaConfiguracaoPasep)
    {
        $this->fkImaConfiguracaoPaseps->removeElement($fkImaConfiguracaoPasep);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoPaseps
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoPasep
     */
    public function getFkImaConfiguracaoPaseps()
    {
        return $this->fkImaConfiguracaoPaseps;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoDirf
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf
     * @return Evento
     */
    public function addFkImaConfiguracaoDirfs(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf)
    {
        if (false === $this->fkImaConfiguracaoDirfs->contains($fkImaConfiguracaoDirf)) {
            $fkImaConfiguracaoDirf->setFkFolhapagamentoEvento($this);
            $this->fkImaConfiguracaoDirfs->add($fkImaConfiguracaoDirf);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoDirf
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf
     */
    public function removeFkImaConfiguracaoDirfs(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf)
    {
        $this->fkImaConfiguracaoDirfs->removeElement($fkImaConfiguracaoDirf);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoDirfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf
     */
    public function getFkImaConfiguracaoDirfs()
    {
        return $this->fkImaConfiguracaoDirfs;
    }

    /**
     * OneToMany (owning side)
     * Add ImaEventoHorasExtras
     *
     * @param \Urbem\CoreBundle\Entity\Ima\EventoHorasExtras $fkImaEventoHorasExtras
     * @return Evento
     */
    public function addFkImaEventoHorasExtras(\Urbem\CoreBundle\Entity\Ima\EventoHorasExtras $fkImaEventoHorasExtras)
    {
        if (false === $this->fkImaEventoHorasExtras->contains($fkImaEventoHorasExtras)) {
            $fkImaEventoHorasExtras->setFkFolhapagamentoEvento($this);
            $this->fkImaEventoHorasExtras->add($fkImaEventoHorasExtras);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaEventoHorasExtras
     *
     * @param \Urbem\CoreBundle\Entity\Ima\EventoHorasExtras $fkImaEventoHorasExtras
     */
    public function removeFkImaEventoHorasExtras(\Urbem\CoreBundle\Entity\Ima\EventoHorasExtras $fkImaEventoHorasExtras)
    {
        $this->fkImaEventoHorasExtras->removeElement($fkImaEventoHorasExtras);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaEventoHorasExtras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\EventoHorasExtras
     */
    public function getFkImaEventoHorasExtras()
    {
        return $this->fkImaEventoHorasExtras;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoEventoProporcional
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoEventoProporcional $fkPessoalAssentamentoEventoProporcional
     * @return Evento
     */
    public function addFkPessoalAssentamentoEventoProporcionais(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoEventoProporcional $fkPessoalAssentamentoEventoProporcional)
    {
        if (false === $this->fkPessoalAssentamentoEventoProporcionais->contains($fkPessoalAssentamentoEventoProporcional)) {
            $fkPessoalAssentamentoEventoProporcional->setFkFolhapagamentoEvento($this);
            $this->fkPessoalAssentamentoEventoProporcionais->add($fkPessoalAssentamentoEventoProporcional);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoEventoProporcional
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoEventoProporcional $fkPessoalAssentamentoEventoProporcional
     */
    public function removeFkPessoalAssentamentoEventoProporcionais(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoEventoProporcional $fkPessoalAssentamentoEventoProporcional)
    {
        $this->fkPessoalAssentamentoEventoProporcionais->removeElement($fkPessoalAssentamentoEventoProporcional);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoEventoProporcionais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoEventoProporcional
     */
    public function getFkPessoalAssentamentoEventoProporcionais()
    {
        return $this->fkPessoalAssentamentoEventoProporcionais;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoEvento $fkPessoalAssentamentoEvento
     * @return Evento
     */
    public function addFkPessoalAssentamentoEventos(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoEvento $fkPessoalAssentamentoEvento)
    {
        if (false === $this->fkPessoalAssentamentoEventos->contains($fkPessoalAssentamentoEvento)) {
            $fkPessoalAssentamentoEvento->setFkFolhapagamentoEvento($this);
            $this->fkPessoalAssentamentoEventos->add($fkPessoalAssentamentoEvento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoEvento $fkPessoalAssentamentoEvento
     */
    public function removeFkPessoalAssentamentoEventos(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoEvento $fkPessoalAssentamentoEvento)
    {
        $this->fkPessoalAssentamentoEventos->removeElement($fkPessoalAssentamentoEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoEvento
     */
    public function getFkPessoalAssentamentoEventos()
    {
        return $this->fkPessoalAssentamentoEventos;
    }

    /**
     * OneToMany (owning side)
     * Add PontoExportacaoPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ExportacaoPonto $fkPontoExportacaoPonto
     * @return Evento
     */
    public function addFkPontoExportacaoPontos(\Urbem\CoreBundle\Entity\Ponto\ExportacaoPonto $fkPontoExportacaoPonto)
    {
        if (false === $this->fkPontoExportacaoPontos->contains($fkPontoExportacaoPonto)) {
            $fkPontoExportacaoPonto->setFkFolhapagamentoEvento($this);
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
     * Add TcemgTetoRemuneratorio
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorio $fkTcemgTetoRemuneratorio
     * @return Evento
     */
    public function addFkTcemgTetoRemuneratorios(\Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorio $fkTcemgTetoRemuneratorio)
    {
        if (false === $this->fkTcemgTetoRemuneratorios->contains($fkTcemgTetoRemuneratorio)) {
            $fkTcemgTetoRemuneratorio->setFkFolhapagamentoEvento($this);
            $this->fkTcemgTetoRemuneratorios->add($fkTcemgTetoRemuneratorio);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgTetoRemuneratorio
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorio $fkTcemgTetoRemuneratorio
     */
    public function removeFkTcemgTetoRemuneratorios(\Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorio $fkTcemgTetoRemuneratorio)
    {
        $this->fkTcemgTetoRemuneratorios->removeElement($fkTcemgTetoRemuneratorio);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgTetoRemuneratorios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorio
     */
    public function getFkTcemgTetoRemuneratorios()
    {
        return $this->fkTcemgTetoRemuneratorios;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTabelaIrrfComprovanteRendimento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfComprovanteRendimento $fkFolhapagamentoTabelaIrrfComprovanteRendimento
     * @return Evento
     */
    public function addFkFolhapagamentoTabelaIrrfComprovanteRendimentos(\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfComprovanteRendimento $fkFolhapagamentoTabelaIrrfComprovanteRendimento)
    {
        if (false === $this->fkFolhapagamentoTabelaIrrfComprovanteRendimentos->contains($fkFolhapagamentoTabelaIrrfComprovanteRendimento)) {
            $fkFolhapagamentoTabelaIrrfComprovanteRendimento->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoTabelaIrrfComprovanteRendimentos->add($fkFolhapagamentoTabelaIrrfComprovanteRendimento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTabelaIrrfComprovanteRendimento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfComprovanteRendimento $fkFolhapagamentoTabelaIrrfComprovanteRendimento
     */
    public function removeFkFolhapagamentoTabelaIrrfComprovanteRendimentos(\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfComprovanteRendimento $fkFolhapagamentoTabelaIrrfComprovanteRendimento)
    {
        $this->fkFolhapagamentoTabelaIrrfComprovanteRendimentos->removeElement($fkFolhapagamentoTabelaIrrfComprovanteRendimento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTabelaIrrfComprovanteRendimentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfComprovanteRendimento
     */
    public function getFkFolhapagamentoTabelaIrrfComprovanteRendimentos()
    {
        return $this->fkFolhapagamentoTabelaIrrfComprovanteRendimentos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoBasesEventoCriado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\BasesEventoCriado $fkFolhapagamentoBasesEventoCriado
     * @return Evento
     */
    public function addFkFolhapagamentoBasesEventoCriados(\Urbem\CoreBundle\Entity\Folhapagamento\BasesEventoCriado $fkFolhapagamentoBasesEventoCriado)
    {
        if (false === $this->fkFolhapagamentoBasesEventoCriados->contains($fkFolhapagamentoBasesEventoCriado)) {
            $fkFolhapagamentoBasesEventoCriado->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoBasesEventoCriados->add($fkFolhapagamentoBasesEventoCriado);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoBasesEventoCriado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\BasesEventoCriado $fkFolhapagamentoBasesEventoCriado
     */
    public function removeFkFolhapagamentoBasesEventoCriados(\Urbem\CoreBundle\Entity\Folhapagamento\BasesEventoCriado $fkFolhapagamentoBasesEventoCriado)
    {
        $this->fkFolhapagamentoBasesEventoCriados->removeElement($fkFolhapagamentoBasesEventoCriado);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoBasesEventoCriados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\BasesEventoCriado
     */
    public function getFkFolhapagamentoBasesEventoCriados()
    {
        return $this->fkFolhapagamentoBasesEventoCriados;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoRegistroEventoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias $fkFolhapagamentoRegistroEventoFerias
     * @return Evento
     */
    public function addFkFolhapagamentoRegistroEventoFerias(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias $fkFolhapagamentoRegistroEventoFerias)
    {
        if (false === $this->fkFolhapagamentoRegistroEventoFerias->contains($fkFolhapagamentoRegistroEventoFerias)) {
            $fkFolhapagamentoRegistroEventoFerias->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoRegistroEventoFerias->add($fkFolhapagamentoRegistroEventoFerias);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoRegistroEventoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias $fkFolhapagamentoRegistroEventoFerias
     */
    public function removeFkFolhapagamentoRegistroEventoFerias(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias $fkFolhapagamentoRegistroEventoFerias)
    {
        $this->fkFolhapagamentoRegistroEventoFerias->removeElement($fkFolhapagamentoRegistroEventoFerias);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoRegistroEventoFerias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias
     */
    public function getFkFolhapagamentoRegistroEventoFerias()
    {
        return $this->fkFolhapagamentoRegistroEventoFerias;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoSalarioFamiliaEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento $fkFolhapagamentoSalarioFamiliaEvento
     * @return Evento
     */
    public function addFkFolhapagamentoSalarioFamiliaEventos(\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento $fkFolhapagamentoSalarioFamiliaEvento)
    {
        if (false === $this->fkFolhapagamentoSalarioFamiliaEventos->contains($fkFolhapagamentoSalarioFamiliaEvento)) {
            $fkFolhapagamentoSalarioFamiliaEvento->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoSalarioFamiliaEventos->add($fkFolhapagamentoSalarioFamiliaEvento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoSalarioFamiliaEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento $fkFolhapagamentoSalarioFamiliaEvento
     */
    public function removeFkFolhapagamentoSalarioFamiliaEventos(\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento $fkFolhapagamentoSalarioFamiliaEvento)
    {
        $this->fkFolhapagamentoSalarioFamiliaEventos->removeElement($fkFolhapagamentoSalarioFamiliaEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoSalarioFamiliaEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento
     */
    public function getFkFolhapagamentoSalarioFamiliaEventos()
    {
        return $this->fkFolhapagamentoSalarioFamiliaEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaSalarioBase
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioBase $fkFolhapagamentoTcmbaSalarioBase
     * @return Evento
     */
    public function addFkFolhapagamentoTcmbaSalarioBases(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioBase $fkFolhapagamentoTcmbaSalarioBase)
    {
        if (false === $this->fkFolhapagamentoTcmbaSalarioBases->contains($fkFolhapagamentoTcmbaSalarioBase)) {
            $fkFolhapagamentoTcmbaSalarioBase->setFkFolhapagamentoEvento($this);
            $this->fkFolhapagamentoTcmbaSalarioBases->add($fkFolhapagamentoTcmbaSalarioBase);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaSalarioBase
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioBase $fkFolhapagamentoTcmbaSalarioBase
     */
    public function removeFkFolhapagamentoTcmbaSalarioBases(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioBase $fkFolhapagamentoTcmbaSalarioBase)
    {
        $this->fkFolhapagamentoTcmbaSalarioBases->removeElement($fkFolhapagamentoTcmbaSalarioBase);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaSalarioBases
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaSalarioBase
     */
    public function getFkFolhapagamentoTcmbaSalarioBases()
    {
        return $this->fkFolhapagamentoTcmbaSalarioBases;
    }

    /**
     * OneToMany (owning side)
     * Add ImaEventoComposicaoRemuneracao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\EventoComposicaoRemuneracao $fkImaEventoComposicaoRemuneracao
     * @return Evento
     */
    public function addFkImaEventoComposicaoRemuneracoes(\Urbem\CoreBundle\Entity\Ima\EventoComposicaoRemuneracao $fkImaEventoComposicaoRemuneracao)
    {
        if (false === $this->fkImaEventoComposicaoRemuneracoes->contains($fkImaEventoComposicaoRemuneracao)) {
            $fkImaEventoComposicaoRemuneracao->setFkFolhapagamentoEvento($this);
            $this->fkImaEventoComposicaoRemuneracoes->add($fkImaEventoComposicaoRemuneracao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaEventoComposicaoRemuneracao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\EventoComposicaoRemuneracao $fkImaEventoComposicaoRemuneracao
     */
    public function removeFkImaEventoComposicaoRemuneracoes(\Urbem\CoreBundle\Entity\Ima\EventoComposicaoRemuneracao $fkImaEventoComposicaoRemuneracao)
    {
        $this->fkImaEventoComposicaoRemuneracoes->removeElement($fkImaEventoComposicaoRemuneracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaEventoComposicaoRemuneracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\EventoComposicaoRemuneracao
     */
    public function getFkImaEventoComposicaoRemuneracoes()
    {
        return $this->fkImaEventoComposicaoRemuneracoes;
    }

    /**
     * OneToMany (owning side)
     * Add PontoDadosExportacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DadosExportacao $fkPontoDadosExportacao
     * @return Evento
     */
    public function addFkPontoDadosExportacoes(\Urbem\CoreBundle\Entity\Ponto\DadosExportacao $fkPontoDadosExportacao)
    {
        if (false === $this->fkPontoDadosExportacoes->contains($fkPontoDadosExportacao)) {
            $fkPontoDadosExportacao->setFkFolhapagamentoEvento($this);
            $this->fkPontoDadosExportacoes->add($fkPontoDadosExportacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoDadosExportacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DadosExportacao $fkPontoDadosExportacao
     */
    public function removeFkPontoDadosExportacoes(\Urbem\CoreBundle\Entity\Ponto\DadosExportacao $fkPontoDadosExportacao)
    {
        $this->fkPontoDadosExportacoes->removeElement($fkPontoDadosExportacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoDadosExportacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\DadosExportacao
     */
    public function getFkPontoDadosExportacoes()
    {
        return $this->fkPontoDadosExportacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoVerbaRescisoriaMte
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\VerbaRescisoriaMte $fkFolhapagamentoVerbaRescisoriaMte
     * @return Evento
     */
    public function setFkFolhapagamentoVerbaRescisoriaMte(\Urbem\CoreBundle\Entity\Folhapagamento\VerbaRescisoriaMte $fkFolhapagamentoVerbaRescisoriaMte)
    {
        $this->codVerba = $fkFolhapagamentoVerbaRescisoriaMte->getCodVerba();
        $this->fkFolhapagamentoVerbaRescisoriaMte = $fkFolhapagamentoVerbaRescisoriaMte;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoVerbaRescisoriaMte
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\VerbaRescisoriaMte
     */
    public function getFkFolhapagamentoVerbaRescisoriaMte()
    {
        return $this->fkFolhapagamentoVerbaRescisoriaMte;
    }

    /**
     * OneToOne (inverse side)
     * Set ImaConsignacaoBanrisulRemuneracao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConsignacaoBanrisulRemuneracao $fkImaConsignacaoBanrisulRemuneracao
     * @return Evento
     */
    public function setFkImaConsignacaoBanrisulRemuneracao(\Urbem\CoreBundle\Entity\Ima\ConsignacaoBanrisulRemuneracao $fkImaConsignacaoBanrisulRemuneracao)
    {
        $fkImaConsignacaoBanrisulRemuneracao->setFkFolhapagamentoEvento($this);
        $this->fkImaConsignacaoBanrisulRemuneracao = $fkImaConsignacaoBanrisulRemuneracao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImaConsignacaoBanrisulRemuneracao
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConsignacaoBanrisulRemuneracao
     */
    public function getFkImaConsignacaoBanrisulRemuneracao()
    {
        return $this->fkImaConsignacaoBanrisulRemuneracao;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalArquivoCodigoVantagensDescontos
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ArquivoCodigoVantagensDescontos $fkPessoalArquivoCodigoVantagensDescontos
     * @return Evento
     */
    public function setFkPessoalArquivoCodigoVantagensDescontos(\Urbem\CoreBundle\Entity\Pessoal\ArquivoCodigoVantagensDescontos $fkPessoalArquivoCodigoVantagensDescontos)
    {
        $fkPessoalArquivoCodigoVantagensDescontos->setFkFolhapagamentoEvento($this);
        $this->fkPessoalArquivoCodigoVantagensDescontos = $fkPessoalArquivoCodigoVantagensDescontos;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalArquivoCodigoVantagensDescontos
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ArquivoCodigoVantagensDescontos
     */
    public function getFkPessoalArquivoCodigoVantagensDescontos()
    {
        return $this->fkPessoalArquivoCodigoVantagensDescontos;
    }

    /**
     * OneToOne (inverse side)
     * Set ImaConsignacaoBanrisulLiquido
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConsignacaoBanrisulLiquido $fkImaConsignacaoBanrisulLiquido
     * @return Evento
     */
    public function setFkImaConsignacaoBanrisulLiquido(\Urbem\CoreBundle\Entity\Ima\ConsignacaoBanrisulLiquido $fkImaConsignacaoBanrisulLiquido)
    {
        $fkImaConsignacaoBanrisulLiquido->setFkFolhapagamentoEvento($this);
        $this->fkImaConsignacaoBanrisulLiquido = $fkImaConsignacaoBanrisulLiquido;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImaConsignacaoBanrisulLiquido
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConsignacaoBanrisulLiquido
     */
    public function getFkImaConsignacaoBanrisulLiquido()
    {
        return $this->fkImaConsignacaoBanrisulLiquido;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codigo, $this->descricao);
    }
}
