<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * BoletimLoteArrecadacaoEstornado
 */
class BoletimLoteArrecadacaoEstornado
{
    /**
     * PK
     * @var integer
     */
    private $codArrecadacao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampArrecadacao;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var integer
     */
    private $codBoletim;

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
     * @var \DateTime
     */
    private $timestampAnulacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao
     */
    private $fkTesourariaBoletimLoteArrecadacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampArrecadacao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codArrecadacao
     *
     * @param integer $codArrecadacao
     * @return BoletimLoteArrecadacaoEstornado
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
     * Set timestampArrecadacao
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestampArrecadacao
     * @return BoletimLoteArrecadacaoEstornado
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
     * Set codLote
     *
     * @param integer $codLote
     * @return BoletimLoteArrecadacaoEstornado
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
     * Set codBoletim
     *
     * @param integer $codBoletim
     * @return BoletimLoteArrecadacaoEstornado
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return BoletimLoteArrecadacaoEstornado
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
     * @return BoletimLoteArrecadacaoEstornado
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
     * Set timestampAnulacao
     *
     * @param \DateTime $timestampAnulacao
     * @return BoletimLoteArrecadacaoEstornado
     */
    public function setTimestampAnulacao(\DateTime $timestampAnulacao)
    {
        $this->timestampAnulacao = $timestampAnulacao;
        return $this;
    }

    /**
     * Get timestampAnulacao
     *
     * @return \DateTime
     */
    public function getTimestampAnulacao()
    {
        return $this->timestampAnulacao;
    }

    /**
     * OneToOne (owning side)
     * Set TesourariaBoletimLoteArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao $fkTesourariaBoletimLoteArrecadacao
     * @return BoletimLoteArrecadacaoEstornado
     */
    public function setFkTesourariaBoletimLoteArrecadacao(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao $fkTesourariaBoletimLoteArrecadacao)
    {
        $this->exercicio = $fkTesourariaBoletimLoteArrecadacao->getExercicio();
        $this->codEntidade = $fkTesourariaBoletimLoteArrecadacao->getCodEntidade();
        $this->codBoletim = $fkTesourariaBoletimLoteArrecadacao->getCodBoletim();
        $this->codLote = $fkTesourariaBoletimLoteArrecadacao->getCodLote();
        $this->timestampArrecadacao = $fkTesourariaBoletimLoteArrecadacao->getTimestampArrecadacao();
        $this->codArrecadacao = $fkTesourariaBoletimLoteArrecadacao->getCodArrecadacao();
        $this->fkTesourariaBoletimLoteArrecadacao = $fkTesourariaBoletimLoteArrecadacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkTesourariaBoletimLoteArrecadacao
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao
     */
    public function getFkTesourariaBoletimLoteArrecadacao()
    {
        return $this->fkTesourariaBoletimLoteArrecadacao;
    }
}
