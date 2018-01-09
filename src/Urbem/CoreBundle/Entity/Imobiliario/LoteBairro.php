<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LoteBairro
 */
class LoteBairro
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var integer
     */
    private $codBairro;

    /**
     * PK
     * @var integer
     */
    private $codUf;

    /**
     * PK
     * @var integer
     */
    private $codMunicipio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    private $fkImobiliarioLote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwBairro
     */
    private $fkSwBairro;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LoteBairro
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set codBairro
     *
     * @param integer $codBairro
     * @return LoteBairro
     */
    public function setCodBairro($codBairro)
    {
        $this->codBairro = $codBairro;
        return $this;
    }

    /**
     * Get codBairro
     *
     * @return integer
     */
    public function getCodBairro()
    {
        return $this->codBairro;
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return LoteBairro
     */
    public function setCodUf($codUf)
    {
        $this->codUf = $codUf;
        return $this;
    }

    /**
     * Get codUf
     *
     * @return integer
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * Set codMunicipio
     *
     * @param integer $codMunicipio
     * @return LoteBairro
     */
    public function setCodMunicipio($codMunicipio)
    {
        $this->codMunicipio = $codMunicipio;
        return $this;
    }

    /**
     * Get codMunicipio
     *
     * @return integer
     */
    public function getCodMunicipio()
    {
        return $this->codMunicipio;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return LoteBairro
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
     * Set fkImobiliarioLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote
     * @return LoteBairro
     */
    public function setFkImobiliarioLote(\Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote)
    {
        $this->codLote = $fkImobiliarioLote->getCodLote();
        $this->fkImobiliarioLote = $fkImobiliarioLote;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLote
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    public function getFkImobiliarioLote()
    {
        return $this->fkImobiliarioLote;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwBairro
     *
     * @param \Urbem\CoreBundle\Entity\SwBairro $fkSwBairro
     * @return LoteBairro
     */
    public function setFkSwBairro(\Urbem\CoreBundle\Entity\SwBairro $fkSwBairro)
    {
        $this->codBairro = $fkSwBairro->getCodBairro();
        $this->codUf = $fkSwBairro->getCodUf();
        $this->codMunicipio = $fkSwBairro->getCodMunicipio();
        $this->fkSwBairro = $fkSwBairro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwBairro
     *
     * @return \Urbem\CoreBundle\Entity\SwBairro
     */
    public function getFkSwBairro()
    {
        return $this->fkSwBairro;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->fkSwBairro->getNomBairro();
    }
}
