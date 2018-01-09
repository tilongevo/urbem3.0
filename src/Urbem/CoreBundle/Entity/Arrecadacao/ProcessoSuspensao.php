<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * ProcessoSuspensao
 */
class ProcessoSuspensao
{
    /**
     * PK
     * @var integer
     */
    private $codSuspensao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codLancamento;

    /**
     * @var integer
     */
    private $codProcesso;

    /**
     * @var string
     */
    private $anoExercicio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Suspensao
     */
    private $fkArrecadacaoSuspensao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codSuspensao
     *
     * @param integer $codSuspensao
     * @return ProcessoSuspensao
     */
    public function setCodSuspensao($codSuspensao)
    {
        $this->codSuspensao = $codSuspensao;
        return $this;
    }

    /**
     * Get codSuspensao
     *
     * @return integer
     */
    public function getCodSuspensao()
    {
        return $this->codSuspensao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return ProcessoSuspensao
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
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return ProcessoSuspensao
     */
    public function setCodLancamento($codLancamento)
    {
        $this->codLancamento = $codLancamento;
        return $this;
    }

    /**
     * Get codLancamento
     *
     * @return integer
     */
    public function getCodLancamento()
    {
        return $this->codLancamento;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return ProcessoSuspensao
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return ProcessoSuspensao
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoSuspensao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Suspensao $fkArrecadacaoSuspensao
     * @return ProcessoSuspensao
     */
    public function setFkArrecadacaoSuspensao(\Urbem\CoreBundle\Entity\Arrecadacao\Suspensao $fkArrecadacaoSuspensao)
    {
        $this->codSuspensao = $fkArrecadacaoSuspensao->getCodSuspensao();
        $this->codLancamento = $fkArrecadacaoSuspensao->getCodLancamento();
        $this->fkArrecadacaoSuspensao = $fkArrecadacaoSuspensao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoSuspensao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Suspensao
     */
    public function getFkArrecadacaoSuspensao()
    {
        return $this->fkArrecadacaoSuspensao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return ProcessoSuspensao
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->anoExercicio = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }
}
