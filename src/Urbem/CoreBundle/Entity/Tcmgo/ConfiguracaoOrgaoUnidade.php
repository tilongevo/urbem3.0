<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * ConfiguracaoOrgaoUnidade
 */
class ConfiguracaoOrgaoUnidade
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
    private $codPoder;

    /**
     * @var integer
     */
    private $numOrgao;

    /**
     * @var integer
     */
    private $numUnidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\Poder
     */
    private $fkTcmgoPoder;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoOrgaoUnidade
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
     * @return ConfiguracaoOrgaoUnidade
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
     * Set codPoder
     *
     * @param integer $codPoder
     * @return ConfiguracaoOrgaoUnidade
     */
    public function setCodPoder($codPoder)
    {
        $this->codPoder = $codPoder;
        return $this;
    }

    /**
     * Get codPoder
     *
     * @return integer
     */
    public function getCodPoder()
    {
        return $this->codPoder;
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return ConfiguracaoOrgaoUnidade
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
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return ConfiguracaoOrgaoUnidade
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
     * ManyToOne (inverse side)
     * Set fkOrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return ConfiguracaoOrgaoUnidade
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
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return ConfiguracaoOrgaoUnidade
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
     * Set fkTcmgoPoder
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Poder $fkTcmgoPoder
     * @return ConfiguracaoOrgaoUnidade
     */
    public function setFkTcmgoPoder(\Urbem\CoreBundle\Entity\Tcmgo\Poder $fkTcmgoPoder)
    {
        $this->codPoder = $fkTcmgoPoder->getCodPoder();
        $this->fkTcmgoPoder = $fkTcmgoPoder;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoPoder
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\Poder
     */
    public function getFkTcmgoPoder()
    {
        return $this->fkTcmgoPoder;
    }
}
