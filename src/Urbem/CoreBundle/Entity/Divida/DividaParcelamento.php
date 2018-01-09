<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * DividaParcelamento
 */
class DividaParcelamento
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
    private $numParcelamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\DividaAtiva
     */
    private $fkDividaDividaAtiva;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\Parcelamento
     */
    private $fkDividaParcelamento;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return DividaParcelamento
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
     * @return DividaParcelamento
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
     * Set numParcelamento
     *
     * @param integer $numParcelamento
     * @return DividaParcelamento
     */
    public function setNumParcelamento($numParcelamento)
    {
        $this->numParcelamento = $numParcelamento;
        return $this;
    }

    /**
     * Get numParcelamento
     *
     * @return integer
     */
    public function getNumParcelamento()
    {
        return $this->numParcelamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaDividaAtiva
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaAtiva $fkDividaDividaAtiva
     * @return DividaParcelamento
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
     * Set fkDividaParcelamento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Parcelamento $fkDividaParcelamento
     * @return DividaParcelamento
     */
    public function setFkDividaParcelamento(\Urbem\CoreBundle\Entity\Divida\Parcelamento $fkDividaParcelamento)
    {
        $this->numParcelamento = $fkDividaParcelamento->getNumParcelamento();
        $this->fkDividaParcelamento = $fkDividaParcelamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaParcelamento
     *
     * @return \Urbem\CoreBundle\Entity\Divida\Parcelamento
     */
    public function getFkDividaParcelamento()
    {
        return $this->fkDividaParcelamento;
    }
}
