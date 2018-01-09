<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ArrecadacaoEstornadaReceita
 */
class ArrecadacaoEstornadaReceita
{
    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampEstornada;

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
    private $codArrecadacao;

    /**
     * @var integer
     */
    private $codReceita;

    /**
     * @var integer
     */
    private $vlEstornado;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada
     */
    private $fkTesourariaArrecadacaoEstornada;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita
     */
    private $fkTesourariaArrecadacaoReceita;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampEstornada = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampArrecadacao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set timestampEstornada
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampEstornada
     * @return ArrecadacaoEstornadaReceita
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
     * Set timestampArrecadacao
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampArrecadacao
     * @return ArrecadacaoEstornadaReceita
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
     * @return ArrecadacaoEstornadaReceita
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
     * Set codArrecadacao
     *
     * @param integer $codArrecadacao
     * @return ArrecadacaoEstornadaReceita
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
     * Set codReceita
     *
     * @param integer $codReceita
     * @return ArrecadacaoEstornadaReceita
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
     * Set vlEstornado
     *
     * @param integer $vlEstornado
     * @return ArrecadacaoEstornadaReceita
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
     * Set fkTesourariaArrecadacaoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita $fkTesourariaArrecadacaoReceita
     * @return ArrecadacaoEstornadaReceita
     */
    public function setFkTesourariaArrecadacaoReceita(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita $fkTesourariaArrecadacaoReceita)
    {
        $this->codArrecadacao = $fkTesourariaArrecadacaoReceita->getCodArrecadacao();
        $this->timestampArrecadacao = $fkTesourariaArrecadacaoReceita->getTimestampArrecadacao();
        $this->codReceita = $fkTesourariaArrecadacaoReceita->getCodReceita();
        $this->exercicio = $fkTesourariaArrecadacaoReceita->getExercicio();
        $this->fkTesourariaArrecadacaoReceita = $fkTesourariaArrecadacaoReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaArrecadacaoReceita
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita
     */
    public function getFkTesourariaArrecadacaoReceita()
    {
        return $this->fkTesourariaArrecadacaoReceita;
    }

    /**
     * OneToOne (owning side)
     * Set TesourariaArrecadacaoEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada $fkTesourariaArrecadacaoEstornada
     * @return ArrecadacaoEstornadaReceita
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
     * OneToOne (owning side)
     * Get fkTesourariaArrecadacaoEstornada
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada
     */
    public function getFkTesourariaArrecadacaoEstornada()
    {
        return $this->fkTesourariaArrecadacaoEstornada;
    }
}
