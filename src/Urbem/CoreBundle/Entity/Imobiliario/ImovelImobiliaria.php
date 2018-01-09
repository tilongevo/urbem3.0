<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * ImovelImobiliaria
 */
class ImovelImobiliaria
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * @var string
     */
    private $creci;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    private $fkImobiliarioImovel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Corretagem
     */
    private $fkImobiliarioCorretagem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return ImovelImobiliaria
     */
    public function setInscricaoMunicipal($inscricaoMunicipal)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /**
     * Get inscricaoMunicipal
     *
     * @return integer
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * Set creci
     *
     * @param string $creci
     * @return ImovelImobiliaria
     */
    public function setCreci($creci)
    {
        $this->creci = $creci;
        return $this;
    }

    /**
     * Get creci
     *
     * @return string
     */
    public function getCreci()
    {
        return $this->creci;
    }

    /**
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return $this
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioCorretagem
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Corretagem $fkImobiliarioCorretagem
     * @return ImovelImobiliaria
     */
    public function setFkImobiliarioCorretagem(\Urbem\CoreBundle\Entity\Imobiliario\Corretagem $fkImobiliarioCorretagem)
    {
        $this->creci = $fkImobiliarioCorretagem->getCreci();
        $this->fkImobiliarioCorretagem = $fkImobiliarioCorretagem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioCorretagem
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Corretagem
     */
    public function getFkImobiliarioCorretagem()
    {
        return $this->fkImobiliarioCorretagem;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel
     * @return ImovelImobiliaria
     */
    public function setFkImobiliarioImovel(\Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel)
    {
        $this->inscricaoMunicipal = $fkImobiliarioImovel->getInscricaoMunicipal();
        $this->fkImobiliarioImovel = $fkImobiliarioImovel;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkImobiliarioImovel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    public function getFkImobiliarioImovel()
    {
        return $this->fkImobiliarioImovel;
    }
}
