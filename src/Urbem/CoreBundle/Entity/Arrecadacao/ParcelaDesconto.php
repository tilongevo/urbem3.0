<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * ParcelaDesconto
 */
class ParcelaDesconto
{
    /**
     * PK
     * @var integer
     */
    private $codParcela;

    /**
     * @var \DateTime
     */
    private $vencimento;

    /**
     * @var integer
     */
    private $valor;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Parcela
     */
    private $fkArrecadacaoParcela;


    /**
     * Set codParcela
     *
     * @param integer $codParcela
     * @return ParcelaDesconto
     */
    public function setCodParcela($codParcela)
    {
        $this->codParcela = $codParcela;
        return $this;
    }

    /**
     * Get codParcela
     *
     * @return integer
     */
    public function getCodParcela()
    {
        return $this->codParcela;
    }

    /**
     * Set vencimento
     *
     * @param \DateTime $vencimento
     * @return ParcelaDesconto
     */
    public function setVencimento(\DateTime $vencimento = null)
    {
        $this->vencimento = $vencimento;
        return $this;
    }

    /**
     * Get vencimento
     *
     * @return \DateTime
     */
    public function getVencimento()
    {
        return $this->vencimento;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return ParcelaDesconto
     */
    public function setValor($valor = null)
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
     * OneToOne (owning side)
     * Set ArrecadacaoParcela
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Parcela $fkArrecadacaoParcela
     * @return ParcelaDesconto
     */
    public function setFkArrecadacaoParcela(\Urbem\CoreBundle\Entity\Arrecadacao\Parcela $fkArrecadacaoParcela)
    {
        $this->codParcela = $fkArrecadacaoParcela->getCodParcela();
        $this->fkArrecadacaoParcela = $fkArrecadacaoParcela;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkArrecadacaoParcela
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Parcela
     */
    public function getFkArrecadacaoParcela()
    {
        return $this->fkArrecadacaoParcela;
    }
}
