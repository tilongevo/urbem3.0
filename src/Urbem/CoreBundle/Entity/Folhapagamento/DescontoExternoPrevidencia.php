<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * DescontoExternoPrevidencia
 */
class DescontoExternoPrevidencia
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
    private $vlBasePrevidencia;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidenciaAnulado
     */
    private $fkFolhapagamentoDescontoExternoPrevidenciaAnulado;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidenciaValor
     */
    private $fkFolhapagamentoDescontoExternoPrevidenciaValores;

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
        $this->fkFolhapagamentoDescontoExternoPrevidenciaValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return DescontoExternoPrevidencia
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
     * @return DescontoExternoPrevidencia
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
     * Set vlBasePrevidencia
     *
     * @param integer $vlBasePrevidencia
     * @return DescontoExternoPrevidencia
     */
    public function setVlBasePrevidencia($vlBasePrevidencia)
    {
        $this->vlBasePrevidencia = $vlBasePrevidencia;
        return $this;
    }

    /**
     * Get vlBasePrevidencia
     *
     * @return integer
     */
    public function getVlBasePrevidencia()
    {
        return $this->vlBasePrevidencia;
    }

    /**
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return DescontoExternoPrevidencia
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
     * Add FolhapagamentoDescontoExternoPrevidenciaValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidenciaValor $fkFolhapagamentoDescontoExternoPrevidenciaValor
     * @return DescontoExternoPrevidencia
     */
    public function addFkFolhapagamentoDescontoExternoPrevidenciaValores(\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidenciaValor $fkFolhapagamentoDescontoExternoPrevidenciaValor)
    {
        if (false === $this->fkFolhapagamentoDescontoExternoPrevidenciaValores->contains($fkFolhapagamentoDescontoExternoPrevidenciaValor)) {
            $fkFolhapagamentoDescontoExternoPrevidenciaValor->setFkFolhapagamentoDescontoExternoPrevidencia($this);
            $this->fkFolhapagamentoDescontoExternoPrevidenciaValores->add($fkFolhapagamentoDescontoExternoPrevidenciaValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoDescontoExternoPrevidenciaValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidenciaValor $fkFolhapagamentoDescontoExternoPrevidenciaValor
     */
    public function removeFkFolhapagamentoDescontoExternoPrevidenciaValores(\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidenciaValor $fkFolhapagamentoDescontoExternoPrevidenciaValor)
    {
        $this->fkFolhapagamentoDescontoExternoPrevidenciaValores->removeElement($fkFolhapagamentoDescontoExternoPrevidenciaValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoDescontoExternoPrevidenciaValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidenciaValor
     */
    public function getFkFolhapagamentoDescontoExternoPrevidenciaValores()
    {
        return $this->fkFolhapagamentoDescontoExternoPrevidenciaValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return DescontoExternoPrevidencia
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
     * Set FolhapagamentoDescontoExternoPrevidenciaAnulado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidenciaAnulado $fkFolhapagamentoDescontoExternoPrevidenciaAnulado
     * @return DescontoExternoPrevidencia
     */
    public function setFkFolhapagamentoDescontoExternoPrevidenciaAnulado(\Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidenciaAnulado $fkFolhapagamentoDescontoExternoPrevidenciaAnulado)
    {
        $fkFolhapagamentoDescontoExternoPrevidenciaAnulado->setFkFolhapagamentoDescontoExternoPrevidencia($this);
        $this->fkFolhapagamentoDescontoExternoPrevidenciaAnulado = $fkFolhapagamentoDescontoExternoPrevidenciaAnulado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoDescontoExternoPrevidenciaAnulado
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidenciaAnulado
     */
    public function getFkFolhapagamentoDescontoExternoPrevidenciaAnulado()
    {
        return $this->fkFolhapagamentoDescontoExternoPrevidenciaAnulado;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->fkPessoalContrato) {
            return sprintf('%s %s %s %s', 'Desconto externo no valor de: R$', $this->vlBasePrevidencia, ' e vigência de ', $this->getVigencia()->format('d/m/Y'));
        } else {
            return 'Desconto Externo';
        }
    }
}
