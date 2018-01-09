<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ErrosPasep
 */
class ErrosPasep
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
     * @var \Urbem\CoreBundle\Entity\Ima\OcorrenciaDetalhe909910
     */
    private $fkImaOcorrenciaDetalhe909910;


    /**
     * Set codErro
     *
     * @param integer $codErro
     * @return ErrosPasep
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
     * @return ErrosPasep
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
     * @return ErrosPasep
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
     * @return ErrosPasep
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
     * @return ErrosPasep
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
     * Set fkImaOcorrenciaDetalhe909910
     *
     * @param \Urbem\CoreBundle\Entity\Ima\OcorrenciaDetalhe909910 $fkImaOcorrenciaDetalhe909910
     * @return ErrosPasep
     */
    public function setFkImaOcorrenciaDetalhe909910(\Urbem\CoreBundle\Entity\Ima\OcorrenciaDetalhe909910 $fkImaOcorrenciaDetalhe909910)
    {
        $this->numOcorrencia = $fkImaOcorrenciaDetalhe909910->getNumOcorrencia();
        $this->fkImaOcorrenciaDetalhe909910 = $fkImaOcorrenciaDetalhe909910;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaOcorrenciaDetalhe909910
     *
     * @return \Urbem\CoreBundle\Entity\Ima\OcorrenciaDetalhe909910
     */
    public function getFkImaOcorrenciaDetalhe909910()
    {
        return $this->fkImaOcorrenciaDetalhe909910;
    }
}
