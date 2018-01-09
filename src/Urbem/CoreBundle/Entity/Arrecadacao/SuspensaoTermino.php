<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * SuspensaoTermino
 */
class SuspensaoTermino
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
     * @var \DateTime
     */
    private $termino;

    /**
     * @var string
     */
    private $observacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Suspensao
     */
    private $fkArrecadacaoSuspensao;

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
     * @return SuspensaoTermino
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
     * @return SuspensaoTermino
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
     * @return SuspensaoTermino
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
     * Set termino
     *
     * @param \DateTime $termino
     * @return SuspensaoTermino
     */
    public function setTermino(\DateTime $termino)
    {
        $this->termino = $termino;
        return $this;
    }

    /**
     * Get termino
     *
     * @return \DateTime
     */
    public function getTermino()
    {
        return $this->termino;
    }

    /**
     * Set observacoes
     *
     * @param string $observacoes
     * @return SuspensaoTermino
     */
    public function setObservacoes($observacoes)
    {
        $this->observacoes = $observacoes;
        return $this;
    }

    /**
     * Get observacoes
     *
     * @return string
     */
    public function getObservacoes()
    {
        return $this->observacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoSuspensao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Suspensao $fkArrecadacaoSuspensao
     * @return SuspensaoTermino
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
}
