<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * CarneConsolidacao
 */
class CarneConsolidacao
{
    /**
     * PK
     * @var string
     */
    private $numeracaoConsolidacao;

    /**
     * PK
     * @var string
     */
    private $numeracao;

    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Carne
     */
    private $fkArrecadacaoCarne;


    /**
     * Set numeracaoConsolidacao
     *
     * @param string $numeracaoConsolidacao
     * @return CarneConsolidacao
     */
    public function setNumeracaoConsolidacao($numeracaoConsolidacao)
    {
        $this->numeracaoConsolidacao = $numeracaoConsolidacao;
        return $this;
    }

    /**
     * Get numeracaoConsolidacao
     *
     * @return string
     */
    public function getNumeracaoConsolidacao()
    {
        return $this->numeracaoConsolidacao;
    }

    /**
     * Set numeracao
     *
     * @param string $numeracao
     * @return CarneConsolidacao
     */
    public function setNumeracao($numeracao)
    {
        $this->numeracao = $numeracao;
        return $this;
    }

    /**
     * Get numeracao
     *
     * @return string
     */
    public function getNumeracao()
    {
        return $this->numeracao;
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return CarneConsolidacao
     */
    public function setCodConvenio($codConvenio)
    {
        $this->codConvenio = $codConvenio;
        return $this;
    }

    /**
     * Get codConvenio
     *
     * @return integer
     */
    public function getCodConvenio()
    {
        return $this->codConvenio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne
     * @return CarneConsolidacao
     */
    public function setFkArrecadacaoCarne(\Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne)
    {
        $this->numeracao = $fkArrecadacaoCarne->getNumeracao();
        $this->codConvenio = $fkArrecadacaoCarne->getCodConvenio();
        $this->fkArrecadacaoCarne = $fkArrecadacaoCarne;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoCarne
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Carne
     */
    public function getFkArrecadacaoCarne()
    {
        return $this->fkArrecadacaoCarne;
    }
}
