<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * PrevidenciaRegimeRat
 */
class PrevidenciaRegimeRat
{
    /**
     * PK
     * @var integer
     */
    private $codPrevidencia;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $aliquotaRat;

    /**
     * @var integer
     */
    private $aliquotaFap;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia
     */
    private $fkFolhapagamentoPrevidenciaPrevidencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codPrevidencia
     *
     * @param integer $codPrevidencia
     * @return PrevidenciaRegimeRat
     */
    public function setCodPrevidencia($codPrevidencia)
    {
        $this->codPrevidencia = $codPrevidencia;
        return $this;
    }

    /**
     * Get codPrevidencia
     *
     * @return integer
     */
    public function getCodPrevidencia()
    {
        return $this->codPrevidencia;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return PrevidenciaRegimeRat
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set aliquotaRat
     *
     * @param integer $aliquotaRat
     * @return PrevidenciaRegimeRat
     */
    public function setAliquotaRat($aliquotaRat)
    {
        $this->aliquotaRat = $aliquotaRat;
        return $this;
    }

    /**
     * Get aliquotaRat
     *
     * @return integer
     */
    public function getAliquotaRat()
    {
        return $this->aliquotaRat;
    }

    /**
     * Set aliquotaFap
     *
     * @param integer $aliquotaFap
     * @return PrevidenciaRegimeRat
     */
    public function setAliquotaFap($aliquotaFap)
    {
        $this->aliquotaFap = $aliquotaFap;
        return $this;
    }

    /**
     * Get aliquotaFap
     *
     * @return integer
     */
    public function getAliquotaFap()
    {
        return $this->aliquotaFap;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoPrevidenciaPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia $fkFolhapagamentoPrevidenciaPrevidencia
     * @return PrevidenciaRegimeRat
     */
    public function setFkFolhapagamentoPrevidenciaPrevidencia(\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia $fkFolhapagamentoPrevidenciaPrevidencia)
    {
        $this->codPrevidencia = $fkFolhapagamentoPrevidenciaPrevidencia->getCodPrevidencia();
        $this->timestamp = $fkFolhapagamentoPrevidenciaPrevidencia->getTimestamp();
        $this->fkFolhapagamentoPrevidenciaPrevidencia = $fkFolhapagamentoPrevidenciaPrevidencia;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoPrevidenciaPrevidencia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia
     */
    public function getFkFolhapagamentoPrevidenciaPrevidencia()
    {
        return $this->fkFolhapagamentoPrevidenciaPrevidencia;
    }
}
