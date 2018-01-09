<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * BoletimLoteArrecadacaoInconsistencia
 */
class BoletimLoteArrecadacaoInconsistencia
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
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codBoletim;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampArrecadacao;

    /**
     * PK
     * @var integer
     */
    private $codArrecadacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Boletim
     */
    private $fkTesourariaBoletim;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    private $fkTesourariaArrecadacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Lote
     */
    private $fkArrecadacaoLote;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampArrecadacao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return BoletimLoteArrecadacaoInconsistencia
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return BoletimLoteArrecadacaoInconsistencia
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
     * @return BoletimLoteArrecadacaoInconsistencia
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
     * Set codLote
     *
     * @param integer $codLote
     * @return BoletimLoteArrecadacaoInconsistencia
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
     * Set timestampArrecadacao
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestampArrecadacao
     * @return BoletimLoteArrecadacaoInconsistencia
     */
    public function setTimestampArrecadacao(\Urbem\CoreBundle\Helper\DateTimePK $timestampArrecadacao)
    {
        $this->timestampArrecadacao = $timestampArrecadacao;
        return $this;
    }

    /**
     * Get timestampArrecadacao
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestampArrecadacao()
    {
        return $this->timestampArrecadacao;
    }

    /**
     * Set codArrecadacao
     *
     * @param integer $codArrecadacao
     * @return BoletimLoteArrecadacaoInconsistencia
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
     * ManyToOne (inverse side)
     * Set fkTesourariaBoletim
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim
     * @return BoletimLoteArrecadacaoInconsistencia
     */
    public function setFkTesourariaBoletim(\Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim)
    {
        $this->codBoletim = $fkTesourariaBoletim->getCodBoletim();
        $this->codEntidade = $fkTesourariaBoletim->getCodEntidade();
        $this->exercicio = $fkTesourariaBoletim->getExercicio();
        $this->fkTesourariaBoletim = $fkTesourariaBoletim;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaBoletim
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Boletim
     */
    public function getFkTesourariaBoletim()
    {
        return $this->fkTesourariaBoletim;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao
     * @return BoletimLoteArrecadacaoInconsistencia
     */
    public function setFkTesourariaArrecadacao(\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao)
    {
        $this->codArrecadacao = $fkTesourariaArrecadacao->getCodArrecadacao();
        $this->exercicio = $fkTesourariaArrecadacao->getExercicio();
        $this->timestampArrecadacao = $fkTesourariaArrecadacao->getTimestampArrecadacao();
        $this->fkTesourariaArrecadacao = $fkTesourariaArrecadacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaArrecadacao
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    public function getFkTesourariaArrecadacao()
    {
        return $this->fkTesourariaArrecadacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoLote
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote
     * @return BoletimLoteArrecadacaoInconsistencia
     */
    public function setFkArrecadacaoLote(\Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote)
    {
        $this->exercicio = $fkArrecadacaoLote->getExercicio();
        $this->codLote = $fkArrecadacaoLote->getCodLote();
        $this->fkArrecadacaoLote = $fkArrecadacaoLote;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoLote
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Lote
     */
    public function getFkArrecadacaoLote()
    {
        return $this->fkArrecadacaoLote;
    }
}
