<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * AutorizacaoEmpenho
 */
class AutorizacaoEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $codAutorizacao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $numUnidade;

    /**
     * @var integer
     */
    private $numOrgao;

    /**
     * @var integer
     */
    private $codPreEmpenho;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $dtAutorizacao;

    /**
     * @var \Urbem\CoreBundle\Helper\TimeMicrosecondPK
     */
    private $hora;

    /**
     * @var integer
     */
    private $codCategoria = 1;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\ContrapartidaAutorizacao
     */
    private $fkEmpenhoContrapartidaAutorizacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\AutorizacaoReserva
     */
    private $fkEmpenhoAutorizacaoReserva;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\AutorizacaoAnulada
     */
    private $fkEmpenhoAutorizacaoAnulada;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Diarias\DiariaEmpenho
     */
    private $fkDiariasDiariaEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenhoAssinatura
     */
    private $fkEmpenhoAutorizacaoEmpenhoAssinaturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoAutorizacao
     */
    private $fkEmpenhoEmpenhoAutorizacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    private $fkEmpenhoPreEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\CategoriaEmpenho
     */
    private $fkEmpenhoCategoriaEmpenho;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkDiariasDiariaEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoAutorizacaoEmpenhoAssinaturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoEmpenhoAutorizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->hora = new \Urbem\CoreBundle\Helper\TimeMicrosecondPK;
    }

    /**
     * Set codAutorizacao
     *
     * @param integer $codAutorizacao
     * @return AutorizacaoEmpenho
     */
    public function setCodAutorizacao($codAutorizacao)
    {
        $this->codAutorizacao = $codAutorizacao;
        return $this;
    }

    /**
     * Get codAutorizacao
     *
     * @return integer
     */
    public function getCodAutorizacao()
    {
        return $this->codAutorizacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return AutorizacaoEmpenho
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return AutorizacaoEmpenho
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return AutorizacaoEmpenho
     */
    public function setNumUnidade($numUnidade)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }

    /**
     * Get numUnidade
     *
     * @return integer
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return AutorizacaoEmpenho
     */
    public function setNumOrgao($numOrgao)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return AutorizacaoEmpenho
     */
    public function setCodPreEmpenho($codPreEmpenho)
    {
        $this->codPreEmpenho = $codPreEmpenho;
        return $this;
    }

    /**
     * Get codPreEmpenho
     *
     * @return integer
     */
    public function getCodPreEmpenho()
    {
        return $this->codPreEmpenho;
    }

    /**
     * Set dtAutorizacao
     *
     * @param DateTimeMicrosecondPK $dtAutorizacao
     * @return AutorizacaoEmpenho
     */
    public function setDtAutorizacao(DateTimeMicrosecondPK $dtAutorizacao)
    {
        $this->dtAutorizacao = $dtAutorizacao;
        return $this;
    }

    /**
     * Get dtAutorizacao
     *
     * @return DateTimeMicrosecondPK
     */
    public function getDtAutorizacao()
    {
        return $this->dtAutorizacao;
    }

    /**
     * Set hora
     *
     * @param \Urbem\CoreBundle\Helper\TimeMicrosecondPK $hora
     * @return AutorizacaoEmpenho
     */
    public function setHora(\Urbem\CoreBundle\Helper\TimeMicrosecondPK $hora)
    {
        $this->hora = $hora;
        return $this;
    }

    /**
     * Get hora
     *
     * @return \Urbem\CoreBundle\Helper\TimeMicrosecondPK
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set codCategoria
     *
     * @param integer $codCategoria
     * @return AutorizacaoEmpenho
     */
    public function setCodCategoria($codCategoria)
    {
        $this->codCategoria = $codCategoria;
        return $this;
    }

    /**
     * Get codCategoria
     *
     * @return integer
     */
    public function getCodCategoria()
    {
        return $this->codCategoria;
    }

    /**
     * OneToMany (owning side)
     * Add DiariasDiariaEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\DiariaEmpenho $fkDiariasDiariaEmpenho
     * @return AutorizacaoEmpenho
     */
    public function addFkDiariasDiariaEmpenhos(\Urbem\CoreBundle\Entity\Diarias\DiariaEmpenho $fkDiariasDiariaEmpenho)
    {
        if (false === $this->fkDiariasDiariaEmpenhos->contains($fkDiariasDiariaEmpenho)) {
            $fkDiariasDiariaEmpenho->setFkEmpenhoAutorizacaoEmpenho($this);
            $this->fkDiariasDiariaEmpenhos->add($fkDiariasDiariaEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DiariasDiariaEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\DiariaEmpenho $fkDiariasDiariaEmpenho
     */
    public function removeFkDiariasDiariaEmpenhos(\Urbem\CoreBundle\Entity\Diarias\DiariaEmpenho $fkDiariasDiariaEmpenho)
    {
        $this->fkDiariasDiariaEmpenhos->removeElement($fkDiariasDiariaEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkDiariasDiariaEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Diarias\DiariaEmpenho
     */
    public function getFkDiariasDiariaEmpenhos()
    {
        return $this->fkDiariasDiariaEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoAutorizacaoEmpenhoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenhoAssinatura $fkEmpenhoAutorizacaoEmpenhoAssinatura
     * @return AutorizacaoEmpenho
     */
    public function addFkEmpenhoAutorizacaoEmpenhoAssinaturas(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenhoAssinatura $fkEmpenhoAutorizacaoEmpenhoAssinatura)
    {
        if (false === $this->fkEmpenhoAutorizacaoEmpenhoAssinaturas->contains($fkEmpenhoAutorizacaoEmpenhoAssinatura)) {
            $fkEmpenhoAutorizacaoEmpenhoAssinatura->setFkEmpenhoAutorizacaoEmpenho($this);
            $this->fkEmpenhoAutorizacaoEmpenhoAssinaturas->add($fkEmpenhoAutorizacaoEmpenhoAssinatura);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoAutorizacaoEmpenhoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenhoAssinatura $fkEmpenhoAutorizacaoEmpenhoAssinatura
     */
    public function removeFkEmpenhoAutorizacaoEmpenhoAssinaturas(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenhoAssinatura $fkEmpenhoAutorizacaoEmpenhoAssinatura)
    {
        $this->fkEmpenhoAutorizacaoEmpenhoAssinaturas->removeElement($fkEmpenhoAutorizacaoEmpenhoAssinatura);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoAutorizacaoEmpenhoAssinaturas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenhoAssinatura
     */
    public function getFkEmpenhoAutorizacaoEmpenhoAssinaturas()
    {
        return $this->fkEmpenhoAutorizacaoEmpenhoAssinaturas;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoEmpenhoAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoAutorizacao $fkEmpenhoEmpenhoAutorizacao
     * @return AutorizacaoEmpenho
     */
    public function addFkEmpenhoEmpenhoAutorizacoes(\Urbem\CoreBundle\Entity\Empenho\EmpenhoAutorizacao $fkEmpenhoEmpenhoAutorizacao)
    {
        if (false === $this->fkEmpenhoEmpenhoAutorizacoes->contains($fkEmpenhoEmpenhoAutorizacao)) {
            $fkEmpenhoEmpenhoAutorizacao->setFkEmpenhoAutorizacaoEmpenho($this);
            $this->fkEmpenhoEmpenhoAutorizacoes->add($fkEmpenhoEmpenhoAutorizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoEmpenhoAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoAutorizacao $fkEmpenhoEmpenhoAutorizacao
     */
    public function removeFkEmpenhoEmpenhoAutorizacoes(\Urbem\CoreBundle\Entity\Empenho\EmpenhoAutorizacao $fkEmpenhoEmpenhoAutorizacao)
    {
        $this->fkEmpenhoEmpenhoAutorizacoes->removeElement($fkEmpenhoEmpenhoAutorizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoEmpenhoAutorizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoAutorizacao
     */
    public function getFkEmpenhoEmpenhoAutorizacoes()
    {
        return $this->fkEmpenhoEmpenhoAutorizacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return AutorizacaoEmpenho
     */
    public function setFkOrcamentoUnidade(\Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade)
    {
        $this->exercicio = $fkOrcamentoUnidade->getExercicio();
        $this->numUnidade = $fkOrcamentoUnidade->getNumUnidade();
        $this->numOrgao = $fkOrcamentoUnidade->getNumOrgao();
        $this->fkOrcamentoUnidade = $fkOrcamentoUnidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoUnidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    public function getFkOrcamentoUnidade()
    {
        return $this->fkOrcamentoUnidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho
     * @return AutorizacaoEmpenho
     */
    public function setFkEmpenhoPreEmpenho(\Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho)
    {
        $this->exercicio = $fkEmpenhoPreEmpenho->getExercicio();
        $this->codPreEmpenho = $fkEmpenhoPreEmpenho->getCodPreEmpenho();
        $this->fkEmpenhoPreEmpenho = $fkEmpenhoPreEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoPreEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    public function getFkEmpenhoPreEmpenho()
    {
        return $this->fkEmpenhoPreEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return AutorizacaoEmpenho
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoCategoriaEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\CategoriaEmpenho $fkEmpenhoCategoriaEmpenho
     * @return AutorizacaoEmpenho
     */
    public function setFkEmpenhoCategoriaEmpenho(\Urbem\CoreBundle\Entity\Empenho\CategoriaEmpenho $fkEmpenhoCategoriaEmpenho)
    {
        $this->codCategoria = $fkEmpenhoCategoriaEmpenho->getCodCategoria();
        $this->fkEmpenhoCategoriaEmpenho = $fkEmpenhoCategoriaEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoCategoriaEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\CategoriaEmpenho
     */
    public function getFkEmpenhoCategoriaEmpenho()
    {
        return $this->fkEmpenhoCategoriaEmpenho;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoContrapartidaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ContrapartidaAutorizacao $fkEmpenhoContrapartidaAutorizacao
     * @return AutorizacaoEmpenho
     */
    public function setFkEmpenhoContrapartidaAutorizacao(\Urbem\CoreBundle\Entity\Empenho\ContrapartidaAutorizacao $fkEmpenhoContrapartidaAutorizacao)
    {
        $fkEmpenhoContrapartidaAutorizacao->setFkEmpenhoAutorizacaoEmpenho($this);
        $this->fkEmpenhoContrapartidaAutorizacao = $fkEmpenhoContrapartidaAutorizacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoContrapartidaAutorizacao
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\ContrapartidaAutorizacao
     */
    public function getFkEmpenhoContrapartidaAutorizacao()
    {
        return $this->fkEmpenhoContrapartidaAutorizacao;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoAutorizacaoReserva
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoReserva $fkEmpenhoAutorizacaoReserva
     * @return AutorizacaoEmpenho
     */
    public function setFkEmpenhoAutorizacaoReserva(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoReserva $fkEmpenhoAutorizacaoReserva)
    {
        $fkEmpenhoAutorizacaoReserva->setFkEmpenhoAutorizacaoEmpenho($this);
        $this->fkEmpenhoAutorizacaoReserva = $fkEmpenhoAutorizacaoReserva;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoAutorizacaoReserva
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\AutorizacaoReserva
     */
    public function getFkEmpenhoAutorizacaoReserva()
    {
        return $this->fkEmpenhoAutorizacaoReserva;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoAutorizacaoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoAnulada $fkEmpenhoAutorizacaoAnulada
     * @return AutorizacaoEmpenho
     */
    public function setFkEmpenhoAutorizacaoAnulada(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoAnulada $fkEmpenhoAutorizacaoAnulada)
    {
        $fkEmpenhoAutorizacaoAnulada->setFkEmpenhoAutorizacaoEmpenho($this);
        $this->fkEmpenhoAutorizacaoAnulada = $fkEmpenhoAutorizacaoAnulada;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoAutorizacaoAnulada
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\AutorizacaoAnulada
     */
    public function getFkEmpenhoAutorizacaoAnulada()
    {
        return $this->fkEmpenhoAutorizacaoAnulada;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->getFkEmpenhoPreEmpenho()->getDescricao();
    }

    /**
     * @return string
     */
    public function getCodAutorizacaoAndExercicio()
    {
        return sprintf('%s/%s', $this->getCodAutorizacao(), $this->getExercicio());
    }

    /**
     * @return string
     */
    public function getNomEntidade()
    {
        return $this->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getFkEmpenhoPreEmpenho()->getDescricao();
    }
}
