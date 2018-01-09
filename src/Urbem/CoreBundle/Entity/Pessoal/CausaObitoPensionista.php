<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * CausaObitoPensionista
 */
class CausaObitoPensionista
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
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausa
     */
    private $fkPessoalContratoPensionistaCasoCausa;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return CausaObitoPensionista
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
     * @return CausaObitoPensionista
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
     * @return CausaObitoPensionista
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
     * Set PessoalContratoPensionistaCasoCausa
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausa $fkPessoalContratoPensionistaCasoCausa
     * @return CausaObitoPensionista
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
