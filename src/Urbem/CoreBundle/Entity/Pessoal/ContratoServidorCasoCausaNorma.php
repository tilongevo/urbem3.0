<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorCasoCausaNorma
 */
class ContratoServidorCasoCausaNorma
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa
     */
    private $fkPessoalContratoServidorCasoCausa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorCasoCausaNorma
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
     * Set codNorma
     *
     * @param integer $codNorma
     * @return ContratoServidorCasoCausaNorma
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return ContratoServidorCasoCausaNorma
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalContratoServidorCasoCausa
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa $fkPessoalContratoServidorCasoCausa
     * @return ContratoServidorCasoCausaNorma
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
