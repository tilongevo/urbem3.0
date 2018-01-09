<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ChequeEmissaoAnulada
 */
class ChequeEmissaoAnulada
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
        $this->dataAnulacao = new \DateTime;
    }

    /**
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return ChequeEmissaoAnulada
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
     * @return ChequeEmissaoAnulada
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
     * @return ChequeEmissaoAnulada
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
     * @return ChequeEmissaoAnulada
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
     * @return ChequeEmissaoAnulada
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
     * Set dataAnulacao
     *
     * @param \DateTime $dataAnulacao
     * @return ChequeEmissaoAnulada
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
     * @return ChequeEmissaoAnulada
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
