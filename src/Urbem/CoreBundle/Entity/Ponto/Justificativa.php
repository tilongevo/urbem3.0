<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * Justificativa
 */
class Justificativa
{
    /**
     * PK
     * @var integer
     */
    private $codJustificativa;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var boolean
     */
    private $anularFaltas;

    /**
     * @var boolean
     */
    private $lancarDiasTrabalho;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\JustificativaHoras
     */
    private $fkPontoJustificativaHoras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativa
     */
    private $fkPontoRelogioPontoJustificativas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPontoRelogioPontoJustificativas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codJustificativa
     *
     * @param integer $codJustificativa
     * @return Justificativa
     */
    public function setCodJustificativa($codJustificativa)
    {
        $this->codJustificativa = $codJustificativa;
        return $this;
    }

    /**
     * Get codJustificativa
     *
     * @return integer
     */
    public function getCodJustificativa()
    {
        return $this->codJustificativa;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Justificativa
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
     * Set anularFaltas
     *
     * @param boolean $anularFaltas
     * @return Justificativa
     */
    public function setAnularFaltas($anularFaltas)
    {
        $this->anularFaltas = $anularFaltas;
        return $this;
    }

    /**
     * Get anularFaltas
     *
     * @return boolean
     */
    public function getAnularFaltas()
    {
        return $this->anularFaltas;
    }

    /**
     * Set lancarDiasTrabalho
     *
     * @param boolean $lancarDiasTrabalho
     * @return Justificativa
     */
    public function setLancarDiasTrabalho($lancarDiasTrabalho)
    {
        $this->lancarDiasTrabalho = $lancarDiasTrabalho;
        return $this;
    }

    /**
     * Get lancarDiasTrabalho
     *
     * @return boolean
     */
    public function getLancarDiasTrabalho()
    {
        return $this->lancarDiasTrabalho;
    }

    /**
     * OneToMany (owning side)
     * Add PontoRelogioPontoJustificativa
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativa $fkPontoRelogioPontoJustificativa
     * @return Justificativa
     */
    public function addFkPontoRelogioPontoJustificativas(\Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativa $fkPontoRelogioPontoJustificativa)
    {
        if (false === $this->fkPontoRelogioPontoJustificativas->contains($fkPontoRelogioPontoJustificativa)) {
            $fkPontoRelogioPontoJustificativa->setFkPontoJustificativa($this);
            $this->fkPontoRelogioPontoJustificativas->add($fkPontoRelogioPontoJustificativa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoRelogioPontoJustificativa
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativa $fkPontoRelogioPontoJustificativa
     */
    public function removeFkPontoRelogioPontoJustificativas(\Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativa $fkPontoRelogioPontoJustificativa)
    {
        $this->fkPontoRelogioPontoJustificativas->removeElement($fkPontoRelogioPontoJustificativa);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoRelogioPontoJustificativas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativa
     */
    public function getFkPontoRelogioPontoJustificativas()
    {
        return $this->fkPontoRelogioPontoJustificativas;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoJustificativaHoras
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\JustificativaHoras $fkPontoJustificativaHoras
     * @return Justificativa
     */
    public function setFkPontoJustificativaHoras(\Urbem\CoreBundle\Entity\Ponto\JustificativaHoras $fkPontoJustificativaHoras)
    {
        $fkPontoJustificativaHoras->setFkPontoJustificativa($this);
        $this->fkPontoJustificativaHoras = $fkPontoJustificativaHoras;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoJustificativaHoras
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\JustificativaHoras
     */
    public function getFkPontoJustificativaHoras()
    {
        return $this->fkPontoJustificativaHoras;
    }
}
