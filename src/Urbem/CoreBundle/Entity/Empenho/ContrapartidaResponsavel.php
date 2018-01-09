<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * ContrapartidaResponsavel
 */
class ContrapartidaResponsavel
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
    private $contaContrapartida;

    /**
     * @var integer
     */
    private $prazo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ContrapartidaAutorizacao
     */
    private $fkEmpenhoContrapartidaAutorizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas
     */
    private $fkEmpenhoItemPrestacaoContas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ContrapartidaEmpenho
     */
    private $fkEmpenhoContrapartidaEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento
     */
    private $fkEmpenhoResponsavelAdiantamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEmpenhoContrapartidaAutorizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoItemPrestacaoContas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoContrapartidaEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoResponsavelAdiantamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContrapartidaResponsavel
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
     * Set contaContrapartida
     *
     * @param integer $contaContrapartida
     * @return ContrapartidaResponsavel
     */
    public function setContaContrapartida($contaContrapartida)
    {
        $this->contaContrapartida = $contaContrapartida;
        return $this;
    }

    /**
     * Get contaContrapartida
     *
     * @return integer
     */
    public function getContaContrapartida()
    {
        return $this->contaContrapartida;
    }

    /**
     * Set prazo
     *
     * @param integer $prazo
     * @return ContrapartidaResponsavel
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
     * OneToMany (owning side)
     * Add EmpenhoContrapartidaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ContrapartidaAutorizacao $fkEmpenhoContrapartidaAutorizacao
     * @return ContrapartidaResponsavel
     */
    public function addFkEmpenhoContrapartidaAutorizacoes(\Urbem\CoreBundle\Entity\Empenho\ContrapartidaAutorizacao $fkEmpenhoContrapartidaAutorizacao)
    {
        if (false === $this->fkEmpenhoContrapartidaAutorizacoes->contains($fkEmpenhoContrapartidaAutorizacao)) {
            $fkEmpenhoContrapartidaAutorizacao->setFkEmpenhoContrapartidaResponsavel($this);
            $this->fkEmpenhoContrapartidaAutorizacoes->add($fkEmpenhoContrapartidaAutorizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoContrapartidaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ContrapartidaAutorizacao $fkEmpenhoContrapartidaAutorizacao
     */
    public function removeFkEmpenhoContrapartidaAutorizacoes(\Urbem\CoreBundle\Entity\Empenho\ContrapartidaAutorizacao $fkEmpenhoContrapartidaAutorizacao)
    {
        $this->fkEmpenhoContrapartidaAutorizacoes->removeElement($fkEmpenhoContrapartidaAutorizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoContrapartidaAutorizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ContrapartidaAutorizacao
     */
    public function getFkEmpenhoContrapartidaAutorizacoes()
    {
        return $this->fkEmpenhoContrapartidaAutorizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoItemPrestacaoContas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas $fkEmpenhoItemPrestacaoContas
     * @return ContrapartidaResponsavel
     */
    public function addFkEmpenhoItemPrestacaoContas(\Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas $fkEmpenhoItemPrestacaoContas)
    {
        if (false === $this->fkEmpenhoItemPrestacaoContas->contains($fkEmpenhoItemPrestacaoContas)) {
            $fkEmpenhoItemPrestacaoContas->setFkEmpenhoContrapartidaResponsavel($this);
            $this->fkEmpenhoItemPrestacaoContas->add($fkEmpenhoItemPrestacaoContas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoItemPrestacaoContas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas $fkEmpenhoItemPrestacaoContas
     */
    public function removeFkEmpenhoItemPrestacaoContas(\Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas $fkEmpenhoItemPrestacaoContas)
    {
        $this->fkEmpenhoItemPrestacaoContas->removeElement($fkEmpenhoItemPrestacaoContas);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoItemPrestacaoContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas
     */
    public function getFkEmpenhoItemPrestacaoContas()
    {
        return $this->fkEmpenhoItemPrestacaoContas;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoContrapartidaEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ContrapartidaEmpenho $fkEmpenhoContrapartidaEmpenho
     * @return ContrapartidaResponsavel
     */
    public function addFkEmpenhoContrapartidaEmpenhos(\Urbem\CoreBundle\Entity\Empenho\ContrapartidaEmpenho $fkEmpenhoContrapartidaEmpenho)
    {
        if (false === $this->fkEmpenhoContrapartidaEmpenhos->contains($fkEmpenhoContrapartidaEmpenho)) {
            $fkEmpenhoContrapartidaEmpenho->setFkEmpenhoContrapartidaResponsavel($this);
            $this->fkEmpenhoContrapartidaEmpenhos->add($fkEmpenhoContrapartidaEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoContrapartidaEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ContrapartidaEmpenho $fkEmpenhoContrapartidaEmpenho
     */
    public function removeFkEmpenhoContrapartidaEmpenhos(\Urbem\CoreBundle\Entity\Empenho\ContrapartidaEmpenho $fkEmpenhoContrapartidaEmpenho)
    {
        $this->fkEmpenhoContrapartidaEmpenhos->removeElement($fkEmpenhoContrapartidaEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoContrapartidaEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ContrapartidaEmpenho
     */
    public function getFkEmpenhoContrapartidaEmpenhos()
    {
        return $this->fkEmpenhoContrapartidaEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoResponsavelAdiantamento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento $fkEmpenhoResponsavelAdiantamento
     * @return ContrapartidaResponsavel
     */
    public function addFkEmpenhoResponsavelAdiantamentos(\Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento $fkEmpenhoResponsavelAdiantamento)
    {
        if (false === $this->fkEmpenhoResponsavelAdiantamentos->contains($fkEmpenhoResponsavelAdiantamento)) {
            $fkEmpenhoResponsavelAdiantamento->setFkEmpenhoContrapartidaResponsavel($this);
            $this->fkEmpenhoResponsavelAdiantamentos->add($fkEmpenhoResponsavelAdiantamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoResponsavelAdiantamento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento $fkEmpenhoResponsavelAdiantamento
     */
    public function removeFkEmpenhoResponsavelAdiantamentos(\Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento $fkEmpenhoResponsavelAdiantamento)
    {
        $this->fkEmpenhoResponsavelAdiantamentos->removeElement($fkEmpenhoResponsavelAdiantamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoResponsavelAdiantamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ResponsavelAdiantamento
     */
    public function getFkEmpenhoResponsavelAdiantamentos()
    {
        return $this->fkEmpenhoResponsavelAdiantamentos;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return ContrapartidaResponsavel
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->contaContrapartida = $fkContabilidadePlanoAnalitica->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica->getExercicio();
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->contaContrapartida, $this->exercicio);
    }
}
