<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * GrupoPeriodo
 */
class GrupoPeriodo
{
    /**
     * PK
     * @var integer
     */
    private $codGrupoPeriodo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\PeriodoCaso
     */
    private $fkPessoalPeriodoCasos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalPeriodoCasos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codGrupoPeriodo
     *
     * @param integer $codGrupoPeriodo
     * @return GrupoPeriodo
     */
    public function setCodGrupoPeriodo($codGrupoPeriodo)
    {
        $this->codGrupoPeriodo = $codGrupoPeriodo;
        return $this;
    }

    /**
     * Get codGrupoPeriodo
     *
     * @return integer
     */
    public function getCodGrupoPeriodo()
    {
        return $this->codGrupoPeriodo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return GrupoPeriodo
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
     * OneToMany (owning side)
     * Add PessoalPeriodoCaso
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PeriodoCaso $fkPessoalPeriodoCaso
     * @return GrupoPeriodo
     */
    public function addFkPessoalPeriodoCasos(\Urbem\CoreBundle\Entity\Pessoal\PeriodoCaso $fkPessoalPeriodoCaso)
    {
        if (false === $this->fkPessoalPeriodoCasos->contains($fkPessoalPeriodoCaso)) {
            $fkPessoalPeriodoCaso->setFkPessoalGrupoPeriodo($this);
            $this->fkPessoalPeriodoCasos->add($fkPessoalPeriodoCaso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalPeriodoCaso
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PeriodoCaso $fkPessoalPeriodoCaso
     */
    public function removeFkPessoalPeriodoCasos(\Urbem\CoreBundle\Entity\Pessoal\PeriodoCaso $fkPessoalPeriodoCaso)
    {
        $this->fkPessoalPeriodoCasos->removeElement($fkPessoalPeriodoCaso);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalPeriodoCasos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\PeriodoCaso
     */
    public function getFkPessoalPeriodoCasos()
    {
        return $this->fkPessoalPeriodoCasos;
    }
}
