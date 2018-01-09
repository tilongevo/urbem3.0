<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * Marca
 */
class Marca
{
    /**
     * PK
     * @var integer
     */
    private $codMarcaTcm;

    /**
     * PK
     * @var integer
     */
    private $codTipoTcm;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $codMarca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\TipoVeiculo
     */
    private $fkTcmbaTipoVeiculo;


    /**
     * Set codMarcaTcm
     *
     * @param integer $codMarcaTcm
     * @return Marca
     */
    public function setCodMarcaTcm($codMarcaTcm)
    {
        $this->codMarcaTcm = $codMarcaTcm;
        return $this;
    }

    /**
     * Get codMarcaTcm
     *
     * @return integer
     */
    public function getCodMarcaTcm()
    {
        return $this->codMarcaTcm;
    }

    /**
     * Set codTipoTcm
     *
     * @param integer $codTipoTcm
     * @return Marca
     */
    public function setCodTipoTcm($codTipoTcm)
    {
        $this->codTipoTcm = $codTipoTcm;
        return $this;
    }

    /**
     * Get codTipoTcm
     *
     * @return integer
     */
    public function getCodTipoTcm()
    {
        return $this->codTipoTcm;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Marca
     */
    public function setDescricao($descricao)
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
     * Set codMarca
     *
     * @param integer $codMarca
     * @return Marca
     */
    public function setCodMarca($codMarca = null)
    {
        $this->codMarca = $codMarca;
        return $this;
    }

    /**
     * Get codMarca
     *
     * @return integer
     */
    public function getCodMarca()
    {
        return $this->codMarca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmbaTipoVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoVeiculo $fkTcmbaTipoVeiculo
     * @return Marca
     */
    public function setFkTcmbaTipoVeiculo(\Urbem\CoreBundle\Entity\Tcmba\TipoVeiculo $fkTcmbaTipoVeiculo)
    {
        $this->codTipoTcm = $fkTcmbaTipoVeiculo->getCodTipoTcm();
        $this->fkTcmbaTipoVeiculo = $fkTcmbaTipoVeiculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaTipoVeiculo
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TipoVeiculo
     */
    public function getFkTcmbaTipoVeiculo()
    {
        return $this->fkTcmbaTipoVeiculo;
    }
}
