<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ErrosPasep910
 */
class ErrosPasep910
{
    /**
     * PK
     * @var integer
     */
    private $codErro;

    /**
     * @var integer
     */
    private $numOcorrencia;

    /**
     * @var integer
     */
    private $registro;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $pisPasep;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\OcorrenciaDetalhe910
     */
    private $fkImaOcorrenciaDetalhe910;


    /**
     * Set codErro
     *
     * @param integer $codErro
     * @return ErrosPasep910
     */
    public function setCodErro($codErro)
    {
        $this->codErro = $codErro;
        return $this;
    }

    /**
     * Get codErro
     *
     * @return integer
     */
    public function getCodErro()
    {
        return $this->codErro;
    }

    /**
     * Set numOcorrencia
     *
     * @param integer $numOcorrencia
     * @return ErrosPasep910
     */
    public function setNumOcorrencia($numOcorrencia)
    {
        $this->numOcorrencia = $numOcorrencia;
        return $this;
    }

    /**
     * Get numOcorrencia
     *
     * @return integer
     */
    public function getNumOcorrencia()
    {
        return $this->numOcorrencia;
    }

    /**
     * Set registro
     *
     * @param integer $registro
     * @return ErrosPasep910
     */
    public function setRegistro($registro = null)
    {
        $this->registro = $registro;
        return $this;
    }

    /**
     * Get registro
     *
     * @return integer
     */
    public function getRegistro()
    {
        return $this->registro;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return ErrosPasep910
     */
    public function setNome($nome = null)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set pisPasep
     *
     * @param string $pisPasep
     * @return ErrosPasep910
     */
    public function setPisPasep($pisPasep)
    {
        $this->pisPasep = $pisPasep;
        return $this;
    }

    /**
     * Get pisPasep
     *
     * @return string
     */
    public function getPisPasep()
    {
        return $this->pisPasep;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaOcorrenciaDetalhe910
     *
     * @param \Urbem\CoreBundle\Entity\Ima\OcorrenciaDetalhe910 $fkImaOcorrenciaDetalhe910
     * @return ErrosPasep910
     */
    public function setFkImaOcorrenciaDetalhe910(\Urbem\CoreBundle\Entity\Ima\OcorrenciaDetalhe910 $fkImaOcorrenciaDetalhe910)
    {
        $this->numOcorrencia = $fkImaOcorrenciaDetalhe910->getNumOcorrencia();
        $this->fkImaOcorrenciaDetalhe910 = $fkImaOcorrenciaDetalhe910;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaOcorrenciaDetalhe910
     *
     * @return \Urbem\CoreBundle\Entity\Ima\OcorrenciaDetalhe910
     */
    public function getFkImaOcorrenciaDetalhe910()
    {
        return $this->fkImaOcorrenciaDetalhe910;
    }
}
