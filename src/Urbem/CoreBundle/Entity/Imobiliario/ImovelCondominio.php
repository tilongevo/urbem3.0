<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * ImovelCondominio
 */
class ImovelCondominio
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * @var integer
     */
    private $codCondominio;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    private $fkImobiliarioImovel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Condominio
     */
    private $fkImobiliarioCondominio;


    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return ImovelCondominio
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
     * Set codCondominio
     *
     * @param integer $codCondominio
     * @return ImovelCondominio
     */
    public function setCodCondominio($codCondominio)
    {
        $this->codCondominio = $codCondominio;
        return $this;
    }

    /**
     * Get codCondominio
     *
     * @return integer
     */
    public function getCodCondominio()
    {
        return $this->codCondominio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Condominio $fkImobiliarioCondominio
     * @return ImovelCondominio
     */
    public function setFkImobiliarioCondominio(\Urbem\CoreBundle\Entity\Imobiliario\Condominio $fkImobiliarioCondominio)
    {
        $this->codCondominio = $fkImobiliarioCondominio->getCodCondominio();
        $this->fkImobiliarioCondominio = $fkImobiliarioCondominio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioCondominio
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Condominio
     */
    public function getFkImobiliarioCondominio()
    {
        return $this->fkImobiliarioCondominio;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel
     * @return ImovelCondominio
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

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkImobiliarioCondominio;
    }
}
