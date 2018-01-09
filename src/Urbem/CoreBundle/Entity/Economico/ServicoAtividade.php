<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * ServicoAtividade
 */
class ServicoAtividade
{
    /**
     * PK
     * @var integer
     */
    private $codServico;

    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * @var boolean
     */
    private $ativo = true;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Servico
     */
    private $fkEconomicoServico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Atividade
     */
    private $fkEconomicoAtividade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoFaturamentoServicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoFaturamentoServicos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codServico
     *
     * @param integer $codServico
     * @return ServicoAtividade
     */
    public function setCodServico($codServico)
    {
        $this->codServico = $codServico;
        return $this;
    }

    /**
     * Get codServico
     *
     * @return integer
     */
    public function getCodServico()
    {
        return $this->codServico;
    }

    /**
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return ServicoAtividade
     */
    public function setCodAtividade($codAtividade)
    {
        $this->codAtividade = $codAtividade;
        return $this;
    }

    /**
     * Get codAtividade
     *
     * @return integer
     */
    public function getCodAtividade()
    {
        return $this->codAtividade;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return ServicoAtividade
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoFaturamentoServico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico $fkArrecadacaoFaturamentoServico
     * @return ServicoAtividade
     */
    public function addFkArrecadacaoFaturamentoServicos(\Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico $fkArrecadacaoFaturamentoServico)
    {
        if (false === $this->fkArrecadacaoFaturamentoServicos->contains($fkArrecadacaoFaturamentoServico)) {
            $fkArrecadacaoFaturamentoServico->setFkEconomicoServicoAtividade($this);
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
     * @return ServicoAtividade
     */
    public function addFkFiscalizacaoFaturamentoServicos(\Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico $fkFiscalizacaoFaturamentoServico)
    {
        if (false === $this->fkFiscalizacaoFaturamentoServicos->contains($fkFiscalizacaoFaturamentoServico)) {
            $fkFiscalizacaoFaturamentoServico->setFkEconomicoServicoAtividade($this);
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

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoServico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Servico $fkEconomicoServico
     * @return ServicoAtividade
     */
    public function setFkEconomicoServico(\Urbem\CoreBundle\Entity\Economico\Servico $fkEconomicoServico)
    {
        $this->codServico = $fkEconomicoServico->getCodServico();
        $this->fkEconomicoServico = $fkEconomicoServico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoServico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Servico
     */
    public function getFkEconomicoServico()
    {
        return $this->fkEconomicoServico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade
     * @return ServicoAtividade
     */
    public function setFkEconomicoAtividade(\Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade)
    {
        $this->codAtividade = $fkEconomicoAtividade->getCodAtividade();
        $this->fkEconomicoAtividade = $fkEconomicoAtividade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoAtividade
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Atividade
     */
    public function getFkEconomicoAtividade()
    {
        return $this->fkEconomicoAtividade;
    }
}
