<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ErrosCadastraisPasep910
 */
class ErrosCadastraisPasep910
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
     * @var string
     */
    private $pisPasep;

    /**
     * @var integer
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\OcorrenciaCadastral910
     */
    private $fkImaOcorrenciaCadastral910;


    /**
     * Set codErro
     *
     * @param integer $codErro
     * @return ErrosCadastraisPasep910
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
     * @return ErrosCadastraisPasep910
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
     * Set pisPasep
     *
     * @param string $pisPasep
     * @return ErrosCadastraisPasep910
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
     * Set valor
     *
     * @param integer $valor
     * @return ErrosCadastraisPasep910
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaOcorrenciaCadastral910
     *
     * @param \Urbem\CoreBundle\Entity\Ima\OcorrenciaCadastral910 $fkImaOcorrenciaCadastral910
     * @return ErrosCadastraisPasep910
     */
    public function setFkImaOcorrenciaCadastral910(\Urbem\CoreBundle\Entity\Ima\OcorrenciaCadastral910 $fkImaOcorrenciaCadastral910)
    {
        $this->numOcorrencia = $fkImaOcorrenciaCadastral910->getNumOcorrencia();
        $this->fkImaOcorrenciaCadastral910 = $fkImaOcorrenciaCadastral910;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaOcorrenciaCadastral910
     *
     * @return \Urbem\CoreBundle\Entity\Ima\OcorrenciaCadastral910
     */
    public function getFkImaOcorrenciaCadastral910()
    {
        return $this->fkImaOcorrenciaCadastral910;
    }
}
