<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ConfiguracaoReglic
 */
class ConfiguracaoReglic
{
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
    private $regulamentoArt47;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $regExclusiva;

    /**
     * @var string
     */
    private $artigoRegExclusiva;

    /**
     * @var integer
     */
    private $valorLimiteRegExclusiva;

    /**
     * @var integer
     */
    private $procSubContratacao;

    /**
     * @var string
     */
    private $artigoProcSubContratacao;

    /**
     * @var integer
     */
    private $percentualSubContratacao;

    /**
     * @var integer
     */
    private $criterioEmpenhoPagamento;

    /**
     * @var string
     */
    private $artigoEmpenhoPagamento;

    /**
     * @var integer
     */
    private $estabeleceuPercContratacao;

    /**
     * @var string
     */
    private $artigoPercContratacao;

    /**
     * @var integer
     */
    private $percentualContratacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoReglic
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
     * @return ConfiguracaoReglic
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
     * Set regulamentoArt47
     *
     * @param integer $regulamentoArt47
     * @return ConfiguracaoReglic
     */
    public function setRegulamentoArt47($regulamentoArt47)
    {
        $this->regulamentoArt47 = $regulamentoArt47;
        return $this;
    }

    /**
     * Get regulamentoArt47
     *
     * @return integer
     */
    public function getRegulamentoArt47()
    {
        return $this->regulamentoArt47;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return ConfiguracaoReglic
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set regExclusiva
     *
     * @param integer $regExclusiva
     * @return ConfiguracaoReglic
     */
    public function setRegExclusiva($regExclusiva)
    {
        $this->regExclusiva = $regExclusiva;
        return $this;
    }

    /**
     * Get regExclusiva
     *
     * @return integer
     */
    public function getRegExclusiva()
    {
        return $this->regExclusiva;
    }

    /**
     * Set artigoRegExclusiva
     *
     * @param string $artigoRegExclusiva
     * @return ConfiguracaoReglic
     */
    public function setArtigoRegExclusiva($artigoRegExclusiva = null)
    {
        $this->artigoRegExclusiva = $artigoRegExclusiva;
        return $this;
    }

    /**
     * Get artigoRegExclusiva
     *
     * @return string
     */
    public function getArtigoRegExclusiva()
    {
        return $this->artigoRegExclusiva;
    }

    /**
     * Set valorLimiteRegExclusiva
     *
     * @param integer $valorLimiteRegExclusiva
     * @return ConfiguracaoReglic
     */
    public function setValorLimiteRegExclusiva($valorLimiteRegExclusiva = null)
    {
        $this->valorLimiteRegExclusiva = $valorLimiteRegExclusiva;
        return $this;
    }

    /**
     * Get valorLimiteRegExclusiva
     *
     * @return integer
     */
    public function getValorLimiteRegExclusiva()
    {
        return $this->valorLimiteRegExclusiva;
    }

    /**
     * Set procSubContratacao
     *
     * @param integer $procSubContratacao
     * @return ConfiguracaoReglic
     */
    public function setProcSubContratacao($procSubContratacao)
    {
        $this->procSubContratacao = $procSubContratacao;
        return $this;
    }

    /**
     * Get procSubContratacao
     *
     * @return integer
     */
    public function getProcSubContratacao()
    {
        return $this->procSubContratacao;
    }

    /**
     * Set artigoProcSubContratacao
     *
     * @param string $artigoProcSubContratacao
     * @return ConfiguracaoReglic
     */
    public function setArtigoProcSubContratacao($artigoProcSubContratacao = null)
    {
        $this->artigoProcSubContratacao = $artigoProcSubContratacao;
        return $this;
    }

    /**
     * Get artigoProcSubContratacao
     *
     * @return string
     */
    public function getArtigoProcSubContratacao()
    {
        return $this->artigoProcSubContratacao;
    }

    /**
     * Set percentualSubContratacao
     *
     * @param integer $percentualSubContratacao
     * @return ConfiguracaoReglic
     */
    public function setPercentualSubContratacao($percentualSubContratacao = null)
    {
        $this->percentualSubContratacao = $percentualSubContratacao;
        return $this;
    }

    /**
     * Get percentualSubContratacao
     *
     * @return integer
     */
    public function getPercentualSubContratacao()
    {
        return $this->percentualSubContratacao;
    }

    /**
     * Set criterioEmpenhoPagamento
     *
     * @param integer $criterioEmpenhoPagamento
     * @return ConfiguracaoReglic
     */
    public function setCriterioEmpenhoPagamento($criterioEmpenhoPagamento)
    {
        $this->criterioEmpenhoPagamento = $criterioEmpenhoPagamento;
        return $this;
    }

    /**
     * Get criterioEmpenhoPagamento
     *
     * @return integer
     */
    public function getCriterioEmpenhoPagamento()
    {
        return $this->criterioEmpenhoPagamento;
    }

    /**
     * Set artigoEmpenhoPagamento
     *
     * @param string $artigoEmpenhoPagamento
     * @return ConfiguracaoReglic
     */
    public function setArtigoEmpenhoPagamento($artigoEmpenhoPagamento = null)
    {
        $this->artigoEmpenhoPagamento = $artigoEmpenhoPagamento;
        return $this;
    }

    /**
     * Get artigoEmpenhoPagamento
     *
     * @return string
     */
    public function getArtigoEmpenhoPagamento()
    {
        return $this->artigoEmpenhoPagamento;
    }

    /**
     * Set estabeleceuPercContratacao
     *
     * @param integer $estabeleceuPercContratacao
     * @return ConfiguracaoReglic
     */
    public function setEstabeleceuPercContratacao($estabeleceuPercContratacao)
    {
        $this->estabeleceuPercContratacao = $estabeleceuPercContratacao;
        return $this;
    }

    /**
     * Get estabeleceuPercContratacao
     *
     * @return integer
     */
    public function getEstabeleceuPercContratacao()
    {
        return $this->estabeleceuPercContratacao;
    }

    /**
     * Set artigoPercContratacao
     *
     * @param string $artigoPercContratacao
     * @return ConfiguracaoReglic
     */
    public function setArtigoPercContratacao($artigoPercContratacao = null)
    {
        $this->artigoPercContratacao = $artigoPercContratacao;
        return $this;
    }

    /**
     * Get artigoPercContratacao
     *
     * @return string
     */
    public function getArtigoPercContratacao()
    {
        return $this->artigoPercContratacao;
    }

    /**
     * Set percentualContratacao
     *
     * @param integer $percentualContratacao
     * @return ConfiguracaoReglic
     */
    public function setPercentualContratacao($percentualContratacao = null)
    {
        $this->percentualContratacao = $percentualContratacao;
        return $this;
    }

    /**
     * Get percentualContratacao
     *
     * @return integer
     */
    public function getPercentualContratacao()
    {
        return $this->percentualContratacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return ConfiguracaoReglic
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
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
     * OneToOne (owning side)
     * Set OrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return ConfiguracaoReglic
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }
}
