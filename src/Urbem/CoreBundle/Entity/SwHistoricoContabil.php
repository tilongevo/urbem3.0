<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwHistoricoContabil
 */
class SwHistoricoContabil
{
    /**
     * PK
     * @var integer
     */
    private $codHistorico;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $nomHistorico;

    /**
     * @var boolean
     */
    private $complemento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwTransacao
     */
    private $fkSwTransacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwTransacao
     */
    private $fkSwTransacoes1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwLancamento
     */
    private $fkSwLancamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwTransacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwTransacoes1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwLancamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codHistorico
     *
     * @param integer $codHistorico
     * @return SwHistoricoContabil
     */
    public function setCodHistorico($codHistorico)
    {
        $this->codHistorico = $codHistorico;
        return $this;
    }

    /**
     * Get codHistorico
     *
     * @return integer
     */
    public function getCodHistorico()
    {
        return $this->codHistorico;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwHistoricoContabil
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
     * Set nomHistorico
     *
     * @param string $nomHistorico
     * @return SwHistoricoContabil
     */
    public function setNomHistorico($nomHistorico)
    {
        $this->nomHistorico = $nomHistorico;
        return $this;
    }

    /**
     * Get nomHistorico
     *
     * @return string
     */
    public function getNomHistorico()
    {
        return $this->nomHistorico;
    }

    /**
     * Set complemento
     *
     * @param boolean $complemento
     * @return SwHistoricoContabil
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
        return $this;
    }

    /**
     * Get complemento
     *
     * @return boolean
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * OneToMany (owning side)
     * Add SwTransacao
     *
     * @param \Urbem\CoreBundle\Entity\SwTransacao $fkSwTransacao
     * @return SwHistoricoContabil
     */
    public function addFkSwTransacoes(\Urbem\CoreBundle\Entity\SwTransacao $fkSwTransacao)
    {
        if (false === $this->fkSwTransacoes->contains($fkSwTransacao)) {
            $fkSwTransacao->setFkSwHistoricoContabil($this);
            $this->fkSwTransacoes->add($fkSwTransacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwTransacao
     *
     * @param \Urbem\CoreBundle\Entity\SwTransacao $fkSwTransacao
     */
    public function removeFkSwTransacoes(\Urbem\CoreBundle\Entity\SwTransacao $fkSwTransacao)
    {
        $this->fkSwTransacoes->removeElement($fkSwTransacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwTransacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwTransacao
     */
    public function getFkSwTransacoes()
    {
        return $this->fkSwTransacoes;
    }

    /**
     * OneToMany (owning side)
     * Add SwTransacao
     *
     * @param \Urbem\CoreBundle\Entity\SwTransacao $fkSwTransacao
     * @return SwHistoricoContabil
     */
    public function addFkSwTransacoes1(\Urbem\CoreBundle\Entity\SwTransacao $fkSwTransacao)
    {
        if (false === $this->fkSwTransacoes1->contains($fkSwTransacao)) {
            $fkSwTransacao->setFkSwHistoricoContabil1($this);
            $this->fkSwTransacoes1->add($fkSwTransacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwTransacao
     *
     * @param \Urbem\CoreBundle\Entity\SwTransacao $fkSwTransacao
     */
    public function removeFkSwTransacoes1(\Urbem\CoreBundle\Entity\SwTransacao $fkSwTransacao)
    {
        $this->fkSwTransacoes1->removeElement($fkSwTransacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwTransacoes1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwTransacao
     */
    public function getFkSwTransacoes1()
    {
        return $this->fkSwTransacoes1;
    }

    /**
     * OneToMany (owning side)
     * Add SwLancamento
     *
     * @param \Urbem\CoreBundle\Entity\SwLancamento $fkSwLancamento
     * @return SwHistoricoContabil
     */
    public function addFkSwLancamentos(\Urbem\CoreBundle\Entity\SwLancamento $fkSwLancamento)
    {
        if (false === $this->fkSwLancamentos->contains($fkSwLancamento)) {
            $fkSwLancamento->setFkSwHistoricoContabil($this);
            $this->fkSwLancamentos->add($fkSwLancamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwLancamento
     *
     * @param \Urbem\CoreBundle\Entity\SwLancamento $fkSwLancamento
     */
    public function removeFkSwLancamentos(\Urbem\CoreBundle\Entity\SwLancamento $fkSwLancamento)
    {
        $this->fkSwLancamentos->removeElement($fkSwLancamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwLancamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwLancamento
     */
    public function getFkSwLancamentos()
    {
        return $this->fkSwLancamentos;
    }
}
