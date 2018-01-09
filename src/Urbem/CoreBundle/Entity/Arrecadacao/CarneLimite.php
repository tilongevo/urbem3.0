<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * CarneLimite
 */
class CarneLimite
{
    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * @var string
     */
    private $numeracao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Carne
     */
    private $fkArrecadacaoCarne;


    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return CarneLimite
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
     * Set numeracao
     *
     * @param string $numeracao
     * @return CarneLimite
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
     * ManyToOne (inverse side)
     * Set fkArrecadacaoCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne
     * @return CarneLimite
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
