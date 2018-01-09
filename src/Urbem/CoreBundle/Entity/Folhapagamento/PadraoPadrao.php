<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * PadraoPadrao
 */
class PadraoPadrao
{
    /**
     * PK
     * @var integer
     */
    private $codPadrao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\AtributoPadraoValor
     */
    private $fkFolhapagamentoAtributoPadraoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajustePadraoPadrao
     */
    private $fkFolhapagamentoReajustePadraoPadroes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Padrao
     */
    private $fkFolhapagamentoPadrao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoAtributoPadraoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoReajustePadraoPadroes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codPadrao
     *
     * @param integer $codPadrao
     * @return PadraoPadrao
     */
    public function setCodPadrao($codPadrao)
    {
        $this->codPadrao = $codPadrao;
        return $this;
    }

    /**
     * Get codPadrao
     *
     * @return integer
     */
    public function getCodPadrao()
    {
        return $this->codPadrao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return PadraoPadrao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return PadraoPadrao
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
     * Set codNorma
     *
     * @param integer $codNorma
     * @return PadraoPadrao
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return PadraoPadrao
     */
    public function setVigencia(\DateTime $vigencia)
    {
        $this->vigencia = $vigencia;
        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \DateTime
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoAtributoPadraoValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\AtributoPadraoValor $fkFolhapagamentoAtributoPadraoValor
     * @return PadraoPadrao
     */
    public function addFkFolhapagamentoAtributoPadraoValores(\Urbem\CoreBundle\Entity\Folhapagamento\AtributoPadraoValor $fkFolhapagamentoAtributoPadraoValor)
    {
        if (false === $this->fkFolhapagamentoAtributoPadraoValores->contains($fkFolhapagamentoAtributoPadraoValor)) {
            $fkFolhapagamentoAtributoPadraoValor->setFkFolhapagamentoPadraoPadrao($this);
            $this->fkFolhapagamentoAtributoPadraoValores->add($fkFolhapagamentoAtributoPadraoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoAtributoPadraoValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\AtributoPadraoValor $fkFolhapagamentoAtributoPadraoValor
     */
    public function removeFkFolhapagamentoAtributoPadraoValores(\Urbem\CoreBundle\Entity\Folhapagamento\AtributoPadraoValor $fkFolhapagamentoAtributoPadraoValor)
    {
        $this->fkFolhapagamentoAtributoPadraoValores->removeElement($fkFolhapagamentoAtributoPadraoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoAtributoPadraoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\AtributoPadraoValor
     */
    public function getFkFolhapagamentoAtributoPadraoValores()
    {
        return $this->fkFolhapagamentoAtributoPadraoValores;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoReajustePadraoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajustePadraoPadrao $fkFolhapagamentoReajustePadraoPadrao
     * @return PadraoPadrao
     */
    public function addFkFolhapagamentoReajustePadraoPadroes(\Urbem\CoreBundle\Entity\Folhapagamento\ReajustePadraoPadrao $fkFolhapagamentoReajustePadraoPadrao)
    {
        if (false === $this->fkFolhapagamentoReajustePadraoPadroes->contains($fkFolhapagamentoReajustePadraoPadrao)) {
            $fkFolhapagamentoReajustePadraoPadrao->setFkFolhapagamentoPadraoPadrao($this);
            $this->fkFolhapagamentoReajustePadraoPadroes->add($fkFolhapagamentoReajustePadraoPadrao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoReajustePadraoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajustePadraoPadrao $fkFolhapagamentoReajustePadraoPadrao
     */
    public function removeFkFolhapagamentoReajustePadraoPadroes(\Urbem\CoreBundle\Entity\Folhapagamento\ReajustePadraoPadrao $fkFolhapagamentoReajustePadraoPadrao)
    {
        $this->fkFolhapagamentoReajustePadraoPadroes->removeElement($fkFolhapagamentoReajustePadraoPadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoReajustePadraoPadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajustePadraoPadrao
     */
    public function getFkFolhapagamentoReajustePadraoPadroes()
    {
        return $this->fkFolhapagamentoReajustePadraoPadroes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Padrao $fkFolhapagamentoPadrao
     * @return PadraoPadrao
     */
    public function setFkFolhapagamentoPadrao(\Urbem\CoreBundle\Entity\Folhapagamento\Padrao $fkFolhapagamentoPadrao)
    {
        $this->codPadrao = $fkFolhapagamentoPadrao->getCodPadrao();
        $this->fkFolhapagamentoPadrao = $fkFolhapagamentoPadrao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPadrao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Padrao
     */
    public function getFkFolhapagamentoPadrao()
    {
        return $this->fkFolhapagamentoPadrao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return PadraoPadrao
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }
}
