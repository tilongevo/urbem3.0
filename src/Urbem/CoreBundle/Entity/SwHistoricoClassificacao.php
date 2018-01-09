<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwHistoricoClassificacao
 */
class SwHistoricoClassificacao
{
    /**
     * PK
     * @var integer
     */
    private $codHistoricoClassificacao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codHistorico;

    /**
     * @var integer
     */
    private $codCategoriaEconomica;

    /**
     * @var integer
     */
    private $codGrupoDespesa;

    /**
     * @var integer
     */
    private $codModalidadeAplicacao;

    /**
     * @var integer
     */
    private $codElementoDespesa;

    /**
     * @var integer
     */
    private $codDesdobramento1;

    /**
     * @var integer
     */
    private $codDesdobramento2;

    /**
     * @var integer
     */
    private $codDesdobramento3;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPreEmpenho
     */
    private $fkSwPreEmpenhos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwHistoricoEmpenho
     */
    private $fkSwHistoricoEmpenho;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwPreEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codHistoricoClassificacao
     *
     * @param integer $codHistoricoClassificacao
     * @return SwHistoricoClassificacao
     */
    public function setCodHistoricoClassificacao($codHistoricoClassificacao)
    {
        $this->codHistoricoClassificacao = $codHistoricoClassificacao;
        return $this;
    }

    /**
     * Get codHistoricoClassificacao
     *
     * @return integer
     */
    public function getCodHistoricoClassificacao()
    {
        return $this->codHistoricoClassificacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwHistoricoClassificacao
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
     * Set codHistorico
     *
     * @param integer $codHistorico
     * @return SwHistoricoClassificacao
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
     * Set codCategoriaEconomica
     *
     * @param integer $codCategoriaEconomica
     * @return SwHistoricoClassificacao
     */
    public function setCodCategoriaEconomica($codCategoriaEconomica)
    {
        $this->codCategoriaEconomica = $codCategoriaEconomica;
        return $this;
    }

    /**
     * Get codCategoriaEconomica
     *
     * @return integer
     */
    public function getCodCategoriaEconomica()
    {
        return $this->codCategoriaEconomica;
    }

    /**
     * Set codGrupoDespesa
     *
     * @param integer $codGrupoDespesa
     * @return SwHistoricoClassificacao
     */
    public function setCodGrupoDespesa($codGrupoDespesa)
    {
        $this->codGrupoDespesa = $codGrupoDespesa;
        return $this;
    }

    /**
     * Get codGrupoDespesa
     *
     * @return integer
     */
    public function getCodGrupoDespesa()
    {
        return $this->codGrupoDespesa;
    }

    /**
     * Set codModalidadeAplicacao
     *
     * @param integer $codModalidadeAplicacao
     * @return SwHistoricoClassificacao
     */
    public function setCodModalidadeAplicacao($codModalidadeAplicacao)
    {
        $this->codModalidadeAplicacao = $codModalidadeAplicacao;
        return $this;
    }

    /**
     * Get codModalidadeAplicacao
     *
     * @return integer
     */
    public function getCodModalidadeAplicacao()
    {
        return $this->codModalidadeAplicacao;
    }

    /**
     * Set codElementoDespesa
     *
     * @param integer $codElementoDespesa
     * @return SwHistoricoClassificacao
     */
    public function setCodElementoDespesa($codElementoDespesa)
    {
        $this->codElementoDespesa = $codElementoDespesa;
        return $this;
    }

    /**
     * Get codElementoDespesa
     *
     * @return integer
     */
    public function getCodElementoDespesa()
    {
        return $this->codElementoDespesa;
    }

    /**
     * Set codDesdobramento1
     *
     * @param integer $codDesdobramento1
     * @return SwHistoricoClassificacao
     */
    public function setCodDesdobramento1($codDesdobramento1)
    {
        $this->codDesdobramento1 = $codDesdobramento1;
        return $this;
    }

    /**
     * Get codDesdobramento1
     *
     * @return integer
     */
    public function getCodDesdobramento1()
    {
        return $this->codDesdobramento1;
    }

    /**
     * Set codDesdobramento2
     *
     * @param integer $codDesdobramento2
     * @return SwHistoricoClassificacao
     */
    public function setCodDesdobramento2($codDesdobramento2)
    {
        $this->codDesdobramento2 = $codDesdobramento2;
        return $this;
    }

    /**
     * Get codDesdobramento2
     *
     * @return integer
     */
    public function getCodDesdobramento2()
    {
        return $this->codDesdobramento2;
    }

    /**
     * Set codDesdobramento3
     *
     * @param integer $codDesdobramento3
     * @return SwHistoricoClassificacao
     */
    public function setCodDesdobramento3($codDesdobramento3)
    {
        $this->codDesdobramento3 = $codDesdobramento3;
        return $this;
    }

    /**
     * Get codDesdobramento3
     *
     * @return integer
     */
    public function getCodDesdobramento3()
    {
        return $this->codDesdobramento3;
    }

    /**
     * OneToMany (owning side)
     * Add SwPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho
     * @return SwHistoricoClassificacao
     */
    public function addFkSwPreEmpenhos(\Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho)
    {
        if (false === $this->fkSwPreEmpenhos->contains($fkSwPreEmpenho)) {
            $fkSwPreEmpenho->setFkSwHistoricoClassificacao($this);
            $this->fkSwPreEmpenhos->add($fkSwPreEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho
     */
    public function removeFkSwPreEmpenhos(\Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho)
    {
        $this->fkSwPreEmpenhos->removeElement($fkSwPreEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwPreEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPreEmpenho
     */
    public function getFkSwPreEmpenhos()
    {
        return $this->fkSwPreEmpenhos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwHistoricoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwHistoricoEmpenho $fkSwHistoricoEmpenho
     * @return SwHistoricoClassificacao
     */
    public function setFkSwHistoricoEmpenho(\Urbem\CoreBundle\Entity\SwHistoricoEmpenho $fkSwHistoricoEmpenho)
    {
        $this->codHistorico = $fkSwHistoricoEmpenho->getCodHistorico();
        $this->exercicio = $fkSwHistoricoEmpenho->getExercicio();
        $this->fkSwHistoricoEmpenho = $fkSwHistoricoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwHistoricoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\SwHistoricoEmpenho
     */
    public function getFkSwHistoricoEmpenho()
    {
        return $this->fkSwHistoricoEmpenho;
    }
}
