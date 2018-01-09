<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * DividaImovel
 */
class DividaImovel
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codInscricao;

    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\DividaAtiva
     */
    private $fkDividaDividaAtiva;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    private $fkImobiliarioImovel;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return DividaImovel
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
     * Set codInscricao
     *
     * @param integer $codInscricao
     * @return DividaImovel
     */
    public function setCodInscricao($codInscricao)
    {
        $this->codInscricao = $codInscricao;
        return $this;
    }

    /**
     * Get codInscricao
     *
     * @return integer
     */
    public function getCodInscricao()
    {
        return $this->codInscricao;
    }

    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return DividaImovel
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
     * ManyToOne (inverse side)
     * Set fkDividaDividaAtiva
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaAtiva $fkDividaDividaAtiva
     * @return DividaImovel
     */
    public function setFkDividaDividaAtiva(\Urbem\CoreBundle\Entity\Divida\DividaAtiva $fkDividaDividaAtiva)
    {
        $this->exercicio = $fkDividaDividaAtiva->getExercicio();
        $this->codInscricao = $fkDividaDividaAtiva->getCodInscricao();
        $this->fkDividaDividaAtiva = $fkDividaDividaAtiva;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaDividaAtiva
     *
     * @return \Urbem\CoreBundle\Entity\Divida\DividaAtiva
     */
    public function getFkDividaDividaAtiva()
    {
        return $this->fkDividaDividaAtiva;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel
     * @return DividaImovel
     */
    public function setFkImobiliarioImovel(\Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel)
    {
        $this->inscricaoMunicipal = $fkImobiliarioImovel->getInscricaoMunicipal();
        $this->fkImobiliarioImovel = $fkImobiliarioImovel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioImovel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    public function getFkImobiliarioImovel()
    {
        return $this->fkImobiliarioImovel;
    }
}
