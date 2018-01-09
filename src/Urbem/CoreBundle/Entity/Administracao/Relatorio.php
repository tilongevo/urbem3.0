<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Relatorio
 */
class Relatorio
{
    const FINANCEIRO_RELACAO_RECEITA_EXTRA = 2;
    const FINANCEIRO_RAZAO = 3;
    const DEMOSTRATIVO_FLUXO_CAIXA = 13;
    const FINANCEIRO_RELACAO_DESPESA_EXTRA = 4;
    const FINANCEIRO_MAPA_RECURSO = 5;
    const ADMINISTRACAO_USUARIO = 5;
    const FINANCEIRO_DESPESA_FONTE_RECURSO = 6;
    const FINANCEIRO_CONFIGURACAO_LANCAMENTO_DESPESA = 7;
    const FINANCEIRO_CONFIGURACAO_LANCAMENTO_RECEITA = 8;
    const FINANCEIRO_BALANCO_PATRIMONIAL = 12;
    const FINANCEIRO_CONSISTENCIA_PCASP = 16;
    const FINANCEIRO_BALANCO_ORCAMENTARIO = 17;
    const RECURSOS_HUMANOS_FOLHAPAGAMENTO_RECIBO_FERIAS = 22;
    const RECURSOS_HMANOS_PESSOAL_CARGOS = 1;
    const RECURSOS_HUMANOS_FOLHAPAGAMENTO_BANCARIOPENSAOJUDICIAL = 2;
    const RECURSOS_HUMANOS_FOLHAPAGAMENTO_CONTRACHEQUE = 29;
    const RECURSOS_HUMANOS_FOLHAPAGAMENTO_FICHAFINANCEIRA = 24;
    const RECURSOS_HUMANOS_FOLHAPAGAMENTO_CUSTOMIZAVELEVENTOS = 8;
    const RECURSOS_HUMANOS_FOLHAPAGAMENTO_CONTRIBUICAOPREVIDENCIARIA = 7;
    const RECURSOS_HUMANOS_FOLHAPAGAMENTO_CONTRIBUICAOPREVIDENCIARIA_AGRUPAR = 20;
    const RECURSOS_HUMANOS_IMA_MANUTENCAO_CONVENIADO_IPERS = 13;
    const TRIBUTARIA_ARRECADACAO_RELATORIO_DESONERADOS = 6;
    const DEMONST_MUTACOES_PATRIMONIO_LIQUIDO = 11;
    const TRIBUTARIA_DIVIDA_ATIVA_REMISSAO_AUTOMATICA = 3;
    const BALANCO_FINANCEIRO = 15;
    const TRIBUTARIA_ARRECADACAO_LISTA_CERTIDOES_EMITIDAS = 5;
    const RECURSOS_HUMANOS_PESSOAL_FERIAS_EMITIR_AVISO_FERIAS = 4;
    const PATRIMONIAL_MOTORISTA = 2;
    const FINANCEIRO_EMPENHO_NOTA_AUTORIZACAO = 9;
    const PATRIMONIAL_VEICULO = 3;

    /**
     * PK
     * @var integer
     */
    private $codGestao;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * PK
     * @var integer
     */
    private $codRelatorio;

    /**
     * @var string
     */
    private $nomRelatorio;

    /**
     * @var string
     */
    private $arquivo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\RelatorioAcao
     */
    private $fkAdministracaoRelatorioAcoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    private $fkAdministracaoModulo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoRelatorioAcoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codGestao
     *
     * @param integer $codGestao
     * @return Relatorio
     */
    public function setCodGestao($codGestao)
    {
        $this->codGestao = $codGestao;
        return $this;
    }

    /**
     * Get codGestao
     *
     * @return integer
     */
    public function getCodGestao()
    {
        return $this->codGestao;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return Relatorio
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set codRelatorio
     *
     * @param integer $codRelatorio
     * @return Relatorio
     */
    public function setCodRelatorio($codRelatorio)
    {
        $this->codRelatorio = $codRelatorio;
        return $this;
    }

    /**
     * Get codRelatorio
     *
     * @return integer
     */
    public function getCodRelatorio()
    {
        return $this->codRelatorio;
    }

    /**
     * Set nomRelatorio
     *
     * @param string $nomRelatorio
     * @return Relatorio
     */
    public function setNomRelatorio($nomRelatorio)
    {
        $this->nomRelatorio = $nomRelatorio;
        return $this;
    }

    /**
     * Get nomRelatorio
     *
     * @return string
     */
    public function getNomRelatorio()
    {
        return $this->nomRelatorio;
    }

    /**
     * Set arquivo
     *
     * @param string $arquivo
     * @return Relatorio
     */
    public function setArquivo($arquivo)
    {
        $this->arquivo = $arquivo;
        return $this;
    }

    /**
     * Get arquivo
     *
     * @return string
     */
    public function getArquivo()
    {
        return $this->arquivo;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoRelatorioAcao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\RelatorioAcao $fkAdministracaoRelatorioAcao
     * @return Relatorio
     */
    public function addFkAdministracaoRelatorioAcoes(\Urbem\CoreBundle\Entity\Administracao\RelatorioAcao $fkAdministracaoRelatorioAcao)
    {
        if (false === $this->fkAdministracaoRelatorioAcoes->contains($fkAdministracaoRelatorioAcao)) {
            $fkAdministracaoRelatorioAcao->setFkAdministracaoRelatorio($this);
            $this->fkAdministracaoRelatorioAcoes->add($fkAdministracaoRelatorioAcao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoRelatorioAcao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\RelatorioAcao $fkAdministracaoRelatorioAcao
     */
    public function removeFkAdministracaoRelatorioAcoes(\Urbem\CoreBundle\Entity\Administracao\RelatorioAcao $fkAdministracaoRelatorioAcao)
    {
        $this->fkAdministracaoRelatorioAcoes->removeElement($fkAdministracaoRelatorioAcao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoRelatorioAcoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\RelatorioAcao
     */
    public function getFkAdministracaoRelatorioAcoes()
    {
        return $this->fkAdministracaoRelatorioAcoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo
     * @return Relatorio
     */
    public function setFkAdministracaoModulo(\Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo)
    {
        $this->codModulo = $fkAdministracaoModulo->getCodModulo();
        $this->fkAdministracaoModulo = $fkAdministracaoModulo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModulo
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    public function getFkAdministracaoModulo()
    {
        return $this->fkAdministracaoModulo;
    }
}
