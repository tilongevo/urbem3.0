<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * DeParaTipoCargo
 */
class DeParaTipoCargo
{
    /**
     * PK
     * @var integer
     */
    private $codSubDivisao;

    /**
     * PK
     * @var integer
     */
    private $codTipoCargoTce;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    private $fkPessoalSubDivisao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepb\TipoCargoTce
     */
    private $fkTcepbTipoCargoTce;


    /**
     * Set codSubDivisao
     *
     * @param integer $codSubDivisao
     * @return DeParaTipoCargo
     */
    public function setCodSubDivisao($codSubDivisao)
    {
        $this->codSubDivisao = $codSubDivisao;
        return $this;
    }

    /**
     * Get codSubDivisao
     *
     * @return integer
     */
    public function getCodSubDivisao()
    {
        return $this->codSubDivisao;
    }

    /**
     * Set codTipoCargoTce
     *
     * @param integer $codTipoCargoTce
     * @return DeParaTipoCargo
     */
    public function setCodTipoCargoTce($codTipoCargoTce)
    {
        $this->codTipoCargoTce = $codTipoCargoTce;
        return $this;
    }

    /**
     * Get codTipoCargoTce
     *
     * @return integer
     */
    public function getCodTipoCargoTce()
    {
        return $this->codTipoCargoTce;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao
     * @return DeParaTipoCargo
     */
    public function setFkPessoalSubDivisao(\Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao)
    {
        $this->codSubDivisao = $fkPessoalSubDivisao->getCodSubDivisao();
        $this->fkPessoalSubDivisao = $fkPessoalSubDivisao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalSubDivisao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    public function getFkPessoalSubDivisao()
    {
        return $this->fkPessoalSubDivisao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepbTipoCargoTce
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\TipoCargoTce $fkTcepbTipoCargoTce
     * @return DeParaTipoCargo
     */
    public function setFkTcepbTipoCargoTce(\Urbem\CoreBundle\Entity\Tcepb\TipoCargoTce $fkTcepbTipoCargoTce)
    {
        $this->codTipoCargoTce = $fkTcepbTipoCargoTce->getCodTipoCargoTce();
        $this->fkTcepbTipoCargoTce = $fkTcepbTipoCargoTce;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepbTipoCargoTce
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\TipoCargoTce
     */
    public function getFkTcepbTipoCargoTce()
    {
        return $this->fkTcepbTipoCargoTce;
    }
}
