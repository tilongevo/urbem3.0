<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * PermissaoTerminal
 */
class PermissaoTerminal
{
    /**
     * PK
     * @var integer
     */
    private $codTerminal;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestampTerminal;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Terminal
     */
    private $fkTesourariaTerminal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampTerminal = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return PermissaoTerminal
     */
    public function setCodTerminal($codTerminal)
    {
        $this->codTerminal = $codTerminal;
        return $this;
    }

    /**
     * Get codTerminal
     *
     * @return integer
     */
    public function getCodTerminal()
    {
        return $this->codTerminal;
    }

    /**
     * Set timestampTerminal
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestampTerminal
     * @return PermissaoTerminal
     */
    public function setTimestampTerminal(\Urbem\CoreBundle\Helper\DateTimePK $timestampTerminal)
    {
        $this->timestampTerminal = $timestampTerminal;
        return $this;
    }

    /**
     * Get timestampTerminal
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestampTerminal()
    {
        return $this->timestampTerminal;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return PermissaoTerminal
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return PermissaoTerminal
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
     * Set fkTesourariaTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Terminal $fkTesourariaTerminal
     * @return PermissaoTerminal
     */
    public function setFkTesourariaTerminal(\Urbem\CoreBundle\Entity\Tesouraria\Terminal $fkTesourariaTerminal)
    {
        $this->codTerminal = $fkTesourariaTerminal->getCodTerminal();
        $this->timestampTerminal = $fkTesourariaTerminal->getTimestampTerminal();
        $this->fkTesourariaTerminal = $fkTesourariaTerminal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaTerminal
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Terminal
     */
    public function getFkTesourariaTerminal()
    {
        return $this->fkTesourariaTerminal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return PermissaoTerminal
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
}
