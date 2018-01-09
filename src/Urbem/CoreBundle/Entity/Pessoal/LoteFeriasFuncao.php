<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * LoteFeriasFuncao
 */
class LoteFeriasFuncao
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
    private $codCargo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\LoteFerias
     */
    private $fkPessoalLoteFerias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    private $fkPessoalCargo;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LoteFeriasFuncao
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
     * Set codCargo
     *
     * @param integer $codCargo
     * @return LoteFeriasFuncao
     */
    public function setCodCargo($codCargo)
    {
        $this->codCargo = $codCargo;
        return $this;
    }

    /**
     * Get codCargo
     *
     * @return integer
     */
    public function getCodCargo()
    {
        return $this->codCargo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalLoteFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFerias $fkPessoalLoteFerias
     * @return LoteFeriasFuncao
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
     * Set fkPessoalCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo
     * @return LoteFeriasFuncao
     */
    public function setFkPessoalCargo(\Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo)
    {
        $this->codCargo = $fkPessoalCargo->getCodCargo();
        $this->fkPessoalCargo = $fkPessoalCargo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCargo
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    public function getFkPessoalCargo()
    {
        return $this->fkPessoalCargo;
    }
}
