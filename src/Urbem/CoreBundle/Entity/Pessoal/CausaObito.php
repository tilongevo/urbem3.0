<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * CausaObito
 */
class CausaObito
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * @var string
     */
    private $numCertidaoObito;

    /**
     * @var string
     */
    private $causaMortis;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa
     */
    private $fkPessoalContratoServidorCasoCausa;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return CausaObito
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
     * Set numCertidaoObito
     *
     * @param string $numCertidaoObito
     * @return CausaObito
     */
    public function setNumCertidaoObito($numCertidaoObito)
    {
        $this->numCertidaoObito = $numCertidaoObito;
        return $this;
    }

    /**
     * Get numCertidaoObito
     *
     * @return string
     */
    public function getNumCertidaoObito()
    {
        return $this->numCertidaoObito;
    }

    /**
     * Set causaMortis
     *
     * @param string $causaMortis
     * @return CausaObito
     */
    public function setCausaMortis($causaMortis)
    {
        $this->causaMortis = $causaMortis;
        return $this;
    }

    /**
     * Get causaMortis
     *
     * @return string
     */
    public function getCausaMortis()
    {
        return $this->causaMortis;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalContratoServidorCasoCausa
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa $fkPessoalContratoServidorCasoCausa
     * @return CausaObito
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
