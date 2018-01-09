<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * LoteFeriasLocal
 */
class LoteFeriasLocal
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
    private $codLocal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\LoteFerias
     */
    private $fkPessoalLoteFerias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Local
     */
    private $fkOrganogramaLocal;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LoteFeriasLocal
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
     * Set codLocal
     *
     * @param integer $codLocal
     * @return LoteFeriasLocal
     */
    public function setCodLocal($codLocal)
    {
        $this->codLocal = $codLocal;
        return $this;
    }

    /**
     * Get codLocal
     *
     * @return integer
     */
    public function getCodLocal()
    {
        return $this->codLocal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalLoteFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFerias $fkPessoalLoteFerias
     * @return LoteFeriasLocal
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
     * Set fkOrganogramaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal
     * @return LoteFeriasLocal
     */
    public function setFkOrganogramaLocal(\Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal)
    {
        $this->codLocal = $fkOrganogramaLocal->getCodLocal();
        $this->fkOrganogramaLocal = $fkOrganogramaLocal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaLocal
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Local
     */
    public function getFkOrganogramaLocal()
    {
        return $this->fkOrganogramaLocal;
    }
}
