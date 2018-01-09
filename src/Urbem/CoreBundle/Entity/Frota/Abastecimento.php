<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * Abastecimento
 */
class Abastecimento
{
    /**
     * PK
     * @var integer
     */
    private $ordemAbastecimento;

    /**
     * @var integer
     */
    private $codCombustivel;

    /**
     * @var integer
     */
    private $codVeiculo;

    /**
     * @var integer
     */
    private $codAbastecedora;

    /**
     * @var \DateTime
     */
    private $dtAbastecimento;

    /**
     * @var integer
     */
    private $kmAbastecimento;

    /**
     * @var integer
     */
    private $qtLitros;

    /**
     * @var string
     */
    private $situacaoOrdem;

    /**
     * @var integer
     */
    private $valorLitro;

    /**
     * @var integer
     */
    private $valorTotal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Combustivel
     */
    private $fkFrotaCombustivel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    private $fkFrotaVeiculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;


    /**
     * Set ordemAbastecimento
     *
     * @param integer $ordemAbastecimento
     * @return Abastecimento
     */
    public function setOrdemAbastecimento($ordemAbastecimento)
    {
        $this->ordemAbastecimento = $ordemAbastecimento;
        return $this;
    }

    /**
     * Get ordemAbastecimento
     *
     * @return integer
     */
    public function getOrdemAbastecimento()
    {
        return $this->ordemAbastecimento;
    }

    /**
     * Set codCombustivel
     *
     * @param integer $codCombustivel
     * @return Abastecimento
     */
    public function setCodCombustivel($codCombustivel)
    {
        $this->codCombustivel = $codCombustivel;
        return $this;
    }

    /**
     * Get codCombustivel
     *
     * @return integer
     */
    public function getCodCombustivel()
    {
        return $this->codCombustivel;
    }

    /**
     * Set codVeiculo
     *
     * @param integer $codVeiculo
     * @return Abastecimento
     */
    public function setCodVeiculo($codVeiculo)
    {
        $this->codVeiculo = $codVeiculo;
        return $this;
    }

    /**
     * Get codVeiculo
     *
     * @return integer
     */
    public function getCodVeiculo()
    {
        return $this->codVeiculo;
    }

    /**
     * Set codAbastecedora
     *
     * @param integer $codAbastecedora
     * @return Abastecimento
     */
    public function setCodAbastecedora($codAbastecedora)
    {
        $this->codAbastecedora = $codAbastecedora;
        return $this;
    }

    /**
     * Get codAbastecedora
     *
     * @return integer
     */
    public function getCodAbastecedora()
    {
        return $this->codAbastecedora;
    }

    /**
     * Set dtAbastecimento
     *
     * @param \DateTime $dtAbastecimento
     * @return Abastecimento
     */
    public function setDtAbastecimento(\DateTime $dtAbastecimento)
    {
        $this->dtAbastecimento = $dtAbastecimento;
        return $this;
    }

    /**
     * Get dtAbastecimento
     *
     * @return \DateTime
     */
    public function getDtAbastecimento()
    {
        return $this->dtAbastecimento;
    }

    /**
     * Set kmAbastecimento
     *
     * @param integer $kmAbastecimento
     * @return Abastecimento
     */
    public function setKmAbastecimento($kmAbastecimento)
    {
        $this->kmAbastecimento = $kmAbastecimento;
        return $this;
    }

    /**
     * Get kmAbastecimento
     *
     * @return integer
     */
    public function getKmAbastecimento()
    {
        return $this->kmAbastecimento;
    }

    /**
     * Set qtLitros
     *
     * @param integer $qtLitros
     * @return Abastecimento
     */
    public function setQtLitros($qtLitros)
    {
        $this->qtLitros = $qtLitros;
        return $this;
    }

    /**
     * Get qtLitros
     *
     * @return integer
     */
    public function getQtLitros()
    {
        return $this->qtLitros;
    }

    /**
     * Set situacaoOrdem
     *
     * @param string $situacaoOrdem
     * @return Abastecimento
     */
    public function setSituacaoOrdem($situacaoOrdem)
    {
        $this->situacaoOrdem = $situacaoOrdem;
        return $this;
    }

    /**
     * Get situacaoOrdem
     *
     * @return string
     */
    public function getSituacaoOrdem()
    {
        return $this->situacaoOrdem;
    }

    /**
     * Set valorLitro
     *
     * @param integer $valorLitro
     * @return Abastecimento
     */
    public function setValorLitro($valorLitro)
    {
        $this->valorLitro = $valorLitro;
        return $this;
    }

    /**
     * Get valorLitro
     *
     * @return integer
     */
    public function getValorLitro()
    {
        return $this->valorLitro;
    }

    /**
     * Set valorTotal
     *
     * @param integer $valorTotal
     * @return Abastecimento
     */
    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;
        return $this;
    }

    /**
     * Get valorTotal
     *
     * @return integer
     */
    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaCombustivel
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Combustivel $fkFrotaCombustivel
     * @return Abastecimento
     */
    public function setFkFrotaCombustivel(\Urbem\CoreBundle\Entity\Frota\Combustivel $fkFrotaCombustivel)
    {
        $this->codCombustivel = $fkFrotaCombustivel->getCodCombustivel();
        $this->fkFrotaCombustivel = $fkFrotaCombustivel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaCombustivel
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Combustivel
     */
    public function getFkFrotaCombustivel()
    {
        return $this->fkFrotaCombustivel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     * @return Abastecimento
     */
    public function setFkFrotaVeiculo(\Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo)
    {
        $this->codVeiculo = $fkFrotaVeiculo->getCodVeiculo();
        $this->fkFrotaVeiculo = $fkFrotaVeiculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaVeiculo
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    public function getFkFrotaVeiculo()
    {
        return $this->fkFrotaVeiculo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Abastecimento
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->codAbastecedora = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }
}
