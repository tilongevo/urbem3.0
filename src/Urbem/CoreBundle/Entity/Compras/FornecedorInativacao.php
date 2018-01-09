<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * FornecedorInativacao
 */
class FornecedorInativacao
{
    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampInicio;

    /**
     * @var \DateTime
     */
    private $timestampFim;

    /**
     * @var string
     */
    private $motivo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    private $fkComprasFornecedor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampInicio = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return FornecedorInativacao
     */
    public function setCgmFornecedor($cgmFornecedor)
    {
        $this->cgmFornecedor = $cgmFornecedor;
        return $this;
    }

    /**
     * Get cgmFornecedor
     *
     * @return integer
     */
    public function getCgmFornecedor()
    {
        return $this->cgmFornecedor;
    }

    /**
     * Set timestampInicio
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampInicio
     * @return FornecedorInativacao
     */
    public function setTimestampInicio(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampInicio)
    {
        $this->timestampInicio = $timestampInicio;
        return $this;
    }

    /**
     * Get timestampInicio
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampInicio()
    {
        return $this->timestampInicio;
    }

    /**
     * Set timestampFim
     *
     * @param \DateTime $timestampFim
     * @return FornecedorInativacao
     */
    public function setTimestampFim(\DateTime $timestampFim = null)
    {
        $this->timestampFim = $timestampFim;
        return $this;
    }

    /**
     * Get timestampFim
     *
     * @return \DateTime
     */
    public function getTimestampFim()
    {
        return $this->timestampFim;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return FornecedorInativacao
     */
    public function setMotivo($motivo = null)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor
     * @return FornecedorInativacao
     */
    public function setFkComprasFornecedor(\Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor)
    {
        $this->cgmFornecedor = $fkComprasFornecedor->getCgmFornecedor();
        $this->fkComprasFornecedor = $fkComprasFornecedor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasFornecedor
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    public function getFkComprasFornecedor()
    {
        return $this->fkComprasFornecedor;
    }
}
