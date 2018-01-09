<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * PlanoContaHistorico
 */
class PlanoContaHistorico
{
    /**
     * PK
     * @var integer
     */
    private $codUf;

    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoContaGeral
     */
    private $fkContabilidadePlanoContaGeral;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return PlanoContaHistorico
     */
    public function setCodUf($codUf)
    {
        $this->codUf = $codUf;
        return $this;
    }

    /**
     * Get codUf
     *
     * @return integer
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return PlanoContaHistorico
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return PlanoContaHistorico
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PlanoContaHistorico
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
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoContaGeral
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoContaGeral $fkContabilidadePlanoContaGeral
     * @return PlanoContaHistorico
     */
    public function setFkContabilidadePlanoContaGeral(\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaGeral $fkContabilidadePlanoContaGeral)
    {
        $this->codUf = $fkContabilidadePlanoContaGeral->getCodUf();
        $this->codPlano = $fkContabilidadePlanoContaGeral->getCodPlano();
        $this->fkContabilidadePlanoContaGeral = $fkContabilidadePlanoContaGeral;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoContaGeral
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoContaGeral
     */
    public function getFkContabilidadePlanoContaGeral()
    {
        return $this->fkContabilidadePlanoContaGeral;
    }
}
