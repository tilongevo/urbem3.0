<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * PenalidadeDesconto
 */
class PenalidadeDesconto
{
    /**
     * PK
     * @var integer
     */
    private $codPenalidade;

    /**
     * PK
     * @var integer
     */
    private $codDesconto;

    /**
     * @var integer
     */
    private $prazo;

    /**
     * @var integer
     */
    private $desconto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade
     */
    private $fkFiscalizacaoPenalidade;


    /**
     * Set codPenalidade
     *
     * @param integer $codPenalidade
     * @return PenalidadeDesconto
     */
    public function setCodPenalidade($codPenalidade)
    {
        $this->codPenalidade = $codPenalidade;
        return $this;
    }

    /**
     * Get codPenalidade
     *
     * @return integer
     */
    public function getCodPenalidade()
    {
        return $this->codPenalidade;
    }

    /**
     * Set codDesconto
     *
     * @param integer $codDesconto
     * @return PenalidadeDesconto
     */
    public function setCodDesconto($codDesconto)
    {
        $this->codDesconto = $codDesconto;
        return $this;
    }

    /**
     * Get codDesconto
     *
     * @return integer
     */
    public function getCodDesconto()
    {
        return $this->codDesconto;
    }

    /**
     * Set prazo
     *
     * @param integer $prazo
     * @return PenalidadeDesconto
     */
    public function setPrazo($prazo)
    {
        $this->prazo = $prazo;
        return $this;
    }

    /**
     * Get prazo
     *
     * @return integer
     */
    public function getPrazo()
    {
        return $this->prazo;
    }

    /**
     * Set desconto
     *
     * @param integer $desconto
     * @return PenalidadeDesconto
     */
    public function setDesconto($desconto)
    {
        $this->desconto = $desconto;
        return $this;
    }

    /**
     * Get desconto
     *
     * @return integer
     */
    public function getDesconto()
    {
        return $this->desconto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade
     * @return PenalidadeDesconto
     */
    public function setFkFiscalizacaoPenalidade(\Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade)
    {
        $this->codPenalidade = $fkFiscalizacaoPenalidade->getCodPenalidade();
        $this->fkFiscalizacaoPenalidade = $fkFiscalizacaoPenalidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoPenalidade
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade
     */
    public function getFkFiscalizacaoPenalidade()
    {
        return $this->fkFiscalizacaoPenalidade;
    }
}
