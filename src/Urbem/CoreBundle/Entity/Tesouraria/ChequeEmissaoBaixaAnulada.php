<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ChequeEmissaoBaixaAnulada
 */
class ChequeEmissaoBaixaAnulada
{
    /**
     * PK
     * @var integer
     */
    private $codAgencia;

    /**
     * PK
     * @var integer
     */
    private $codBanco;

    /**
     * PK
     * @var integer
     */
    private $codContaCorrente;

    /**
     * PK
     * @var string
     */
    private $numCheque;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampEmissao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampBaixa;

    /**
     * @var \DateTime
     */
    private $dataAnulacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Cheque
     */
    private $fkTesourariaCheque;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampEmissao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampBaixa = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->dataAnulacao = new \DateTime;
    }

    /**
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return ChequeEmissaoBaixaAnulada
     */
    public function setCodAgencia($codAgencia)
    {
        $this->codAgencia = $codAgencia;
        return $this;
    }

    /**
     * Get codAgencia
     *
     * @return integer
     */
    public function getCodAgencia()
    {
        return $this->codAgencia;
    }

    /**
     * Set codBanco
     *
     * @param integer $codBanco
     * @return ChequeEmissaoBaixaAnulada
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;
        return $this;
    }

    /**
     * Get codBanco
     *
     * @return integer
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * Set codContaCorrente
     *
     * @param integer $codContaCorrente
     * @return ChequeEmissaoBaixaAnulada
     */
    public function setCodContaCorrente($codContaCorrente)
    {
        $this->codContaCorrente = $codContaCorrente;
        return $this;
    }

    /**
     * Get codContaCorrente
     *
     * @return integer
     */
    public function getCodContaCorrente()
    {
        return $this->codContaCorrente;
    }

    /**
     * Set numCheque
     *
     * @param string $numCheque
     * @return ChequeEmissaoBaixaAnulada
     */
    public function setNumCheque($numCheque)
    {
        $this->numCheque = $numCheque;
        return $this;
    }

    /**
     * Get numCheque
     *
     * @return string
     */
    public function getNumCheque()
    {
        return $this->numCheque;
    }

    /**
     * Set timestampEmissao
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampEmissao
     * @return ChequeEmissaoBaixaAnulada
     */
    public function setTimestampEmissao(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampEmissao)
    {
        $this->timestampEmissao = $timestampEmissao;
        return $this;
    }

    /**
     * Get timestampEmissao
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampEmissao()
    {
        return $this->timestampEmissao;
    }

    /**
     * Set timestampBaixa
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampBaixa
     * @return ChequeEmissaoBaixaAnulada
     */
    public function setTimestampBaixa(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampBaixa)
    {
        $this->timestampBaixa = $timestampBaixa;
        return $this;
    }

    /**
     * Get timestampBaixa
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampBaixa()
    {
        return $this->timestampBaixa;
    }

    /**
     * Set dataAnulacao
     *
     * @param \DateTime $dataAnulacao
     * @return ChequeEmissaoBaixaAnulada
     */
    public function setDataAnulacao(\DateTime $dataAnulacao)
    {
        $this->dataAnulacao = $dataAnulacao;
        return $this;
    }

    /**
     * Get dataAnulacao
     *
     * @return \DateTime
     */
    public function getDataAnulacao()
    {
        return $this->dataAnulacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaCheque
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Cheque $fkTesourariaCheque
     * @return ChequeEmissaoBaixaAnulada
     */
    public function setFkTesourariaCheque(\Urbem\CoreBundle\Entity\Tesouraria\Cheque $fkTesourariaCheque)
    {
        $this->codAgencia = $fkTesourariaCheque->getCodAgencia();
        $this->codBanco = $fkTesourariaCheque->getCodBanco();
        $this->codContaCorrente = $fkTesourariaCheque->getCodContaCorrente();
        $this->numCheque = $fkTesourariaCheque->getNumCheque();
        $this->fkTesourariaCheque = $fkTesourariaCheque;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaCheque
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Cheque
     */
    public function getFkTesourariaCheque()
    {
        return $this->fkTesourariaCheque;
    }
}
