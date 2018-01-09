<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ErrosPasep952
 */
class ErrosPasep952
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
     * @var \Urbem\CoreBundle\Entity\Ima\OcorrenciaDetalhe952
     */
    private $fkImaOcorrenciaDetalhe952;


    /**
     * Set codErro
     *
     * @param integer $codErro
     * @return ErrosPasep952
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
     * @return ErrosPasep952
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
     * @return ErrosPasep952
     */
    public function setRegistro($registro)
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
     * @return ErrosPasep952
     */
    public function setNome($nome)
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
     * @return ErrosPasep952
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
     * Set fkImaOcorrenciaDetalhe952
     *
     * @param \Urbem\CoreBundle\Entity\Ima\OcorrenciaDetalhe952 $fkImaOcorrenciaDetalhe952
     * @return ErrosPasep952
     */
    public function setFkImaOcorrenciaDetalhe952(\Urbem\CoreBundle\Entity\Ima\OcorrenciaDetalhe952 $fkImaOcorrenciaDetalhe952)
    {
        $this->numOcorrencia = $fkImaOcorrenciaDetalhe952->getNumOcorrencia();
        $this->fkImaOcorrenciaDetalhe952 = $fkImaOcorrenciaDetalhe952;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaOcorrenciaDetalhe952
     *
     * @return \Urbem\CoreBundle\Entity\Ima\OcorrenciaDetalhe952
     */
    public function getFkImaOcorrenciaDetalhe952()
    {
        return $this->fkImaOcorrenciaDetalhe952;
    }
}
