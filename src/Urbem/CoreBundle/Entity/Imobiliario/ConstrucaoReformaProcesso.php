<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * ConstrucaoReformaProcesso
 */
class ConstrucaoReformaProcesso
{
    /**
     * PK
     * @var integer
     */
    private $codConstrucao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codProcesso;

    /**
     * @var string
     */
    private $anoExercicio;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReforma
     */
    private $fkImobiliarioConstrucaoReforma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return ConstrucaoReformaProcesso
     */
    public function setCodConstrucao($codConstrucao)
    {
        $this->codConstrucao = $codConstrucao;
        return $this;
    }

    /**
     * Get codConstrucao
     *
     * @return integer
     */
    public function getCodConstrucao()
    {
        return $this->codConstrucao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return ConstrucaoReformaProcesso
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return ConstrucaoReformaProcesso
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return ConstrucaoReformaProcesso
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return ConstrucaoReformaProcesso
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->anoExercicio = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioConstrucaoReforma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReforma $fkImobiliarioConstrucaoReforma
     * @return ConstrucaoReformaProcesso
     */
    public function setFkImobiliarioConstrucaoReforma(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReforma $fkImobiliarioConstrucaoReforma)
    {
        $this->codConstrucao = $fkImobiliarioConstrucaoReforma->getCodConstrucao();
        $this->timestamp = $fkImobiliarioConstrucaoReforma->getTimestamp();
        $this->fkImobiliarioConstrucaoReforma = $fkImobiliarioConstrucaoReforma;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkImobiliarioConstrucaoReforma
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReforma
     */
    public function getFkImobiliarioConstrucaoReforma()
    {
        return $this->fkImobiliarioConstrucaoReforma;
    }
}
