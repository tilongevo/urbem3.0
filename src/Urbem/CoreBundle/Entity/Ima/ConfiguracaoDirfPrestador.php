<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoDirfPrestador
 */
class ConfiguracaoDirfPrestador
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
    private $codPrestador;

    /**
     * @var integer
     */
    private $codDirf;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var integer
     */
    private $codConta;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    private $fkOrcamentoContaDespesa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\CodigoDirf
     */
    private $fkImaCodigoDirf;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf
     */
    private $fkImaConfiguracaoDirf;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoDirfPrestador
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
     * Set codPrestador
     *
     * @param integer $codPrestador
     * @return ConfiguracaoDirfPrestador
     */
    public function setCodPrestador($codPrestador)
    {
        $this->codPrestador = $codPrestador;
        return $this;
    }

    /**
     * Get codPrestador
     *
     * @return integer
     */
    public function getCodPrestador()
    {
        return $this->codPrestador;
    }

    /**
     * Set codDirf
     *
     * @param integer $codDirf
     * @return ConfiguracaoDirfPrestador
     */
    public function setCodDirf($codDirf)
    {
        $this->codDirf = $codDirf;
        return $this;
    }

    /**
     * Get codDirf
     *
     * @return integer
     */
    public function getCodDirf()
    {
        return $this->codDirf;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return ConfiguracaoDirfPrestador
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return ConfiguracaoDirfPrestador
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
     * Set fkOrcamentoContaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa
     * @return ConfiguracaoDirfPrestador
     */
    public function setFkOrcamentoContaDespesa(\Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa)
    {
        $this->exercicio = $fkOrcamentoContaDespesa->getExercicio();
        $this->codConta = $fkOrcamentoContaDespesa->getCodConta();
        $this->fkOrcamentoContaDespesa = $fkOrcamentoContaDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoContaDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    public function getFkOrcamentoContaDespesa()
    {
        return $this->fkOrcamentoContaDespesa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaCodigoDirf
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CodigoDirf $fkImaCodigoDirf
     * @return ConfiguracaoDirfPrestador
     */
    public function setFkImaCodigoDirf(\Urbem\CoreBundle\Entity\Ima\CodigoDirf $fkImaCodigoDirf)
    {
        $this->exercicio = $fkImaCodigoDirf->getExercicio();
        $this->codDirf = $fkImaCodigoDirf->getCodDirf();
        $this->tipo = $fkImaCodigoDirf->getTipo();
        $this->fkImaCodigoDirf = $fkImaCodigoDirf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaCodigoDirf
     *
     * @return \Urbem\CoreBundle\Entity\Ima\CodigoDirf
     */
    public function getFkImaCodigoDirf()
    {
        return $this->fkImaCodigoDirf;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaConfiguracaoDirf
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf
     * @return ConfiguracaoDirfPrestador
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
}
