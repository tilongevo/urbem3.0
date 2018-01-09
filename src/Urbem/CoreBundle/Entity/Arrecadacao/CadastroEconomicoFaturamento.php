<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * CadastroEconomicoFaturamento
 */
class CadastroEconomicoFaturamento
{
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
     * @var string
     */
    private $competencia;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoSemMovimento
     */
    private $fkArrecadacaoFaturamentoSemMovimento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoCalculo
     */
    private $fkArrecadacaoCadastroEconomicoCalculos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoFonte
     */
    private $fkArrecadacaoRetencaoFontes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoCadEconFaturamentoValor
     */
    private $fkArrecadacaoAtributoCadEconFaturamentoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico
     */
    private $fkArrecadacaoFaturamentoServicos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    private $fkEconomicoCadastroEconomico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoCadastroEconomicoCalculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoRetencaoFontes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoAtributoCadEconFaturamentoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoFaturamentoServicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return CadastroEconomicoFaturamento
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
     * @return CadastroEconomicoFaturamento
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
     * Set competencia
     *
     * @param string $competencia
     * @return CadastroEconomicoFaturamento
     */
    public function setCompetencia($competencia)
    {
        $this->competencia = $competencia;
        return $this;
    }

    /**
     * Get competencia
     *
     * @return string
     */
    public function getCompetencia()
    {
        return $this->competencia;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoCadastroEconomicoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoCalculo $fkArrecadacaoCadastroEconomicoCalculo
     * @return CadastroEconomicoFaturamento
     */
    public function addFkArrecadacaoCadastroEconomicoCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoCalculo $fkArrecadacaoCadastroEconomicoCalculo)
    {
        if (false === $this->fkArrecadacaoCadastroEconomicoCalculos->contains($fkArrecadacaoCadastroEconomicoCalculo)) {
            $fkArrecadacaoCadastroEconomicoCalculo->setFkArrecadacaoCadastroEconomicoFaturamento($this);
            $this->fkArrecadacaoCadastroEconomicoCalculos->add($fkArrecadacaoCadastroEconomicoCalculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCadastroEconomicoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoCalculo $fkArrecadacaoCadastroEconomicoCalculo
     */
    public function removeFkArrecadacaoCadastroEconomicoCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoCalculo $fkArrecadacaoCadastroEconomicoCalculo)
    {
        $this->fkArrecadacaoCadastroEconomicoCalculos->removeElement($fkArrecadacaoCadastroEconomicoCalculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCadastroEconomicoCalculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoCalculo
     */
    public function getFkArrecadacaoCadastroEconomicoCalculos()
    {
        return $this->fkArrecadacaoCadastroEconomicoCalculos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoRetencaoFonte
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoFonte $fkArrecadacaoRetencaoFonte
     * @return CadastroEconomicoFaturamento
     */
    public function addFkArrecadacaoRetencaoFontes(\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoFonte $fkArrecadacaoRetencaoFonte)
    {
        if (false === $this->fkArrecadacaoRetencaoFontes->contains($fkArrecadacaoRetencaoFonte)) {
            $fkArrecadacaoRetencaoFonte->setFkArrecadacaoCadastroEconomicoFaturamento($this);
            $this->fkArrecadacaoRetencaoFontes->add($fkArrecadacaoRetencaoFonte);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoRetencaoFonte
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoFonte $fkArrecadacaoRetencaoFonte
     */
    public function removeFkArrecadacaoRetencaoFontes(\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoFonte $fkArrecadacaoRetencaoFonte)
    {
        $this->fkArrecadacaoRetencaoFontes->removeElement($fkArrecadacaoRetencaoFonte);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoRetencaoFontes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoFonte
     */
    public function getFkArrecadacaoRetencaoFontes()
    {
        return $this->fkArrecadacaoRetencaoFontes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoAtributoCadEconFaturamentoValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoCadEconFaturamentoValor $fkArrecadacaoAtributoCadEconFaturamentoValor
     * @return CadastroEconomicoFaturamento
     */
    public function addFkArrecadacaoAtributoCadEconFaturamentoValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoCadEconFaturamentoValor $fkArrecadacaoAtributoCadEconFaturamentoValor)
    {
        if (false === $this->fkArrecadacaoAtributoCadEconFaturamentoValores->contains($fkArrecadacaoAtributoCadEconFaturamentoValor)) {
            $fkArrecadacaoAtributoCadEconFaturamentoValor->setFkArrecadacaoCadastroEconomicoFaturamento($this);
            $this->fkArrecadacaoAtributoCadEconFaturamentoValores->add($fkArrecadacaoAtributoCadEconFaturamentoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAtributoCadEconFaturamentoValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoCadEconFaturamentoValor $fkArrecadacaoAtributoCadEconFaturamentoValor
     */
    public function removeFkArrecadacaoAtributoCadEconFaturamentoValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoCadEconFaturamentoValor $fkArrecadacaoAtributoCadEconFaturamentoValor)
    {
        $this->fkArrecadacaoAtributoCadEconFaturamentoValores->removeElement($fkArrecadacaoAtributoCadEconFaturamentoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAtributoCadEconFaturamentoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoCadEconFaturamentoValor
     */
    public function getFkArrecadacaoAtributoCadEconFaturamentoValores()
    {
        return $this->fkArrecadacaoAtributoCadEconFaturamentoValores;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoFaturamentoServico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico $fkArrecadacaoFaturamentoServico
     * @return CadastroEconomicoFaturamento
     */
    public function addFkArrecadacaoFaturamentoServicos(\Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico $fkArrecadacaoFaturamentoServico)
    {
        if (false === $this->fkArrecadacaoFaturamentoServicos->contains($fkArrecadacaoFaturamentoServico)) {
            $fkArrecadacaoFaturamentoServico->setFkArrecadacaoCadastroEconomicoFaturamento($this);
            $this->fkArrecadacaoFaturamentoServicos->add($fkArrecadacaoFaturamentoServico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoFaturamentoServico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico $fkArrecadacaoFaturamentoServico
     */
    public function removeFkArrecadacaoFaturamentoServicos(\Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico $fkArrecadacaoFaturamentoServico)
    {
        $this->fkArrecadacaoFaturamentoServicos->removeElement($fkArrecadacaoFaturamentoServico);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoFaturamentoServicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico
     */
    public function getFkArrecadacaoFaturamentoServicos()
    {
        return $this->fkArrecadacaoFaturamentoServicos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico
     * @return CadastroEconomicoFaturamento
     */
    public function setFkEconomicoCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoCadastroEconomico->getInscricaoEconomica();
        $this->fkEconomicoCadastroEconomico = $fkEconomicoCadastroEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    public function getFkEconomicoCadastroEconomico()
    {
        return $this->fkEconomicoCadastroEconomico;
    }

    /**
     * OneToOne (inverse side)
     * Set ArrecadacaoFaturamentoSemMovimento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoSemMovimento $fkArrecadacaoFaturamentoSemMovimento
     * @return CadastroEconomicoFaturamento
     */
    public function setFkArrecadacaoFaturamentoSemMovimento(\Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoSemMovimento $fkArrecadacaoFaturamentoSemMovimento)
    {
        $fkArrecadacaoFaturamentoSemMovimento->setFkArrecadacaoCadastroEconomicoFaturamento($this);
        $this->fkArrecadacaoFaturamentoSemMovimento = $fkArrecadacaoFaturamentoSemMovimento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoFaturamentoSemMovimento
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoSemMovimento
     */
    public function getFkArrecadacaoFaturamentoSemMovimento()
    {
        return $this->fkArrecadacaoFaturamentoSemMovimento;
    }
}
