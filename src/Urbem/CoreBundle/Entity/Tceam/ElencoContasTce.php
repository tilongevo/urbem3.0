<?php
 
namespace Urbem\CoreBundle\Entity\Tceam;

/**
 * ElencoContasTce
 */
class ElencoContasTce
{
    /**
     * PK
     * @var integer
     */
    private $codElenco;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $seq;

    /**
     * @var string
     */
    private $codContaTce;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $nivel;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\VinculoElencoPlanoContas
     */
    private $fkTceamVinculoElencoPlanoContas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTceamVinculoElencoPlanoContas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codElenco
     *
     * @param integer $codElenco
     * @return ElencoContasTce
     */
    public function setCodElenco($codElenco)
    {
        $this->codElenco = $codElenco;
        return $this;
    }

    /**
     * Get codElenco
     *
     * @return integer
     */
    public function getCodElenco()
    {
        return $this->codElenco;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ElencoContasTce
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
     * Set seq
     *
     * @param integer $seq
     * @return ElencoContasTce
     */
    public function setSeq($seq)
    {
        $this->seq = $seq;
        return $this;
    }

    /**
     * Get seq
     *
     * @return integer
     */
    public function getSeq()
    {
        return $this->seq;
    }

    /**
     * Set codContaTce
     *
     * @param string $codContaTce
     * @return ElencoContasTce
     */
    public function setCodContaTce($codContaTce)
    {
        $this->codContaTce = $codContaTce;
        return $this;
    }

    /**
     * Get codContaTce
     *
     * @return string
     */
    public function getCodContaTce()
    {
        return $this->codContaTce;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ElencoContasTce
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set nivel
     *
     * @param string $nivel
     * @return ElencoContasTce
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
        return $this;
    }

    /**
     * Get nivel
     *
     * @return string
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * OneToMany (owning side)
     * Add TceamVinculoElencoPlanoContas
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\VinculoElencoPlanoContas $fkTceamVinculoElencoPlanoContas
     * @return ElencoContasTce
     */
    public function addFkTceamVinculoElencoPlanoContas(\Urbem\CoreBundle\Entity\Tceam\VinculoElencoPlanoContas $fkTceamVinculoElencoPlanoContas)
    {
        if (false === $this->fkTceamVinculoElencoPlanoContas->contains($fkTceamVinculoElencoPlanoContas)) {
            $fkTceamVinculoElencoPlanoContas->setFkTceamElencoContasTce($this);
            $this->fkTceamVinculoElencoPlanoContas->add($fkTceamVinculoElencoPlanoContas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TceamVinculoElencoPlanoContas
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\VinculoElencoPlanoContas $fkTceamVinculoElencoPlanoContas
     */
    public function removeFkTceamVinculoElencoPlanoContas(\Urbem\CoreBundle\Entity\Tceam\VinculoElencoPlanoContas $fkTceamVinculoElencoPlanoContas)
    {
        $this->fkTceamVinculoElencoPlanoContas->removeElement($fkTceamVinculoElencoPlanoContas);
    }

    /**
     * OneToMany (owning side)
     * Get fkTceamVinculoElencoPlanoContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\VinculoElencoPlanoContas
     */
    public function getFkTceamVinculoElencoPlanoContas()
    {
        return $this->fkTceamVinculoElencoPlanoContas;
    }
}
