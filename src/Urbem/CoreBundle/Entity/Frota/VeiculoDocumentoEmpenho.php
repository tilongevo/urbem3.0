<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * VeiculoDocumentoEmpenho
 */
class VeiculoDocumentoEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $codVeiculo;

    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codEmpenho;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var string
     */
    private $exercicioEmpenho;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Frota\VeiculoDocumento
     */
    private $fkFrotaVeiculoDocumento;


    /**
     * Set codVeiculo
     *
     * @param integer $codVeiculo
     * @return VeiculoDocumentoEmpenho
     */
    public function setCodVeiculo($codVeiculo)
    {
        $this->codVeiculo = $codVeiculo;
        return $this;
    }

    /**
     * Get codVeiculo
     *
     * @return integer
     */
    public function getCodVeiculo()
    {
        return $this->codVeiculo;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return VeiculoDocumentoEmpenho
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return VeiculoDocumentoEmpenho
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
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return VeiculoDocumentoEmpenho
     */
    public function setCodEmpenho($codEmpenho)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return VeiculoDocumentoEmpenho
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
     * Set exercicioEmpenho
     *
     * @param string $exercicioEmpenho
     * @return VeiculoDocumentoEmpenho
     */
    public function setExercicioEmpenho($exercicioEmpenho)
    {
        $this->exercicioEmpenho = $exercicioEmpenho;
        return $this;
    }

    /**
     * Get exercicioEmpenho
     *
     * @return string
     */
    public function getExercicioEmpenho()
    {
        return $this->exercicioEmpenho;
    }

    /**
     * OneToOne (owning side)
     * Set FrotaVeiculoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoDocumento $fkFrotaVeiculoDocumento
     * @return VeiculoDocumentoEmpenho
     */
    public function setFkFrotaVeiculoDocumento(\Urbem\CoreBundle\Entity\Frota\VeiculoDocumento $fkFrotaVeiculoDocumento)
    {
        $this->codVeiculo = $fkFrotaVeiculoDocumento->getCodVeiculo();
        $this->codDocumento = $fkFrotaVeiculoDocumento->getCodDocumento();
        $this->exercicio = $fkFrotaVeiculoDocumento->getExercicio();
        $this->fkFrotaVeiculoDocumento = $fkFrotaVeiculoDocumento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFrotaVeiculoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Frota\VeiculoDocumento
     */
    public function getFkFrotaVeiculoDocumento()
    {
        return $this->fkFrotaVeiculoDocumento;
    }
}
