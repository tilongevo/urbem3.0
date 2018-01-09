<?php

namespace Urbem\CoreBundle\Entity\Compras;

/**
 * FornecedorSocio
 */
class FornecedorSocio
{
    /**
     * PK
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * @var integer
     */
    private $cgmSocio;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var boolean
     */
    private $ativo = false;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\TipoSocio
     */
    private $fkComprasTipoSocio;


    /**
     * Set id
     *
     * @param integer $id
     * @return FornecedorSocio
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return FornecedorSocio
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
     * Set cgmSocio
     *
     * @param integer $cgmSocio
     * @return FornecedorSocio
     */
    public function setCgmSocio($cgmSocio)
    {
        $this->cgmSocio = $cgmSocio;
        return $this;
    }

    /**
     * Get cgmSocio
     *
     * @return integer
     */
    public function getCgmSocio()
    {
        return $this->cgmSocio;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return FornecedorSocio
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return FornecedorSocio
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor
     * @return FornecedorSocio
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
     * @return FornecedorSocio
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmSocio = $fkSwCgm->getNumcgm();
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

    /**
     * ManyToOne (inverse side)
     * Set fkComprasTipoSocio
     *
     * @param \Urbem\CoreBundle\Entity\Compras\TipoSocio $fkComprasTipoSocio
     * @return FornecedorSocio
     */
    public function setFkComprasTipoSocio(\Urbem\CoreBundle\Entity\Compras\TipoSocio $fkComprasTipoSocio)
    {
        $this->codTipo = $fkComprasTipoSocio->getCodTipo();
        $this->fkComprasTipoSocio = $fkComprasTipoSocio;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasTipoSocio
     *
     * @return \Urbem\CoreBundle\Entity\Compras\TipoSocio
     */
    public function getFkComprasTipoSocio()
    {
        return $this->fkComprasTipoSocio;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->id) {
            return (string) "{$this->cgmFornecedor} - {$this->getFkSwCgm()->getNomCgm()}";
        } else {
            return "Fornecedor Sócio";
        }
    }
}
