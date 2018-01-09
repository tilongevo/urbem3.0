<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * ParcelaProrrogacao
 */
class ParcelaProrrogacao
{
    /**
     * PK
     * @var integer
     */
    private $codParcela;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $vencimentoAnterior;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Parcela
     */
    private $fkArrecadacaoParcela;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codParcela
     *
     * @param integer $codParcela
     * @return ParcelaProrrogacao
     */
    public function setCodParcela($codParcela)
    {
        $this->codParcela = $codParcela;
        return $this;
    }

    /**
     * Get codParcela
     *
     * @return integer
     */
    public function getCodParcela()
    {
        return $this->codParcela;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return ParcelaProrrogacao
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
     * Set vencimentoAnterior
     *
     * @param \DateTime $vencimentoAnterior
     * @return ParcelaProrrogacao
     */
    public function setVencimentoAnterior(\DateTime $vencimentoAnterior)
    {
        $this->vencimentoAnterior = $vencimentoAnterior;
        return $this;
    }

    /**
     * Get vencimentoAnterior
     *
     * @return \DateTime
     */
    public function getVencimentoAnterior()
    {
        return $this->vencimentoAnterior;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoParcela
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Parcela $fkArrecadacaoParcela
     * @return ParcelaProrrogacao
     */
    public function setFkArrecadacaoParcela(\Urbem\CoreBundle\Entity\Arrecadacao\Parcela $fkArrecadacaoParcela)
    {
        $this->codParcela = $fkArrecadacaoParcela->getCodParcela();
        $this->fkArrecadacaoParcela = $fkArrecadacaoParcela;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoParcela
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Parcela
     */
    public function getFkArrecadacaoParcela()
    {
        return $this->fkArrecadacaoParcela;
    }
}
