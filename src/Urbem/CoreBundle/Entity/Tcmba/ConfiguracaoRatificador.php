<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * ConfiguracaoRatificador
 */
class ConfiguracaoRatificador
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
    private $cgmRatificador;

    /**
     * PK
     * @var integer
     */
    private $numUnidade;

    /**
     * PK
     * @var integer
     */
    private $numOrgao;

    /**
     * @var \DateTime
     */
    private $dtInicioVigencia;

    /**
     * @var \DateTime
     */
    private $dtFimVigencia;

    /**
     * @var integer
     */
    private $codTipoResponsavel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\TipoResponsavel
     */
    private $fkTcmbaTipoResponsavel;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoRatificador
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
     * @return ConfiguracaoRatificador
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
     * Set cgmRatificador
     *
     * @param integer $cgmRatificador
     * @return ConfiguracaoRatificador
     */
    public function setCgmRatificador($cgmRatificador)
    {
        $this->cgmRatificador = $cgmRatificador;
        return $this;
    }

    /**
     * Get cgmRatificador
     *
     * @return integer
     */
    public function getCgmRatificador()
    {
        return $this->cgmRatificador;
    }

    /**
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return ConfiguracaoRatificador
     */
    public function setNumUnidade($numUnidade)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }

    /**
     * Get numUnidade
     *
     * @return integer
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return ConfiguracaoRatificador
     */
    public function setNumOrgao($numOrgao)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set dtInicioVigencia
     *
     * @param \DateTime $dtInicioVigencia
     * @return ConfiguracaoRatificador
     */
    public function setDtInicioVigencia(\DateTime $dtInicioVigencia)
    {
        $this->dtInicioVigencia = $dtInicioVigencia;
        return $this;
    }

    /**
     * Get dtInicioVigencia
     *
     * @return \DateTime
     */
    public function getDtInicioVigencia()
    {
        return $this->dtInicioVigencia;
    }

    /**
     * Set dtFimVigencia
     *
     * @param \DateTime $dtFimVigencia
     * @return ConfiguracaoRatificador
     */
    public function setDtFimVigencia(\DateTime $dtFimVigencia)
    {
        $this->dtFimVigencia = $dtFimVigencia;
        return $this;
    }

    /**
     * Get dtFimVigencia
     *
     * @return \DateTime
     */
    public function getDtFimVigencia()
    {
        return $this->dtFimVigencia;
    }

    /**
     * Set codTipoResponsavel
     *
     * @param integer $codTipoResponsavel
     * @return ConfiguracaoRatificador
     */
    public function setCodTipoResponsavel($codTipoResponsavel)
    {
        $this->codTipoResponsavel = $codTipoResponsavel;
        return $this;
    }

    /**
     * Get codTipoResponsavel
     *
     * @return integer
     */
    public function getCodTipoResponsavel()
    {
        return $this->codTipoResponsavel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return ConfiguracaoRatificador
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return ConfiguracaoRatificador
     */
    public function setFkOrcamentoUnidade(\Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade)
    {
        $this->exercicio = $fkOrcamentoUnidade->getExercicio();
        $this->numUnidade = $fkOrcamentoUnidade->getNumUnidade();
        $this->numOrgao = $fkOrcamentoUnidade->getNumOrgao();
        $this->fkOrcamentoUnidade = $fkOrcamentoUnidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoUnidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    public function getFkOrcamentoUnidade()
    {
        return $this->fkOrcamentoUnidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return ConfiguracaoRatificador
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->cgmRatificador = $fkSwCgmPessoaFisica->getNumcgm();
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
     * Set fkTcmbaTipoResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoResponsavel $fkTcmbaTipoResponsavel
     * @return ConfiguracaoRatificador
     */
    public function setFkTcmbaTipoResponsavel(\Urbem\CoreBundle\Entity\Tcmba\TipoResponsavel $fkTcmbaTipoResponsavel)
    {
        $this->codTipoResponsavel = $fkTcmbaTipoResponsavel->getCodTipoResponsavel();
        $this->fkTcmbaTipoResponsavel = $fkTcmbaTipoResponsavel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaTipoResponsavel
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TipoResponsavel
     */
    public function getFkTcmbaTipoResponsavel()
    {
        return $this->fkTcmbaTipoResponsavel;
    }
}
