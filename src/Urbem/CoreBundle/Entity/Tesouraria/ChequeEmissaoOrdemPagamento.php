<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ChequeEmissaoOrdemPagamento
 */
class ChequeEmissaoOrdemPagamento
{
    /**
     * PK
     * @var integer
     */
    private $codOrdem;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento
     */
    private $fkEmpenhoOrdemPagamento;

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
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return ChequeEmissaoOrdemPagamento
     */
    public function setCodOrdem($codOrdem)
    {
        $this->codOrdem = $codOrdem;
        return $this;
    }

    /**
     * Get codOrdem
     *
     * @return integer
     */
    public function getCodOrdem()
    {
        return $this->codOrdem;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ChequeEmissaoOrdemPagamento
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
     * @return ChequeEmissaoOrdemPagamento
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
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return ChequeEmissaoOrdemPagamento
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
     * @return ChequeEmissaoOrdemPagamento
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
     * @return ChequeEmissaoOrdemPagamento
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
     * @return ChequeEmissaoOrdemPagamento
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
     * @return ChequeEmissaoOrdemPagamento
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
     * Set fkEmpenhoOrdemPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento $fkEmpenhoOrdemPagamento
     * @return ChequeEmissaoOrdemPagamento
     */
    public function setFkEmpenhoOrdemPagamento(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamento $fkEmpenhoOrdemPagamento)
    {
        $this->codOrdem = $fkEmpenhoOrdemPagamento->getCodOrdem();
        $this->exercicio = $fkEmpenhoOrdemPagamento->getExercicio();
        $this->codEntidade = $fkEmpenhoOrdemPagamento->getCodEntidade();
        $this->fkEmpenhoOrdemPagamento = $fkEmpenhoOrdemPagamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoOrdemPagamento
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento
     */
    public function getFkEmpenhoOrdemPagamento()
    {
        return $this->fkEmpenhoOrdemPagamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaChequeEmissao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissao $fkTesourariaChequeEmissao
     * @return ChequeEmissaoOrdemPagamento
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
        return sprintf('%s', $this->codOrdem);
    }
}
