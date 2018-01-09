<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ChequeEmissao
 */
class ChequeEmissao
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
    private $dataEmissao;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoOrdemPagamento
     */
    private $fkTesourariaChequeEmissaoOrdemPagamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoTransferencia
     */
    private $fkTesourariaChequeEmissaoTransferencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoReciboExtra
     */
    private $fkTesourariaChequeEmissaoReciboExtras;

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
        $this->fkTesourariaChequeEmissaoOrdemPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaChequeEmissaoTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaChequeEmissaoReciboExtras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampEmissao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->dataEmissao = new \DateTime;
    }

    /**
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return ChequeEmissao
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
     * @return ChequeEmissao
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
     * @return ChequeEmissao
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
     * @return ChequeEmissao
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
     * @return ChequeEmissao
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
     * Set dataEmissao
     *
     * @param \DateTime $dataEmissao
     * @return ChequeEmissao
     */
    public function setDataEmissao(\DateTime $dataEmissao)
    {
        $this->dataEmissao = $dataEmissao;
        return $this;
    }

    /**
     * Get dataEmissao
     *
     * @return \DateTime
     */
    public function getDataEmissao()
    {
        return $this->dataEmissao;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return ChequeEmissao
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ChequeEmissao
     */
    public function setDescricao($descricao = null)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaChequeEmissaoOrdemPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoOrdemPagamento $fkTesourariaChequeEmissaoOrdemPagamento
     * @return ChequeEmissao
     */
    public function addFkTesourariaChequeEmissaoOrdemPagamentos(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoOrdemPagamento $fkTesourariaChequeEmissaoOrdemPagamento)
    {
        if (false === $this->fkTesourariaChequeEmissaoOrdemPagamentos->contains($fkTesourariaChequeEmissaoOrdemPagamento)) {
            $fkTesourariaChequeEmissaoOrdemPagamento->setFkTesourariaChequeEmissao($this);
            $this->fkTesourariaChequeEmissaoOrdemPagamentos->add($fkTesourariaChequeEmissaoOrdemPagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaChequeEmissaoOrdemPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoOrdemPagamento $fkTesourariaChequeEmissaoOrdemPagamento
     */
    public function removeFkTesourariaChequeEmissaoOrdemPagamentos(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoOrdemPagamento $fkTesourariaChequeEmissaoOrdemPagamento)
    {
        $this->fkTesourariaChequeEmissaoOrdemPagamentos->removeElement($fkTesourariaChequeEmissaoOrdemPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaChequeEmissaoOrdemPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoOrdemPagamento
     */
    public function getFkTesourariaChequeEmissaoOrdemPagamentos()
    {
        return $this->fkTesourariaChequeEmissaoOrdemPagamentos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaChequeEmissaoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoTransferencia $fkTesourariaChequeEmissaoTransferencia
     * @return ChequeEmissao
     */
    public function addFkTesourariaChequeEmissaoTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoTransferencia $fkTesourariaChequeEmissaoTransferencia)
    {
        if (false === $this->fkTesourariaChequeEmissaoTransferencias->contains($fkTesourariaChequeEmissaoTransferencia)) {
            $fkTesourariaChequeEmissaoTransferencia->setFkTesourariaChequeEmissao($this);
            $this->fkTesourariaChequeEmissaoTransferencias->add($fkTesourariaChequeEmissaoTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaChequeEmissaoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoTransferencia $fkTesourariaChequeEmissaoTransferencia
     */
    public function removeFkTesourariaChequeEmissaoTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoTransferencia $fkTesourariaChequeEmissaoTransferencia)
    {
        $this->fkTesourariaChequeEmissaoTransferencias->removeElement($fkTesourariaChequeEmissaoTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaChequeEmissaoTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoTransferencia
     */
    public function getFkTesourariaChequeEmissaoTransferencias()
    {
        return $this->fkTesourariaChequeEmissaoTransferencias;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaChequeEmissaoReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoReciboExtra $fkTesourariaChequeEmissaoReciboExtra
     * @return ChequeEmissao
     */
    public function addFkTesourariaChequeEmissaoReciboExtras(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoReciboExtra $fkTesourariaChequeEmissaoReciboExtra)
    {
        if (false === $this->fkTesourariaChequeEmissaoReciboExtras->contains($fkTesourariaChequeEmissaoReciboExtra)) {
            $fkTesourariaChequeEmissaoReciboExtra->setFkTesourariaChequeEmissao($this);
            $this->fkTesourariaChequeEmissaoReciboExtras->add($fkTesourariaChequeEmissaoReciboExtra);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaChequeEmissaoReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoReciboExtra $fkTesourariaChequeEmissaoReciboExtra
     */
    public function removeFkTesourariaChequeEmissaoReciboExtras(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoReciboExtra $fkTesourariaChequeEmissaoReciboExtra)
    {
        $this->fkTesourariaChequeEmissaoReciboExtras->removeElement($fkTesourariaChequeEmissaoReciboExtra);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaChequeEmissaoReciboExtras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoReciboExtra
     */
    public function getFkTesourariaChequeEmissaoReciboExtras()
    {
        return $this->fkTesourariaChequeEmissaoReciboExtras;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaCheque
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Cheque $fkTesourariaCheque
     * @return ChequeEmissao
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
