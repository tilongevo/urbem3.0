<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoEmpenho
 */
class ConfiguracaoEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $exercicioPao;

    /**
     * @var string
     */
    private $exercicioDespesa;

    /**
     * @var integer
     */
    private $codDespesa;

    /**
     * @var integer
     */
    private $numPao;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoContaDespesa
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoContaDespesa;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributo
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoAtributos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoEvento
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLotacao
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoLotacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSituacao
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoSituacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLocal
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSubdivisao
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoSubdivisoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Pao
     */
    private $fkOrcamentoPao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEvento
     */
    private $fkFolhapagamentoConfiguracaoEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    private $fkOrcamentoDespesa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoAtributos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoLotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoSituacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoSubdivisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoEmpenho
     */
    public function setCodConfiguracao($codConfiguracao)
    {
        $this->codConfiguracao = $codConfiguracao;
        return $this;
    }

    /**
     * Get codConfiguracao
     *
     * @return integer
     */
    public function getCodConfiguracao()
    {
        return $this->codConfiguracao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoEmpenho
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return ConfiguracaoEmpenho
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoEmpenho
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
     * Set exercicioPao
     *
     * @param string $exercicioPao
     * @return ConfiguracaoEmpenho
     */
    public function setExercicioPao($exercicioPao)
    {
        $this->exercicioPao = $exercicioPao;
        return $this;
    }

    /**
     * Get exercicioPao
     *
     * @return string
     */
    public function getExercicioPao()
    {
        return $this->exercicioPao;
    }

    /**
     * Set exercicioDespesa
     *
     * @param string $exercicioDespesa
     * @return ConfiguracaoEmpenho
     */
    public function setExercicioDespesa($exercicioDespesa)
    {
        $this->exercicioDespesa = $exercicioDespesa;
        return $this;
    }

    /**
     * Get exercicioDespesa
     *
     * @return string
     */
    public function getExercicioDespesa()
    {
        return $this->exercicioDespesa;
    }

    /**
     * Set codDespesa
     *
     * @param integer $codDespesa
     * @return ConfiguracaoEmpenho
     */
    public function setCodDespesa($codDespesa)
    {
        $this->codDespesa = $codDespesa;
        return $this;
    }

    /**
     * Get codDespesa
     *
     * @return integer
     */
    public function getCodDespesa()
    {
        return $this->codDespesa;
    }

    /**
     * Set numPao
     *
     * @param integer $numPao
     * @return ConfiguracaoEmpenho
     */
    public function setNumPao($numPao)
    {
        $this->numPao = $numPao;
        return $this;
    }

    /**
     * Get numPao
     *
     * @return integer
     */
    public function getNumPao()
    {
        return $this->numPao;
    }

    /**
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return ConfiguracaoEmpenho
     */
    public function setVigencia(\DateTime $vigencia)
    {
        $this->vigencia = $vigencia;
        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \DateTime
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoAtributo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributo $fkFolhapagamentoConfiguracaoEmpenhoAtributo
     * @return ConfiguracaoEmpenho
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoAtributos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributo $fkFolhapagamentoConfiguracaoEmpenhoAtributo)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoAtributos->contains($fkFolhapagamentoConfiguracaoEmpenhoAtributo)) {
            $fkFolhapagamentoConfiguracaoEmpenhoAtributo->setFkFolhapagamentoConfiguracaoEmpenho($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoAtributos->add($fkFolhapagamentoConfiguracaoEmpenhoAtributo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoAtributo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributo $fkFolhapagamentoConfiguracaoEmpenhoAtributo
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoAtributos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributo $fkFolhapagamentoConfiguracaoEmpenhoAtributo)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoAtributos->removeElement($fkFolhapagamentoConfiguracaoEmpenhoAtributo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoAtributos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributo
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoAtributos()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoAtributos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoEvento $fkFolhapagamentoConfiguracaoEmpenhoEvento
     * @return ConfiguracaoEmpenho
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoEvento $fkFolhapagamentoConfiguracaoEmpenhoEvento)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoEventos->contains($fkFolhapagamentoConfiguracaoEmpenhoEvento)) {
            $fkFolhapagamentoConfiguracaoEmpenhoEvento->setFkFolhapagamentoConfiguracaoEmpenho($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoEventos->add($fkFolhapagamentoConfiguracaoEmpenhoEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoEvento $fkFolhapagamentoConfiguracaoEmpenhoEvento
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoEvento $fkFolhapagamentoConfiguracaoEmpenhoEvento)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoEventos->removeElement($fkFolhapagamentoConfiguracaoEmpenhoEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoEvento
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoEventos()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLotacao $fkFolhapagamentoConfiguracaoEmpenhoLotacao
     * @return ConfiguracaoEmpenho
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoLotacoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLotacao $fkFolhapagamentoConfiguracaoEmpenhoLotacao)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoLotacoes->contains($fkFolhapagamentoConfiguracaoEmpenhoLotacao)) {
            $fkFolhapagamentoConfiguracaoEmpenhoLotacao->setFkFolhapagamentoConfiguracaoEmpenho($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoLotacoes->add($fkFolhapagamentoConfiguracaoEmpenhoLotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLotacao $fkFolhapagamentoConfiguracaoEmpenhoLotacao
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoLotacoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLotacao $fkFolhapagamentoConfiguracaoEmpenhoLotacao)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoLotacoes->removeElement($fkFolhapagamentoConfiguracaoEmpenhoLotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoLotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLotacao
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoLotacoes()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoLotacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoSituacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSituacao $fkFolhapagamentoConfiguracaoEmpenhoSituacao
     * @return ConfiguracaoEmpenho
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoSituacoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSituacao $fkFolhapagamentoConfiguracaoEmpenhoSituacao)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoSituacoes->contains($fkFolhapagamentoConfiguracaoEmpenhoSituacao)) {
            $fkFolhapagamentoConfiguracaoEmpenhoSituacao->setFkFolhapagamentoConfiguracaoEmpenho($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoSituacoes->add($fkFolhapagamentoConfiguracaoEmpenhoSituacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoSituacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSituacao $fkFolhapagamentoConfiguracaoEmpenhoSituacao
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoSituacoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSituacao $fkFolhapagamentoConfiguracaoEmpenhoSituacao)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoSituacoes->removeElement($fkFolhapagamentoConfiguracaoEmpenhoSituacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoSituacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSituacao
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoSituacoes()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoSituacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLocal $fkFolhapagamentoConfiguracaoEmpenhoLocal
     * @return ConfiguracaoEmpenho
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoLocais(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLocal $fkFolhapagamentoConfiguracaoEmpenhoLocal)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoLocais->contains($fkFolhapagamentoConfiguracaoEmpenhoLocal)) {
            $fkFolhapagamentoConfiguracaoEmpenhoLocal->setFkFolhapagamentoConfiguracaoEmpenho($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoLocais->add($fkFolhapagamentoConfiguracaoEmpenhoLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLocal $fkFolhapagamentoConfiguracaoEmpenhoLocal
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoLocais(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLocal $fkFolhapagamentoConfiguracaoEmpenhoLocal)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoLocais->removeElement($fkFolhapagamentoConfiguracaoEmpenhoLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLocal
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoLocais()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoLocais;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoSubdivisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSubdivisao $fkFolhapagamentoConfiguracaoEmpenhoSubdivisao
     * @return ConfiguracaoEmpenho
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoSubdivisoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSubdivisao $fkFolhapagamentoConfiguracaoEmpenhoSubdivisao)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoSubdivisoes->contains($fkFolhapagamentoConfiguracaoEmpenhoSubdivisao)) {
            $fkFolhapagamentoConfiguracaoEmpenhoSubdivisao->setFkFolhapagamentoConfiguracaoEmpenho($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoSubdivisoes->add($fkFolhapagamentoConfiguracaoEmpenhoSubdivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoSubdivisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSubdivisao $fkFolhapagamentoConfiguracaoEmpenhoSubdivisao
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoSubdivisoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSubdivisao $fkFolhapagamentoConfiguracaoEmpenhoSubdivisao)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoSubdivisoes->removeElement($fkFolhapagamentoConfiguracaoEmpenhoSubdivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoSubdivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSubdivisao
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoSubdivisoes()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoSubdivisoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoPao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Pao $fkOrcamentoPao
     * @return ConfiguracaoEmpenho
     */
    public function setFkOrcamentoPao(\Urbem\CoreBundle\Entity\Orcamento\Pao $fkOrcamentoPao)
    {
        $this->exercicioPao = $fkOrcamentoPao->getExercicio();
        $this->numPao = $fkOrcamentoPao->getNumPao();
        $this->fkOrcamentoPao = $fkOrcamentoPao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoPao
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Pao
     */
    public function getFkOrcamentoPao()
    {
        return $this->fkOrcamentoPao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoConfiguracaoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEvento $fkFolhapagamentoConfiguracaoEvento
     * @return ConfiguracaoEmpenho
     */
    public function setFkFolhapagamentoConfiguracaoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEvento $fkFolhapagamentoConfiguracaoEvento)
    {
        $this->codConfiguracao = $fkFolhapagamentoConfiguracaoEvento->getCodConfiguracao();
        $this->fkFolhapagamentoConfiguracaoEvento = $fkFolhapagamentoConfiguracaoEvento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEvento
     */
    public function getFkFolhapagamentoConfiguracaoEvento()
    {
        return $this->fkFolhapagamentoConfiguracaoEvento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     * @return ConfiguracaoEmpenho
     */
    public function setFkOrcamentoDespesa(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        $this->exercicioDespesa = $fkOrcamentoDespesa->getExercicio();
        $this->codDespesa = $fkOrcamentoDespesa->getCodDespesa();
        $this->fkOrcamentoDespesa = $fkOrcamentoDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    public function getFkOrcamentoDespesa()
    {
        return $this->fkOrcamentoDespesa;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoConfiguracaoEmpenhoContaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoContaDespesa $fkFolhapagamentoConfiguracaoEmpenhoContaDespesa
     * @return ConfiguracaoEmpenho
     */
    public function setFkFolhapagamentoConfiguracaoEmpenhoContaDespesa(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoContaDespesa $fkFolhapagamentoConfiguracaoEmpenhoContaDespesa)
    {
        $fkFolhapagamentoConfiguracaoEmpenhoContaDespesa->setFkFolhapagamentoConfiguracaoEmpenho($this);
        $this->fkFolhapagamentoConfiguracaoEmpenhoContaDespesa = $fkFolhapagamentoConfiguracaoEmpenhoContaDespesa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoContaDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoContaDespesa
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoContaDespesa()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoContaDespesa;
    }
}
