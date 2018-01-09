<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * BoletimLiberadoLote
 */
class BoletimLiberadoLote
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codBoletim;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampFechamento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampLiberado;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var string
     */
    private $tipo;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\Lote
     */
    private $fkContabilidadeLote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberado
     */
    private $fkTesourariaBoletimLiberado;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampFechamento = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampLiberado = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return BoletimLiberadoLote
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
     * Set codBoletim
     *
     * @param integer $codBoletim
     * @return BoletimLiberadoLote
     */
    public function setCodBoletim($codBoletim)
    {
        $this->codBoletim = $codBoletim;
        return $this;
    }

    /**
     * Get codBoletim
     *
     * @return integer
     */
    public function getCodBoletim()
    {
        return $this->codBoletim;
    }

    /**
     * Set timestampFechamento
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampFechamento
     * @return BoletimLiberadoLote
     */
    public function setTimestampFechamento(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampFechamento)
    {
        $this->timestampFechamento = $timestampFechamento;
        return $this;
    }

    /**
     * Get timestampFechamento
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampFechamento()
    {
        return $this->timestampFechamento;
    }

    /**
     * Set timestampLiberado
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampLiberado
     * @return BoletimLiberadoLote
     */
    public function setTimestampLiberado(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampLiberado)
    {
        $this->timestampLiberado = $timestampLiberado;
        return $this;
    }

    /**
     * Get timestampLiberado
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampLiberado()
    {
        return $this->timestampLiberado;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return BoletimLiberadoLote
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
     * Set tipo
     *
     * @param string $tipo
     * @return BoletimLiberadoLote
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
     * Set codLote
     *
     * @param integer $codLote
     * @return BoletimLiberadoLote
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeLote
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Lote $fkContabilidadeLote
     * @return BoletimLiberadoLote
     */
    public function setFkContabilidadeLote(\Urbem\CoreBundle\Entity\Contabilidade\Lote $fkContabilidadeLote)
    {
        $this->codLote = $fkContabilidadeLote->getCodLote();
        $this->exercicio = $fkContabilidadeLote->getExercicio();
        $this->tipo = $fkContabilidadeLote->getTipo();
        $this->codEntidade = $fkContabilidadeLote->getCodEntidade();
        $this->fkContabilidadeLote = $fkContabilidadeLote;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadeLote
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\Lote
     */
    public function getFkContabilidadeLote()
    {
        return $this->fkContabilidadeLote;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaBoletimLiberado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberado $fkTesourariaBoletimLiberado
     * @return BoletimLiberadoLote
     */
    public function setFkTesourariaBoletimLiberado(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberado $fkTesourariaBoletimLiberado)
    {
        $this->codBoletim = $fkTesourariaBoletimLiberado->getCodBoletim();
        $this->exercicio = $fkTesourariaBoletimLiberado->getExercicio();
        $this->codEntidade = $fkTesourariaBoletimLiberado->getCodEntidade();
        $this->timestampLiberado = $fkTesourariaBoletimLiberado->getTimestampLiberado();
        $this->timestampFechamento = $fkTesourariaBoletimLiberado->getTimestampFechamento();
        $this->fkTesourariaBoletimLiberado = $fkTesourariaBoletimLiberado;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaBoletimLiberado
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberado
     */
    public function getFkTesourariaBoletimLiberado()
    {
        return $this->fkTesourariaBoletimLiberado;
    }
}
