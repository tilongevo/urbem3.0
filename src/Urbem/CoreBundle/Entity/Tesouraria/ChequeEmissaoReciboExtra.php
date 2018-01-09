<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ChequeEmissaoReciboExtra
 */
class ChequeEmissaoReciboExtra
{
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
     * PK
     * @var integer
     */
    private $codReciboExtra;

    /**
     * PK
     * @var string
     */
    private $tipoRecibo;

    /**
     * PK
     * @var integer
     */
    private $codBanco;

    /**
     * PK
     * @var integer
     */
    private $codAgencia;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra
     */
    private $fkTesourariaReciboExtra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissao
     */
    private $fkTesourariaChequeEmissao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampEmissao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ChequeEmissaoReciboExtra
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
     * @return ChequeEmissaoReciboExtra
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
     * Set codReciboExtra
     *
     * @param integer $codReciboExtra
     * @return ChequeEmissaoReciboExtra
     */
    public function setCodReciboExtra($codReciboExtra)
    {
        $this->codReciboExtra = $codReciboExtra;
        return $this;
    }

    /**
     * Get codReciboExtra
     *
     * @return integer
     */
    public function getCodReciboExtra()
    {
        return $this->codReciboExtra;
    }

    /**
     * Set tipoRecibo
     *
     * @param string $tipoRecibo
     * @return ChequeEmissaoReciboExtra
     */
    public function setTipoRecibo($tipoRecibo)
    {
        $this->tipoRecibo = $tipoRecibo;
        return $this;
    }

    /**
     * Get tipoRecibo
     *
     * @return string
     */
    public function getTipoRecibo()
    {
        return $this->tipoRecibo;
    }

    /**
     * Set codBanco
     *
     * @param integer $codBanco
     * @return ChequeEmissaoReciboExtra
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
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return ChequeEmissaoReciboExtra
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
     * Set codContaCorrente
     *
     * @param integer $codContaCorrente
     * @return ChequeEmissaoReciboExtra
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
     * @return ChequeEmissaoReciboExtra
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
     * @return ChequeEmissaoReciboExtra
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
     * ManyToOne (inverse side)
     * Set fkTesourariaReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra
     * @return ChequeEmissaoReciboExtra
     */
    public function setFkTesourariaReciboExtra(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra)
    {
        $this->codReciboExtra = $fkTesourariaReciboExtra->getCodReciboExtra();
        $this->exercicio = $fkTesourariaReciboExtra->getExercicio();
        $this->codEntidade = $fkTesourariaReciboExtra->getCodEntidade();
        $this->tipoRecibo = $fkTesourariaReciboExtra->getTipoRecibo();
        $this->fkTesourariaReciboExtra = $fkTesourariaReciboExtra;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaReciboExtra
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra
     */
    public function getFkTesourariaReciboExtra()
    {
        return $this->fkTesourariaReciboExtra;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaChequeEmissao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissao $fkTesourariaChequeEmissao
     * @return ChequeEmissaoReciboExtra
     */
    public function setFkTesourariaChequeEmissao(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissao $fkTesourariaChequeEmissao)
    {
        $this->codAgencia = $fkTesourariaChequeEmissao->getCodAgencia();
        $this->codBanco = $fkTesourariaChequeEmissao->getCodBanco();
        $this->codContaCorrente = $fkTesourariaChequeEmissao->getCodContaCorrente();
        $this->numCheque = $fkTesourariaChequeEmissao->getNumCheque();
        $this->timestampEmissao = $fkTesourariaChequeEmissao->getTimestampEmissao();
        $this->fkTesourariaChequeEmissao = $fkTesourariaChequeEmissao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaChequeEmissao
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissao
     */
    public function getFkTesourariaChequeEmissao()
    {
        return $this->fkTesourariaChequeEmissao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s', $this->codReciboExtra);
    }
}
