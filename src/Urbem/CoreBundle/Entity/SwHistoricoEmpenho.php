<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwHistoricoEmpenho
 */
class SwHistoricoEmpenho
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
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwHistoricoClassificacao
     */
    private $fkSwHistoricoClassificacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwHistoricoClassificacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codHistorico
     *
     * @param integer $codHistorico
     * @return SwHistoricoEmpenho
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
     * @return SwHistoricoEmpenho
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
     * @return SwHistoricoEmpenho
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
     * OneToMany (owning side)
     * Add SwHistoricoClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\SwHistoricoClassificacao $fkSwHistoricoClassificacao
     * @return SwHistoricoEmpenho
     */
    public function addFkSwHistoricoClassificacoes(\Urbem\CoreBundle\Entity\SwHistoricoClassificacao $fkSwHistoricoClassificacao)
    {
        if (false === $this->fkSwHistoricoClassificacoes->contains($fkSwHistoricoClassificacao)) {
            $fkSwHistoricoClassificacao->setFkSwHistoricoEmpenho($this);
            $this->fkSwHistoricoClassificacoes->add($fkSwHistoricoClassificacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwHistoricoClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\SwHistoricoClassificacao $fkSwHistoricoClassificacao
     */
    public function removeFkSwHistoricoClassificacoes(\Urbem\CoreBundle\Entity\SwHistoricoClassificacao $fkSwHistoricoClassificacao)
    {
        $this->fkSwHistoricoClassificacoes->removeElement($fkSwHistoricoClassificacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwHistoricoClassificacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwHistoricoClassificacao
     */
    public function getFkSwHistoricoClassificacoes()
    {
        return $this->fkSwHistoricoClassificacoes;
    }
}
