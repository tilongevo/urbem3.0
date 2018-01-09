<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * ConstrucaoReforma
 */
class ConstrucaoReforma
{
    /**
     * PK
     * @var integer
     */
    private $codConstrucao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReformaProcesso
     */
    private $fkImobiliarioConstrucaoReformaProcesso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Construcao
     */
    private $fkImobiliarioConstrucao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return ConstrucaoReforma
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
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConstrucaoReforma
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
     * ManyToOne (inverse side)
     * Set fkImobiliarioConstrucao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Construcao $fkImobiliarioConstrucao
     * @return ConstrucaoReforma
     */
    public function setFkImobiliarioConstrucao(\Urbem\CoreBundle\Entity\Imobiliario\Construcao $fkImobiliarioConstrucao)
    {
        $this->codConstrucao = $fkImobiliarioConstrucao->getCodConstrucao();
        $this->fkImobiliarioConstrucao = $fkImobiliarioConstrucao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioConstrucao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Construcao
     */
    public function getFkImobiliarioConstrucao()
    {
        return $this->fkImobiliarioConstrucao;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioConstrucaoReformaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReformaProcesso $fkImobiliarioConstrucaoReformaProcesso
     * @return ConstrucaoReforma
     */
    public function setFkImobiliarioConstrucaoReformaProcesso(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReformaProcesso $fkImobiliarioConstrucaoReformaProcesso)
    {
        $fkImobiliarioConstrucaoReformaProcesso->setFkImobiliarioConstrucaoReforma($this);
        $this->fkImobiliarioConstrucaoReformaProcesso = $fkImobiliarioConstrucaoReformaProcesso;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioConstrucaoReformaProcesso
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReformaProcesso
     */
    public function getFkImobiliarioConstrucaoReformaProcesso()
    {
        return $this->fkImobiliarioConstrucaoReformaProcesso;
    }
}
