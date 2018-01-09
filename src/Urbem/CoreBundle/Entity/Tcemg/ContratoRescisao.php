<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ContratoRescisao
 */
class ContratoRescisao
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var \DateTime
     */
    private $dataRescisao;

    /**
     * @var integer
     */
    private $valorRescisao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    private $fkTcemgContrato;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoRescisao
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ContratoRescisao
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContratoRescisao
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set dataRescisao
     *
     * @param \DateTime $dataRescisao
     * @return ContratoRescisao
     */
    public function setDataRescisao(\DateTime $dataRescisao)
    {
        $this->dataRescisao = $dataRescisao;
        return $this;
    }

    /**
     * Get dataRescisao
     *
     * @return \DateTime
     */
    public function getDataRescisao()
    {
        return $this->dataRescisao;
    }

    /**
     * Set valorRescisao
     *
     * @param integer $valorRescisao
     * @return ContratoRescisao
     */
    public function setValorRescisao($valorRescisao)
    {
        $this->valorRescisao = $valorRescisao;
        return $this;
    }

    /**
     * Get valorRescisao
     *
     * @return integer
     */
    public function getValorRescisao()
    {
        return $this->valorRescisao;
    }

    /**
     * OneToOne (owning side)
     * Set TcemgContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato
     * @return ContratoRescisao
     */
    public function setFkTcemgContrato(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        $this->codContrato = $fkTcemgContrato->getCodContrato();
        $this->codEntidade = $fkTcemgContrato->getCodEntidade();
        $this->exercicio = $fkTcemgContrato->getExercicio();
        $this->fkTcemgContrato = $fkTcemgContrato;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkTcemgContrato
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    public function getFkTcemgContrato()
    {
        return $this->fkTcemgContrato;
    }
}
