<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * Desoneracao
 */
class Desoneracao
{
    /**
     * PK
     * @var integer
     */
    private $codDesoneracao;

    /**
     * @var integer
     */
    private $codCredito;

    /**
     * @var integer
     */
    private $codNatureza;

    /**
     * @var integer
     */
    private $codGenero;

    /**
     * @var integer
     */
    private $codEspecie;

    /**
     * @var integer
     */
    private $codTipoDesoneracao;

    /**
     * @var \DateTime
     */
    private $inicio;

    /**
     * @var \DateTime
     */
    private $termino;

    /**
     * @var boolean
     */
    private $prorrogavel = false;

    /**
     * @var boolean
     */
    private $revogavel = false;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * @var integer
     */
    private $fundamentacaoLegal;

    /**
     * @var \DateTime
     */
    private $expiracao;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var integer
     */
    private $codBiblioteca;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracao
     */
    private $fkArrecadacaoAtributoDesoneracoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoProrrogacao
     */
    private $fkArrecadacaoFundamentacaoProrrogacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoRevogacao
     */
    private $fkArrecadacaoFundamentacaoRevogacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Desonerado
     */
    private $fkArrecadacaoDesonerados;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Credito
     */
    private $fkMonetarioCredito;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\TipoDesoneracao
     */
    private $fkArrecadacaoTipoDesoneracao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    private $fkAdministracaoFuncao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoAtributoDesoneracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoFundamentacaoProrrogacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoFundamentacaoRevogacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoDesonerados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDesoneracao
     *
     * @param integer $codDesoneracao
     * @return Desoneracao
     */
    public function setCodDesoneracao($codDesoneracao)
    {
        $this->codDesoneracao = $codDesoneracao;
        return $this;
    }

    /**
     * Get codDesoneracao
     *
     * @return integer
     */
    public function getCodDesoneracao()
    {
        return $this->codDesoneracao;
    }

    /**
     * Set codCredito
     *
     * @param integer $codCredito
     * @return Desoneracao
     */
    public function setCodCredito($codCredito)
    {
        $this->codCredito = $codCredito;
        return $this;
    }

    /**
     * Get codCredito
     *
     * @return integer
     */
    public function getCodCredito()
    {
        return $this->codCredito;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return Desoneracao
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set codGenero
     *
     * @param integer $codGenero
     * @return Desoneracao
     */
    public function setCodGenero($codGenero)
    {
        $this->codGenero = $codGenero;
        return $this;
    }

    /**
     * Get codGenero
     *
     * @return integer
     */
    public function getCodGenero()
    {
        return $this->codGenero;
    }

    /**
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return Desoneracao
     */
    public function setCodEspecie($codEspecie)
    {
        $this->codEspecie = $codEspecie;
        return $this;
    }

    /**
     * Get codEspecie
     *
     * @return integer
     */
    public function getCodEspecie()
    {
        return $this->codEspecie;
    }

    /**
     * Set codTipoDesoneracao
     *
     * @param integer $codTipoDesoneracao
     * @return Desoneracao
     */
    public function setCodTipoDesoneracao($codTipoDesoneracao)
    {
        $this->codTipoDesoneracao = $codTipoDesoneracao;
        return $this;
    }

    /**
     * Get codTipoDesoneracao
     *
     * @return integer
     */
    public function getCodTipoDesoneracao()
    {
        return $this->codTipoDesoneracao;
    }

    /**
     * Set inicio
     *
     * @param \DateTime $inicio
     * @return Desoneracao
     */
    public function setInicio(\DateTime $inicio)
    {
        $this->inicio = $inicio;
        return $this;
    }

    /**
     * Get inicio
     *
     * @return \DateTime
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set termino
     *
     * @param \DateTime $termino
     * @return Desoneracao
     */
    public function setTermino(\DateTime $termino)
    {
        $this->termino = $termino;
        return $this;
    }

    /**
     * Get termino
     *
     * @return \DateTime
     */
    public function getTermino()
    {
        return $this->termino;
    }

    /**
     * Set prorrogavel
     *
     * @param boolean $prorrogavel
     * @return Desoneracao
     */
    public function setProrrogavel($prorrogavel)
    {
        $this->prorrogavel = $prorrogavel;
        return $this;
    }

    /**
     * Get prorrogavel
     *
     * @return boolean
     */
    public function getProrrogavel()
    {
        return $this->prorrogavel;
    }

    /**
     * Set revogavel
     *
     * @param boolean $revogavel
     * @return Desoneracao
     */
    public function setRevogavel($revogavel)
    {
        $this->revogavel = $revogavel;
        return $this;
    }

    /**
     * Get revogavel
     *
     * @return boolean
     */
    public function getRevogavel()
    {
        return $this->revogavel;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return Desoneracao
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
     * Set fundamentacaoLegal
     *
     * @param integer $fundamentacaoLegal
     * @return Desoneracao
     */
    public function setFundamentacaoLegal($fundamentacaoLegal)
    {
        $this->fundamentacaoLegal = $fundamentacaoLegal;
        return $this;
    }

    /**
     * Get fundamentacaoLegal
     *
     * @return integer
     */
    public function getFundamentacaoLegal()
    {
        return $this->fundamentacaoLegal;
    }

    /**
     * Set expiracao
     *
     * @param \DateTime $expiracao
     * @return Desoneracao
     */
    public function setExpiracao(\DateTime $expiracao = null)
    {
        $this->expiracao = $expiracao;
        return $this;
    }

    /**
     * Get expiracao
     *
     * @return \DateTime
     */
    public function getExpiracao()
    {
        return $this->expiracao;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return Desoneracao
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
     * @return Desoneracao
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
     * OneToMany (owning side)
     * Add ArrecadacaoAtributoDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracao $fkArrecadacaoAtributoDesoneracao
     * @return Desoneracao
     */
    public function addFkArrecadacaoAtributoDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracao $fkArrecadacaoAtributoDesoneracao)
    {
        if (false === $this->fkArrecadacaoAtributoDesoneracoes->contains($fkArrecadacaoAtributoDesoneracao)) {
            $fkArrecadacaoAtributoDesoneracao->setFkArrecadacaoDesoneracao($this);
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
     * Add ArrecadacaoFundamentacaoProrrogacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoProrrogacao $fkArrecadacaoFundamentacaoProrrogacao
     * @return Desoneracao
     */
    public function addFkArrecadacaoFundamentacaoProrrogacoes(\Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoProrrogacao $fkArrecadacaoFundamentacaoProrrogacao)
    {
        if (false === $this->fkArrecadacaoFundamentacaoProrrogacoes->contains($fkArrecadacaoFundamentacaoProrrogacao)) {
            $fkArrecadacaoFundamentacaoProrrogacao->setFkArrecadacaoDesoneracao($this);
            $this->fkArrecadacaoFundamentacaoProrrogacoes->add($fkArrecadacaoFundamentacaoProrrogacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoFundamentacaoProrrogacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoProrrogacao $fkArrecadacaoFundamentacaoProrrogacao
     */
    public function removeFkArrecadacaoFundamentacaoProrrogacoes(\Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoProrrogacao $fkArrecadacaoFundamentacaoProrrogacao)
    {
        $this->fkArrecadacaoFundamentacaoProrrogacoes->removeElement($fkArrecadacaoFundamentacaoProrrogacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoFundamentacaoProrrogacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoProrrogacao
     */
    public function getFkArrecadacaoFundamentacaoProrrogacoes()
    {
        return $this->fkArrecadacaoFundamentacaoProrrogacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoFundamentacaoRevogacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoRevogacao $fkArrecadacaoFundamentacaoRevogacao
     * @return Desoneracao
     */
    public function addFkArrecadacaoFundamentacaoRevogacoes(\Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoRevogacao $fkArrecadacaoFundamentacaoRevogacao)
    {
        if (false === $this->fkArrecadacaoFundamentacaoRevogacoes->contains($fkArrecadacaoFundamentacaoRevogacao)) {
            $fkArrecadacaoFundamentacaoRevogacao->setFkArrecadacaoDesoneracao($this);
            $this->fkArrecadacaoFundamentacaoRevogacoes->add($fkArrecadacaoFundamentacaoRevogacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoFundamentacaoRevogacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoRevogacao $fkArrecadacaoFundamentacaoRevogacao
     */
    public function removeFkArrecadacaoFundamentacaoRevogacoes(\Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoRevogacao $fkArrecadacaoFundamentacaoRevogacao)
    {
        $this->fkArrecadacaoFundamentacaoRevogacoes->removeElement($fkArrecadacaoFundamentacaoRevogacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoFundamentacaoRevogacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\FundamentacaoRevogacao
     */
    public function getFkArrecadacaoFundamentacaoRevogacoes()
    {
        return $this->fkArrecadacaoFundamentacaoRevogacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoDesonerado
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desonerado $fkArrecadacaoDesonerado
     * @return Desoneracao
     */
    public function addFkArrecadacaoDesonerados(\Urbem\CoreBundle\Entity\Arrecadacao\Desonerado $fkArrecadacaoDesonerado)
    {
        if (false === $this->fkArrecadacaoDesonerados->contains($fkArrecadacaoDesonerado)) {
            $fkArrecadacaoDesonerado->setFkArrecadacaoDesoneracao($this);
            $this->fkArrecadacaoDesonerados->add($fkArrecadacaoDesonerado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDesonerado
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desonerado $fkArrecadacaoDesonerado
     */
    public function removeFkArrecadacaoDesonerados(\Urbem\CoreBundle\Entity\Arrecadacao\Desonerado $fkArrecadacaoDesonerado)
    {
        $this->fkArrecadacaoDesonerados->removeElement($fkArrecadacaoDesonerado);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDesonerados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Desonerado
     */
    public function getFkArrecadacaoDesonerados()
    {
        return $this->fkArrecadacaoDesonerados;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito
     * @return Desoneracao
     */
    public function setFkMonetarioCredito(\Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito)
    {
        $this->codCredito = $fkMonetarioCredito->getCodCredito();
        $this->codNatureza = $fkMonetarioCredito->getCodNatureza();
        $this->codGenero = $fkMonetarioCredito->getCodGenero();
        $this->codEspecie = $fkMonetarioCredito->getCodEspecie();
        $this->fkMonetarioCredito = $fkMonetarioCredito;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioCredito
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Credito
     */
    public function getFkMonetarioCredito()
    {
        return $this->fkMonetarioCredito;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoTipoDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\TipoDesoneracao $fkArrecadacaoTipoDesoneracao
     * @return Desoneracao
     */
    public function setFkArrecadacaoTipoDesoneracao(\Urbem\CoreBundle\Entity\Arrecadacao\TipoDesoneracao $fkArrecadacaoTipoDesoneracao)
    {
        $this->codTipoDesoneracao = $fkArrecadacaoTipoDesoneracao->getCodTipoDesoneracao();
        $this->fkArrecadacaoTipoDesoneracao = $fkArrecadacaoTipoDesoneracao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoTipoDesoneracao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\TipoDesoneracao
     */
    public function getFkArrecadacaoTipoDesoneracao()
    {
        return $this->fkArrecadacaoTipoDesoneracao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return Desoneracao
     */
    public function setFkAdministracaoFuncao(\Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao)
    {
        $this->codModulo = $fkAdministracaoFuncao->getCodModulo();
        $this->codBiblioteca = $fkAdministracaoFuncao->getCodBiblioteca();
        $this->codFuncao = $fkAdministracaoFuncao->getCodFuncao();
        $this->fkAdministracaoFuncao = $fkAdministracaoFuncao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoFuncao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    public function getFkAdministracaoFuncao()
    {
        return $this->fkAdministracaoFuncao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return Desoneracao
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->fundamentacaoLegal = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%d', $this->codDesoneracao);
    }
}
