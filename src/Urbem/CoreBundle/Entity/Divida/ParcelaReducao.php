<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * ParcelaReducao
 */
class ParcelaReducao
{
    /**
     * PK
     * @var integer
     */
    private $numParcela;

    /**
     * PK
     * @var integer
     */
    private $numParcelamento;

    /**
     * PK
     * @var string
     */
    private $origemReducao;

    /**
     * @var integer
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\Parcela
     */
    private $fkDividaParcela;


    /**
     * Set numParcela
     *
     * @param integer $numParcela
     * @return ParcelaReducao
     */
    public function setNumParcela($numParcela)
    {
        $this->numParcela = $numParcela;
        return $this;
    }

    /**
     * Get numParcela
     *
     * @return integer
     */
    public function getNumParcela()
    {
        return $this->numParcela;
    }

    /**
     * Set numParcelamento
     *
     * @param integer $numParcelamento
     * @return ParcelaReducao
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
     * Set origemReducao
     *
     * @param string $origemReducao
     * @return ParcelaReducao
     */
    public function setOrigemReducao($origemReducao)
    {
        $this->origemReducao = $origemReducao;
        return $this;
    }

    /**
     * Get origemReducao
     *
     * @return string
     */
    public function getOrigemReducao()
    {
        return $this->origemReducao;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return ParcelaReducao
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaParcela
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Parcela $fkDividaParcela
     * @return ParcelaReducao
     */
    public function setFkDividaParcela(\Urbem\CoreBundle\Entity\Divida\Parcela $fkDividaParcela)
    {
        $this->numParcelamento = $fkDividaParcela->getNumParcelamento();
        $this->numParcela = $fkDividaParcela->getNumParcela();
        $this->fkDividaParcela = $fkDividaParcela;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaParcela
     *
     * @return \Urbem\CoreBundle\Entity\Divida\Parcela
     */
    public function getFkDividaParcela()
    {
        return $this->fkDividaParcela;
    }
}
