<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * ImovelConfrontacao
 */
class ImovelConfrontacao
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * @var integer
     */
    private $codLote;

    /**
     * @var integer
     */
    private $codConfrontacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    private $fkImobiliarioImovel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoTrecho
     */
    private $fkImobiliarioConfrontacaoTrecho;


    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return ImovelConfrontacao
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
     * Set codLote
     *
     * @param integer $codLote
     * @return ImovelConfrontacao
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
     * Set codConfrontacao
     *
     * @param integer $codConfrontacao
     * @return ImovelConfrontacao
     */
    public function setCodConfrontacao($codConfrontacao)
    {
        $this->codConfrontacao = $codConfrontacao;
        return $this;
    }

    /**
     * Get codConfrontacao
     *
     * @return integer
     */
    public function getCodConfrontacao()
    {
        return $this->codConfrontacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioConfrontacaoTrecho
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoTrecho $fkImobiliarioConfrontacaoTrecho
     * @return ImovelConfrontacao
     */
    public function setFkImobiliarioConfrontacaoTrecho(\Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoTrecho $fkImobiliarioConfrontacaoTrecho)
    {
        $this->codConfrontacao = $fkImobiliarioConfrontacaoTrecho->getCodConfrontacao();
        $this->codLote = $fkImobiliarioConfrontacaoTrecho->getCodLote();
        $this->fkImobiliarioConfrontacaoTrecho = $fkImobiliarioConfrontacaoTrecho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioConfrontacaoTrecho
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoTrecho
     */
    public function getFkImobiliarioConfrontacaoTrecho()
    {
        return $this->fkImobiliarioConfrontacaoTrecho;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel
     * @return ImovelConfrontacao
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
