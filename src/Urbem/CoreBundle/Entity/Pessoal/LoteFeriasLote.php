<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * LoteFeriasLote
 */
class LoteFeriasLote
{
    /**
     * PK
     * @var integer
     */
    private $codFerias;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Ferias
     */
    private $fkPessoalFerias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\LoteFerias
     */
    private $fkPessoalLoteFerias;


    /**
     * Set codFerias
     *
     * @param integer $codFerias
     * @return LoteFeriasLote
     */
    public function setCodFerias($codFerias)
    {
        $this->codFerias = $codFerias;
        return $this;
    }

    /**
     * Get codFerias
     *
     * @return integer
     */
    public function getCodFerias()
    {
        return $this->codFerias;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LoteFeriasLote
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
     * ManyToOne (inverse side)
     * Set fkPessoalFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Ferias $fkPessoalFerias
     * @return LoteFeriasLote
     */
    public function setFkPessoalFerias(\Urbem\CoreBundle\Entity\Pessoal\Ferias $fkPessoalFerias)
    {
        $this->codFerias = $fkPessoalFerias->getCodFerias();
        $this->fkPessoalFerias = $fkPessoalFerias;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalFerias
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Ferias
     */
    public function getFkPessoalFerias()
    {
        return $this->fkPessoalFerias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalLoteFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFerias $fkPessoalLoteFerias
     * @return LoteFeriasLote
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
}
