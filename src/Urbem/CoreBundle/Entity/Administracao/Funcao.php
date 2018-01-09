<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Funcao
 */
class Funcao
{
    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * PK
     * @var integer
     */
    private $codBiblioteca;

    /**
     * PK
     * @var integer
     */
    private $codFuncao;

    /**
     * @var integer
     */
    private $codTipoRetorno;

    /**
     * @var string
     */
    private $nomFuncao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Administracao\FuncaoExterna
     */
    private $fkAdministracaoFuncaoExterna;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\AtributoFuncao
     */
    private $fkAdministracaoAtributoFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\FuncaoReferencia
     */
    private $fkAdministracaoFuncaoReferencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Variavel
     */
    private $fkAdministracaoVariaveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao
     */
    private $fkArrecadacaoDesoneracoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ParametroCalculo
     */
    private $fkArrecadacaoParametroCalculos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\RegraDesoneracaoGrupo
     */
    private $fkArrecadacaoRegraDesoneracaoGrupos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeAcrescimo
     */
    private $fkDividaModalidadeAcrescimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeReducao
     */
    private $fkDividaModalidadeReducoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia
     */
    private $fkDividaModalidadeVigencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\Bases
     */
    private $fkFolhapagamentoBaseses;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso
     */
    private $fkFolhapagamentoConfiguracaoEventoCasos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PensaoFuncaoPadrao
     */
    private $fkFolhapagamentoPensaoFuncaoPadroes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\SindicatoFuncao
     */
    private $fkFolhapagamentoSindicatoFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TipoMedia
     */
    private $fkFolhapagamentoTipoMedias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\TipoConvenio
     */
    private $fkMonetarioTipoConvenios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\RegraDesoneracaoCredito
     */
    private $fkMonetarioRegraDesoneracaoCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\FormulaIndicador
     */
    private $fkMonetarioFormulaIndicadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\RegraConversaoMoeda
     */
    private $fkMonetarioRegraConversaoMoedas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\FormulaAcrescimo
     */
    private $fkMonetarioFormulaAcrescimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\PensaoFuncao
     */
    private $fkPessoalPensaoFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculadoFuncao
     */
    private $fkPessoalAssentamentoVinculadoFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta
     */
    private $fkFiscalizacaoPenalidadeMultas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Biblioteca
     */
    private $fkAdministracaoBiblioteca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\TipoPrimitivo
     */
    private $fkAdministracaoTipoPrimitivo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoAtributoFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoFuncaoReferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoVariaveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoDesoneracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoParametroCalculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoRegraDesoneracaoGrupos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaModalidadeAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaModalidadeReducoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaModalidadeVigencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoBaseses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEventoCasos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoPensaoFuncaoPadroes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoSindicatoFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTipoMedias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioTipoConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioRegraDesoneracaoCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioFormulaIndicadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioRegraConversaoMoedas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioFormulaAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalPensaoFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAssentamentoVinculadoFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoPenalidadeMultas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return Funcao
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
     * Set codBiblioteca
     *
     * @param integer $codBiblioteca
     * @return Funcao
     */
    public function setCodBiblioteca($codBiblioteca)
    {
        $this->codBiblioteca = $codBiblioteca;
        return $this;
    }

    /**
     * Get codBiblioteca
     *
     * @return integer
     */
    public function getCodBiblioteca()
    {
        return $this->codBiblioteca;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return Funcao
     */
    public function setCodFuncao($codFuncao)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * Set codTipoRetorno
     *
     * @param integer $codTipoRetorno
     * @return Funcao
     */
    public function setCodTipoRetorno($codTipoRetorno)
    {
        $this->codTipoRetorno = $codTipoRetorno;
        return $this;
    }

    /**
     * Get codTipoRetorno
     *
     * @return integer
     */
    public function getCodTipoRetorno()
    {
        return $this->codTipoRetorno;
    }

    /**
     * Set nomFuncao
     *
     * @param string $nomFuncao
     * @return Funcao
     */
    public function setNomFuncao($nomFuncao = null)
    {
        $this->nomFuncao = $nomFuncao;
        return $this;
    }

    /**
     * Get nomFuncao
     *
     * @return string
     */
    public function getNomFuncao()
    {
        return $this->nomFuncao;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoAtributoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoFuncao $fkAdministracaoAtributoFuncao
     * @return Funcao
     */
    public function addFkAdministracaoAtributoFuncoes(\Urbem\CoreBundle\Entity\Administracao\AtributoFuncao $fkAdministracaoAtributoFuncao)
    {
        if (false === $this->fkAdministracaoAtributoFuncoes->contains($fkAdministracaoAtributoFuncao)) {
            $fkAdministracaoAtributoFuncao->setFkAdministracaoFuncao($this);
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
     * Add AdministracaoFuncaoReferencia
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\FuncaoReferencia $fkAdministracaoFuncaoReferencia
     * @return Funcao
     */
    public function addFkAdministracaoFuncaoReferencias(\Urbem\CoreBundle\Entity\Administracao\FuncaoReferencia $fkAdministracaoFuncaoReferencia)
    {
        if (false === $this->fkAdministracaoFuncaoReferencias->contains($fkAdministracaoFuncaoReferencia)) {
            $fkAdministracaoFuncaoReferencia->setFkAdministracaoFuncao($this);
            $this->fkAdministracaoFuncaoReferencias->add($fkAdministracaoFuncaoReferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoFuncaoReferencia
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\FuncaoReferencia $fkAdministracaoFuncaoReferencia
     */
    public function removeFkAdministracaoFuncaoReferencias(\Urbem\CoreBundle\Entity\Administracao\FuncaoReferencia $fkAdministracaoFuncaoReferencia)
    {
        $this->fkAdministracaoFuncaoReferencias->removeElement($fkAdministracaoFuncaoReferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoFuncaoReferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\FuncaoReferencia
     */
    public function getFkAdministracaoFuncaoReferencias()
    {
        return $this->fkAdministracaoFuncaoReferencias;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoVariavel
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Variavel $fkAdministracaoVariavel
     * @return Funcao
     */
    public function addFkAdministracaoVariaveis(\Urbem\CoreBundle\Entity\Administracao\Variavel $fkAdministracaoVariavel)
    {
        if (false === $this->fkAdministracaoVariaveis->contains($fkAdministracaoVariavel)) {
            $fkAdministracaoVariavel->setFkAdministracaoFuncao($this);
            $this->fkAdministracaoVariaveis->add($fkAdministracaoVariavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoVariavel
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Variavel $fkAdministracaoVariavel
     */
    public function removeFkAdministracaoVariaveis(\Urbem\CoreBundle\Entity\Administracao\Variavel $fkAdministracaoVariavel)
    {
        $this->fkAdministracaoVariaveis->removeElement($fkAdministracaoVariavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoVariaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Variavel
     */
    public function getFkAdministracaoVariaveis()
    {
        return $this->fkAdministracaoVariaveis;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao
     * @return Funcao
     */
    public function addFkArrecadacaoDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao)
    {
        if (false === $this->fkArrecadacaoDesoneracoes->contains($fkArrecadacaoDesoneracao)) {
            $fkArrecadacaoDesoneracao->setFkAdministracaoFuncao($this);
            $this->fkArrecadacaoDesoneracoes->add($fkArrecadacaoDesoneracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao
     */
    public function removeFkArrecadacaoDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao)
    {
        $this->fkArrecadacaoDesoneracoes->removeElement($fkArrecadacaoDesoneracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDesoneracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao
     */
    public function getFkArrecadacaoDesoneracoes()
    {
        return $this->fkArrecadacaoDesoneracoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoParametroCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ParametroCalculo $fkArrecadacaoParametroCalculo
     * @return Funcao
     */
    public function addFkArrecadacaoParametroCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\ParametroCalculo $fkArrecadacaoParametroCalculo)
    {
        if (false === $this->fkArrecadacaoParametroCalculos->contains($fkArrecadacaoParametroCalculo)) {
            $fkArrecadacaoParametroCalculo->setFkAdministracaoFuncao($this);
            $this->fkArrecadacaoParametroCalculos->add($fkArrecadacaoParametroCalculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoParametroCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ParametroCalculo $fkArrecadacaoParametroCalculo
     */
    public function removeFkArrecadacaoParametroCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\ParametroCalculo $fkArrecadacaoParametroCalculo)
    {
        $this->fkArrecadacaoParametroCalculos->removeElement($fkArrecadacaoParametroCalculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoParametroCalculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ParametroCalculo
     */
    public function getFkArrecadacaoParametroCalculos()
    {
        return $this->fkArrecadacaoParametroCalculos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoRegraDesoneracaoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\RegraDesoneracaoGrupo $fkArrecadacaoRegraDesoneracaoGrupo
     * @return Funcao
     */
    public function addFkArrecadacaoRegraDesoneracaoGrupos(\Urbem\CoreBundle\Entity\Arrecadacao\RegraDesoneracaoGrupo $fkArrecadacaoRegraDesoneracaoGrupo)
    {
        if (false === $this->fkArrecadacaoRegraDesoneracaoGrupos->contains($fkArrecadacaoRegraDesoneracaoGrupo)) {
            $fkArrecadacaoRegraDesoneracaoGrupo->setFkAdministracaoFuncao($this);
            $this->fkArrecadacaoRegraDesoneracaoGrupos->add($fkArrecadacaoRegraDesoneracaoGrupo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoRegraDesoneracaoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\RegraDesoneracaoGrupo $fkArrecadacaoRegraDesoneracaoGrupo
     */
    public function removeFkArrecadacaoRegraDesoneracaoGrupos(\Urbem\CoreBundle\Entity\Arrecadacao\RegraDesoneracaoGrupo $fkArrecadacaoRegraDesoneracaoGrupo)
    {
        $this->fkArrecadacaoRegraDesoneracaoGrupos->removeElement($fkArrecadacaoRegraDesoneracaoGrupo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoRegraDesoneracaoGrupos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\RegraDesoneracaoGrupo
     */
    public function getFkArrecadacaoRegraDesoneracaoGrupos()
    {
        return $this->fkArrecadacaoRegraDesoneracaoGrupos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaModalidadeAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeAcrescimo $fkDividaModalidadeAcrescimo
     * @return Funcao
     */
    public function addFkDividaModalidadeAcrescimos(\Urbem\CoreBundle\Entity\Divida\ModalidadeAcrescimo $fkDividaModalidadeAcrescimo)
    {
        if (false === $this->fkDividaModalidadeAcrescimos->contains($fkDividaModalidadeAcrescimo)) {
            $fkDividaModalidadeAcrescimo->setFkAdministracaoFuncao($this);
            $this->fkDividaModalidadeAcrescimos->add($fkDividaModalidadeAcrescimo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaModalidadeAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeAcrescimo $fkDividaModalidadeAcrescimo
     */
    public function removeFkDividaModalidadeAcrescimos(\Urbem\CoreBundle\Entity\Divida\ModalidadeAcrescimo $fkDividaModalidadeAcrescimo)
    {
        $this->fkDividaModalidadeAcrescimos->removeElement($fkDividaModalidadeAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaModalidadeAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeAcrescimo
     */
    public function getFkDividaModalidadeAcrescimos()
    {
        return $this->fkDividaModalidadeAcrescimos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaModalidadeReducao
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeReducao $fkDividaModalidadeReducao
     * @return Funcao
     */
    public function addFkDividaModalidadeReducoes(\Urbem\CoreBundle\Entity\Divida\ModalidadeReducao $fkDividaModalidadeReducao)
    {
        if (false === $this->fkDividaModalidadeReducoes->contains($fkDividaModalidadeReducao)) {
            $fkDividaModalidadeReducao->setFkAdministracaoFuncao($this);
            $this->fkDividaModalidadeReducoes->add($fkDividaModalidadeReducao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaModalidadeReducao
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeReducao $fkDividaModalidadeReducao
     */
    public function removeFkDividaModalidadeReducoes(\Urbem\CoreBundle\Entity\Divida\ModalidadeReducao $fkDividaModalidadeReducao)
    {
        $this->fkDividaModalidadeReducoes->removeElement($fkDividaModalidadeReducao);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaModalidadeReducoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeReducao
     */
    public function getFkDividaModalidadeReducoes()
    {
        return $this->fkDividaModalidadeReducoes;
    }

    /**
     * OneToMany (owning side)
     * Add DividaModalidadeVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia
     * @return Funcao
     */
    public function addFkDividaModalidadeVigencias(\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia)
    {
        if (false === $this->fkDividaModalidadeVigencias->contains($fkDividaModalidadeVigencia)) {
            $fkDividaModalidadeVigencia->setFkAdministracaoFuncao($this);
            $this->fkDividaModalidadeVigencias->add($fkDividaModalidadeVigencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaModalidadeVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia
     */
    public function removeFkDividaModalidadeVigencias(\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia)
    {
        $this->fkDividaModalidadeVigencias->removeElement($fkDividaModalidadeVigencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaModalidadeVigencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia
     */
    public function getFkDividaModalidadeVigencias()
    {
        return $this->fkDividaModalidadeVigencias;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoBases
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Bases $fkFolhapagamentoBases
     * @return Funcao
     */
    public function addFkFolhapagamentoBaseses(\Urbem\CoreBundle\Entity\Folhapagamento\Bases $fkFolhapagamentoBases)
    {
        if (false === $this->fkFolhapagamentoBaseses->contains($fkFolhapagamentoBases)) {
            $fkFolhapagamentoBases->setFkAdministracaoFuncao($this);
            $this->fkFolhapagamentoBaseses->add($fkFolhapagamentoBases);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoBases
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Bases $fkFolhapagamentoBases
     */
    public function removeFkFolhapagamentoBaseses(\Urbem\CoreBundle\Entity\Folhapagamento\Bases $fkFolhapagamentoBases)
    {
        $this->fkFolhapagamentoBaseses->removeElement($fkFolhapagamentoBases);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoBaseses
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\Bases
     */
    public function getFkFolhapagamentoBaseses()
    {
        return $this->fkFolhapagamentoBaseses;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEventoCaso
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso
     * @return Funcao
     */
    public function addFkFolhapagamentoConfiguracaoEventoCasos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEventoCasos->contains($fkFolhapagamentoConfiguracaoEventoCaso)) {
            $fkFolhapagamentoConfiguracaoEventoCaso->setFkAdministracaoFuncao($this);
            $this->fkFolhapagamentoConfiguracaoEventoCasos->add($fkFolhapagamentoConfiguracaoEventoCaso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEventoCaso
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso
     */
    public function removeFkFolhapagamentoConfiguracaoEventoCasos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso)
    {
        $this->fkFolhapagamentoConfiguracaoEventoCasos->removeElement($fkFolhapagamentoConfiguracaoEventoCaso);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEventoCasos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso
     */
    public function getFkFolhapagamentoConfiguracaoEventoCasos()
    {
        return $this->fkFolhapagamentoConfiguracaoEventoCasos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoPensaoFuncaoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PensaoFuncaoPadrao $fkFolhapagamentoPensaoFuncaoPadrao
     * @return Funcao
     */
    public function addFkFolhapagamentoPensaoFuncaoPadroes(\Urbem\CoreBundle\Entity\Folhapagamento\PensaoFuncaoPadrao $fkFolhapagamentoPensaoFuncaoPadrao)
    {
        if (false === $this->fkFolhapagamentoPensaoFuncaoPadroes->contains($fkFolhapagamentoPensaoFuncaoPadrao)) {
            $fkFolhapagamentoPensaoFuncaoPadrao->setFkAdministracaoFuncao($this);
            $this->fkFolhapagamentoPensaoFuncaoPadroes->add($fkFolhapagamentoPensaoFuncaoPadrao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoPensaoFuncaoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PensaoFuncaoPadrao $fkFolhapagamentoPensaoFuncaoPadrao
     */
    public function removeFkFolhapagamentoPensaoFuncaoPadroes(\Urbem\CoreBundle\Entity\Folhapagamento\PensaoFuncaoPadrao $fkFolhapagamentoPensaoFuncaoPadrao)
    {
        $this->fkFolhapagamentoPensaoFuncaoPadroes->removeElement($fkFolhapagamentoPensaoFuncaoPadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoPensaoFuncaoPadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PensaoFuncaoPadrao
     */
    public function getFkFolhapagamentoPensaoFuncaoPadroes()
    {
        return $this->fkFolhapagamentoPensaoFuncaoPadroes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoSindicatoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SindicatoFuncao $fkFolhapagamentoSindicatoFuncao
     * @return Funcao
     */
    public function addFkFolhapagamentoSindicatoFuncoes(\Urbem\CoreBundle\Entity\Folhapagamento\SindicatoFuncao $fkFolhapagamentoSindicatoFuncao)
    {
        if (false === $this->fkFolhapagamentoSindicatoFuncoes->contains($fkFolhapagamentoSindicatoFuncao)) {
            $fkFolhapagamentoSindicatoFuncao->setFkAdministracaoFuncao($this);
            $this->fkFolhapagamentoSindicatoFuncoes->add($fkFolhapagamentoSindicatoFuncao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoSindicatoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SindicatoFuncao $fkFolhapagamentoSindicatoFuncao
     */
    public function removeFkFolhapagamentoSindicatoFuncoes(\Urbem\CoreBundle\Entity\Folhapagamento\SindicatoFuncao $fkFolhapagamentoSindicatoFuncao)
    {
        $this->fkFolhapagamentoSindicatoFuncoes->removeElement($fkFolhapagamentoSindicatoFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoSindicatoFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\SindicatoFuncao
     */
    public function getFkFolhapagamentoSindicatoFuncoes()
    {
        return $this->fkFolhapagamentoSindicatoFuncoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTipoMedia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoMedia $fkFolhapagamentoTipoMedia
     * @return Funcao
     */
    public function addFkFolhapagamentoTipoMedias(\Urbem\CoreBundle\Entity\Folhapagamento\TipoMedia $fkFolhapagamentoTipoMedia)
    {
        if (false === $this->fkFolhapagamentoTipoMedias->contains($fkFolhapagamentoTipoMedia)) {
            $fkFolhapagamentoTipoMedia->setFkAdministracaoFuncao($this);
            $this->fkFolhapagamentoTipoMedias->add($fkFolhapagamentoTipoMedia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTipoMedia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoMedia $fkFolhapagamentoTipoMedia
     */
    public function removeFkFolhapagamentoTipoMedias(\Urbem\CoreBundle\Entity\Folhapagamento\TipoMedia $fkFolhapagamentoTipoMedia)
    {
        $this->fkFolhapagamentoTipoMedias->removeElement($fkFolhapagamentoTipoMedia);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTipoMedias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TipoMedia
     */
    public function getFkFolhapagamentoTipoMedias()
    {
        return $this->fkFolhapagamentoTipoMedias;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioTipoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\TipoConvenio $fkMonetarioTipoConvenio
     * @return Funcao
     */
    public function addFkMonetarioTipoConvenios(\Urbem\CoreBundle\Entity\Monetario\TipoConvenio $fkMonetarioTipoConvenio)
    {
        if (false === $this->fkMonetarioTipoConvenios->contains($fkMonetarioTipoConvenio)) {
            $fkMonetarioTipoConvenio->setFkAdministracaoFuncao($this);
            $this->fkMonetarioTipoConvenios->add($fkMonetarioTipoConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioTipoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\TipoConvenio $fkMonetarioTipoConvenio
     */
    public function removeFkMonetarioTipoConvenios(\Urbem\CoreBundle\Entity\Monetario\TipoConvenio $fkMonetarioTipoConvenio)
    {
        $this->fkMonetarioTipoConvenios->removeElement($fkMonetarioTipoConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioTipoConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\TipoConvenio
     */
    public function getFkMonetarioTipoConvenios()
    {
        return $this->fkMonetarioTipoConvenios;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioRegraDesoneracaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\RegraDesoneracaoCredito $fkMonetarioRegraDesoneracaoCredito
     * @return Funcao
     */
    public function addFkMonetarioRegraDesoneracaoCreditos(\Urbem\CoreBundle\Entity\Monetario\RegraDesoneracaoCredito $fkMonetarioRegraDesoneracaoCredito)
    {
        if (false === $this->fkMonetarioRegraDesoneracaoCreditos->contains($fkMonetarioRegraDesoneracaoCredito)) {
            $fkMonetarioRegraDesoneracaoCredito->setFkAdministracaoFuncao($this);
            $this->fkMonetarioRegraDesoneracaoCreditos->add($fkMonetarioRegraDesoneracaoCredito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioRegraDesoneracaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\RegraDesoneracaoCredito $fkMonetarioRegraDesoneracaoCredito
     */
    public function removeFkMonetarioRegraDesoneracaoCreditos(\Urbem\CoreBundle\Entity\Monetario\RegraDesoneracaoCredito $fkMonetarioRegraDesoneracaoCredito)
    {
        $this->fkMonetarioRegraDesoneracaoCreditos->removeElement($fkMonetarioRegraDesoneracaoCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioRegraDesoneracaoCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\RegraDesoneracaoCredito
     */
    public function getFkMonetarioRegraDesoneracaoCreditos()
    {
        return $this->fkMonetarioRegraDesoneracaoCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioFormulaIndicador
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\FormulaIndicador $fkMonetarioFormulaIndicador
     * @return Funcao
     */
    public function addFkMonetarioFormulaIndicadores(\Urbem\CoreBundle\Entity\Monetario\FormulaIndicador $fkMonetarioFormulaIndicador)
    {
        if (false === $this->fkMonetarioFormulaIndicadores->contains($fkMonetarioFormulaIndicador)) {
            $fkMonetarioFormulaIndicador->setFkAdministracaoFuncao($this);
            $this->fkMonetarioFormulaIndicadores->add($fkMonetarioFormulaIndicador);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioFormulaIndicador
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\FormulaIndicador $fkMonetarioFormulaIndicador
     */
    public function removeFkMonetarioFormulaIndicadores(\Urbem\CoreBundle\Entity\Monetario\FormulaIndicador $fkMonetarioFormulaIndicador)
    {
        $this->fkMonetarioFormulaIndicadores->removeElement($fkMonetarioFormulaIndicador);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioFormulaIndicadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\FormulaIndicador
     */
    public function getFkMonetarioFormulaIndicadores()
    {
        return $this->fkMonetarioFormulaIndicadores;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioRegraConversaoMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\RegraConversaoMoeda $fkMonetarioRegraConversaoMoeda
     * @return Funcao
     */
    public function addFkMonetarioRegraConversaoMoedas(\Urbem\CoreBundle\Entity\Monetario\RegraConversaoMoeda $fkMonetarioRegraConversaoMoeda)
    {
        if (false === $this->fkMonetarioRegraConversaoMoedas->contains($fkMonetarioRegraConversaoMoeda)) {
            $fkMonetarioRegraConversaoMoeda->setFkAdministracaoFuncao($this);
            $this->fkMonetarioRegraConversaoMoedas->add($fkMonetarioRegraConversaoMoeda);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioRegraConversaoMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\RegraConversaoMoeda $fkMonetarioRegraConversaoMoeda
     */
    public function removeFkMonetarioRegraConversaoMoedas(\Urbem\CoreBundle\Entity\Monetario\RegraConversaoMoeda $fkMonetarioRegraConversaoMoeda)
    {
        $this->fkMonetarioRegraConversaoMoedas->removeElement($fkMonetarioRegraConversaoMoeda);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioRegraConversaoMoedas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\RegraConversaoMoeda
     */
    public function getFkMonetarioRegraConversaoMoedas()
    {
        return $this->fkMonetarioRegraConversaoMoedas;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioFormulaAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\FormulaAcrescimo $fkMonetarioFormulaAcrescimo
     * @return Funcao
     */
    public function addFkMonetarioFormulaAcrescimos(\Urbem\CoreBundle\Entity\Monetario\FormulaAcrescimo $fkMonetarioFormulaAcrescimo)
    {
        if (false === $this->fkMonetarioFormulaAcrescimos->contains($fkMonetarioFormulaAcrescimo)) {
            $fkMonetarioFormulaAcrescimo->setFkAdministracaoFuncao($this);
            $this->fkMonetarioFormulaAcrescimos->add($fkMonetarioFormulaAcrescimo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioFormulaAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\FormulaAcrescimo $fkMonetarioFormulaAcrescimo
     */
    public function removeFkMonetarioFormulaAcrescimos(\Urbem\CoreBundle\Entity\Monetario\FormulaAcrescimo $fkMonetarioFormulaAcrescimo)
    {
        $this->fkMonetarioFormulaAcrescimos->removeElement($fkMonetarioFormulaAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioFormulaAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\FormulaAcrescimo
     */
    public function getFkMonetarioFormulaAcrescimos()
    {
        return $this->fkMonetarioFormulaAcrescimos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalPensaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PensaoFuncao $fkPessoalPensaoFuncao
     * @return Funcao
     */
    public function addFkPessoalPensaoFuncoes(\Urbem\CoreBundle\Entity\Pessoal\PensaoFuncao $fkPessoalPensaoFuncao)
    {
        if (false === $this->fkPessoalPensaoFuncoes->contains($fkPessoalPensaoFuncao)) {
            $fkPessoalPensaoFuncao->setFkAdministracaoFuncao($this);
            $this->fkPessoalPensaoFuncoes->add($fkPessoalPensaoFuncao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalPensaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PensaoFuncao $fkPessoalPensaoFuncao
     */
    public function removeFkPessoalPensaoFuncoes(\Urbem\CoreBundle\Entity\Pessoal\PensaoFuncao $fkPessoalPensaoFuncao)
    {
        $this->fkPessoalPensaoFuncoes->removeElement($fkPessoalPensaoFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalPensaoFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\PensaoFuncao
     */
    public function getFkPessoalPensaoFuncoes()
    {
        return $this->fkPessoalPensaoFuncoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoVinculadoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculadoFuncao $fkPessoalAssentamentoVinculadoFuncao
     * @return Funcao
     */
    public function addFkPessoalAssentamentoVinculadoFuncoes(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculadoFuncao $fkPessoalAssentamentoVinculadoFuncao)
    {
        if (false === $this->fkPessoalAssentamentoVinculadoFuncoes->contains($fkPessoalAssentamentoVinculadoFuncao)) {
            $fkPessoalAssentamentoVinculadoFuncao->setFkAdministracaoFuncao($this);
            $this->fkPessoalAssentamentoVinculadoFuncoes->add($fkPessoalAssentamentoVinculadoFuncao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoVinculadoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculadoFuncao $fkPessoalAssentamentoVinculadoFuncao
     */
    public function removeFkPessoalAssentamentoVinculadoFuncoes(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculadoFuncao $fkPessoalAssentamentoVinculadoFuncao)
    {
        $this->fkPessoalAssentamentoVinculadoFuncoes->removeElement($fkPessoalAssentamentoVinculadoFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoVinculadoFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculadoFuncao
     */
    public function getFkPessoalAssentamentoVinculadoFuncoes()
    {
        return $this->fkPessoalAssentamentoVinculadoFuncoes;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoPenalidadeMulta
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta $fkFiscalizacaoPenalidadeMulta
     * @return Funcao
     */
    public function addFkFiscalizacaoPenalidadeMultas(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta $fkFiscalizacaoPenalidadeMulta)
    {
        if (false === $this->fkFiscalizacaoPenalidadeMultas->contains($fkFiscalizacaoPenalidadeMulta)) {
            $fkFiscalizacaoPenalidadeMulta->setFkAdministracaoFuncao($this);
            $this->fkFiscalizacaoPenalidadeMultas->add($fkFiscalizacaoPenalidadeMulta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoPenalidadeMulta
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta $fkFiscalizacaoPenalidadeMulta
     */
    public function removeFkFiscalizacaoPenalidadeMultas(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta $fkFiscalizacaoPenalidadeMulta)
    {
        $this->fkFiscalizacaoPenalidadeMultas->removeElement($fkFiscalizacaoPenalidadeMulta);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoPenalidadeMultas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta
     */
    public function getFkFiscalizacaoPenalidadeMultas()
    {
        return $this->fkFiscalizacaoPenalidadeMultas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoBiblioteca
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Biblioteca $fkAdministracaoBiblioteca
     * @return Funcao
     */
    public function setFkAdministracaoBiblioteca(\Urbem\CoreBundle\Entity\Administracao\Biblioteca $fkAdministracaoBiblioteca)
    {
        $this->codModulo = $fkAdministracaoBiblioteca->getCodModulo();
        $this->codBiblioteca = $fkAdministracaoBiblioteca->getCodBiblioteca();
        $this->fkAdministracaoBiblioteca = $fkAdministracaoBiblioteca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoBiblioteca
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Biblioteca
     */
    public function getFkAdministracaoBiblioteca()
    {
        return $this->fkAdministracaoBiblioteca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoTipoPrimitivo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\TipoPrimitivo $fkAdministracaoTipoPrimitivo
     * @return Funcao
     */
    public function setFkAdministracaoTipoPrimitivo(\Urbem\CoreBundle\Entity\Administracao\TipoPrimitivo $fkAdministracaoTipoPrimitivo)
    {
        $this->codTipoRetorno = $fkAdministracaoTipoPrimitivo->getCodTipo();
        $this->fkAdministracaoTipoPrimitivo = $fkAdministracaoTipoPrimitivo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoTipoPrimitivo
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\TipoPrimitivo
     */
    public function getFkAdministracaoTipoPrimitivo()
    {
        return $this->fkAdministracaoTipoPrimitivo;
    }

    /**
     * OneToOne (inverse side)
     * Set AdministracaoFuncaoExterna
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\FuncaoExterna $fkAdministracaoFuncaoExterna
     * @return Funcao
     */
    public function setFkAdministracaoFuncaoExterna(\Urbem\CoreBundle\Entity\Administracao\FuncaoExterna $fkAdministracaoFuncaoExterna)
    {
        $fkAdministracaoFuncaoExterna->setFkAdministracaoFuncao($this);
        $this->fkAdministracaoFuncaoExterna = $fkAdministracaoFuncaoExterna;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkAdministracaoFuncaoExterna
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\FuncaoExterna
     */
    public function getFkAdministracaoFuncaoExterna()
    {
        return $this->fkAdministracaoFuncaoExterna;
    }
    
    public function __toString()
    {
        return $this->codModulo
        . "." . $this->codBiblioteca
        . "." . $this->codFuncao
        . " - " . $this->nomFuncao
        ;
    }
}
