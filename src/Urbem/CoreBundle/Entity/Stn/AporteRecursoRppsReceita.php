<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * AporteRecursoRppsReceita
 */
class AporteRecursoRppsReceita
{
    /**
     * PK
     * @var integer
     */
    private $codAporte;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codReceita;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Stn\AporteRecursoRpps
     */
    private $fkStnAporteRecursoRpps;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceita;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codAporte
     *
     * @param integer $codAporte
     * @return AporteRecursoRppsReceita
     */
    public function setCodAporte($codAporte)
    {
        $this->codAporte = $codAporte;
        return $this;
    }

    /**
     * Get codAporte
     *
     * @return integer
     */
    public function getCodAporte()
    {
        return $this->codAporte;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return AporteRecursoRppsReceita
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
     * Set codReceita
     *
     * @param integer $codReceita
     * @return AporteRecursoRppsReceita
     */
    public function setCodReceita($codReceita)
    {
        $this->codReceita = $codReceita;
        return $this;
    }

    /**
     * Get codReceita
     *
     * @return integer
     */
    public function getCodReceita()
    {
        return $this->codReceita;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return AporteRecursoRppsReceita
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkStnAporteRecursoRpps
     *
     * @param \Urbem\CoreBundle\Entity\Stn\AporteRecursoRpps $fkStnAporteRecursoRpps
     * @return AporteRecursoRppsReceita
     */
    public function setFkStnAporteRecursoRpps(\Urbem\CoreBundle\Entity\Stn\AporteRecursoRpps $fkStnAporteRecursoRpps)
    {
        $this->codAporte = $fkStnAporteRecursoRpps->getCodAporte();
        $this->exercicio = $fkStnAporteRecursoRpps->getExercicio();
        $this->fkStnAporteRecursoRpps = $fkStnAporteRecursoRpps;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkStnAporteRecursoRpps
     *
     * @return \Urbem\CoreBundle\Entity\Stn\AporteRecursoRpps
     */
    public function getFkStnAporteRecursoRpps()
    {
        return $this->fkStnAporteRecursoRpps;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return AporteRecursoRppsReceita
     */
    public function setFkOrcamentoReceita(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        $this->exercicio = $fkOrcamentoReceita->getExercicio();
        $this->codReceita = $fkOrcamentoReceita->getCodReceita();
        $this->fkOrcamentoReceita = $fkOrcamentoReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    public function getFkOrcamentoReceita()
    {
        return $this->fkOrcamentoReceita;
    }
}
