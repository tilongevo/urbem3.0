<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * RetencaoFonte
 */
class RetencaoFonte
{
    /**
     * PK
     * @var integer
     */
    private $codRetencao;

    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $valorRetencao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota
     */
    private $fkArrecadacaoRetencaoNotas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento
     */
    private $fkArrecadacaoCadastroEconomicoFaturamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoRetencaoNotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codRetencao
     *
     * @param integer $codRetencao
     * @return RetencaoFonte
     */
    public function setCodRetencao($codRetencao)
    {
        $this->codRetencao = $codRetencao;
        return $this;
    }

    /**
     * Get codRetencao
     *
     * @return integer
     */
    public function getCodRetencao()
    {
        return $this->codRetencao;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return RetencaoFonte
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return RetencaoFonte
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
     * Set valorRetencao
     *
     * @param integer $valorRetencao
     * @return RetencaoFonte
     */
    public function setValorRetencao($valorRetencao)
    {
        $this->valorRetencao = $valorRetencao;
        return $this;
    }

    /**
     * Get valorRetencao
     *
     * @return integer
     */
    public function getValorRetencao()
    {
        return $this->valorRetencao;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoRetencaoNota
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota $fkArrecadacaoRetencaoNota
     * @return RetencaoFonte
     */
    public function addFkArrecadacaoRetencaoNotas(\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota $fkArrecadacaoRetencaoNota)
    {
        if (false === $this->fkArrecadacaoRetencaoNotas->contains($fkArrecadacaoRetencaoNota)) {
            $fkArrecadacaoRetencaoNota->setFkArrecadacaoRetencaoFonte($this);
            $this->fkArrecadacaoRetencaoNotas->add($fkArrecadacaoRetencaoNota);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoRetencaoNota
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota $fkArrecadacaoRetencaoNota
     */
    public function removeFkArrecadacaoRetencaoNotas(\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota $fkArrecadacaoRetencaoNota)
    {
        $this->fkArrecadacaoRetencaoNotas->removeElement($fkArrecadacaoRetencaoNota);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoRetencaoNotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota
     */
    public function getFkArrecadacaoRetencaoNotas()
    {
        return $this->fkArrecadacaoRetencaoNotas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoCadastroEconomicoFaturamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento $fkArrecadacaoCadastroEconomicoFaturamento
     * @return RetencaoFonte
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
}
