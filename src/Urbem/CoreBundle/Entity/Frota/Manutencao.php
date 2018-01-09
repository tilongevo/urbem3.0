<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * Manutencao
 */
class Manutencao
{
    const TIPOMANUTENCAOAUTORIZACAO = 1;
    const TIPOMANUTENCAOOUTROS = 2;

    /**
     * PK
     * @var integer
     */
    private $codManutencao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codVeiculo;

    /**
     * @var integer
     */
    private $km;

    /**
     * @var \DateTime
     */
    private $dtManutencao;

    /**
     * @var string
     */
    private $observacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Frota\ManutencaoAnulacao
     */
    private $fkFrotaManutencaoAnulacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Frota\ManutencaoEmpenho
     */
    private $fkFrotaManutencaoEmpenho;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoManutencaoFrota
     */
    private $fkAlmoxarifadoLancamentoManutencaoFrotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Efetivacao
     */
    private $fkFrotaEfetivacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\ManutencaoItem
     */
    private $fkFrotaManutencaoItens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    private $fkFrotaVeiculo;
    
    private $codManutencaoExercicio;

    /**
     * Propriedade criada para aplicar a regra de negócio dessa amarração
     * @var \Urbem\CoreBundle\Entity\Frota\Efetivacao $efetivacao
     */
    private $efetivacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoLancamentoManutencaoFrotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaEfetivacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaManutencaoItens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codManutencao
     *
     * @param integer $codManutencao
     * @return Manutencao
     */
    public function setCodManutencao($codManutencao)
    {
        $this->codManutencao = $codManutencao;
        return $this;
    }

    /**
     * Get codManutencao
     *
     * @return integer
     */
    public function getCodManutencao()
    {
        return $this->codManutencao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Manutencao
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
     * Set codVeiculo
     *
     * @param integer $codVeiculo
     * @return Manutencao
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
     * Set km
     *
     * @param integer $km
     * @return Manutencao
     */
    public function setKm($km)
    {
        $this->km = $km;
        return $this;
    }

    /**
     * Get km
     *
     * @return integer
     */
    public function getKm()
    {
        return $this->km;
    }

    /**
     * Set dtManutencao
     *
     * @param \DateTime $dtManutencao
     * @return Manutencao
     */
    public function setDtManutencao(\DateTime $dtManutencao)
    {
        $this->dtManutencao = $dtManutencao;
        return $this;
    }

    /**
     * Get dtManutencao
     *
     * @return \DateTime
     */
    public function getDtManutencao()
    {
        return $this->dtManutencao;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return Manutencao
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoLancamentoManutencaoFrota
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoManutencaoFrota $fkAlmoxarifadoLancamentoManutencaoFrota
     * @return Manutencao
     */
    public function addFkAlmoxarifadoLancamentoManutencaoFrotas(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoManutencaoFrota $fkAlmoxarifadoLancamentoManutencaoFrota)
    {
        if (false === $this->fkAlmoxarifadoLancamentoManutencaoFrotas->contains($fkAlmoxarifadoLancamentoManutencaoFrota)) {
            $fkAlmoxarifadoLancamentoManutencaoFrota->setFkFrotaManutencao($this);
            $this->fkAlmoxarifadoLancamentoManutencaoFrotas->add($fkAlmoxarifadoLancamentoManutencaoFrota);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoLancamentoManutencaoFrota
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoManutencaoFrota $fkAlmoxarifadoLancamentoManutencaoFrota
     */
    public function removeFkAlmoxarifadoLancamentoManutencaoFrotas(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoManutencaoFrota $fkAlmoxarifadoLancamentoManutencaoFrota)
    {
        $this->fkAlmoxarifadoLancamentoManutencaoFrotas->removeElement($fkAlmoxarifadoLancamentoManutencaoFrota);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoLancamentoManutencaoFrotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoManutencaoFrota
     */
    public function getFkAlmoxarifadoLancamentoManutencaoFrotas()
    {
        return $this->fkAlmoxarifadoLancamentoManutencaoFrotas;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaEfetivacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Efetivacao $fkFrotaEfetivacao
     * @return Manutencao
     */
    public function addFkFrotaEfetivacoes(\Urbem\CoreBundle\Entity\Frota\Efetivacao $fkFrotaEfetivacao)
    {
        if (false === $this->fkFrotaEfetivacoes->contains($fkFrotaEfetivacao)) {
            $fkFrotaEfetivacao->setFkFrotaManutencao($this);
            $this->fkFrotaEfetivacoes->add($fkFrotaEfetivacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaEfetivacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Efetivacao $fkFrotaEfetivacao
     */
    public function removeFkFrotaEfetivacoes(\Urbem\CoreBundle\Entity\Frota\Efetivacao $fkFrotaEfetivacao)
    {
        $this->fkFrotaEfetivacoes->removeElement($fkFrotaEfetivacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaEfetivacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Efetivacao
     */
    public function getFkFrotaEfetivacoes()
    {
        return $this->fkFrotaEfetivacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaManutencaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Frota\ManutencaoItem $fkFrotaManutencaoItem
     * @return Manutencao
     */
    public function addFkFrotaManutencaoItens(\Urbem\CoreBundle\Entity\Frota\ManutencaoItem $fkFrotaManutencaoItem)
    {
        if (false === $this->fkFrotaManutencaoItens->contains($fkFrotaManutencaoItem)) {
            $fkFrotaManutencaoItem->setFkFrotaManutencao($this);
            $this->fkFrotaManutencaoItens->add($fkFrotaManutencaoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaManutencaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Frota\ManutencaoItem $fkFrotaManutencaoItem
     */
    public function removeFkFrotaManutencaoItens(\Urbem\CoreBundle\Entity\Frota\ManutencaoItem $fkFrotaManutencaoItem)
    {
        $this->fkFrotaManutencaoItens->removeElement($fkFrotaManutencaoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaManutencaoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\ManutencaoItem
     */
    public function getFkFrotaManutencaoItens()
    {
        return $this->fkFrotaManutencaoItens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     * @return Manutencao
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
     * OneToOne (inverse side)
     * Set FrotaManutencaoAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\ManutencaoAnulacao $fkFrotaManutencaoAnulacao
     * @return Manutencao
     */
    public function setFkFrotaManutencaoAnulacao(\Urbem\CoreBundle\Entity\Frota\ManutencaoAnulacao $fkFrotaManutencaoAnulacao)
    {
        $fkFrotaManutencaoAnulacao->setFkFrotaManutencao($this);
        $this->fkFrotaManutencaoAnulacao = $fkFrotaManutencaoAnulacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFrotaManutencaoAnulacao
     *
     * @return \Urbem\CoreBundle\Entity\Frota\ManutencaoAnulacao
     */
    public function getFkFrotaManutencaoAnulacao()
    {
        return $this->fkFrotaManutencaoAnulacao;
    }

    /**
     * OneToOne (inverse side)
     * Set FrotaManutencaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Frota\ManutencaoEmpenho $fkFrotaManutencaoEmpenho
     * @return Manutencao
     */
    public function setFkFrotaManutencaoEmpenho(\Urbem\CoreBundle\Entity\Frota\ManutencaoEmpenho $fkFrotaManutencaoEmpenho)
    {
        $fkFrotaManutencaoEmpenho->setFkFrotaManutencao($this);
        $this->fkFrotaManutencaoEmpenho = $fkFrotaManutencaoEmpenho;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFrotaManutencaoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Frota\ManutencaoEmpenho
     */
    public function getFkFrotaManutencaoEmpenho()
    {
        return $this->fkFrotaManutencaoEmpenho;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getCodManutencaoExercicio();
    }

    /**
     * Gets the codManutencaoExercicio.
     *
     * @return string
     */
    public function getCodManutencaoExercicio()
    {
        if ($this->codManutencao && $this->exercicio) {
            return sprintf(
                '%s/%s',
                $this->codManutencao,
                $this->exercicio
            );
        } else {
            return 'Manutenção';
        }
    }

    /**
     * @return \Urbem\CoreBundle\Entity\Frota\Efetivacao
     */
    public function getEfetivacao()
    {
        return $this->fkFrotaEfetivacoes->last();
    }

    /**
     * @return bool
     */
    public function isTipoManutencaoAutorizacao()
    {
        return (bool) $this->getEfetivacao();
    }
}
