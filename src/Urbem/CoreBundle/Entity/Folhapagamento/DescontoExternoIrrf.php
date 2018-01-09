<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * DescontoExternoIrrf
 */
class DescontoExternoIrrf
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $vlBaseIrrf;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrfAnulado
     */
    private $fkFolhapagamentoDescontoExternoIrrfAnulado;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrfValor
     */
    private $fkFolhapagamentoDescontoExternoIrrfValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoDescontoExternoIrrfValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return DescontoExternoIrrf
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return DescontoExternoIrrf
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
     * Set vlBaseIrrf
     *
     * @param integer $vlBaseIrrf
     * @return DescontoExternoIrrf
     */
    public function setVlBaseIrrf($vlBaseIrrf)
    {
        $this->vlBaseIrrf = $vlBaseIrrf;
        return $this;
    }

    /**
     * Get vlBaseIrrf
     *
     * @return integer
     */
    public function getVlBaseIrrf()
    {
        return $this->vlBaseIrrf;
    }

    /**
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return DescontoExternoIrrf
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
     * Add FolhapagamentoDescontoExternoIrrfValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrfValor $fkFolhapagamentoDescontoExternoIrrfValor
     * @return DescontoExternoIrrf
     */
    public function addFkFolhapagamentoDescontoExternoIrrfValores(\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrfValor $fkFolhapagamentoDescontoExternoIrrfValor)
    {
        if (false === $this->fkFolhapagamentoDescontoExternoIrrfValores->contains($fkFolhapagamentoDescontoExternoIrrfValor)) {
            $fkFolhapagamentoDescontoExternoIrrfValor->setFkFolhapagamentoDescontoExternoIrrf($this);
            $this->fkFolhapagamentoDescontoExternoIrrfValores->add($fkFolhapagamentoDescontoExternoIrrfValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoDescontoExternoIrrfValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrfValor $fkFolhapagamentoDescontoExternoIrrfValor
     */
    public function removeFkFolhapagamentoDescontoExternoIrrfValores(\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrfValor $fkFolhapagamentoDescontoExternoIrrfValor)
    {
        $this->fkFolhapagamentoDescontoExternoIrrfValores->removeElement($fkFolhapagamentoDescontoExternoIrrfValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoDescontoExternoIrrfValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrfValor
     */
    public function getFkFolhapagamentoDescontoExternoIrrfValores()
    {
        return $this->fkFolhapagamentoDescontoExternoIrrfValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return DescontoExternoIrrf
     */
    public function setFkPessoalContrato(\Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato)
    {
        $this->codContrato = $fkPessoalContrato->getCodContrato();
        $this->fkPessoalContrato = $fkPessoalContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContrato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    public function getFkPessoalContrato()
    {
        return $this->fkPessoalContrato;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoDescontoExternoIrrfAnulado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrfAnulado $fkFolhapagamentoDescontoExternoIrrfAnulado
     * @return DescontoExternoIrrf
     */
    public function setFkFolhapagamentoDescontoExternoIrrfAnulado(\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrfAnulado $fkFolhapagamentoDescontoExternoIrrfAnulado)
    {
        $fkFolhapagamentoDescontoExternoIrrfAnulado->setFkFolhapagamentoDescontoExternoIrrf($this);
        $this->fkFolhapagamentoDescontoExternoIrrfAnulado = $fkFolhapagamentoDescontoExternoIrrfAnulado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoDescontoExternoIrrfAnulado
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoIrrfAnulado
     */
    public function getFkFolhapagamentoDescontoExternoIrrfAnulado()
    {
        return $this->fkFolhapagamentoDescontoExternoIrrfAnulado;
    }

    public function __toString()
    {
        if ($this->fkPessoalContrato) {
            return sprintf('%s %s %s %s', 'Desconto externo no valor de: R$', $this->vlBaseIrrf, ' e vigência de ', $this->getVigencia()->format('d/m/Y'));
        } else {
            return 'Desconto Externo';
        }
    }
}
