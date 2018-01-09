<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * Resplic
 */
class Resplic
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
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var integer
     */
    private $codLicitacao;

    /**
     * @var integer
     */
    private $cgmRespAberturaLicitacao;

    /**
     * @var integer
     */
    private $cgmRespEdital;

    /**
     * @var integer
     */
    private $cgmRespRecursoOrcamentario;

    /**
     * @var integer
     */
    private $cgmRespConducaoLicitacao;

    /**
     * @var integer
     */
    private $cgmRespHomologacao;

    /**
     * @var integer
     */
    private $cgmRespAdjudicacao;

    /**
     * @var integer
     */
    private $cgmRespPublicacao;

    /**
     * @var integer
     */
    private $cgmRespAvaliacaoBens;

    /**
     * @var integer
     */
    private $cgmRespPesquisa;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica1;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica2;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica3;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica4;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica5;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica6;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica7;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica8;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Resplic
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
     * @return Resplic
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
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return Resplic
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return Resplic
     */
    public function setCodLicitacao($codLicitacao)
    {
        $this->codLicitacao = $codLicitacao;
        return $this;
    }

    /**
     * Get codLicitacao
     *
     * @return integer
     */
    public function getCodLicitacao()
    {
        return $this->codLicitacao;
    }

    /**
     * Set cgmRespAberturaLicitacao
     *
     * @param integer $cgmRespAberturaLicitacao
     * @return Resplic
     */
    public function setCgmRespAberturaLicitacao($cgmRespAberturaLicitacao = null)
    {
        $this->cgmRespAberturaLicitacao = $cgmRespAberturaLicitacao;
        return $this;
    }

    /**
     * Get cgmRespAberturaLicitacao
     *
     * @return integer
     */
    public function getCgmRespAberturaLicitacao()
    {
        return $this->cgmRespAberturaLicitacao;
    }

    /**
     * Set cgmRespEdital
     *
     * @param integer $cgmRespEdital
     * @return Resplic
     */
    public function setCgmRespEdital($cgmRespEdital = null)
    {
        $this->cgmRespEdital = $cgmRespEdital;
        return $this;
    }

    /**
     * Get cgmRespEdital
     *
     * @return integer
     */
    public function getCgmRespEdital()
    {
        return $this->cgmRespEdital;
    }

    /**
     * Set cgmRespRecursoOrcamentario
     *
     * @param integer $cgmRespRecursoOrcamentario
     * @return Resplic
     */
    public function setCgmRespRecursoOrcamentario($cgmRespRecursoOrcamentario = null)
    {
        $this->cgmRespRecursoOrcamentario = $cgmRespRecursoOrcamentario;
        return $this;
    }

    /**
     * Get cgmRespRecursoOrcamentario
     *
     * @return integer
     */
    public function getCgmRespRecursoOrcamentario()
    {
        return $this->cgmRespRecursoOrcamentario;
    }

    /**
     * Set cgmRespConducaoLicitacao
     *
     * @param integer $cgmRespConducaoLicitacao
     * @return Resplic
     */
    public function setCgmRespConducaoLicitacao($cgmRespConducaoLicitacao = null)
    {
        $this->cgmRespConducaoLicitacao = $cgmRespConducaoLicitacao;
        return $this;
    }

    /**
     * Get cgmRespConducaoLicitacao
     *
     * @return integer
     */
    public function getCgmRespConducaoLicitacao()
    {
        return $this->cgmRespConducaoLicitacao;
    }

    /**
     * Set cgmRespHomologacao
     *
     * @param integer $cgmRespHomologacao
     * @return Resplic
     */
    public function setCgmRespHomologacao($cgmRespHomologacao = null)
    {
        $this->cgmRespHomologacao = $cgmRespHomologacao;
        return $this;
    }

    /**
     * Get cgmRespHomologacao
     *
     * @return integer
     */
    public function getCgmRespHomologacao()
    {
        return $this->cgmRespHomologacao;
    }

    /**
     * Set cgmRespAdjudicacao
     *
     * @param integer $cgmRespAdjudicacao
     * @return Resplic
     */
    public function setCgmRespAdjudicacao($cgmRespAdjudicacao = null)
    {
        $this->cgmRespAdjudicacao = $cgmRespAdjudicacao;
        return $this;
    }

    /**
     * Get cgmRespAdjudicacao
     *
     * @return integer
     */
    public function getCgmRespAdjudicacao()
    {
        return $this->cgmRespAdjudicacao;
    }

    /**
     * Set cgmRespPublicacao
     *
     * @param integer $cgmRespPublicacao
     * @return Resplic
     */
    public function setCgmRespPublicacao($cgmRespPublicacao = null)
    {
        $this->cgmRespPublicacao = $cgmRespPublicacao;
        return $this;
    }

    /**
     * Get cgmRespPublicacao
     *
     * @return integer
     */
    public function getCgmRespPublicacao()
    {
        return $this->cgmRespPublicacao;
    }

    /**
     * Set cgmRespAvaliacaoBens
     *
     * @param integer $cgmRespAvaliacaoBens
     * @return Resplic
     */
    public function setCgmRespAvaliacaoBens($cgmRespAvaliacaoBens = null)
    {
        $this->cgmRespAvaliacaoBens = $cgmRespAvaliacaoBens;
        return $this;
    }

    /**
     * Get cgmRespAvaliacaoBens
     *
     * @return integer
     */
    public function getCgmRespAvaliacaoBens()
    {
        return $this->cgmRespAvaliacaoBens;
    }

    /**
     * Set cgmRespPesquisa
     *
     * @param integer $cgmRespPesquisa
     * @return Resplic
     */
    public function setCgmRespPesquisa($cgmRespPesquisa = null)
    {
        $this->cgmRespPesquisa = $cgmRespPesquisa;
        return $this;
    }

    /**
     * Get cgmRespPesquisa
     *
     * @return integer
     */
    public function getCgmRespPesquisa()
    {
        return $this->cgmRespPesquisa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return Resplic
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->cgmRespAberturaLicitacao = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica1
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica1
     * @return Resplic
     */
    public function setFkSwCgmPessoaFisica1(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica1)
    {
        $this->cgmRespEdital = $fkSwCgmPessoaFisica1->getNumcgm();
        $this->fkSwCgmPessoaFisica1 = $fkSwCgmPessoaFisica1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica1
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica1()
    {
        return $this->fkSwCgmPessoaFisica1;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica2
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica2
     * @return Resplic
     */
    public function setFkSwCgmPessoaFisica2(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica2)
    {
        $this->cgmRespRecursoOrcamentario = $fkSwCgmPessoaFisica2->getNumcgm();
        $this->fkSwCgmPessoaFisica2 = $fkSwCgmPessoaFisica2;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica2
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica2()
    {
        return $this->fkSwCgmPessoaFisica2;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica3
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica3
     * @return Resplic
     */
    public function setFkSwCgmPessoaFisica3(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica3)
    {
        $this->cgmRespConducaoLicitacao = $fkSwCgmPessoaFisica3->getNumcgm();
        $this->fkSwCgmPessoaFisica3 = $fkSwCgmPessoaFisica3;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica3
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica3()
    {
        return $this->fkSwCgmPessoaFisica3;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica4
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica4
     * @return Resplic
     */
    public function setFkSwCgmPessoaFisica4(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica4)
    {
        $this->cgmRespHomologacao = $fkSwCgmPessoaFisica4->getNumcgm();
        $this->fkSwCgmPessoaFisica4 = $fkSwCgmPessoaFisica4;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica4
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica4()
    {
        return $this->fkSwCgmPessoaFisica4;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica5
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica5
     * @return Resplic
     */
    public function setFkSwCgmPessoaFisica5(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica5)
    {
        $this->cgmRespAdjudicacao = $fkSwCgmPessoaFisica5->getNumcgm();
        $this->fkSwCgmPessoaFisica5 = $fkSwCgmPessoaFisica5;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica5
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica5()
    {
        return $this->fkSwCgmPessoaFisica5;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica6
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica6
     * @return Resplic
     */
    public function setFkSwCgmPessoaFisica6(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica6)
    {
        $this->cgmRespPublicacao = $fkSwCgmPessoaFisica6->getNumcgm();
        $this->fkSwCgmPessoaFisica6 = $fkSwCgmPessoaFisica6;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica6
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica6()
    {
        return $this->fkSwCgmPessoaFisica6;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica7
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica7
     * @return Resplic
     */
    public function setFkSwCgmPessoaFisica7(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica7)
    {
        $this->cgmRespAvaliacaoBens = $fkSwCgmPessoaFisica7->getNumcgm();
        $this->fkSwCgmPessoaFisica7 = $fkSwCgmPessoaFisica7;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica7
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica7()
    {
        return $this->fkSwCgmPessoaFisica7;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica8
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica8
     * @return Resplic
     */
    public function setFkSwCgmPessoaFisica8(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica8)
    {
        $this->cgmRespPesquisa = $fkSwCgmPessoaFisica8->getNumcgm();
        $this->fkSwCgmPessoaFisica8 = $fkSwCgmPessoaFisica8;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica8
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica8()
    {
        return $this->fkSwCgmPessoaFisica8;
    }

    /**
     * OneToOne (owning side)
     * Set LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return Resplic
     */
    public function setFkLicitacaoLicitacao(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        $this->codLicitacao = $fkLicitacaoLicitacao->getCodLicitacao();
        $this->codModalidade = $fkLicitacaoLicitacao->getCodModalidade();
        $this->codEntidade = $fkLicitacaoLicitacao->getCodEntidade();
        $this->exercicio = $fkLicitacaoLicitacao->getExercicio();
        $this->fkLicitacaoLicitacao = $fkLicitacaoLicitacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkLicitacaoLicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    public function getFkLicitacaoLicitacao()
    {
        return $this->fkLicitacaoLicitacao;
    }
}
