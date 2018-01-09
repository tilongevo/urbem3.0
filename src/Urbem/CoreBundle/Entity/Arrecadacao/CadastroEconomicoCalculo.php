<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * CadastroEconomicoCalculo
 */
class CadastroEconomicoCalculo
{
    /**
     * PK
     * @var integer
     */
    private $codCalculo;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    private $fkArrecadacaoCalculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento
     */
    private $fkArrecadacaoCadastroEconomicoFaturamento;


    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codCalculo
     *
     * @param integer $codCalculo
     * @return CadastroEconomicoCalculo
     */
    public function setCodCalculo($codCalculo)
    {
        $this->codCalculo = $codCalculo;
        return $this;
    }

    /**
     * Get codCalculo
     *
     * @return integer
     */
    public function getCodCalculo()
    {
        return $this->codCalculo;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return CadastroEconomicoCalculo
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
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return CadastroEconomicoCalculo
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoCadastroEconomicoFaturamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento $fkArrecadacaoCadastroEconomicoFaturamento
     * @return CadastroEconomicoCalculo
     */
    public function setFkArrecadacaoCadastroEconomicoFaturamento(\Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento $fkArrecadacaoCadastroEconomicoFaturamento)
    {
        $this->inscricaoEconomica = $fkArrecadacaoCadastroEconomicoFaturamento->getInscricaoEconomica();
        $this->timestamp = $fkArrecadacaoCadastroEconomicoFaturamento->getTimestamp();
        $this->fkArrecadacaoCadastroEconomicoFaturamento = $fkArrecadacaoCadastroEconomicoFaturamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoCadastroEconomicoFaturamento
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento
     */
    public function getFkArrecadacaoCadastroEconomicoFaturamento()
    {
        return $this->fkArrecadacaoCadastroEconomicoFaturamento;
    }

    /**
     * OneToOne (owning side)
     * Set ArrecadacaoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo
     * @return CadastroEconomicoCalculo
     */
    public function setFkArrecadacaoCalculo(\Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo)
    {
        $this->codCalculo = $fkArrecadacaoCalculo->getCodCalculo();
        $this->fkArrecadacaoCalculo = $fkArrecadacaoCalculo;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkArrecadacaoCalculo
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    public function getFkArrecadacaoCalculo()
    {
        return $this->fkArrecadacaoCalculo;
    }
}
