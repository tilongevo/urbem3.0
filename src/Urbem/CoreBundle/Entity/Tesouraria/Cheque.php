<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * Cheque
 */
class Cheque
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
     * @var \DateTime
     */
    private $dataEntrada;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoAnulada
     */
    private $fkTesourariaChequeEmissaoAnuladas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoBaixa
     */
    private $fkTesourariaChequeEmissaoBaixas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoBaixaAnulada
     */
    private $fkTesourariaChequeEmissaoBaixaAnuladas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissao
     */
    private $fkTesourariaChequeEmissoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\ContaCorrente
     */
    private $fkMonetarioContaCorrente;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTesourariaChequeEmissaoAnuladas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaChequeEmissaoBaixas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaChequeEmissaoBaixaAnuladas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaChequeEmissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dataEntrada = new \DateTime;
    }

    /**
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return Cheque
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
     * @return Cheque
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
     * @return Cheque
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
     * @return Cheque
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
     * Set dataEntrada
     *
     * @param \DateTime $dataEntrada
     * @return Cheque
     */
    public function setDataEntrada(\DateTime $dataEntrada)
    {
        $this->dataEntrada = $dataEntrada;
        return $this;
    }

    /**
     * Get dataEntrada
     *
     * @return \DateTime
     */
    public function getDataEntrada()
    {
        return $this->dataEntrada;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaChequeEmissaoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoAnulada $fkTesourariaChequeEmissaoAnulada
     * @return Cheque
     */
    public function addFkTesourariaChequeEmissaoAnuladas(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoAnulada $fkTesourariaChequeEmissaoAnulada)
    {
        if (false === $this->fkTesourariaChequeEmissaoAnuladas->contains($fkTesourariaChequeEmissaoAnulada)) {
            $fkTesourariaChequeEmissaoAnulada->setFkTesourariaCheque($this);
            $this->fkTesourariaChequeEmissaoAnuladas->add($fkTesourariaChequeEmissaoAnulada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaChequeEmissaoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoAnulada $fkTesourariaChequeEmissaoAnulada
     */
    public function removeFkTesourariaChequeEmissaoAnuladas(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoAnulada $fkTesourariaChequeEmissaoAnulada)
    {
        $this->fkTesourariaChequeEmissaoAnuladas->removeElement($fkTesourariaChequeEmissaoAnulada);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaChequeEmissaoAnuladas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoAnulada
     */
    public function getFkTesourariaChequeEmissaoAnuladas()
    {
        return $this->fkTesourariaChequeEmissaoAnuladas;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaChequeEmissaoBaixa
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoBaixa $fkTesourariaChequeEmissaoBaixa
     * @return Cheque
     */
    public function addFkTesourariaChequeEmissaoBaixas(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoBaixa $fkTesourariaChequeEmissaoBaixa)
    {
        if (false === $this->fkTesourariaChequeEmissaoBaixas->contains($fkTesourariaChequeEmissaoBaixa)) {
            $fkTesourariaChequeEmissaoBaixa->setFkTesourariaCheque($this);
            $this->fkTesourariaChequeEmissaoBaixas->add($fkTesourariaChequeEmissaoBaixa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaChequeEmissaoBaixa
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoBaixa $fkTesourariaChequeEmissaoBaixa
     */
    public function removeFkTesourariaChequeEmissaoBaixas(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoBaixa $fkTesourariaChequeEmissaoBaixa)
    {
        $this->fkTesourariaChequeEmissaoBaixas->removeElement($fkTesourariaChequeEmissaoBaixa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaChequeEmissaoBaixas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoBaixa
     */
    public function getFkTesourariaChequeEmissaoBaixas()
    {
        return $this->fkTesourariaChequeEmissaoBaixas;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaChequeEmissaoBaixaAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoBaixaAnulada $fkTesourariaChequeEmissaoBaixaAnulada
     * @return Cheque
     */
    public function addFkTesourariaChequeEmissaoBaixaAnuladas(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoBaixaAnulada $fkTesourariaChequeEmissaoBaixaAnulada)
    {
        if (false === $this->fkTesourariaChequeEmissaoBaixaAnuladas->contains($fkTesourariaChequeEmissaoBaixaAnulada)) {
            $fkTesourariaChequeEmissaoBaixaAnulada->setFkTesourariaCheque($this);
            $this->fkTesourariaChequeEmissaoBaixaAnuladas->add($fkTesourariaChequeEmissaoBaixaAnulada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaChequeEmissaoBaixaAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoBaixaAnulada $fkTesourariaChequeEmissaoBaixaAnulada
     */
    public function removeFkTesourariaChequeEmissaoBaixaAnuladas(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoBaixaAnulada $fkTesourariaChequeEmissaoBaixaAnulada)
    {
        $this->fkTesourariaChequeEmissaoBaixaAnuladas->removeElement($fkTesourariaChequeEmissaoBaixaAnulada);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaChequeEmissaoBaixaAnuladas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoBaixaAnulada
     */
    public function getFkTesourariaChequeEmissaoBaixaAnuladas()
    {
        return $this->fkTesourariaChequeEmissaoBaixaAnuladas;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaChequeEmissao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissao $fkTesourariaChequeEmissao
     * @return Cheque
     */
    public function addFkTesourariaChequeEmissoes(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissao $fkTesourariaChequeEmissao)
    {
        if (false === $this->fkTesourariaChequeEmissoes->contains($fkTesourariaChequeEmissao)) {
            $fkTesourariaChequeEmissao->setFkTesourariaCheque($this);
            $this->fkTesourariaChequeEmissoes->add($fkTesourariaChequeEmissao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaChequeEmissao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissao $fkTesourariaChequeEmissao
     */
    public function removeFkTesourariaChequeEmissoes(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissao $fkTesourariaChequeEmissao)
    {
        $this->fkTesourariaChequeEmissoes->removeElement($fkTesourariaChequeEmissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaChequeEmissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissao
     */
    public function getFkTesourariaChequeEmissoes()
    {
        return $this->fkTesourariaChequeEmissoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente
     * @return Cheque
     */
    public function setFkMonetarioContaCorrente(\Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente)
    {
        $this->codBanco = $fkMonetarioContaCorrente->getCodBanco();
        $this->codAgencia = $fkMonetarioContaCorrente->getCodAgencia();
        $this->codContaCorrente = $fkMonetarioContaCorrente->getCodContaCorrente();
        $this->fkMonetarioContaCorrente = $fkMonetarioContaCorrente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioContaCorrente
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\ContaCorrente
     */
    public function getFkMonetarioContaCorrente()
    {
        return $this->fkMonetarioContaCorrente;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s', $this->numCheque);
    }
}