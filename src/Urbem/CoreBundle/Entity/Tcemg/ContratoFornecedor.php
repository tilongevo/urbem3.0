<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ContratoFornecedor
 */
class ContratoFornecedor
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

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
    private $cgmFornecedor;

    /**
     * @var integer
     */
    private $cgmRepresentante;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    private $fkTcemgContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    private $fkComprasFornecedor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoFornecedor
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ContratoFornecedor
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
     * @return ContratoFornecedor
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
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return ContratoFornecedor
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
     * Set cgmRepresentante
     *
     * @param integer $cgmRepresentante
     * @return ContratoFornecedor
     */
    public function setCgmRepresentante($cgmRepresentante)
    {
        $this->cgmRepresentante = $cgmRepresentante;
        return $this;
    }

    /**
     * Get cgmRepresentante
     *
     * @return integer
     */
    public function getCgmRepresentante()
    {
        return $this->cgmRepresentante;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato
     * @return ContratoFornecedor
     */
    public function setFkTcemgContrato(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        $this->codContrato = $fkTcemgContrato->getCodContrato();
        $this->codEntidade = $fkTcemgContrato->getCodEntidade();
        $this->exercicio = $fkTcemgContrato->getExercicio();
        $this->fkTcemgContrato = $fkTcemgContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgContrato
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    public function getFkTcemgContrato()
    {
        return $this->fkTcemgContrato;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor
     * @return ContratoFornecedor
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

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ContratoFornecedor
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmRepresentante = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }
}
