<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * LoteFeriasContrato
 */
class LoteFeriasContrato
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\LoteFerias
     */
    private $fkPessoalLoteFerias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LoteFeriasContrato
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return LoteFeriasContrato
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
     * ManyToOne (inverse side)
     * Set fkPessoalLoteFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFerias $fkPessoalLoteFerias
     * @return LoteFeriasContrato
     */
    public function setFkPessoalLoteFerias(\Urbem\CoreBundle\Entity\Pessoal\LoteFerias $fkPessoalLoteFerias)
    {
        $this->codLote = $fkPessoalLoteFerias->getCodLote();
        $this->fkPessoalLoteFerias = $fkPessoalLoteFerias;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalLoteFerias
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\LoteFerias
     */
    public function getFkPessoalLoteFerias()
    {
        return $this->fkPessoalLoteFerias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return LoteFeriasContrato
     */
    public function setFkPessoalContrato(\Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato)
    {
        $this->codContrato = $fkPessoalContrato->getCodContrato();
        $this->fkPessoalContrato = $fkPessoalContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContrato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    public function getFkPessoalContrato()
    {
        return $this->fkPessoalContrato;
    }
}
