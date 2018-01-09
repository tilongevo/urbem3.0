<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * QuestaoCenso
 */
class QuestaoCenso
{
    /**
     * PK
     * @var integer
     */
    private $codQuestao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $nomQuestao;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $valorPadrao;

    /**
     * @var integer
     */
    private $ordem;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\RespostaCenso
     */
    private $fkCseRespostaCensos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\RespostaQuestao
     */
    private $fkCseRespostaQuestoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCseRespostaCensos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkCseRespostaQuestoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codQuestao
     *
     * @param integer $codQuestao
     * @return QuestaoCenso
     */
    public function setCodQuestao($codQuestao)
    {
        $this->codQuestao = $codQuestao;
        return $this;
    }

    /**
     * Get codQuestao
     *
     * @return integer
     */
    public function getCodQuestao()
    {
        return $this->codQuestao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return QuestaoCenso
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
     * Set nomQuestao
     *
     * @param string $nomQuestao
     * @return QuestaoCenso
     */
    public function setNomQuestao($nomQuestao)
    {
        $this->nomQuestao = $nomQuestao;
        return $this;
    }

    /**
     * Get nomQuestao
     *
     * @return string
     */
    public function getNomQuestao()
    {
        return $this->nomQuestao;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return QuestaoCenso
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set valorPadrao
     *
     * @param string $valorPadrao
     * @return QuestaoCenso
     */
    public function setValorPadrao($valorPadrao)
    {
        $this->valorPadrao = $valorPadrao;
        return $this;
    }

    /**
     * Get valorPadrao
     *
     * @return string
     */
    public function getValorPadrao()
    {
        return $this->valorPadrao;
    }

    /**
     * Set ordem
     *
     * @param integer $ordem
     * @return QuestaoCenso
     */
    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
        return $this;
    }

    /**
     * Get ordem
     *
     * @return integer
     */
    public function getOrdem()
    {
        return $this->ordem;
    }

    /**
     * OneToMany (owning side)
     * Add CseRespostaCenso
     *
     * @param \Urbem\CoreBundle\Entity\Cse\RespostaCenso $fkCseRespostaCenso
     * @return QuestaoCenso
     */
    public function addFkCseRespostaCensos(\Urbem\CoreBundle\Entity\Cse\RespostaCenso $fkCseRespostaCenso)
    {
        if (false === $this->fkCseRespostaCensos->contains($fkCseRespostaCenso)) {
            $fkCseRespostaCenso->setFkCseQuestaoCenso($this);
            $this->fkCseRespostaCensos->add($fkCseRespostaCenso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseRespostaCenso
     *
     * @param \Urbem\CoreBundle\Entity\Cse\RespostaCenso $fkCseRespostaCenso
     */
    public function removeFkCseRespostaCensos(\Urbem\CoreBundle\Entity\Cse\RespostaCenso $fkCseRespostaCenso)
    {
        $this->fkCseRespostaCensos->removeElement($fkCseRespostaCenso);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseRespostaCensos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\RespostaCenso
     */
    public function getFkCseRespostaCensos()
    {
        return $this->fkCseRespostaCensos;
    }

    /**
     * OneToMany (owning side)
     * Add CseRespostaQuestao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\RespostaQuestao $fkCseRespostaQuestao
     * @return QuestaoCenso
     */
    public function addFkCseRespostaQuestoes(\Urbem\CoreBundle\Entity\Cse\RespostaQuestao $fkCseRespostaQuestao)
    {
        if (false === $this->fkCseRespostaQuestoes->contains($fkCseRespostaQuestao)) {
            $fkCseRespostaQuestao->setFkCseQuestaoCenso($this);
            $this->fkCseRespostaQuestoes->add($fkCseRespostaQuestao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseRespostaQuestao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\RespostaQuestao $fkCseRespostaQuestao
     */
    public function removeFkCseRespostaQuestoes(\Urbem\CoreBundle\Entity\Cse\RespostaQuestao $fkCseRespostaQuestao)
    {
        $this->fkCseRespostaQuestoes->removeElement($fkCseRespostaQuestao);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseRespostaQuestoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\RespostaQuestao
     */
    public function getFkCseRespostaQuestoes()
    {
        return $this->fkCseRespostaQuestoes;
    }
}
