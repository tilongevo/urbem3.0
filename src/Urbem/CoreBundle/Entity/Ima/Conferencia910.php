<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * Conferencia910
 */
class Conferencia910
{
    /**
     * PK
     * @var integer
     */
    private $codConferencia;

    /**
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $valorPasep;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;


    /**
     * Set codConferencia
     *
     * @param integer $codConferencia
     * @return Conferencia910
     */
    public function setCodConferencia($codConferencia)
    {
        $this->codConferencia = $codConferencia;
        return $this;
    }

    /**
     * Get codConferencia
     *
     * @return integer
     */
    public function getCodConferencia()
    {
        return $this->codConferencia;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return Conferencia910
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
     * Set valorPasep
     *
     * @param integer $valorPasep
     * @return Conferencia910
     */
    public function setValorPasep($valorPasep)
    {
        $this->valorPasep = $valorPasep;
        return $this;
    }

    /**
     * Get valorPasep
     *
     * @return integer
     */
    public function getValorPasep()
    {
        return $this->valorPasep;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return Conferencia910
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
