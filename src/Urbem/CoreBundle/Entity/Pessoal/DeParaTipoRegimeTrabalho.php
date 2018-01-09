<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * DeParaTipoRegimeTrabalho
 */
class DeParaTipoRegimeTrabalho
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
    private $codTipoRegimeTrabalhoTce;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    private $fkPessoalSubDivisao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepb\TipoRegimeTrabalhoTce
     */
    private $fkTcepbTipoRegimeTrabalhoTce;


    /**
     * Set codSubDivisao
     *
     * @param integer $codSubDivisao
     * @return DeParaTipoRegimeTrabalho
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
     * Set codTipoRegimeTrabalhoTce
     *
     * @param integer $codTipoRegimeTrabalhoTce
     * @return DeParaTipoRegimeTrabalho
     */
    public function setCodTipoRegimeTrabalhoTce($codTipoRegimeTrabalhoTce)
    {
        $this->codTipoRegimeTrabalhoTce = $codTipoRegimeTrabalhoTce;
        return $this;
    }

    /**
     * Get codTipoRegimeTrabalhoTce
     *
     * @return integer
     */
    public function getCodTipoRegimeTrabalhoTce()
    {
        return $this->codTipoRegimeTrabalhoTce;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao
     * @return DeParaTipoRegimeTrabalho
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
     * Set fkTcepbTipoRegimeTrabalhoTce
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\TipoRegimeTrabalhoTce $fkTcepbTipoRegimeTrabalhoTce
     * @return DeParaTipoRegimeTrabalho
     */
    public function setFkTcepbTipoRegimeTrabalhoTce(\Urbem\CoreBundle\Entity\Tcepb\TipoRegimeTrabalhoTce $fkTcepbTipoRegimeTrabalhoTce)
    {
        $this->codTipoRegimeTrabalhoTce = $fkTcepbTipoRegimeTrabalhoTce->getCodTipoRegimeTrabalhoTce();
        $this->fkTcepbTipoRegimeTrabalhoTce = $fkTcepbTipoRegimeTrabalhoTce;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepbTipoRegimeTrabalhoTce
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\TipoRegimeTrabalhoTce
     */
    public function getFkTcepbTipoRegimeTrabalhoTce()
    {
        return $this->fkTcepbTipoRegimeTrabalhoTce;
    }
}
