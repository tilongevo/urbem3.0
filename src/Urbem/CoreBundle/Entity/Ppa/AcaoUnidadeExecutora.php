<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * AcaoUnidadeExecutora
 */
class AcaoUnidadeExecutora
{
    /**
     * PK
     * @var integer
     */
    private $codAcao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampAcaoDados;

    /**
     * PK
     * @var string
     */
    private $exercicioUnidade;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\AcaoDados
     */
    private $fkPpaAcaoDados;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampAcaoDados = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return AcaoUnidadeExecutora
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
        return $this;
    }

    /**
     * Get codAcao
     *
     * @return integer
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * Set timestampAcaoDados
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAcaoDados
     * @return AcaoUnidadeExecutora
     */
    public function setTimestampAcaoDados(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAcaoDados)
    {
        $this->timestampAcaoDados = $timestampAcaoDados;
        return $this;
    }

    /**
     * Get timestampAcaoDados
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampAcaoDados()
    {
        return $this->timestampAcaoDados;
    }

    /**
     * Set exercicioUnidade
     *
     * @param string $exercicioUnidade
     * @return AcaoUnidadeExecutora
     */
    public function setExercicioUnidade($exercicioUnidade)
    {
        $this->exercicioUnidade = $exercicioUnidade;
        return $this;
    }

    /**
     * Get exercicioUnidade
     *
     * @return string
     */
    public function getExercicioUnidade()
    {
        return $this->exercicioUnidade;
    }

    /**
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return AcaoUnidadeExecutora
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
     * @return AcaoUnidadeExecutora
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
     * ManyToOne (inverse side)
     * Set fkPpaAcaoDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados
     * @return AcaoUnidadeExecutora
     */
    public function setFkPpaAcaoDados(\Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados)
    {
        $this->codAcao = $fkPpaAcaoDados->getCodAcao();
        $this->timestampAcaoDados = $fkPpaAcaoDados->getTimestampAcaoDados();
        $this->fkPpaAcaoDados = $fkPpaAcaoDados;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaAcaoDados
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\AcaoDados
     */
    public function getFkPpaAcaoDados()
    {
        return $this->fkPpaAcaoDados;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return AcaoUnidadeExecutora
     */
    public function setFkOrcamentoUnidade(\Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade)
    {
        $this->exercicioUnidade = $fkOrcamentoUnidade->getExercicio();
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
}
