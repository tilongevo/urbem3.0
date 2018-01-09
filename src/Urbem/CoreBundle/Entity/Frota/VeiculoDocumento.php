<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * VeiculoDocumento
 */
class VeiculoDocumento
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
    private $mes;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Frota\VeiculoDocumentoEmpenho
     */
    private $fkFrotaVeiculoDocumentoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    private $fkFrotaVeiculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Documento
     */
    private $fkFrotaDocumento;


    /**
     * Set codVeiculo
     *
     * @param integer $codVeiculo
     * @return VeiculoDocumento
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
     * @return VeiculoDocumento
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
     * @return VeiculoDocumento
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
     * Set mes
     *
     * @param integer $mes
     * @return VeiculoDocumento
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     * @return VeiculoDocumento
     */
    public function setFkFrotaVeiculo(\Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo)
    {
        $this->codVeiculo = $fkFrotaVeiculo->getCodVeiculo();
        $this->fkFrotaVeiculo = $fkFrotaVeiculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaVeiculo
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    public function getFkFrotaVeiculo()
    {
        return $this->fkFrotaVeiculo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Documento $fkFrotaDocumento
     * @return VeiculoDocumento
     */
    public function setFkFrotaDocumento(\Urbem\CoreBundle\Entity\Frota\Documento $fkFrotaDocumento)
    {
        $this->codDocumento = $fkFrotaDocumento->getCodDocumento();
        $this->fkFrotaDocumento = $fkFrotaDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Documento
     */
    public function getFkFrotaDocumento()
    {
        return $this->fkFrotaDocumento;
    }

    /**
     * OneToOne (inverse side)
     * Set FrotaVeiculoDocumentoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoDocumentoEmpenho $fkFrotaVeiculoDocumentoEmpenho
     * @return VeiculoDocumento
     */
    public function setFkFrotaVeiculoDocumentoEmpenho(\Urbem\CoreBundle\Entity\Frota\VeiculoDocumentoEmpenho $fkFrotaVeiculoDocumentoEmpenho)
    {
        $fkFrotaVeiculoDocumentoEmpenho->setFkFrotaVeiculoDocumento($this);
        $this->fkFrotaVeiculoDocumentoEmpenho = $fkFrotaVeiculoDocumentoEmpenho;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFrotaVeiculoDocumentoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Frota\VeiculoDocumentoEmpenho
     */
    public function getFkFrotaVeiculoDocumentoEmpenho()
    {
        return $this->fkFrotaVeiculoDocumentoEmpenho;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkFrotaDocumento;
    }
}
