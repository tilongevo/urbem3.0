<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * ParcelaCalculo
 */
class ParcelaCalculo
{
    /**
     * PK
     * @var integer
     */
    private $numParcelamento;

    /**
     * PK
     * @var integer
     */
    private $numParcela;

    /**
     * PK
     * @var integer
     */
    private $codCalculo;

    /**
     * @var integer
     */
    private $vlCredito;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\Parcela
     */
    private $fkDividaParcela;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    private $fkArrecadacaoCalculo;


    /**
     * Set numParcelamento
     *
     * @param integer $numParcelamento
     * @return ParcelaCalculo
     */
    public function setNumParcelamento($numParcelamento)
    {
        $this->numParcelamento = $numParcelamento;
        return $this;
    }

    /**
     * Get numParcelamento
     *
     * @return integer
     */
    public function getNumParcelamento()
    {
        return $this->numParcelamento;
    }

    /**
     * Set numParcela
     *
     * @param integer $numParcela
     * @return ParcelaCalculo
     */
    public function setNumParcela($numParcela)
    {
        $this->numParcela = $numParcela;
        return $this;
    }

    /**
     * Get numParcela
     *
     * @return integer
     */
    public function getNumParcela()
    {
        return $this->numParcela;
    }

    /**
     * Set codCalculo
     *
     * @param integer $codCalculo
     * @return ParcelaCalculo
     */
    public function setCodCalculo($codCalculo)
    {
        $this->codCalculo = $codCalculo;
        return $this;
    }

    /**
     * Get codCalculo
     *
     * @return integer
     */
    public function getCodCalculo()
    {
        return $this->codCalculo;
    }

    /**
     * Set vlCredito
     *
     * @param integer $vlCredito
     * @return ParcelaCalculo
     */
    public function setVlCredito($vlCredito)
    {
        $this->vlCredito = $vlCredito;
        return $this;
    }

    /**
     * Get vlCredito
     *
     * @return integer
     */
    public function getVlCredito()
    {
        return $this->vlCredito;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaParcela
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Parcela $fkDividaParcela
     * @return ParcelaCalculo
     */
    public function setFkDividaParcela(\Urbem\CoreBundle\Entity\Divida\Parcela $fkDividaParcela)
    {
        $this->numParcelamento = $fkDividaParcela->getNumParcelamento();
        $this->numParcela = $fkDividaParcela->getNumParcela();
        $this->fkDividaParcela = $fkDividaParcela;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaParcela
     *
     * @return \Urbem\CoreBundle\Entity\Divida\Parcela
     */
    public function getFkDividaParcela()
    {
        return $this->fkDividaParcela;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo
     * @return ParcelaCalculo
     */
    public function setFkArrecadacaoCalculo(\Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo)
    {
        $this->codCalculo = $fkArrecadacaoCalculo->getCodCalculo();
        $this->fkArrecadacaoCalculo = $fkArrecadacaoCalculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoCalculo
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    public function getFkArrecadacaoCalculo()
    {
        return $this->fkArrecadacaoCalculo;
    }
}
