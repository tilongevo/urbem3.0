<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * DataConstrucao
 */
class DataConstrucao
{
    /**
     * PK
     * @var integer
     */
    private $codConstrucao;

    /**
     * @var \DateTime
     */
    private $dataConstrucao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Construcao
     */
    private $fkImobiliarioConstrucao;


    /**
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return DataConstrucao
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
     * Set dataConstrucao
     *
     * @param \DateTime $dataConstrucao
     * @return DataConstrucao
     */
    public function setDataConstrucao(\DateTime $dataConstrucao)
    {
        $this->dataConstrucao = $dataConstrucao;
        return $this;
    }

    /**
     * Get dataConstrucao
     *
     * @return \DateTime
     */
    public function getDataConstrucao()
    {
        return $this->dataConstrucao;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioConstrucao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Construcao $fkImobiliarioConstrucao
     * @return DataConstrucao
     */
    public function setFkImobiliarioConstrucao(\Urbem\CoreBundle\Entity\Imobiliario\Construcao $fkImobiliarioConstrucao)
    {
        $this->codConstrucao = $fkImobiliarioConstrucao->getCodConstrucao();
        $this->fkImobiliarioConstrucao = $fkImobiliarioConstrucao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkImobiliarioConstrucao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Construcao
     */
    public function getFkImobiliarioConstrucao()
    {
        return $this->fkImobiliarioConstrucao;
    }
}
