<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoDirfIrrfContaReceita
 */
class ConfiguracaoDirfIrrfContaReceita
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
    private $codConta;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\ContaReceita
     */
    private $fkOrcamentoContaReceita;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf
     */
    private $fkImaConfiguracaoDirf;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoDirfIrrfContaReceita
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
     * Set codConta
     *
     * @param integer $codConta
     * @return ConfiguracaoDirfIrrfContaReceita
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaConfiguracaoDirf
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf
     * @return ConfiguracaoDirfIrrfContaReceita
     */
    public function setFkImaConfiguracaoDirf(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf)
    {
        $this->exercicio = $fkImaConfiguracaoDirf->getExercicio();
        $this->fkImaConfiguracaoDirf = $fkImaConfiguracaoDirf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaConfiguracaoDirf
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf
     */
    public function getFkImaConfiguracaoDirf()
    {
        return $this->fkImaConfiguracaoDirf;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoContaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaReceita $fkOrcamentoContaReceita
     * @return ConfiguracaoDirfIrrfContaReceita
     */
    public function setFkOrcamentoContaReceita(\Urbem\CoreBundle\Entity\Orcamento\ContaReceita $fkOrcamentoContaReceita)
    {
        $this->exercicio = $fkOrcamentoContaReceita->getExercicio();
        $this->codConta = $fkOrcamentoContaReceita->getCodConta();
        $this->fkOrcamentoContaReceita = $fkOrcamentoContaReceita;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoContaReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ContaReceita
     */
    public function getFkOrcamentoContaReceita()
    {
        return $this->fkOrcamentoContaReceita;
    }
}
