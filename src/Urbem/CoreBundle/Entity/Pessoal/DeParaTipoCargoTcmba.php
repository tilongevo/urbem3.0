<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * DeParaTipoCargoTcmba
 */
class DeParaTipoCargoTcmba
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
     * @var integer
     */
    private $codTipoRegimeTce;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    private $fkPessoalSubDivisao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\TipoCargoTce
     */
    private $fkTcmbaTipoCargoTce;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\TipoRegimeTce
     */
    private $fkTcmbaTipoRegimeTce;


    /**
     * Set codSubDivisao
     *
     * @param integer $codSubDivisao
     * @return DeParaTipoCargoTcmba
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
     * @return DeParaTipoCargoTcmba
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
     * Set codTipoRegimeTce
     *
     * @param integer $codTipoRegimeTce
     * @return DeParaTipoCargoTcmba
     */
    public function setCodTipoRegimeTce($codTipoRegimeTce)
    {
        $this->codTipoRegimeTce = $codTipoRegimeTce;
        return $this;
    }

    /**
     * Get codTipoRegimeTce
     *
     * @return integer
     */
    public function getCodTipoRegimeTce()
    {
        return $this->codTipoRegimeTce;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao
     * @return DeParaTipoCargoTcmba
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
     * Set fkTcmbaTipoCargoTce
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoCargoTce $fkTcmbaTipoCargoTce
     * @return DeParaTipoCargoTcmba
     */
    public function setFkTcmbaTipoCargoTce(\Urbem\CoreBundle\Entity\Tcmba\TipoCargoTce $fkTcmbaTipoCargoTce)
    {
        $this->codTipoCargoTce = $fkTcmbaTipoCargoTce->getCodTipoCargoTce();
        $this->fkTcmbaTipoCargoTce = $fkTcmbaTipoCargoTce;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaTipoCargoTce
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TipoCargoTce
     */
    public function getFkTcmbaTipoCargoTce()
    {
        return $this->fkTcmbaTipoCargoTce;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmbaTipoRegimeTce
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoRegimeTce $fkTcmbaTipoRegimeTce
     * @return DeParaTipoCargoTcmba
     */
    public function setFkTcmbaTipoRegimeTce(\Urbem\CoreBundle\Entity\Tcmba\TipoRegimeTce $fkTcmbaTipoRegimeTce)
    {
        $this->codTipoRegimeTce = $fkTcmbaTipoRegimeTce->getCodTipoRegimeTce();
        $this->fkTcmbaTipoRegimeTce = $fkTcmbaTipoRegimeTce;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaTipoRegimeTce
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TipoRegimeTce
     */
    public function getFkTcmbaTipoRegimeTce()
    {
        return $this->fkTcmbaTipoRegimeTce;
    }
}
