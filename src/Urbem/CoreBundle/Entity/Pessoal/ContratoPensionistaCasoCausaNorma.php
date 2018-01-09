<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoPensionistaCasoCausaNorma
 */
class ContratoPensionistaCasoCausaNorma
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
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausa
     */
    private $fkPessoalContratoPensionistaCasoCausa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoPensionistaCasoCausaNorma
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
     * @return ContratoPensionistaCasoCausaNorma
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
     * @return ContratoPensionistaCasoCausaNorma
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
     * Set PessoalContratoPensionistaCasoCausa
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausa $fkPessoalContratoPensionistaCasoCausa
     * @return ContratoPensionistaCasoCausaNorma
     */
    public function setFkPessoalContratoPensionistaCasoCausa(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausa $fkPessoalContratoPensionistaCasoCausa)
    {
        $this->codContrato = $fkPessoalContratoPensionistaCasoCausa->getCodContrato();
        $this->fkPessoalContratoPensionistaCasoCausa = $fkPessoalContratoPensionistaCasoCausa;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalContratoPensionistaCasoCausa
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausa
     */
    public function getFkPessoalContratoPensionistaCasoCausa()
    {
        return $this->fkPessoalContratoPensionistaCasoCausa;
    }
}
