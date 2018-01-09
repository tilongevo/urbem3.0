<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwTransacao
 */
class SwTransacao
{
    /**
     * PK
     * @var integer
     */
    private $codTransacao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $anoReferencia;

    /**
     * @var integer
     */
    private $codHistoricoLancamento;

    /**
     * @var integer
     */
    private $codHistoricoEstorno;

    /**
     * @var string
     */
    private $nomTransacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwEntidadeTransacao
     */
    private $fkSwEntidadeTransacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwTransacaoOperacao
     */
    private $fkSwTransacaoOperacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwHistoricoContabil
     */
    private $fkSwHistoricoContabil;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwHistoricoContabil
     */
    private $fkSwHistoricoContabil1;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwEntidadeTransacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwTransacaoOperacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTransacao
     *
     * @param integer $codTransacao
     * @return SwTransacao
     */
    public function setCodTransacao($codTransacao)
    {
        $this->codTransacao = $codTransacao;
        return $this;
    }

    /**
     * Get codTransacao
     *
     * @return integer
     */
    public function getCodTransacao()
    {
        return $this->codTransacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwTransacao
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
     * Set anoReferencia
     *
     * @param string $anoReferencia
     * @return SwTransacao
     */
    public function setAnoReferencia($anoReferencia)
    {
        $this->anoReferencia = $anoReferencia;
        return $this;
    }

    /**
     * Get anoReferencia
     *
     * @return string
     */
    public function getAnoReferencia()
    {
        return $this->anoReferencia;
    }

    /**
     * Set codHistoricoLancamento
     *
     * @param integer $codHistoricoLancamento
     * @return SwTransacao
     */
    public function setCodHistoricoLancamento($codHistoricoLancamento)
    {
        $this->codHistoricoLancamento = $codHistoricoLancamento;
        return $this;
    }

    /**
     * Get codHistoricoLancamento
     *
     * @return integer
     */
    public function getCodHistoricoLancamento()
    {
        return $this->codHistoricoLancamento;
    }

    /**
     * Set codHistoricoEstorno
     *
     * @param integer $codHistoricoEstorno
     * @return SwTransacao
     */
    public function setCodHistoricoEstorno($codHistoricoEstorno)
    {
        $this->codHistoricoEstorno = $codHistoricoEstorno;
        return $this;
    }

    /**
     * Get codHistoricoEstorno
     *
     * @return integer
     */
    public function getCodHistoricoEstorno()
    {
        return $this->codHistoricoEstorno;
    }

    /**
     * Set nomTransacao
     *
     * @param string $nomTransacao
     * @return SwTransacao
     */
    public function setNomTransacao($nomTransacao)
    {
        $this->nomTransacao = $nomTransacao;
        return $this;
    }

    /**
     * Get nomTransacao
     *
     * @return string
     */
    public function getNomTransacao()
    {
        return $this->nomTransacao;
    }

    /**
     * OneToMany (owning side)
     * Add SwEntidadeTransacao
     *
     * @param \Urbem\CoreBundle\Entity\SwEntidadeTransacao $fkSwEntidadeTransacao
     * @return SwTransacao
     */
    public function addFkSwEntidadeTransacoes(\Urbem\CoreBundle\Entity\SwEntidadeTransacao $fkSwEntidadeTransacao)
    {
        if (false === $this->fkSwEntidadeTransacoes->contains($fkSwEntidadeTransacao)) {
            $fkSwEntidadeTransacao->setFkSwTransacao($this);
            $this->fkSwEntidadeTransacoes->add($fkSwEntidadeTransacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwEntidadeTransacao
     *
     * @param \Urbem\CoreBundle\Entity\SwEntidadeTransacao $fkSwEntidadeTransacao
     */
    public function removeFkSwEntidadeTransacoes(\Urbem\CoreBundle\Entity\SwEntidadeTransacao $fkSwEntidadeTransacao)
    {
        $this->fkSwEntidadeTransacoes->removeElement($fkSwEntidadeTransacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwEntidadeTransacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwEntidadeTransacao
     */
    public function getFkSwEntidadeTransacoes()
    {
        return $this->fkSwEntidadeTransacoes;
    }

    /**
     * OneToMany (owning side)
     * Add SwTransacaoOperacao
     *
     * @param \Urbem\CoreBundle\Entity\SwTransacaoOperacao $fkSwTransacaoOperacao
     * @return SwTransacao
     */
    public function addFkSwTransacaoOperacoes(\Urbem\CoreBundle\Entity\SwTransacaoOperacao $fkSwTransacaoOperacao)
    {
        if (false === $this->fkSwTransacaoOperacoes->contains($fkSwTransacaoOperacao)) {
            $fkSwTransacaoOperacao->setFkSwTransacao($this);
            $this->fkSwTransacaoOperacoes->add($fkSwTransacaoOperacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwTransacaoOperacao
     *
     * @param \Urbem\CoreBundle\Entity\SwTransacaoOperacao $fkSwTransacaoOperacao
     */
    public function removeFkSwTransacaoOperacoes(\Urbem\CoreBundle\Entity\SwTransacaoOperacao $fkSwTransacaoOperacao)
    {
        $this->fkSwTransacaoOperacoes->removeElement($fkSwTransacaoOperacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwTransacaoOperacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwTransacaoOperacao
     */
    public function getFkSwTransacaoOperacoes()
    {
        return $this->fkSwTransacaoOperacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwHistoricoContabil
     *
     * @param \Urbem\CoreBundle\Entity\SwHistoricoContabil $fkSwHistoricoContabil
     * @return SwTransacao
     */
    public function setFkSwHistoricoContabil(\Urbem\CoreBundle\Entity\SwHistoricoContabil $fkSwHistoricoContabil)
    {
        $this->codHistoricoEstorno = $fkSwHistoricoContabil->getCodHistorico();
        $this->exercicio = $fkSwHistoricoContabil->getExercicio();
        $this->fkSwHistoricoContabil = $fkSwHistoricoContabil;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwHistoricoContabil
     *
     * @return \Urbem\CoreBundle\Entity\SwHistoricoContabil
     */
    public function getFkSwHistoricoContabil()
    {
        return $this->fkSwHistoricoContabil;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwHistoricoContabil1
     *
     * @param \Urbem\CoreBundle\Entity\SwHistoricoContabil $fkSwHistoricoContabil1
     * @return SwTransacao
     */
    public function setFkSwHistoricoContabil1(\Urbem\CoreBundle\Entity\SwHistoricoContabil $fkSwHistoricoContabil1)
    {
        $this->codHistoricoLancamento = $fkSwHistoricoContabil1->getCodHistorico();
        $this->exercicio = $fkSwHistoricoContabil1->getExercicio();
        $this->fkSwHistoricoContabil1 = $fkSwHistoricoContabil1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwHistoricoContabil1
     *
     * @return \Urbem\CoreBundle\Entity\SwHistoricoContabil
     */
    public function getFkSwHistoricoContabil1()
    {
        return $this->fkSwHistoricoContabil1;
    }
}
