<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ArrecadacaoCarne
 */
class ArrecadacaoCarne
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
     * @var string
     */
    private $numeracao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarneEstornado
     */
    private $fkTesourariaArrecadacaoCarneEstornado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    private $fkTesourariaArrecadacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Carne
     */
    private $fkArrecadacaoCarne;

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
     * @return ArrecadacaoCarne
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
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampArrecadacao
     * @return ArrecadacaoCarne
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
     * Set numeracao
     *
     * @param string $numeracao
     * @return ArrecadacaoCarne
     */
    public function setNumeracao($numeracao)
    {
        $this->numeracao = $numeracao;
        return $this;
    }

    /**
     * Get numeracao
     *
     * @return string
     */
    public function getNumeracao()
    {
        return $this->numeracao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ArrecadacaoCarne
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
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ArrecadacaoCarne
     */
    public function setCodConvenio($codConvenio)
    {
        $this->codConvenio = $codConvenio;
        return $this;
    }

    /**
     * Get codConvenio
     *
     * @return integer
     */
    public function getCodConvenio()
    {
        return $this->codConvenio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao
     * @return ArrecadacaoCarne
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
     * Set fkArrecadacaoCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne
     * @return ArrecadacaoCarne
     */
    public function setFkArrecadacaoCarne(\Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne)
    {
        $this->numeracao = $fkArrecadacaoCarne->getNumeracao();
        $this->codConvenio = $fkArrecadacaoCarne->getCodConvenio();
        $this->fkArrecadacaoCarne = $fkArrecadacaoCarne;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoCarne
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Carne
     */
    public function getFkArrecadacaoCarne()
    {
        return $this->fkArrecadacaoCarne;
    }

    /**
     * OneToOne (inverse side)
     * Set TesourariaArrecadacaoCarneEstornado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarneEstornado $fkTesourariaArrecadacaoCarneEstornado
     * @return ArrecadacaoCarne
     */
    public function setFkTesourariaArrecadacaoCarneEstornado(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarneEstornado $fkTesourariaArrecadacaoCarneEstornado)
    {
        $fkTesourariaArrecadacaoCarneEstornado->setFkTesourariaArrecadacaoCarne($this);
        $this->fkTesourariaArrecadacaoCarneEstornado = $fkTesourariaArrecadacaoCarneEstornado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaArrecadacaoCarneEstornado
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarneEstornado
     */
    public function getFkTesourariaArrecadacaoCarneEstornado()
    {
        return $this->fkTesourariaArrecadacaoCarneEstornado;
    }
}
