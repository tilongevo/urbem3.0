<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * ResponsavelLicitacao
 */
class ResponsavelLicitacao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ResponsavelLicitacao
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
     * @return ResponsavelLicitacao
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
     * @return ResponsavelLicitacao
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
     * @return ResponsavelLicitacao
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
     * @return ResponsavelLicitacao
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
     * @return ResponsavelLicitacao
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
     * @return ResponsavelLicitacao
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
     * @return ResponsavelLicitacao
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
     * @return ResponsavelLicitacao
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
     * @return ResponsavelLicitacao
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
     * Set cgmRespPesquisa
     *
     * @param integer $cgmRespPesquisa
     * @return ResponsavelLicitacao
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
     * @return ResponsavelLicitacao
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
     * @return ResponsavelLicitacao
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
     * @return ResponsavelLicitacao
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
     * @return ResponsavelLicitacao
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
     * @return ResponsavelLicitacao
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
     * @return ResponsavelLicitacao
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
     * @return ResponsavelLicitacao
     */
    public function setFkSwCgmPessoaFisica6(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica6)
    {
        $this->cgmRespPesquisa = $fkSwCgmPessoaFisica6->getNumcgm();
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
     * OneToOne (owning side)
     * Set LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return ResponsavelLicitacao
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
