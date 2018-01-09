<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ArrecadacaoReceitaDedutoraEstornada
 */
class ArrecadacaoReceitaDedutoraEstornada
{
    /**
     * PK
     * @var integer
     */
    private $codReceitaDedutora;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampArrecadacao;

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
     * @var integer
     */
    private $codArrecadacao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampDedutoraEstornada;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampEstornada;

    /**
     * @var integer
     */
    private $vlEstornado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutora
     */
    private $fkTesourariaArrecadacaoReceitaDedutora;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada
     */
    private $fkTesourariaArrecadacaoEstornada;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampArrecadacao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampDedutoraEstornada = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampEstornada = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codReceitaDedutora
     *
     * @param integer $codReceitaDedutora
     * @return ArrecadacaoReceitaDedutoraEstornada
     */
    public function setCodReceitaDedutora($codReceitaDedutora)
    {
        $this->codReceitaDedutora = $codReceitaDedutora;
        return $this;
    }

    /**
     * Get codReceitaDedutora
     *
     * @return integer
     */
    public function getCodReceitaDedutora()
    {
        return $this->codReceitaDedutora;
    }

    /**
     * Set timestampArrecadacao
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampArrecadacao
     * @return ArrecadacaoReceitaDedutoraEstornada
     */
    public function setTimestampArrecadacao(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampArrecadacao)
    {
        $this->timestampArrecadacao = $timestampArrecadacao;
        return $this;
    }

    /**
     * Get timestampArrecadacao
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampArrecadacao()
    {
        return $this->timestampArrecadacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ArrecadacaoReceitaDedutoraEstornada
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
     * @return ArrecadacaoReceitaDedutoraEstornada
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
     * Set codArrecadacao
     *
     * @param integer $codArrecadacao
     * @return ArrecadacaoReceitaDedutoraEstornada
     */
    public function setCodArrecadacao($codArrecadacao)
    {
        $this->codArrecadacao = $codArrecadacao;
        return $this;
    }

    /**
     * Get codArrecadacao
     *
     * @return integer
     */
    public function getCodArrecadacao()
    {
        return $this->codArrecadacao;
    }

    /**
     * Set timestampDedutoraEstornada
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampDedutoraEstornada
     * @return ArrecadacaoReceitaDedutoraEstornada
     */
    public function setTimestampDedutoraEstornada(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampDedutoraEstornada)
    {
        $this->timestampDedutoraEstornada = $timestampDedutoraEstornada;
        return $this;
    }

    /**
     * Get timestampDedutoraEstornada
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampDedutoraEstornada()
    {
        return $this->timestampDedutoraEstornada;
    }

    /**
     * Set timestampEstornada
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampEstornada
     * @return ArrecadacaoReceitaDedutoraEstornada
     */
    public function setTimestampEstornada(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampEstornada)
    {
        $this->timestampEstornada = $timestampEstornada;
        return $this;
    }

    /**
     * Get timestampEstornada
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampEstornada()
    {
        return $this->timestampEstornada;
    }

    /**
     * Set vlEstornado
     *
     * @param integer $vlEstornado
     * @return ArrecadacaoReceitaDedutoraEstornada
     */
    public function setVlEstornado($vlEstornado)
    {
        $this->vlEstornado = $vlEstornado;
        return $this;
    }

    /**
     * Get vlEstornado
     *
     * @return integer
     */
    public function getVlEstornado()
    {
        return $this->vlEstornado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaArrecadacaoReceitaDedutora
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutora $fkTesourariaArrecadacaoReceitaDedutora
     * @return ArrecadacaoReceitaDedutoraEstornada
     */
    public function setFkTesourariaArrecadacaoReceitaDedutora(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutora $fkTesourariaArrecadacaoReceitaDedutora)
    {
        $this->codArrecadacao = $fkTesourariaArrecadacaoReceitaDedutora->getCodArrecadacao();
        $this->timestampArrecadacao = $fkTesourariaArrecadacaoReceitaDedutora->getTimestampArrecadacao();
        $this->codReceita = $fkTesourariaArrecadacaoReceitaDedutora->getCodReceita();
        $this->codReceitaDedutora = $fkTesourariaArrecadacaoReceitaDedutora->getCodReceitaDedutora();
        $this->exercicio = $fkTesourariaArrecadacaoReceitaDedutora->getExercicio();
        $this->fkTesourariaArrecadacaoReceitaDedutora = $fkTesourariaArrecadacaoReceitaDedutora;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaArrecadacaoReceitaDedutora
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutora
     */
    public function getFkTesourariaArrecadacaoReceitaDedutora()
    {
        return $this->fkTesourariaArrecadacaoReceitaDedutora;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaArrecadacaoEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada $fkTesourariaArrecadacaoEstornada
     * @return ArrecadacaoReceitaDedutoraEstornada
     */
    public function setFkTesourariaArrecadacaoEstornada(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada $fkTesourariaArrecadacaoEstornada)
    {
        $this->codArrecadacao = $fkTesourariaArrecadacaoEstornada->getCodArrecadacao();
        $this->exercicio = $fkTesourariaArrecadacaoEstornada->getExercicio();
        $this->timestampArrecadacao = $fkTesourariaArrecadacaoEstornada->getTimestampArrecadacao();
        $this->timestampEstornada = $fkTesourariaArrecadacaoEstornada->getTimestampEstornada();
        $this->fkTesourariaArrecadacaoEstornada = $fkTesourariaArrecadacaoEstornada;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaArrecadacaoEstornada
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada
     */
    public function getFkTesourariaArrecadacaoEstornada()
    {
        return $this->fkTesourariaArrecadacaoEstornada;
    }
}
