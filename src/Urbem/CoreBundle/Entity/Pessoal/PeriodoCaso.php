<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * PeriodoCaso
 */
class PeriodoCaso
{
    /**
     * PK
     * @var integer
     */
    private $codPeriodo;

    /**
     * @var integer
     */
    private $codGrupoPeriodo;

    /**
     * @var integer
     */
    private $periodoInicial;

    /**
     * @var integer
     */
    private $periodoFinal;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CasoCausa
     */
    private $fkPessoalCasoCausas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\GrupoPeriodo
     */
    private $fkPessoalGrupoPeriodo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalCasoCausas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPeriodo
     *
     * @param integer $codPeriodo
     * @return PeriodoCaso
     */
    public function setCodPeriodo($codPeriodo)
    {
        $this->codPeriodo = $codPeriodo;
        return $this;
    }

    /**
     * Get codPeriodo
     *
     * @return integer
     */
    public function getCodPeriodo()
    {
        return $this->codPeriodo;
    }

    /**
     * Set codGrupoPeriodo
     *
     * @param integer $codGrupoPeriodo
     * @return PeriodoCaso
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
     * Set periodoInicial
     *
     * @param integer $periodoInicial
     * @return PeriodoCaso
     */
    public function setPeriodoInicial($periodoInicial)
    {
        $this->periodoInicial = $periodoInicial;
        return $this;
    }

    /**
     * Get periodoInicial
     *
     * @return integer
     */
    public function getPeriodoInicial()
    {
        return $this->periodoInicial;
    }

    /**
     * Set periodoFinal
     *
     * @param integer $periodoFinal
     * @return PeriodoCaso
     */
    public function setPeriodoFinal($periodoFinal)
    {
        $this->periodoFinal = $periodoFinal;
        return $this;
    }

    /**
     * Get periodoFinal
     *
     * @return integer
     */
    public function getPeriodoFinal()
    {
        return $this->periodoFinal;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return PeriodoCaso
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
     * Add PessoalCasoCausa
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CasoCausa $fkPessoalCasoCausa
     * @return PeriodoCaso
     */
    public function addFkPessoalCasoCausas(\Urbem\CoreBundle\Entity\Pessoal\CasoCausa $fkPessoalCasoCausa)
    {
        if (false === $this->fkPessoalCasoCausas->contains($fkPessoalCasoCausa)) {
            $fkPessoalCasoCausa->setFkPessoalPeriodoCaso($this);
            $this->fkPessoalCasoCausas->add($fkPessoalCasoCausa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCasoCausa
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CasoCausa $fkPessoalCasoCausa
     */
    public function removeFkPessoalCasoCausas(\Urbem\CoreBundle\Entity\Pessoal\CasoCausa $fkPessoalCasoCausa)
    {
        $this->fkPessoalCasoCausas->removeElement($fkPessoalCasoCausa);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCasoCausas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CasoCausa
     */
    public function getFkPessoalCasoCausas()
    {
        return $this->fkPessoalCasoCausas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalGrupoPeriodo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\GrupoPeriodo $fkPessoalGrupoPeriodo
     * @return PeriodoCaso
     */
    public function setFkPessoalGrupoPeriodo(\Urbem\CoreBundle\Entity\Pessoal\GrupoPeriodo $fkPessoalGrupoPeriodo)
    {
        $this->codGrupoPeriodo = $fkPessoalGrupoPeriodo->getCodGrupoPeriodo();
        $this->fkPessoalGrupoPeriodo = $fkPessoalGrupoPeriodo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalGrupoPeriodo
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\GrupoPeriodo
     */
    public function getFkPessoalGrupoPeriodo()
    {
        return $this->fkPessoalGrupoPeriodo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
