<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * AtividadeCnaeFiscal
 */
class AtividadeCnaeFiscal
{
    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * @var integer
     */
    private $codCnae;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Economico\Atividade
     */
    private $fkEconomicoAtividade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CnaeFiscal
     */
    private $fkEconomicoCnaeFiscal;


    /**
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return AtividadeCnaeFiscal
     */
    public function setCodAtividade($codAtividade)
    {
        $this->codAtividade = $codAtividade;
        return $this;
    }

    /**
     * Get codAtividade
     *
     * @return integer
     */
    public function getCodAtividade()
    {
        return $this->codAtividade;
    }

    /**
     * Set codCnae
     *
     * @param integer $codCnae
     * @return AtividadeCnaeFiscal
     */
    public function setCodCnae($codCnae)
    {
        $this->codCnae = $codCnae;
        return $this;
    }

    /**
     * Get codCnae
     *
     * @return integer
     */
    public function getCodCnae()
    {
        return $this->codCnae;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCnaeFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CnaeFiscal $fkEconomicoCnaeFiscal
     * @return AtividadeCnaeFiscal
     */
    public function setFkEconomicoCnaeFiscal(\Urbem\CoreBundle\Entity\Economico\CnaeFiscal $fkEconomicoCnaeFiscal)
    {
        $this->codCnae = $fkEconomicoCnaeFiscal->getCodCnae();
        $this->fkEconomicoCnaeFiscal = $fkEconomicoCnaeFiscal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCnaeFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CnaeFiscal
     */
    public function getFkEconomicoCnaeFiscal()
    {
        return $this->fkEconomicoCnaeFiscal;
    }

    /**
     * OneToOne (owning side)
     * Set EconomicoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade
     * @return AtividadeCnaeFiscal
     */
    public function setFkEconomicoAtividade(\Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade)
    {
        $this->codAtividade = $fkEconomicoAtividade->getCodAtividade();
        $this->fkEconomicoAtividade = $fkEconomicoAtividade;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEconomicoAtividade
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Atividade
     */
    public function getFkEconomicoAtividade()
    {
        return $this->fkEconomicoAtividade;
    }
}
