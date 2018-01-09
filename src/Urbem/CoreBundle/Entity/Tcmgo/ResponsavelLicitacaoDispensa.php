<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * ResponsavelLicitacaoDispensa
 */
class ResponsavelLicitacaoDispensa
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
    private $cgmRespAberturaDisp;

    /**
     * @var integer
     */
    private $cgmRespCotacaoPrecos;

    /**
     * @var integer
     */
    private $cgmRespRecurso;

    /**
     * @var integer
     */
    private $cgmRespRatificacao;

    /**
     * @var integer
     */
    private $cgmRespPublicacaoOrgao;

    /**
     * @var integer
     */
    private $cgmRespParecerJuridico;

    /**
     * @var integer
     */
    private $cgmRespParecerOutro;

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
     * @return ResponsavelLicitacaoDispensa
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
     * @return ResponsavelLicitacaoDispensa
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
     * @return ResponsavelLicitacaoDispensa
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
     * @return ResponsavelLicitacaoDispensa
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
     * Set cgmRespAberturaDisp
     *
     * @param integer $cgmRespAberturaDisp
     * @return ResponsavelLicitacaoDispensa
     */
    public function setCgmRespAberturaDisp($cgmRespAberturaDisp = null)
    {
        $this->cgmRespAberturaDisp = $cgmRespAberturaDisp;
        return $this;
    }

    /**
     * Get cgmRespAberturaDisp
     *
     * @return integer
     */
    public function getCgmRespAberturaDisp()
    {
        return $this->cgmRespAberturaDisp;
    }

    /**
     * Set cgmRespCotacaoPrecos
     *
     * @param integer $cgmRespCotacaoPrecos
     * @return ResponsavelLicitacaoDispensa
     */
    public function setCgmRespCotacaoPrecos($cgmRespCotacaoPrecos = null)
    {
        $this->cgmRespCotacaoPrecos = $cgmRespCotacaoPrecos;
        return $this;
    }

    /**
     * Get cgmRespCotacaoPrecos
     *
     * @return integer
     */
    public function getCgmRespCotacaoPrecos()
    {
        return $this->cgmRespCotacaoPrecos;
    }

    /**
     * Set cgmRespRecurso
     *
     * @param integer $cgmRespRecurso
     * @return ResponsavelLicitacaoDispensa
     */
    public function setCgmRespRecurso($cgmRespRecurso = null)
    {
        $this->cgmRespRecurso = $cgmRespRecurso;
        return $this;
    }

    /**
     * Get cgmRespRecurso
     *
     * @return integer
     */
    public function getCgmRespRecurso()
    {
        return $this->cgmRespRecurso;
    }

    /**
     * Set cgmRespRatificacao
     *
     * @param integer $cgmRespRatificacao
     * @return ResponsavelLicitacaoDispensa
     */
    public function setCgmRespRatificacao($cgmRespRatificacao = null)
    {
        $this->cgmRespRatificacao = $cgmRespRatificacao;
        return $this;
    }

    /**
     * Get cgmRespRatificacao
     *
     * @return integer
     */
    public function getCgmRespRatificacao()
    {
        return $this->cgmRespRatificacao;
    }

    /**
     * Set cgmRespPublicacaoOrgao
     *
     * @param integer $cgmRespPublicacaoOrgao
     * @return ResponsavelLicitacaoDispensa
     */
    public function setCgmRespPublicacaoOrgao($cgmRespPublicacaoOrgao = null)
    {
        $this->cgmRespPublicacaoOrgao = $cgmRespPublicacaoOrgao;
        return $this;
    }

    /**
     * Get cgmRespPublicacaoOrgao
     *
     * @return integer
     */
    public function getCgmRespPublicacaoOrgao()
    {
        return $this->cgmRespPublicacaoOrgao;
    }

    /**
     * Set cgmRespParecerJuridico
     *
     * @param integer $cgmRespParecerJuridico
     * @return ResponsavelLicitacaoDispensa
     */
    public function setCgmRespParecerJuridico($cgmRespParecerJuridico = null)
    {
        $this->cgmRespParecerJuridico = $cgmRespParecerJuridico;
        return $this;
    }

    /**
     * Get cgmRespParecerJuridico
     *
     * @return integer
     */
    public function getCgmRespParecerJuridico()
    {
        return $this->cgmRespParecerJuridico;
    }

    /**
     * Set cgmRespParecerOutro
     *
     * @param integer $cgmRespParecerOutro
     * @return ResponsavelLicitacaoDispensa
     */
    public function setCgmRespParecerOutro($cgmRespParecerOutro = null)
    {
        $this->cgmRespParecerOutro = $cgmRespParecerOutro;
        return $this;
    }

    /**
     * Get cgmRespParecerOutro
     *
     * @return integer
     */
    public function getCgmRespParecerOutro()
    {
        return $this->cgmRespParecerOutro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return ResponsavelLicitacaoDispensa
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->cgmRespAberturaDisp = $fkSwCgmPessoaFisica->getNumcgm();
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
     * @return ResponsavelLicitacaoDispensa
     */
    public function setFkSwCgmPessoaFisica1(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica1)
    {
        $this->cgmRespCotacaoPrecos = $fkSwCgmPessoaFisica1->getNumcgm();
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
     * @return ResponsavelLicitacaoDispensa
     */
    public function setFkSwCgmPessoaFisica2(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica2)
    {
        $this->cgmRespRecurso = $fkSwCgmPessoaFisica2->getNumcgm();
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
     * @return ResponsavelLicitacaoDispensa
     */
    public function setFkSwCgmPessoaFisica3(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica3)
    {
        $this->cgmRespRatificacao = $fkSwCgmPessoaFisica3->getNumcgm();
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
     * @return ResponsavelLicitacaoDispensa
     */
    public function setFkSwCgmPessoaFisica4(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica4)
    {
        $this->cgmRespPublicacaoOrgao = $fkSwCgmPessoaFisica4->getNumcgm();
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
     * @return ResponsavelLicitacaoDispensa
     */
    public function setFkSwCgmPessoaFisica5(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica5)
    {
        $this->cgmRespParecerJuridico = $fkSwCgmPessoaFisica5->getNumcgm();
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
     * @return ResponsavelLicitacaoDispensa
     */
    public function setFkSwCgmPessoaFisica6(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica6)
    {
        $this->cgmRespParecerOutro = $fkSwCgmPessoaFisica6->getNumcgm();
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
     * @return ResponsavelLicitacaoDispensa
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
