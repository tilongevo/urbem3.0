<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AvisoPrevio
 */
class AvisoPrevio
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * @var string
     */
    private $avisoPrevio;

    /**
     * @var \DateTime
     */
    private $dtAviso;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa
     */
    private $fkPessoalContratoServidorCasoCausa;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return AvisoPrevio
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
     * Set avisoPrevio
     *
     * @param string $avisoPrevio
     * @return AvisoPrevio
     */
    public function setAvisoPrevio($avisoPrevio)
    {
        $this->avisoPrevio = $avisoPrevio;
        return $this;
    }

    /**
     * Get avisoPrevio
     *
     * @return string
     */
    public function getAvisoPrevio()
    {
        return $this->avisoPrevio;
    }

    /**
     * Set dtAviso
     *
     * @param \DateTime $dtAviso
     * @return AvisoPrevio
     */
    public function setDtAviso(\DateTime $dtAviso = null)
    {
        $this->dtAviso = $dtAviso;
        return $this;
    }

    /**
     * Get dtAviso
     *
     * @return \DateTime
     */
    public function getDtAviso()
    {
        return $this->dtAviso;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalContratoServidorCasoCausa
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa $fkPessoalContratoServidorCasoCausa
     * @return AvisoPrevio
     */
    public function setFkPessoalContratoServidorCasoCausa(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa $fkPessoalContratoServidorCasoCausa)
    {
        $this->codContrato = $fkPessoalContratoServidorCasoCausa->getCodContrato();
        $this->fkPessoalContratoServidorCasoCausa = $fkPessoalContratoServidorCasoCausa;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalContratoServidorCasoCausa
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa
     */
    public function getFkPessoalContratoServidorCasoCausa()
    {
        return $this->fkPessoalContratoServidorCasoCausa;
    }
}
