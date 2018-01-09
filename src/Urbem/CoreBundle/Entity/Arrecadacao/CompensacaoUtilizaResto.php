<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * CompensacaoUtilizaResto
 */
class CompensacaoUtilizaResto
{
    /**
     * PK
     * @var integer
     */
    private $codCompensacao;

    /**
     * @var integer
     */
    private $codCompensacaoResto;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Compensacao
     */
    private $fkArrecadacaoCompensacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoResto
     */
    private $fkArrecadacaoCompensacaoResto;


    /**
     * Set codCompensacao
     *
     * @param integer $codCompensacao
     * @return CompensacaoUtilizaResto
     */
    public function setCodCompensacao($codCompensacao)
    {
        $this->codCompensacao = $codCompensacao;
        return $this;
    }

    /**
     * Get codCompensacao
     *
     * @return integer
     */
    public function getCodCompensacao()
    {
        return $this->codCompensacao;
    }

    /**
     * Set codCompensacaoResto
     *
     * @param integer $codCompensacaoResto
     * @return CompensacaoUtilizaResto
     */
    public function setCodCompensacaoResto($codCompensacaoResto)
    {
        $this->codCompensacaoResto = $codCompensacaoResto;
        return $this;
    }

    /**
     * Get codCompensacaoResto
     *
     * @return integer
     */
    public function getCodCompensacaoResto()
    {
        return $this->codCompensacaoResto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoCompensacaoResto
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoResto $fkArrecadacaoCompensacaoResto
     * @return CompensacaoUtilizaResto
     */
    public function setFkArrecadacaoCompensacaoResto(\Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoResto $fkArrecadacaoCompensacaoResto)
    {
        $this->codCompensacaoResto = $fkArrecadacaoCompensacaoResto->getCodCompensacao();
        $this->fkArrecadacaoCompensacaoResto = $fkArrecadacaoCompensacaoResto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoCompensacaoResto
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoResto
     */
    public function getFkArrecadacaoCompensacaoResto()
    {
        return $this->fkArrecadacaoCompensacaoResto;
    }

    /**
     * OneToOne (owning side)
     * Set ArrecadacaoCompensacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Compensacao $fkArrecadacaoCompensacao
     * @return CompensacaoUtilizaResto
     */
    public function setFkArrecadacaoCompensacao(\Urbem\CoreBundle\Entity\Arrecadacao\Compensacao $fkArrecadacaoCompensacao)
    {
        $this->codCompensacao = $fkArrecadacaoCompensacao->getCodCompensacao();
        $this->fkArrecadacaoCompensacao = $fkArrecadacaoCompensacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkArrecadacaoCompensacao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Compensacao
     */
    public function getFkArrecadacaoCompensacao()
    {
        return $this->fkArrecadacaoCompensacao;
    }
}
