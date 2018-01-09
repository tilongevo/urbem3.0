<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * ModalidadeLancamento
 */
class ModalidadeLancamento
{
    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * @var string
     */
    private $nomModalidade;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento
     */
    private $fkEconomicoAtividadeModalidadeLancamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento
     */
    private $fkEconomicoCadastroEconomicoModalidadeLancamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico
     */
    private $fkArrecadacaoFaturamentoServicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico
     */
    private $fkFiscalizacaoFaturamentoServicos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoAtividadeModalidadeLancamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoCadastroEconomicoModalidadeLancamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoFaturamentoServicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoFaturamentoServicos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ModalidadeLancamento
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set nomModalidade
     *
     * @param string $nomModalidade
     * @return ModalidadeLancamento
     */
    public function setNomModalidade($nomModalidade)
    {
        $this->nomModalidade = $nomModalidade;
        return $this;
    }

    /**
     * Get nomModalidade
     *
     * @return string
     */
    public function getNomModalidade()
    {
        return $this->nomModalidade;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtividadeModalidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento $fkEconomicoAtividadeModalidadeLancamento
     * @return ModalidadeLancamento
     */
    public function addFkEconomicoAtividadeModalidadeLancamentos(\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento $fkEconomicoAtividadeModalidadeLancamento)
    {
        if (false === $this->fkEconomicoAtividadeModalidadeLancamentos->contains($fkEconomicoAtividadeModalidadeLancamento)) {
            $fkEconomicoAtividadeModalidadeLancamento->setFkEconomicoModalidadeLancamento($this);
            $this->fkEconomicoAtividadeModalidadeLancamentos->add($fkEconomicoAtividadeModalidadeLancamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtividadeModalidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento $fkEconomicoAtividadeModalidadeLancamento
     */
    public function removeFkEconomicoAtividadeModalidadeLancamentos(\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento $fkEconomicoAtividadeModalidadeLancamento)
    {
        $this->fkEconomicoAtividadeModalidadeLancamentos->removeElement($fkEconomicoAtividadeModalidadeLancamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtividadeModalidadeLancamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento
     */
    public function getFkEconomicoAtividadeModalidadeLancamentos()
    {
        return $this->fkEconomicoAtividadeModalidadeLancamentos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoCadastroEconomicoModalidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento $fkEconomicoCadastroEconomicoModalidadeLancamento
     * @return ModalidadeLancamento
     */
    public function addFkEconomicoCadastroEconomicoModalidadeLancamentos(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento $fkEconomicoCadastroEconomicoModalidadeLancamento)
    {
        if (false === $this->fkEconomicoCadastroEconomicoModalidadeLancamentos->contains($fkEconomicoCadastroEconomicoModalidadeLancamento)) {
            $fkEconomicoCadastroEconomicoModalidadeLancamento->setFkEconomicoModalidadeLancamento($this);
            $this->fkEconomicoCadastroEconomicoModalidadeLancamentos->add($fkEconomicoCadastroEconomicoModalidadeLancamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoCadastroEconomicoModalidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento $fkEconomicoCadastroEconomicoModalidadeLancamento
     */
    public function removeFkEconomicoCadastroEconomicoModalidadeLancamentos(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento $fkEconomicoCadastroEconomicoModalidadeLancamento)
    {
        $this->fkEconomicoCadastroEconomicoModalidadeLancamentos->removeElement($fkEconomicoCadastroEconomicoModalidadeLancamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoCadastroEconomicoModalidadeLancamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento
     */
    public function getFkEconomicoCadastroEconomicoModalidadeLancamentos()
    {
        return $this->fkEconomicoCadastroEconomicoModalidadeLancamentos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoFaturamentoServico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico $fkArrecadacaoFaturamentoServico
     * @return ModalidadeLancamento
     */
    public function addFkArrecadacaoFaturamentoServicos(\Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico $fkArrecadacaoFaturamentoServico)
    {
        if (false === $this->fkArrecadacaoFaturamentoServicos->contains($fkArrecadacaoFaturamentoServico)) {
            $fkArrecadacaoFaturamentoServico->setFkEconomicoModalidadeLancamento($this);
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
     * OneToMany (owning side)
     * Add FiscalizacaoFaturamentoServico
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico $fkFiscalizacaoFaturamentoServico
     * @return ModalidadeLancamento
     */
    public function addFkFiscalizacaoFaturamentoServicos(\Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico $fkFiscalizacaoFaturamentoServico)
    {
        if (false === $this->fkFiscalizacaoFaturamentoServicos->contains($fkFiscalizacaoFaturamentoServico)) {
            $fkFiscalizacaoFaturamentoServico->setFkEconomicoModalidadeLancamento($this);
            $this->fkFiscalizacaoFaturamentoServicos->add($fkFiscalizacaoFaturamentoServico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoFaturamentoServico
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico $fkFiscalizacaoFaturamentoServico
     */
    public function removeFkFiscalizacaoFaturamentoServicos(\Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico $fkFiscalizacaoFaturamentoServico)
    {
        $this->fkFiscalizacaoFaturamentoServicos->removeElement($fkFiscalizacaoFaturamentoServico);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoFaturamentoServicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico
     */
    public function getFkFiscalizacaoFaturamentoServicos()
    {
        return $this->fkFiscalizacaoFaturamentoServicos;
    }
}
