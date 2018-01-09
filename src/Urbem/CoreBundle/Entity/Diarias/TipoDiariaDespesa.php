<?php
 
namespace Urbem\CoreBundle\Entity\Diarias;

/**
 * TipoDiariaDespesa
 */
class TipoDiariaDespesa
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codConta;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Diarias\TipoDiaria
     */
    private $fkDiariasTipoDiaria;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    private $fkOrcamentoContaDespesa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoDiariaDespesa
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return TipoDiariaDespesa
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
     * Set codConta
     *
     * @param integer $codConta
     * @return TipoDiariaDespesa
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return TipoDiariaDespesa
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
     * Set fkOrcamentoContaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa
     * @return TipoDiariaDespesa
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
     * OneToOne (owning side)
     * Set DiariasTipoDiaria
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\TipoDiaria $fkDiariasTipoDiaria
     * @return TipoDiariaDespesa
     */
    public function setFkDiariasTipoDiaria(\Urbem\CoreBundle\Entity\Diarias\TipoDiaria $fkDiariasTipoDiaria)
    {
        $this->codTipo = $fkDiariasTipoDiaria->getCodTipo();
        $this->timestamp = $fkDiariasTipoDiaria->getTimestamp();
        $this->fkDiariasTipoDiaria = $fkDiariasTipoDiaria;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkDiariasTipoDiaria
     *
     * @return \Urbem\CoreBundle\Entity\Diarias\TipoDiaria
     */
    public function getFkDiariasTipoDiaria()
    {
        return $this->fkDiariasTipoDiaria;
    }
}
