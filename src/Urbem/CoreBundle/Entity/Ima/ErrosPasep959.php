<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ErrosPasep959
 */
class ErrosPasep959
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
     * @var \Urbem\CoreBundle\Entity\Ima\OcorrenciaDetalhe959
     */
    private $fkImaOcorrenciaDetalhe959;


    /**
     * Set codErro
     *
     * @param integer $codErro
     * @return ErrosPasep959
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
     * @return ErrosPasep959
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
     * @return ErrosPasep959
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
     * @return ErrosPasep959
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
     * @return ErrosPasep959
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
     * Set fkImaOcorrenciaDetalhe959
     *
     * @param \Urbem\CoreBundle\Entity\Ima\OcorrenciaDetalhe959 $fkImaOcorrenciaDetalhe959
     * @return ErrosPasep959
     */
    public function setFkImaOcorrenciaDetalhe959(\Urbem\CoreBundle\Entity\Ima\OcorrenciaDetalhe959 $fkImaOcorrenciaDetalhe959)
    {
        $this->numOcorrencia = $fkImaOcorrenciaDetalhe959->getNumOcorrencia();
        $this->fkImaOcorrenciaDetalhe959 = $fkImaOcorrenciaDetalhe959;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaOcorrenciaDetalhe959
     *
     * @return \Urbem\CoreBundle\Entity\Ima\OcorrenciaDetalhe959
     */
    public function getFkImaOcorrenciaDetalhe959()
    {
        return $this->fkImaOcorrenciaDetalhe959;
    }
}
