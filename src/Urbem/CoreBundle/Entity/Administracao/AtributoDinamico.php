<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * AtributoDinamico
 */
class AtributoDinamico
{
    const COD_TIPO_LISTA = 3;
    const COD_TIPO_LISTA_MULTIPLA = 4;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var boolean
     */
    private $naoNulo;

    /**
     * @var string
     */
    private $nomAtributo;

    /**
     * @var string
     */
    private $valorPadrao;

    /**
     * @var string
     */
    private $ajuda;

    /**
     * @var string
     */
    private $mascara;

    /**
     * @var boolean
     */
    private $ativo;

    /**
     * @var boolean
     */
    private $interno;

    /**
     * @var boolean
     */
    private $indexavel;

    /**
     * @var string
     */
    private $codAtributoAnterior;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItemValor
     */
    private $fkAlmoxarifadoAtributoRequisicaoItemValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\AtributoValorPadrao
     */
    private $fkAdministracaoAtributoValorPadroes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\AtributoFuncao
     */
    private $fkAdministracaoAtributoFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\AtributoIntegridade
     */
    private $fkAdministracaoAtributoIntegridades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem
     */
    private $fkAlmoxarifadoAtributoCatalogoItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacao
     */
    private $fkAlmoxarifadoAtributoCatalogoClassificacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoCalendarioValor
     */
    private $fkArrecadacaoAtributoCalendarioValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracao
     */
    private $fkArrecadacaoAtributoDesoneracoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupo
     */
    private $fkArrecadacaoAtributoGrupos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoItbiValor
     */
    private $fkArrecadacaoAtributoItbiValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\VariaveisLayoutCarne
     */
    private $fkArrecadacaoVariaveisLayoutCarnes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\AtributoCandidatoValor
     */
    private $fkConcursoAtributoCandidatoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\AtributoConcursoValor
     */
    private $fkConcursoAtributoConcursoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoElemento
     */
    private $fkEconomicoAtributoElementos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoEmpresaDireitoValor
     */
    private $fkEconomicoAtributoEmpresaDireitoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa
     */
    private $fkEconomicoAtributoTipoLicencaDiversas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AtributoEmpenhoValor
     */
    private $fkEmpenhoAtributoEmpenhoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AtributoLiquidacaoValor
     */
    private $fkEmpenhoAtributoLiquidacaoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\AtributoEstagiarioEstagio
     */
    private $fkEstagioAtributoEstagiarioEstagios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\AtributoEventoValor
     */
    private $fkFolhapagamentoAtributoEventoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\AtributoPadraoValor
     */
    private $fkFolhapagamentoAtributoPadraoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\AtributoPrevidenciaValor
     */
    private $fkFolhapagamentoAtributoPrevidenciaValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributo
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoAtributos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributo
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributos;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpePensionista
     */
    private $fkFolhapagamentoConfiguracaoIpePensionistas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpePensionista
     */
    private $fkFolhapagamentoConfiguracaoIpePensionistas1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoCondominioValor
     */
    private $fkImobiliarioAtributoCondominioValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoFaceQuadraValor
     */
    private $fkImobiliarioAtributoFaceQuadraValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoImovelValor
     */
    private $fkImobiliarioAtributoImovelValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteRuralValor
     */
    private $fkImobiliarioAtributoLoteRuralValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteUrbanoValor
     */
    private $fkImobiliarioAtributoLoteUrbanoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao
     */
    private $fkImobiliarioAtributoTipoEdificacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca
     */
    private $fkImobiliarioAtributoTipoLicencas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTrechoValor
     */
    private $fkImobiliarioAtributoTrechoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\DocumentosAtributos
     */
    private $fkLicitacaoDocumentosAtributos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma
     */
    private $fkNormasAtributoTipoNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo
     */
    private $fkPatrimonioEspecieAtributos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AtributoContratoPensionista
     */
    private $fkPessoalAtributoContratoPensionistas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AtributoCargoValor
     */
    private $fkPessoalAtributoCargoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AtributoContratoServidorValor
     */
    private $fkPessoalAtributoContratoServidorValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoCadEconFaturamentoValor
     */
    private $fkArrecadacaoAtributoCadEconFaturamentoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoImovelVVenalValor
     */
    private $fkArrecadacaoAtributoImovelVVenalValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoCadEconAutonomoValor
     */
    private $fkEconomicoAtributoCadEconAutonomoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoEmpresaFatoValor
     */
    private $fkEconomicoAtributoEmpresaFatoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoConstrucaoOutrosValor
     */
    private $fkImobiliarioAtributoConstrucaoOutrosValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel
     */
    private $fkImobiliarioAtributoNiveis;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Cadastro
     */
    private $fkAdministracaoCadastro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\TipoAtributo
     */
    private $fkAdministracaoTipoAtributo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoAtributoRequisicaoItemValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoAtributoValorPadroes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoAtributoFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoAtributoIntegridades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoAtributoCatalogoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoAtributoCatalogoClassificacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoAtributoCalendarioValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoAtributoDesoneracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoAtributoGrupos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoAtributoItbiValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoVariaveisLayoutCarnes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkConcursoAtributoCandidatoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkConcursoAtributoConcursoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoAtributoElementos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoAtributoEmpresaDireitoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoAtributoTipoLicencaDiversas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoAtributoEmpenhoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoAtributoLiquidacaoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEstagioAtributoEstagiarioEstagios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoAtributoEventoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoAtributoPadraoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoAtributoPrevidenciaValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoAtributos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoIpes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoIpes1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoIpePensionistas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoIpePensionistas1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioAtributoCondominioValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioAtributoFaceQuadraValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioAtributoImovelValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioAtributoLoteRuralValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioAtributoLoteUrbanoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioAtributoTipoEdificacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioAtributoTipoLicencas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioAtributoTrechoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoDocumentosAtributos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkNormasAtributoTipoNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioEspecieAtributos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAtributoContratoPensionistas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAtributoCargoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAtributoContratoServidorValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoAtributoCadEconFaturamentoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoAtributoImovelVVenalValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoAtributoCadEconAutonomoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoAtributoEmpresaFatoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioAtributoConstrucaoOutrosValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioAtributoNiveis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoDinamico
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
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoDinamico
     */
    public function setCodCadastro($codCadastro)
    {
        $this->codCadastro = $codCadastro;
        return $this;
    }

    /**
     * Get codCadastro
     *
     * @return integer
     */
    public function getCodCadastro()
    {
        return $this->codCadastro;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoDinamico
     */
    public function setCodAtributo($codAtributo)
    {
        $this->codAtributo = $codAtributo;
        return $this;
    }

    /**
     * Get codAtributo
     *
     * @return integer
     */
    public function getCodAtributo()
    {
        return $this->codAtributo;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return AtributoDinamico
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
     * Set naoNulo
     *
     * @param boolean $naoNulo
     * @return AtributoDinamico
     */
    public function setNaoNulo($naoNulo = null)
    {
        $this->naoNulo = $naoNulo;
        return $this;
    }

    /**
     * Get naoNulo
     *
     * @return boolean
     */
    public function getNaoNulo()
    {
        return $this->naoNulo;
    }

    /**
     * Set nomAtributo
     *
     * @param string $nomAtributo
     * @return AtributoDinamico
     */
    public function setNomAtributo($nomAtributo = null)
    {
        $this->nomAtributo = $nomAtributo;
        return $this;
    }

    /**
     * Get nomAtributo
     *
     * @return string
     */
    public function getNomAtributo()
    {
        return $this->nomAtributo;
    }

    /**
     * Set valorPadrao
     *
     * @param string $valorPadrao
     * @return AtributoDinamico
     */
    public function setValorPadrao($valorPadrao = null)
    {
        $this->valorPadrao = $valorPadrao;
        return $this;
    }

    /**
     * Get valorPadrao
     *
     * @return string
     */
    public function getValorPadrao()
    {
        return $this->valorPadrao;
    }

    /**
     * Set ajuda
     *
     * @param string $ajuda
     * @return AtributoDinamico
     */
    public function setAjuda($ajuda = null)
    {
        $this->ajuda = $ajuda;
        return $this;
    }

    /**
     * Get ajuda
     *
     * @return string
     */
    public function getAjuda()
    {
        return $this->ajuda;
    }

    /**
     * Set mascara
     *
     * @param string $mascara
     * @return AtributoDinamico
     */
    public function setMascara($mascara = null)
    {
        $this->mascara = $mascara;
        return $this;
    }

    /**
     * Get mascara
     *
     * @return string
     */
    public function getMascara()
    {
        return $this->mascara;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return AtributoDinamico
     */
    public function setAtivo($ativo = null)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * Set interno
     *
     * @param boolean $interno
     * @return AtributoDinamico
     */
    public function setInterno($interno = null)
    {
        $this->interno = $interno;
        return $this;
    }

    /**
     * Get interno
     *
     * @return boolean
     */
    public function getInterno()
    {
        return $this->interno;
    }

    /**
     * Set indexavel
     *
     * @param boolean $indexavel
     * @return AtributoDinamico
     */
    public function setIndexavel($indexavel = null)
    {
        $this->indexavel = $indexavel;
        return $this;
    }

    /**
     * Get indexavel
     *
     * @return boolean
     */
    public function getIndexavel()
    {
        return $this->indexavel;
    }

    /**
     * Set codAtributoAnterior
     *
     * @param string $codAtributoAnterior
     * @return AtributoDinamico
     */
    public function setCodAtributoAnterior($codAtributoAnterior = null)
    {
        $this->codAtributoAnterior = $codAtributoAnterior;
        return $this;
    }

    /**
     * Get codAtributoAnterior
     *
     * @return string
     */
    public function getCodAtributoAnterior()
    {
        return $this->codAtributoAnterior;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoAtributoRequisicaoItemValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItemValor $fkAlmoxarifadoAtributoRequisicaoItemValor
     * @return AtributoDinamico
     */
    public function addFkAlmoxarifadoAtributoRequisicaoItemValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItemValor $fkAlmoxarifadoAtributoRequisicaoItemValor)
    {
        if (false === $this->fkAlmoxarifadoAtributoRequisicaoItemValores->contains($fkAlmoxarifadoAtributoRequisicaoItemValor)) {
            $fkAlmoxarifadoAtributoRequisicaoItemValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkAlmoxarifadoAtributoRequisicaoItemValores->add($fkAlmoxarifadoAtributoRequisicaoItemValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoAtributoRequisicaoItemValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItemValor $fkAlmoxarifadoAtributoRequisicaoItemValor
     */
    public function removeFkAlmoxarifadoAtributoRequisicaoItemValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItemValor $fkAlmoxarifadoAtributoRequisicaoItemValor)
    {
        $this->fkAlmoxarifadoAtributoRequisicaoItemValores->removeElement($fkAlmoxarifadoAtributoRequisicaoItemValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoAtributoRequisicaoItemValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItemValor
     */
    public function getFkAlmoxarifadoAtributoRequisicaoItemValores()
    {
        return $this->fkAlmoxarifadoAtributoRequisicaoItemValores;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoAtributoValorPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoValorPadrao $fkAdministracaoAtributoValorPadrao
     * @return AtributoDinamico
     */
    public function addFkAdministracaoAtributoValorPadroes(\Urbem\CoreBundle\Entity\Administracao\AtributoValorPadrao $fkAdministracaoAtributoValorPadrao)
    {
        if (false === $this->fkAdministracaoAtributoValorPadroes->contains($fkAdministracaoAtributoValorPadrao)) {
            $fkAdministracaoAtributoValorPadrao->setFkAdministracaoAtributoDinamico($this);
            $this->fkAdministracaoAtributoValorPadroes->add($fkAdministracaoAtributoValorPadrao);
        }
        
        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection|AtributoValorPadrao $fkAdministracaoAtributoValorPadroes
     */
    public function setFkAdministracaoAtributoValorPadroes($fkAdministracaoAtributoValorPadroes)
    {
        $this->fkAdministracaoAtributoValorPadroes = $fkAdministracaoAtributoValorPadroes;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoAtributoValorPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoValorPadrao $fkAdministracaoAtributoValorPadrao
     */
    public function removeFkAdministracaoAtributoValorPadroes(\Urbem\CoreBundle\Entity\Administracao\AtributoValorPadrao $fkAdministracaoAtributoValorPadrao)
    {
        $this->fkAdministracaoAtributoValorPadroes->removeElement($fkAdministracaoAtributoValorPadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoAtributoValorPadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\AtributoValorPadrao
     */
    public function getFkAdministracaoAtributoValorPadroes()
    {
        return $this->fkAdministracaoAtributoValorPadroes;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoAtributoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoFuncao $fkAdministracaoAtributoFuncao
     * @return AtributoDinamico
     */
    public function addFkAdministracaoAtributoFuncoes(\Urbem\CoreBundle\Entity\Administracao\AtributoFuncao $fkAdministracaoAtributoFuncao)
    {
        if (false === $this->fkAdministracaoAtributoFuncoes->contains($fkAdministracaoAtributoFuncao)) {
            $fkAdministracaoAtributoFuncao->setFkAdministracaoAtributoDinamico($this);
            $this->fkAdministracaoAtributoFuncoes->add($fkAdministracaoAtributoFuncao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoAtributoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoFuncao $fkAdministracaoAtributoFuncao
     */
    public function removeFkAdministracaoAtributoFuncoes(\Urbem\CoreBundle\Entity\Administracao\AtributoFuncao $fkAdministracaoAtributoFuncao)
    {
        $this->fkAdministracaoAtributoFuncoes->removeElement($fkAdministracaoAtributoFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoAtributoFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\AtributoFuncao
     */
    public function getFkAdministracaoAtributoFuncoes()
    {
        return $this->fkAdministracaoAtributoFuncoes;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoAtributoIntegridade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoIntegridade $fkAdministracaoAtributoIntegridade
     * @return AtributoDinamico
     */
    public function addFkAdministracaoAtributoIntegridades(\Urbem\CoreBundle\Entity\Administracao\AtributoIntegridade $fkAdministracaoAtributoIntegridade)
    {
        if (false === $this->fkAdministracaoAtributoIntegridades->contains($fkAdministracaoAtributoIntegridade)) {
            $fkAdministracaoAtributoIntegridade->setFkAdministracaoAtributoDinamico($this);
            $this->fkAdministracaoAtributoIntegridades->add($fkAdministracaoAtributoIntegridade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoAtributoIntegridade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoIntegridade $fkAdministracaoAtributoIntegridade
     */
    public function removeFkAdministracaoAtributoIntegridades(\Urbem\CoreBundle\Entity\Administracao\AtributoIntegridade $fkAdministracaoAtributoIntegridade)
    {
        $this->fkAdministracaoAtributoIntegridades->removeElement($fkAdministracaoAtributoIntegridade);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoAtributoIntegridades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\AtributoIntegridade
     */
    public function getFkAdministracaoAtributoIntegridades()
    {
        return $this->fkAdministracaoAtributoIntegridades;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoAtributoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem $fkAlmoxarifadoAtributoCatalogoItem
     * @return AtributoDinamico
     */
    public function addFkAlmoxarifadoAtributoCatalogoItens(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem $fkAlmoxarifadoAtributoCatalogoItem)
    {
        if (false === $this->fkAlmoxarifadoAtributoCatalogoItens->contains($fkAlmoxarifadoAtributoCatalogoItem)) {
            $fkAlmoxarifadoAtributoCatalogoItem->setFkAdministracaoAtributoDinamico($this);
            $this->fkAlmoxarifadoAtributoCatalogoItens->add($fkAlmoxarifadoAtributoCatalogoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoAtributoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem $fkAlmoxarifadoAtributoCatalogoItem
     */
    public function removeFkAlmoxarifadoAtributoCatalogoItens(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem $fkAlmoxarifadoAtributoCatalogoItem)
    {
        $this->fkAlmoxarifadoAtributoCatalogoItens->removeElement($fkAlmoxarifadoAtributoCatalogoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoAtributoCatalogoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem
     */
    public function getFkAlmoxarifadoAtributoCatalogoItens()
    {
        return $this->fkAlmoxarifadoAtributoCatalogoItens;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoAtributoCatalogoClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacao $fkAlmoxarifadoAtributoCatalogoClassificacao
     * @return AtributoDinamico
     */
    public function addFkAlmoxarifadoAtributoCatalogoClassificacoes(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacao $fkAlmoxarifadoAtributoCatalogoClassificacao)
    {
        if (false === $this->fkAlmoxarifadoAtributoCatalogoClassificacoes->contains($fkAlmoxarifadoAtributoCatalogoClassificacao)) {
            $fkAlmoxarifadoAtributoCatalogoClassificacao->setFkAdministracaoAtributoDinamico($this);
            $this->fkAlmoxarifadoAtributoCatalogoClassificacoes->add($fkAlmoxarifadoAtributoCatalogoClassificacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoAtributoCatalogoClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacao $fkAlmoxarifadoAtributoCatalogoClassificacao
     */
    public function removeFkAlmoxarifadoAtributoCatalogoClassificacoes(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacao $fkAlmoxarifadoAtributoCatalogoClassificacao)
    {
        $this->fkAlmoxarifadoAtributoCatalogoClassificacoes->removeElement($fkAlmoxarifadoAtributoCatalogoClassificacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoAtributoCatalogoClassificacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacao
     */
    public function getFkAlmoxarifadoAtributoCatalogoClassificacoes()
    {
        return $this->fkAlmoxarifadoAtributoCatalogoClassificacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoAtributoCalendarioValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoCalendarioValor $fkArrecadacaoAtributoCalendarioValor
     * @return AtributoDinamico
     */
    public function addFkArrecadacaoAtributoCalendarioValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoCalendarioValor $fkArrecadacaoAtributoCalendarioValor)
    {
        if (false === $this->fkArrecadacaoAtributoCalendarioValores->contains($fkArrecadacaoAtributoCalendarioValor)) {
            $fkArrecadacaoAtributoCalendarioValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkArrecadacaoAtributoCalendarioValores->add($fkArrecadacaoAtributoCalendarioValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAtributoCalendarioValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoCalendarioValor $fkArrecadacaoAtributoCalendarioValor
     */
    public function removeFkArrecadacaoAtributoCalendarioValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoCalendarioValor $fkArrecadacaoAtributoCalendarioValor)
    {
        $this->fkArrecadacaoAtributoCalendarioValores->removeElement($fkArrecadacaoAtributoCalendarioValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAtributoCalendarioValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoCalendarioValor
     */
    public function getFkArrecadacaoAtributoCalendarioValores()
    {
        return $this->fkArrecadacaoAtributoCalendarioValores;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoAtributoDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracao $fkArrecadacaoAtributoDesoneracao
     * @return AtributoDinamico
     */
    public function addFkArrecadacaoAtributoDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracao $fkArrecadacaoAtributoDesoneracao)
    {
        if (false === $this->fkArrecadacaoAtributoDesoneracoes->contains($fkArrecadacaoAtributoDesoneracao)) {
            $fkArrecadacaoAtributoDesoneracao->setFkAdministracaoAtributoDinamico($this);
            $this->fkArrecadacaoAtributoDesoneracoes->add($fkArrecadacaoAtributoDesoneracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAtributoDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracao $fkArrecadacaoAtributoDesoneracao
     */
    public function removeFkArrecadacaoAtributoDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracao $fkArrecadacaoAtributoDesoneracao)
    {
        $this->fkArrecadacaoAtributoDesoneracoes->removeElement($fkArrecadacaoAtributoDesoneracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAtributoDesoneracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracao
     */
    public function getFkArrecadacaoAtributoDesoneracoes()
    {
        return $this->fkArrecadacaoAtributoDesoneracoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoAtributoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupo $fkArrecadacaoAtributoGrupo
     * @return AtributoDinamico
     */
    public function addFkArrecadacaoAtributoGrupos(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupo $fkArrecadacaoAtributoGrupo)
    {
        if (false === $this->fkArrecadacaoAtributoGrupos->contains($fkArrecadacaoAtributoGrupo)) {
            $fkArrecadacaoAtributoGrupo->setFkAdministracaoAtributoDinamico($this);
            $this->fkArrecadacaoAtributoGrupos->add($fkArrecadacaoAtributoGrupo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAtributoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupo $fkArrecadacaoAtributoGrupo
     */
    public function removeFkArrecadacaoAtributoGrupos(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupo $fkArrecadacaoAtributoGrupo)
    {
        $this->fkArrecadacaoAtributoGrupos->removeElement($fkArrecadacaoAtributoGrupo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAtributoGrupos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupo
     */
    public function getFkArrecadacaoAtributoGrupos()
    {
        return $this->fkArrecadacaoAtributoGrupos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoAtributoItbiValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoItbiValor $fkArrecadacaoAtributoItbiValor
     * @return AtributoDinamico
     */
    public function addFkArrecadacaoAtributoItbiValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoItbiValor $fkArrecadacaoAtributoItbiValor)
    {
        if (false === $this->fkArrecadacaoAtributoItbiValores->contains($fkArrecadacaoAtributoItbiValor)) {
            $fkArrecadacaoAtributoItbiValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkArrecadacaoAtributoItbiValores->add($fkArrecadacaoAtributoItbiValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAtributoItbiValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoItbiValor $fkArrecadacaoAtributoItbiValor
     */
    public function removeFkArrecadacaoAtributoItbiValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoItbiValor $fkArrecadacaoAtributoItbiValor)
    {
        $this->fkArrecadacaoAtributoItbiValores->removeElement($fkArrecadacaoAtributoItbiValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAtributoItbiValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoItbiValor
     */
    public function getFkArrecadacaoAtributoItbiValores()
    {
        return $this->fkArrecadacaoAtributoItbiValores;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoVariaveisLayoutCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\VariaveisLayoutCarne $fkArrecadacaoVariaveisLayoutCarne
     * @return AtributoDinamico
     */
    public function addFkArrecadacaoVariaveisLayoutCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\VariaveisLayoutCarne $fkArrecadacaoVariaveisLayoutCarne)
    {
        if (false === $this->fkArrecadacaoVariaveisLayoutCarnes->contains($fkArrecadacaoVariaveisLayoutCarne)) {
            $fkArrecadacaoVariaveisLayoutCarne->setFkAdministracaoAtributoDinamico($this);
            $this->fkArrecadacaoVariaveisLayoutCarnes->add($fkArrecadacaoVariaveisLayoutCarne);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoVariaveisLayoutCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\VariaveisLayoutCarne $fkArrecadacaoVariaveisLayoutCarne
     */
    public function removeFkArrecadacaoVariaveisLayoutCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\VariaveisLayoutCarne $fkArrecadacaoVariaveisLayoutCarne)
    {
        $this->fkArrecadacaoVariaveisLayoutCarnes->removeElement($fkArrecadacaoVariaveisLayoutCarne);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoVariaveisLayoutCarnes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\VariaveisLayoutCarne
     */
    public function getFkArrecadacaoVariaveisLayoutCarnes()
    {
        return $this->fkArrecadacaoVariaveisLayoutCarnes;
    }

    /**
     * OneToMany (owning side)
     * Add ConcursoAtributoCandidatoValor
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\AtributoCandidatoValor $fkConcursoAtributoCandidatoValor
     * @return AtributoDinamico
     */
    public function addFkConcursoAtributoCandidatoValores(\Urbem\CoreBundle\Entity\Concurso\AtributoCandidatoValor $fkConcursoAtributoCandidatoValor)
    {
        if (false === $this->fkConcursoAtributoCandidatoValores->contains($fkConcursoAtributoCandidatoValor)) {
            $fkConcursoAtributoCandidatoValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkConcursoAtributoCandidatoValores->add($fkConcursoAtributoCandidatoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ConcursoAtributoCandidatoValor
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\AtributoCandidatoValor $fkConcursoAtributoCandidatoValor
     */
    public function removeFkConcursoAtributoCandidatoValores(\Urbem\CoreBundle\Entity\Concurso\AtributoCandidatoValor $fkConcursoAtributoCandidatoValor)
    {
        $this->fkConcursoAtributoCandidatoValores->removeElement($fkConcursoAtributoCandidatoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkConcursoAtributoCandidatoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\AtributoCandidatoValor
     */
    public function getFkConcursoAtributoCandidatoValores()
    {
        return $this->fkConcursoAtributoCandidatoValores;
    }

    /**
     * OneToMany (owning side)
     * Add ConcursoAtributoConcursoValor
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\AtributoConcursoValor $fkConcursoAtributoConcursoValor
     * @return AtributoDinamico
     */
    public function addFkConcursoAtributoConcursoValores(\Urbem\CoreBundle\Entity\Concurso\AtributoConcursoValor $fkConcursoAtributoConcursoValor)
    {
        if (false === $this->fkConcursoAtributoConcursoValores->contains($fkConcursoAtributoConcursoValor)) {
            $fkConcursoAtributoConcursoValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkConcursoAtributoConcursoValores->add($fkConcursoAtributoConcursoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ConcursoAtributoConcursoValor
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\AtributoConcursoValor $fkConcursoAtributoConcursoValor
     */
    public function removeFkConcursoAtributoConcursoValores(\Urbem\CoreBundle\Entity\Concurso\AtributoConcursoValor $fkConcursoAtributoConcursoValor)
    {
        $this->fkConcursoAtributoConcursoValores->removeElement($fkConcursoAtributoConcursoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkConcursoAtributoConcursoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\AtributoConcursoValor
     */
    public function getFkConcursoAtributoConcursoValores()
    {
        return $this->fkConcursoAtributoConcursoValores;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtributoElemento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoElemento $fkEconomicoAtributoElemento
     * @return AtributoDinamico
     */
    public function addFkEconomicoAtributoElementos(\Urbem\CoreBundle\Entity\Economico\AtributoElemento $fkEconomicoAtributoElemento)
    {
        if (false === $this->fkEconomicoAtributoElementos->contains($fkEconomicoAtributoElemento)) {
            $fkEconomicoAtributoElemento->setFkAdministracaoAtributoDinamico($this);
            $this->fkEconomicoAtributoElementos->add($fkEconomicoAtributoElemento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtributoElemento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoElemento $fkEconomicoAtributoElemento
     */
    public function removeFkEconomicoAtributoElementos(\Urbem\CoreBundle\Entity\Economico\AtributoElemento $fkEconomicoAtributoElemento)
    {
        $this->fkEconomicoAtributoElementos->removeElement($fkEconomicoAtributoElemento);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtributoElementos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoElemento
     */
    public function getFkEconomicoAtributoElementos()
    {
        return $this->fkEconomicoAtributoElementos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtributoEmpresaDireitoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoEmpresaDireitoValor $fkEconomicoAtributoEmpresaDireitoValor
     * @return AtributoDinamico
     */
    public function addFkEconomicoAtributoEmpresaDireitoValores(\Urbem\CoreBundle\Entity\Economico\AtributoEmpresaDireitoValor $fkEconomicoAtributoEmpresaDireitoValor)
    {
        if (false === $this->fkEconomicoAtributoEmpresaDireitoValores->contains($fkEconomicoAtributoEmpresaDireitoValor)) {
            $fkEconomicoAtributoEmpresaDireitoValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkEconomicoAtributoEmpresaDireitoValores->add($fkEconomicoAtributoEmpresaDireitoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtributoEmpresaDireitoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoEmpresaDireitoValor $fkEconomicoAtributoEmpresaDireitoValor
     */
    public function removeFkEconomicoAtributoEmpresaDireitoValores(\Urbem\CoreBundle\Entity\Economico\AtributoEmpresaDireitoValor $fkEconomicoAtributoEmpresaDireitoValor)
    {
        $this->fkEconomicoAtributoEmpresaDireitoValores->removeElement($fkEconomicoAtributoEmpresaDireitoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtributoEmpresaDireitoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoEmpresaDireitoValor
     */
    public function getFkEconomicoAtributoEmpresaDireitoValores()
    {
        return $this->fkEconomicoAtributoEmpresaDireitoValores;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtributoTipoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa $fkEconomicoAtributoTipoLicencaDiversa
     * @return AtributoDinamico
     */
    public function addFkEconomicoAtributoTipoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa $fkEconomicoAtributoTipoLicencaDiversa)
    {
        if (false === $this->fkEconomicoAtributoTipoLicencaDiversas->contains($fkEconomicoAtributoTipoLicencaDiversa)) {
            $fkEconomicoAtributoTipoLicencaDiversa->setFkAdministracaoAtributoDinamico($this);
            $this->fkEconomicoAtributoTipoLicencaDiversas->add($fkEconomicoAtributoTipoLicencaDiversa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtributoTipoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa $fkEconomicoAtributoTipoLicencaDiversa
     */
    public function removeFkEconomicoAtributoTipoLicencaDiversas(\Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa $fkEconomicoAtributoTipoLicencaDiversa)
    {
        $this->fkEconomicoAtributoTipoLicencaDiversas->removeElement($fkEconomicoAtributoTipoLicencaDiversa);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtributoTipoLicencaDiversas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa
     */
    public function getFkEconomicoAtributoTipoLicencaDiversas()
    {
        return $this->fkEconomicoAtributoTipoLicencaDiversas;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoAtributoEmpenhoValor
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AtributoEmpenhoValor $fkEmpenhoAtributoEmpenhoValor
     * @return AtributoDinamico
     */
    public function addFkEmpenhoAtributoEmpenhoValores(\Urbem\CoreBundle\Entity\Empenho\AtributoEmpenhoValor $fkEmpenhoAtributoEmpenhoValor)
    {
        if (false === $this->fkEmpenhoAtributoEmpenhoValores->contains($fkEmpenhoAtributoEmpenhoValor)) {
            $fkEmpenhoAtributoEmpenhoValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkEmpenhoAtributoEmpenhoValores->add($fkEmpenhoAtributoEmpenhoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoAtributoEmpenhoValor
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AtributoEmpenhoValor $fkEmpenhoAtributoEmpenhoValor
     */
    public function removeFkEmpenhoAtributoEmpenhoValores(\Urbem\CoreBundle\Entity\Empenho\AtributoEmpenhoValor $fkEmpenhoAtributoEmpenhoValor)
    {
        $this->fkEmpenhoAtributoEmpenhoValores->removeElement($fkEmpenhoAtributoEmpenhoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoAtributoEmpenhoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AtributoEmpenhoValor
     */
    public function getFkEmpenhoAtributoEmpenhoValores()
    {
        return $this->fkEmpenhoAtributoEmpenhoValores;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoAtributoLiquidacaoValor
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AtributoLiquidacaoValor $fkEmpenhoAtributoLiquidacaoValor
     * @return AtributoDinamico
     */
    public function addFkEmpenhoAtributoLiquidacaoValores(\Urbem\CoreBundle\Entity\Empenho\AtributoLiquidacaoValor $fkEmpenhoAtributoLiquidacaoValor)
    {
        if (false === $this->fkEmpenhoAtributoLiquidacaoValores->contains($fkEmpenhoAtributoLiquidacaoValor)) {
            $fkEmpenhoAtributoLiquidacaoValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkEmpenhoAtributoLiquidacaoValores->add($fkEmpenhoAtributoLiquidacaoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoAtributoLiquidacaoValor
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AtributoLiquidacaoValor $fkEmpenhoAtributoLiquidacaoValor
     */
    public function removeFkEmpenhoAtributoLiquidacaoValores(\Urbem\CoreBundle\Entity\Empenho\AtributoLiquidacaoValor $fkEmpenhoAtributoLiquidacaoValor)
    {
        $this->fkEmpenhoAtributoLiquidacaoValores->removeElement($fkEmpenhoAtributoLiquidacaoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoAtributoLiquidacaoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AtributoLiquidacaoValor
     */
    public function getFkEmpenhoAtributoLiquidacaoValores()
    {
        return $this->fkEmpenhoAtributoLiquidacaoValores;
    }

    /**
     * OneToMany (owning side)
     * Add EstagioAtributoEstagiarioEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\AtributoEstagiarioEstagio $fkEstagioAtributoEstagiarioEstagio
     * @return AtributoDinamico
     */
    public function addFkEstagioAtributoEstagiarioEstagios(\Urbem\CoreBundle\Entity\Estagio\AtributoEstagiarioEstagio $fkEstagioAtributoEstagiarioEstagio)
    {
        if (false === $this->fkEstagioAtributoEstagiarioEstagios->contains($fkEstagioAtributoEstagiarioEstagio)) {
            $fkEstagioAtributoEstagiarioEstagio->setFkAdministracaoAtributoDinamico($this);
            $this->fkEstagioAtributoEstagiarioEstagios->add($fkEstagioAtributoEstagiarioEstagio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioAtributoEstagiarioEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\AtributoEstagiarioEstagio $fkEstagioAtributoEstagiarioEstagio
     */
    public function removeFkEstagioAtributoEstagiarioEstagios(\Urbem\CoreBundle\Entity\Estagio\AtributoEstagiarioEstagio $fkEstagioAtributoEstagiarioEstagio)
    {
        $this->fkEstagioAtributoEstagiarioEstagios->removeElement($fkEstagioAtributoEstagiarioEstagio);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioAtributoEstagiarioEstagios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\AtributoEstagiarioEstagio
     */
    public function getFkEstagioAtributoEstagiarioEstagios()
    {
        return $this->fkEstagioAtributoEstagiarioEstagios;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoAtributoEventoValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\AtributoEventoValor $fkFolhapagamentoAtributoEventoValor
     * @return AtributoDinamico
     */
    public function addFkFolhapagamentoAtributoEventoValores(\Urbem\CoreBundle\Entity\Folhapagamento\AtributoEventoValor $fkFolhapagamentoAtributoEventoValor)
    {
        if (false === $this->fkFolhapagamentoAtributoEventoValores->contains($fkFolhapagamentoAtributoEventoValor)) {
            $fkFolhapagamentoAtributoEventoValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkFolhapagamentoAtributoEventoValores->add($fkFolhapagamentoAtributoEventoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoAtributoEventoValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\AtributoEventoValor $fkFolhapagamentoAtributoEventoValor
     */
    public function removeFkFolhapagamentoAtributoEventoValores(\Urbem\CoreBundle\Entity\Folhapagamento\AtributoEventoValor $fkFolhapagamentoAtributoEventoValor)
    {
        $this->fkFolhapagamentoAtributoEventoValores->removeElement($fkFolhapagamentoAtributoEventoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoAtributoEventoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\AtributoEventoValor
     */
    public function getFkFolhapagamentoAtributoEventoValores()
    {
        return $this->fkFolhapagamentoAtributoEventoValores;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoAtributoPadraoValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\AtributoPadraoValor $fkFolhapagamentoAtributoPadraoValor
     * @return AtributoDinamico
     */
    public function addFkFolhapagamentoAtributoPadraoValores(\Urbem\CoreBundle\Entity\Folhapagamento\AtributoPadraoValor $fkFolhapagamentoAtributoPadraoValor)
    {
        if (false === $this->fkFolhapagamentoAtributoPadraoValores->contains($fkFolhapagamentoAtributoPadraoValor)) {
            $fkFolhapagamentoAtributoPadraoValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkFolhapagamentoAtributoPadraoValores->add($fkFolhapagamentoAtributoPadraoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoAtributoPadraoValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\AtributoPadraoValor $fkFolhapagamentoAtributoPadraoValor
     */
    public function removeFkFolhapagamentoAtributoPadraoValores(\Urbem\CoreBundle\Entity\Folhapagamento\AtributoPadraoValor $fkFolhapagamentoAtributoPadraoValor)
    {
        $this->fkFolhapagamentoAtributoPadraoValores->removeElement($fkFolhapagamentoAtributoPadraoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoAtributoPadraoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\AtributoPadraoValor
     */
    public function getFkFolhapagamentoAtributoPadraoValores()
    {
        return $this->fkFolhapagamentoAtributoPadraoValores;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoAtributoPrevidenciaValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\AtributoPrevidenciaValor $fkFolhapagamentoAtributoPrevidenciaValor
     * @return AtributoDinamico
     */
    public function addFkFolhapagamentoAtributoPrevidenciaValores(\Urbem\CoreBundle\Entity\Folhapagamento\AtributoPrevidenciaValor $fkFolhapagamentoAtributoPrevidenciaValor)
    {
        if (false === $this->fkFolhapagamentoAtributoPrevidenciaValores->contains($fkFolhapagamentoAtributoPrevidenciaValor)) {
            $fkFolhapagamentoAtributoPrevidenciaValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkFolhapagamentoAtributoPrevidenciaValores->add($fkFolhapagamentoAtributoPrevidenciaValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoAtributoPrevidenciaValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\AtributoPrevidenciaValor $fkFolhapagamentoAtributoPrevidenciaValor
     */
    public function removeFkFolhapagamentoAtributoPrevidenciaValores(\Urbem\CoreBundle\Entity\Folhapagamento\AtributoPrevidenciaValor $fkFolhapagamentoAtributoPrevidenciaValor)
    {
        $this->fkFolhapagamentoAtributoPrevidenciaValores->removeElement($fkFolhapagamentoAtributoPrevidenciaValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoAtributoPrevidenciaValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\AtributoPrevidenciaValor
     */
    public function getFkFolhapagamentoAtributoPrevidenciaValores()
    {
        return $this->fkFolhapagamentoAtributoPrevidenciaValores;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoAtributo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributo $fkFolhapagamentoConfiguracaoEmpenhoAtributo
     * @return AtributoDinamico
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoAtributos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributo $fkFolhapagamentoConfiguracaoEmpenhoAtributo)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoAtributos->contains($fkFolhapagamentoConfiguracaoEmpenhoAtributo)) {
            $fkFolhapagamentoConfiguracaoEmpenhoAtributo->setFkAdministracaoAtributoDinamico($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoAtributos->add($fkFolhapagamentoConfiguracaoEmpenhoAtributo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoAtributo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributo $fkFolhapagamentoConfiguracaoEmpenhoAtributo
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoAtributos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributo $fkFolhapagamentoConfiguracaoEmpenhoAtributo)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoAtributos->removeElement($fkFolhapagamentoConfiguracaoEmpenhoAtributo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoAtributos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributo
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoAtributos()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoAtributos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoLlaAtributo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributo $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo
     * @return AtributoDinamico
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoLlaAtributos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributo $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributos->contains($fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo)) {
            $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo->setFkAdministracaoAtributoDinamico($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributos->add($fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoLlaAtributo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributo $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoLlaAtributos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributo $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributos->removeElement($fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoLlaAtributos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributo
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoLlaAtributos()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoIpe
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe $fkFolhapagamentoConfiguracaoIpe
     * @return AtributoDinamico
     */
    public function addFkFolhapagamentoConfiguracaoIpes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe $fkFolhapagamentoConfiguracaoIpe)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoIpes->contains($fkFolhapagamentoConfiguracaoIpe)) {
            $fkFolhapagamentoConfiguracaoIpe->setFkAdministracaoAtributoDinamico($this);
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
     * @return AtributoDinamico
     */
    public function addFkFolhapagamentoConfiguracaoIpes1(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe $fkFolhapagamentoConfiguracaoIpe)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoIpes1->contains($fkFolhapagamentoConfiguracaoIpe)) {
            $fkFolhapagamentoConfiguracaoIpe->setFkAdministracaoAtributoDinamico1($this);
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
     * Add FolhapagamentoConfiguracaoIpePensionista
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpePensionista $fkFolhapagamentoConfiguracaoIpePensionista
     * @return AtributoDinamico
     */
    public function addFkFolhapagamentoConfiguracaoIpePensionistas(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpePensionista $fkFolhapagamentoConfiguracaoIpePensionista)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoIpePensionistas->contains($fkFolhapagamentoConfiguracaoIpePensionista)) {
            $fkFolhapagamentoConfiguracaoIpePensionista->setFkAdministracaoAtributoDinamico($this);
            $this->fkFolhapagamentoConfiguracaoIpePensionistas->add($fkFolhapagamentoConfiguracaoIpePensionista);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoIpePensionista
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpePensionista $fkFolhapagamentoConfiguracaoIpePensionista
     */
    public function removeFkFolhapagamentoConfiguracaoIpePensionistas(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpePensionista $fkFolhapagamentoConfiguracaoIpePensionista)
    {
        $this->fkFolhapagamentoConfiguracaoIpePensionistas->removeElement($fkFolhapagamentoConfiguracaoIpePensionista);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoIpePensionistas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpePensionista
     */
    public function getFkFolhapagamentoConfiguracaoIpePensionistas()
    {
        return $this->fkFolhapagamentoConfiguracaoIpePensionistas;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoIpePensionista
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpePensionista $fkFolhapagamentoConfiguracaoIpePensionista
     * @return AtributoDinamico
     */
    public function addFkFolhapagamentoConfiguracaoIpePensionistas1(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpePensionista $fkFolhapagamentoConfiguracaoIpePensionista)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoIpePensionistas1->contains($fkFolhapagamentoConfiguracaoIpePensionista)) {
            $fkFolhapagamentoConfiguracaoIpePensionista->setFkAdministracaoAtributoDinamico1($this);
            $this->fkFolhapagamentoConfiguracaoIpePensionistas1->add($fkFolhapagamentoConfiguracaoIpePensionista);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoIpePensionista
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpePensionista $fkFolhapagamentoConfiguracaoIpePensionista
     */
    public function removeFkFolhapagamentoConfiguracaoIpePensionistas1(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpePensionista $fkFolhapagamentoConfiguracaoIpePensionista)
    {
        $this->fkFolhapagamentoConfiguracaoIpePensionistas1->removeElement($fkFolhapagamentoConfiguracaoIpePensionista);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoIpePensionistas1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpePensionista
     */
    public function getFkFolhapagamentoConfiguracaoIpePensionistas1()
    {
        return $this->fkFolhapagamentoConfiguracaoIpePensionistas1;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoCondominioValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoCondominioValor $fkImobiliarioAtributoCondominioValor
     * @return AtributoDinamico
     */
    public function addFkImobiliarioAtributoCondominioValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoCondominioValor $fkImobiliarioAtributoCondominioValor)
    {
        if (false === $this->fkImobiliarioAtributoCondominioValores->contains($fkImobiliarioAtributoCondominioValor)) {
            $fkImobiliarioAtributoCondominioValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkImobiliarioAtributoCondominioValores->add($fkImobiliarioAtributoCondominioValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoCondominioValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoCondominioValor $fkImobiliarioAtributoCondominioValor
     */
    public function removeFkImobiliarioAtributoCondominioValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoCondominioValor $fkImobiliarioAtributoCondominioValor)
    {
        $this->fkImobiliarioAtributoCondominioValores->removeElement($fkImobiliarioAtributoCondominioValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoCondominioValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoCondominioValor
     */
    public function getFkImobiliarioAtributoCondominioValores()
    {
        return $this->fkImobiliarioAtributoCondominioValores;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoFaceQuadraValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoFaceQuadraValor $fkImobiliarioAtributoFaceQuadraValor
     * @return AtributoDinamico
     */
    public function addFkImobiliarioAtributoFaceQuadraValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoFaceQuadraValor $fkImobiliarioAtributoFaceQuadraValor)
    {
        if (false === $this->fkImobiliarioAtributoFaceQuadraValores->contains($fkImobiliarioAtributoFaceQuadraValor)) {
            $fkImobiliarioAtributoFaceQuadraValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkImobiliarioAtributoFaceQuadraValores->add($fkImobiliarioAtributoFaceQuadraValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoFaceQuadraValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoFaceQuadraValor $fkImobiliarioAtributoFaceQuadraValor
     */
    public function removeFkImobiliarioAtributoFaceQuadraValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoFaceQuadraValor $fkImobiliarioAtributoFaceQuadraValor)
    {
        $this->fkImobiliarioAtributoFaceQuadraValores->removeElement($fkImobiliarioAtributoFaceQuadraValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoFaceQuadraValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoFaceQuadraValor
     */
    public function getFkImobiliarioAtributoFaceQuadraValores()
    {
        return $this->fkImobiliarioAtributoFaceQuadraValores;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoImovelValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoImovelValor $fkImobiliarioAtributoImovelValor
     * @return AtributoDinamico
     */
    public function addFkImobiliarioAtributoImovelValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoImovelValor $fkImobiliarioAtributoImovelValor)
    {
        if (false === $this->fkImobiliarioAtributoImovelValores->contains($fkImobiliarioAtributoImovelValor)) {
            $fkImobiliarioAtributoImovelValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkImobiliarioAtributoImovelValores->add($fkImobiliarioAtributoImovelValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoImovelValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoImovelValor $fkImobiliarioAtributoImovelValor
     */
    public function removeFkImobiliarioAtributoImovelValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoImovelValor $fkImobiliarioAtributoImovelValor)
    {
        $this->fkImobiliarioAtributoImovelValores->removeElement($fkImobiliarioAtributoImovelValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoImovelValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoImovelValor
     */
    public function getFkImobiliarioAtributoImovelValores()
    {
        return $this->fkImobiliarioAtributoImovelValores;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoLoteRuralValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteRuralValor $fkImobiliarioAtributoLoteRuralValor
     * @return AtributoDinamico
     */
    public function addFkImobiliarioAtributoLoteRuralValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteRuralValor $fkImobiliarioAtributoLoteRuralValor)
    {
        if (false === $this->fkImobiliarioAtributoLoteRuralValores->contains($fkImobiliarioAtributoLoteRuralValor)) {
            $fkImobiliarioAtributoLoteRuralValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkImobiliarioAtributoLoteRuralValores->add($fkImobiliarioAtributoLoteRuralValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoLoteRuralValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteRuralValor $fkImobiliarioAtributoLoteRuralValor
     */
    public function removeFkImobiliarioAtributoLoteRuralValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteRuralValor $fkImobiliarioAtributoLoteRuralValor)
    {
        $this->fkImobiliarioAtributoLoteRuralValores->removeElement($fkImobiliarioAtributoLoteRuralValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoLoteRuralValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteRuralValor
     */
    public function getFkImobiliarioAtributoLoteRuralValores()
    {
        return $this->fkImobiliarioAtributoLoteRuralValores;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoLoteUrbanoValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteUrbanoValor $fkImobiliarioAtributoLoteUrbanoValor
     * @return AtributoDinamico
     */
    public function addFkImobiliarioAtributoLoteUrbanoValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteUrbanoValor $fkImobiliarioAtributoLoteUrbanoValor)
    {
        if (false === $this->fkImobiliarioAtributoLoteUrbanoValores->contains($fkImobiliarioAtributoLoteUrbanoValor)) {
            $fkImobiliarioAtributoLoteUrbanoValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkImobiliarioAtributoLoteUrbanoValores->add($fkImobiliarioAtributoLoteUrbanoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoLoteUrbanoValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteUrbanoValor $fkImobiliarioAtributoLoteUrbanoValor
     */
    public function removeFkImobiliarioAtributoLoteUrbanoValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteUrbanoValor $fkImobiliarioAtributoLoteUrbanoValor)
    {
        $this->fkImobiliarioAtributoLoteUrbanoValores->removeElement($fkImobiliarioAtributoLoteUrbanoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoLoteUrbanoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteUrbanoValor
     */
    public function getFkImobiliarioAtributoLoteUrbanoValores()
    {
        return $this->fkImobiliarioAtributoLoteUrbanoValores;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoTipoEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao $fkImobiliarioAtributoTipoEdificacao
     * @return AtributoDinamico
     */
    public function addFkImobiliarioAtributoTipoEdificacoes(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao $fkImobiliarioAtributoTipoEdificacao)
    {
        if (false === $this->fkImobiliarioAtributoTipoEdificacoes->contains($fkImobiliarioAtributoTipoEdificacao)) {
            $fkImobiliarioAtributoTipoEdificacao->setFkAdministracaoAtributoDinamico($this);
            $this->fkImobiliarioAtributoTipoEdificacoes->add($fkImobiliarioAtributoTipoEdificacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoTipoEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao $fkImobiliarioAtributoTipoEdificacao
     */
    public function removeFkImobiliarioAtributoTipoEdificacoes(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao $fkImobiliarioAtributoTipoEdificacao)
    {
        $this->fkImobiliarioAtributoTipoEdificacoes->removeElement($fkImobiliarioAtributoTipoEdificacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoTipoEdificacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao
     */
    public function getFkImobiliarioAtributoTipoEdificacoes()
    {
        return $this->fkImobiliarioAtributoTipoEdificacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoTipoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca $fkImobiliarioAtributoTipoLicenca
     * @return AtributoDinamico
     */
    public function addFkImobiliarioAtributoTipoLicencas(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca $fkImobiliarioAtributoTipoLicenca)
    {
        if (false === $this->fkImobiliarioAtributoTipoLicencas->contains($fkImobiliarioAtributoTipoLicenca)) {
            $fkImobiliarioAtributoTipoLicenca->setFkAdministracaoAtributoDinamico($this);
            $this->fkImobiliarioAtributoTipoLicencas->add($fkImobiliarioAtributoTipoLicenca);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoTipoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca $fkImobiliarioAtributoTipoLicenca
     */
    public function removeFkImobiliarioAtributoTipoLicencas(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca $fkImobiliarioAtributoTipoLicenca)
    {
        $this->fkImobiliarioAtributoTipoLicencas->removeElement($fkImobiliarioAtributoTipoLicenca);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoTipoLicencas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca
     */
    public function getFkImobiliarioAtributoTipoLicencas()
    {
        return $this->fkImobiliarioAtributoTipoLicencas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoTrechoValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTrechoValor $fkImobiliarioAtributoTrechoValor
     * @return AtributoDinamico
     */
    public function addFkImobiliarioAtributoTrechoValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTrechoValor $fkImobiliarioAtributoTrechoValor)
    {
        if (false === $this->fkImobiliarioAtributoTrechoValores->contains($fkImobiliarioAtributoTrechoValor)) {
            $fkImobiliarioAtributoTrechoValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkImobiliarioAtributoTrechoValores->add($fkImobiliarioAtributoTrechoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoTrechoValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTrechoValor $fkImobiliarioAtributoTrechoValor
     */
    public function removeFkImobiliarioAtributoTrechoValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTrechoValor $fkImobiliarioAtributoTrechoValor)
    {
        $this->fkImobiliarioAtributoTrechoValores->removeElement($fkImobiliarioAtributoTrechoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoTrechoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTrechoValor
     */
    public function getFkImobiliarioAtributoTrechoValores()
    {
        return $this->fkImobiliarioAtributoTrechoValores;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoDocumentosAtributos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\DocumentosAtributos $fkLicitacaoDocumentosAtributos
     * @return AtributoDinamico
     */
    public function addFkLicitacaoDocumentosAtributos(\Urbem\CoreBundle\Entity\Licitacao\DocumentosAtributos $fkLicitacaoDocumentosAtributos)
    {
        if (false === $this->fkLicitacaoDocumentosAtributos->contains($fkLicitacaoDocumentosAtributos)) {
            $fkLicitacaoDocumentosAtributos->setFkAdministracaoAtributoDinamico($this);
            $this->fkLicitacaoDocumentosAtributos->add($fkLicitacaoDocumentosAtributos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoDocumentosAtributos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\DocumentosAtributos $fkLicitacaoDocumentosAtributos
     */
    public function removeFkLicitacaoDocumentosAtributos(\Urbem\CoreBundle\Entity\Licitacao\DocumentosAtributos $fkLicitacaoDocumentosAtributos)
    {
        $this->fkLicitacaoDocumentosAtributos->removeElement($fkLicitacaoDocumentosAtributos);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoDocumentosAtributos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\DocumentosAtributos
     */
    public function getFkLicitacaoDocumentosAtributos()
    {
        return $this->fkLicitacaoDocumentosAtributos;
    }

    /**
     * OneToMany (owning side)
     * Add NormasAtributoTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma $fkNormasAtributoTipoNorma
     * @return AtributoDinamico
     */
    public function addFkNormasAtributoTipoNormas(\Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma $fkNormasAtributoTipoNorma)
    {
        if (false === $this->fkNormasAtributoTipoNormas->contains($fkNormasAtributoTipoNorma)) {
            $fkNormasAtributoTipoNorma->setFkAdministracaoAtributoDinamico($this);
            $this->fkNormasAtributoTipoNormas->add($fkNormasAtributoTipoNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove NormasAtributoTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma $fkNormasAtributoTipoNorma
     */
    public function removeFkNormasAtributoTipoNormas(\Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma $fkNormasAtributoTipoNorma)
    {
        $this->fkNormasAtributoTipoNormas->removeElement($fkNormasAtributoTipoNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkNormasAtributoTipoNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma
     */
    public function getFkNormasAtributoTipoNormas()
    {
        return $this->fkNormasAtributoTipoNormas;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioEspecieAtributo
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo $fkPatrimonioEspecieAtributo
     * @return AtributoDinamico
     */
    public function addFkPatrimonioEspecieAtributos(\Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo $fkPatrimonioEspecieAtributo)
    {
        if (false === $this->fkPatrimonioEspecieAtributos->contains($fkPatrimonioEspecieAtributo)) {
            $fkPatrimonioEspecieAtributo->setFkAdministracaoAtributoDinamico($this);
            $this->fkPatrimonioEspecieAtributos->add($fkPatrimonioEspecieAtributo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioEspecieAtributo
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo $fkPatrimonioEspecieAtributo
     */
    public function removeFkPatrimonioEspecieAtributos(\Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo $fkPatrimonioEspecieAtributo)
    {
        $this->fkPatrimonioEspecieAtributos->removeElement($fkPatrimonioEspecieAtributo);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioEspecieAtributos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo
     */
    public function getFkPatrimonioEspecieAtributos()
    {
        return $this->fkPatrimonioEspecieAtributos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAtributoContratoPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AtributoContratoPensionista $fkPessoalAtributoContratoPensionista
     * @return AtributoDinamico
     */
    public function addFkPessoalAtributoContratoPensionistas(\Urbem\CoreBundle\Entity\Pessoal\AtributoContratoPensionista $fkPessoalAtributoContratoPensionista)
    {
        if (false === $this->fkPessoalAtributoContratoPensionistas->contains($fkPessoalAtributoContratoPensionista)) {
            $fkPessoalAtributoContratoPensionista->setFkAdministracaoAtributoDinamico($this);
            $this->fkPessoalAtributoContratoPensionistas->add($fkPessoalAtributoContratoPensionista);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAtributoContratoPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AtributoContratoPensionista $fkPessoalAtributoContratoPensionista
     */
    public function removeFkPessoalAtributoContratoPensionistas(\Urbem\CoreBundle\Entity\Pessoal\AtributoContratoPensionista $fkPessoalAtributoContratoPensionista)
    {
        $this->fkPessoalAtributoContratoPensionistas->removeElement($fkPessoalAtributoContratoPensionista);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAtributoContratoPensionistas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AtributoContratoPensionista
     */
    public function getFkPessoalAtributoContratoPensionistas()
    {
        return $this->fkPessoalAtributoContratoPensionistas;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAtributoCargoValor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AtributoCargoValor $fkPessoalAtributoCargoValor
     * @return AtributoDinamico
     */
    public function addFkPessoalAtributoCargoValores(\Urbem\CoreBundle\Entity\Pessoal\AtributoCargoValor $fkPessoalAtributoCargoValor)
    {
        if (false === $this->fkPessoalAtributoCargoValores->contains($fkPessoalAtributoCargoValor)) {
            $fkPessoalAtributoCargoValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkPessoalAtributoCargoValores->add($fkPessoalAtributoCargoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAtributoCargoValor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AtributoCargoValor $fkPessoalAtributoCargoValor
     */
    public function removeFkPessoalAtributoCargoValores(\Urbem\CoreBundle\Entity\Pessoal\AtributoCargoValor $fkPessoalAtributoCargoValor)
    {
        $this->fkPessoalAtributoCargoValores->removeElement($fkPessoalAtributoCargoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAtributoCargoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AtributoCargoValor
     */
    public function getFkPessoalAtributoCargoValores()
    {
        return $this->fkPessoalAtributoCargoValores;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAtributoContratoServidorValor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AtributoContratoServidorValor $fkPessoalAtributoContratoServidorValor
     * @return AtributoDinamico
     */
    public function addFkPessoalAtributoContratoServidorValores(\Urbem\CoreBundle\Entity\Pessoal\AtributoContratoServidorValor $fkPessoalAtributoContratoServidorValor)
    {
        if (false === $this->fkPessoalAtributoContratoServidorValores->contains($fkPessoalAtributoContratoServidorValor)) {
            $fkPessoalAtributoContratoServidorValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkPessoalAtributoContratoServidorValores->add($fkPessoalAtributoContratoServidorValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAtributoContratoServidorValor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AtributoContratoServidorValor $fkPessoalAtributoContratoServidorValor
     */
    public function removeFkPessoalAtributoContratoServidorValores(\Urbem\CoreBundle\Entity\Pessoal\AtributoContratoServidorValor $fkPessoalAtributoContratoServidorValor)
    {
        $this->fkPessoalAtributoContratoServidorValores->removeElement($fkPessoalAtributoContratoServidorValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAtributoContratoServidorValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AtributoContratoServidorValor
     */
    public function getFkPessoalAtributoContratoServidorValores()
    {
        return $this->fkPessoalAtributoContratoServidorValores;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoAtributoCadEconFaturamentoValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoCadEconFaturamentoValor $fkArrecadacaoAtributoCadEconFaturamentoValor
     * @return AtributoDinamico
     */
    public function addFkArrecadacaoAtributoCadEconFaturamentoValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoCadEconFaturamentoValor $fkArrecadacaoAtributoCadEconFaturamentoValor)
    {
        if (false === $this->fkArrecadacaoAtributoCadEconFaturamentoValores->contains($fkArrecadacaoAtributoCadEconFaturamentoValor)) {
            $fkArrecadacaoAtributoCadEconFaturamentoValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkArrecadacaoAtributoCadEconFaturamentoValores->add($fkArrecadacaoAtributoCadEconFaturamentoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAtributoCadEconFaturamentoValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoCadEconFaturamentoValor $fkArrecadacaoAtributoCadEconFaturamentoValor
     */
    public function removeFkArrecadacaoAtributoCadEconFaturamentoValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoCadEconFaturamentoValor $fkArrecadacaoAtributoCadEconFaturamentoValor)
    {
        $this->fkArrecadacaoAtributoCadEconFaturamentoValores->removeElement($fkArrecadacaoAtributoCadEconFaturamentoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAtributoCadEconFaturamentoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoCadEconFaturamentoValor
     */
    public function getFkArrecadacaoAtributoCadEconFaturamentoValores()
    {
        return $this->fkArrecadacaoAtributoCadEconFaturamentoValores;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoAtributoImovelVVenalValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoImovelVVenalValor $fkArrecadacaoAtributoImovelVVenalValor
     * @return AtributoDinamico
     */
    public function addFkArrecadacaoAtributoImovelVVenalValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoImovelVVenalValor $fkArrecadacaoAtributoImovelVVenalValor)
    {
        if (false === $this->fkArrecadacaoAtributoImovelVVenalValores->contains($fkArrecadacaoAtributoImovelVVenalValor)) {
            $fkArrecadacaoAtributoImovelVVenalValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkArrecadacaoAtributoImovelVVenalValores->add($fkArrecadacaoAtributoImovelVVenalValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAtributoImovelVVenalValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoImovelVVenalValor $fkArrecadacaoAtributoImovelVVenalValor
     */
    public function removeFkArrecadacaoAtributoImovelVVenalValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoImovelVVenalValor $fkArrecadacaoAtributoImovelVVenalValor)
    {
        $this->fkArrecadacaoAtributoImovelVVenalValores->removeElement($fkArrecadacaoAtributoImovelVVenalValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAtributoImovelVVenalValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoImovelVVenalValor
     */
    public function getFkArrecadacaoAtributoImovelVVenalValores()
    {
        return $this->fkArrecadacaoAtributoImovelVVenalValores;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtributoCadEconAutonomoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoCadEconAutonomoValor $fkEconomicoAtributoCadEconAutonomoValor
     * @return AtributoDinamico
     */
    public function addFkEconomicoAtributoCadEconAutonomoValores(\Urbem\CoreBundle\Entity\Economico\AtributoCadEconAutonomoValor $fkEconomicoAtributoCadEconAutonomoValor)
    {
        if (false === $this->fkEconomicoAtributoCadEconAutonomoValores->contains($fkEconomicoAtributoCadEconAutonomoValor)) {
            $fkEconomicoAtributoCadEconAutonomoValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkEconomicoAtributoCadEconAutonomoValores->add($fkEconomicoAtributoCadEconAutonomoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtributoCadEconAutonomoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoCadEconAutonomoValor $fkEconomicoAtributoCadEconAutonomoValor
     */
    public function removeFkEconomicoAtributoCadEconAutonomoValores(\Urbem\CoreBundle\Entity\Economico\AtributoCadEconAutonomoValor $fkEconomicoAtributoCadEconAutonomoValor)
    {
        $this->fkEconomicoAtributoCadEconAutonomoValores->removeElement($fkEconomicoAtributoCadEconAutonomoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtributoCadEconAutonomoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoCadEconAutonomoValor
     */
    public function getFkEconomicoAtributoCadEconAutonomoValores()
    {
        return $this->fkEconomicoAtributoCadEconAutonomoValores;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtributoEmpresaFatoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoEmpresaFatoValor $fkEconomicoAtributoEmpresaFatoValor
     * @return AtributoDinamico
     */
    public function addFkEconomicoAtributoEmpresaFatoValores(\Urbem\CoreBundle\Entity\Economico\AtributoEmpresaFatoValor $fkEconomicoAtributoEmpresaFatoValor)
    {
        if (false === $this->fkEconomicoAtributoEmpresaFatoValores->contains($fkEconomicoAtributoEmpresaFatoValor)) {
            $fkEconomicoAtributoEmpresaFatoValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkEconomicoAtributoEmpresaFatoValores->add($fkEconomicoAtributoEmpresaFatoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtributoEmpresaFatoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoEmpresaFatoValor $fkEconomicoAtributoEmpresaFatoValor
     */
    public function removeFkEconomicoAtributoEmpresaFatoValores(\Urbem\CoreBundle\Entity\Economico\AtributoEmpresaFatoValor $fkEconomicoAtributoEmpresaFatoValor)
    {
        $this->fkEconomicoAtributoEmpresaFatoValores->removeElement($fkEconomicoAtributoEmpresaFatoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtributoEmpresaFatoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoEmpresaFatoValor
     */
    public function getFkEconomicoAtributoEmpresaFatoValores()
    {
        return $this->fkEconomicoAtributoEmpresaFatoValores;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoConstrucaoOutrosValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoConstrucaoOutrosValor $fkImobiliarioAtributoConstrucaoOutrosValor
     * @return AtributoDinamico
     */
    public function addFkImobiliarioAtributoConstrucaoOutrosValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoConstrucaoOutrosValor $fkImobiliarioAtributoConstrucaoOutrosValor)
    {
        if (false === $this->fkImobiliarioAtributoConstrucaoOutrosValores->contains($fkImobiliarioAtributoConstrucaoOutrosValor)) {
            $fkImobiliarioAtributoConstrucaoOutrosValor->setFkAdministracaoAtributoDinamico($this);
            $this->fkImobiliarioAtributoConstrucaoOutrosValores->add($fkImobiliarioAtributoConstrucaoOutrosValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoConstrucaoOutrosValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoConstrucaoOutrosValor $fkImobiliarioAtributoConstrucaoOutrosValor
     */
    public function removeFkImobiliarioAtributoConstrucaoOutrosValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoConstrucaoOutrosValor $fkImobiliarioAtributoConstrucaoOutrosValor)
    {
        $this->fkImobiliarioAtributoConstrucaoOutrosValores->removeElement($fkImobiliarioAtributoConstrucaoOutrosValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoConstrucaoOutrosValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoConstrucaoOutrosValor
     */
    public function getFkImobiliarioAtributoConstrucaoOutrosValores()
    {
        return $this->fkImobiliarioAtributoConstrucaoOutrosValores;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel $fkImobiliarioAtributoNivel
     * @return AtributoDinamico
     */
    public function addFkImobiliarioAtributoNiveis(\Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel $fkImobiliarioAtributoNivel)
    {
        if (false === $this->fkImobiliarioAtributoNiveis->contains($fkImobiliarioAtributoNivel)) {
            $fkImobiliarioAtributoNivel->setFkAdministracaoAtributoDinamico($this);
            $this->fkImobiliarioAtributoNiveis->add($fkImobiliarioAtributoNivel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel $fkImobiliarioAtributoNivel
     */
    public function removeFkImobiliarioAtributoNiveis(\Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel $fkImobiliarioAtributoNivel)
    {
        $this->fkImobiliarioAtributoNiveis->removeElement($fkImobiliarioAtributoNivel);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoNiveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel
     */
    public function getFkImobiliarioAtributoNiveis()
    {
        return $this->fkImobiliarioAtributoNiveis;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoCadastro
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Cadastro $fkAdministracaoCadastro
     * @return AtributoDinamico
     */
    public function setFkAdministracaoCadastro(\Urbem\CoreBundle\Entity\Administracao\Cadastro $fkAdministracaoCadastro)
    {
        $this->codModulo = $fkAdministracaoCadastro->getCodModulo();
        $this->codCadastro = $fkAdministracaoCadastro->getCodCadastro();
        $this->fkAdministracaoCadastro = $fkAdministracaoCadastro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoCadastro
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Cadastro
     */
    public function getFkAdministracaoCadastro()
    {
        return $this->fkAdministracaoCadastro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoTipoAtributo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\TipoAtributo $fkAdministracaoTipoAtributo
     * @return AtributoDinamico
     */
    public function setFkAdministracaoTipoAtributo(\Urbem\CoreBundle\Entity\Administracao\TipoAtributo $fkAdministracaoTipoAtributo)
    {
        $this->codTipo = $fkAdministracaoTipoAtributo->getCodTipo();
        $this->fkAdministracaoTipoAtributo = $fkAdministracaoTipoAtributo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoTipoAtributo
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\TipoAtributo
     */
    public function getFkAdministracaoTipoAtributo()
    {
        return $this->fkAdministracaoTipoAtributo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s - %s',
            $this->codAtributo,
            $this->nomAtributo
        );
    }
}
