<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * LoteRegistroPrecos
 */
class LoteRegistroPrecos
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $numeroRegistroPrecos;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var boolean
     */
    private $interno;

    /**
     * PK
     * @var integer
     */
    private $numcgmGerenciador;

    /**
     * @var string
     */
    private $descricaoLote;

    /**
     * @var integer
     */
    private $percentualDescontoLote;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos
     */
    private $fkTcemgItemRegistroPrecos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos
     */
    private $fkTcemgRegistroPrecos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgItemRegistroPrecos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return LoteRegistroPrecos
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set numeroRegistroPrecos
     *
     * @param integer $numeroRegistroPrecos
     * @return LoteRegistroPrecos
     */
    public function setNumeroRegistroPrecos($numeroRegistroPrecos)
    {
        $this->numeroRegistroPrecos = $numeroRegistroPrecos;
        return $this;
    }

    /**
     * Get numeroRegistroPrecos
     *
     * @return integer
     */
    public function getNumeroRegistroPrecos()
    {
        return $this->numeroRegistroPrecos;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return LoteRegistroPrecos
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
     * Set codLote
     *
     * @param integer $codLote
     * @return LoteRegistroPrecos
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set interno
     *
     * @param boolean $interno
     * @return LoteRegistroPrecos
     */
    public function setInterno($interno)
    {
        $this->interno = $interno;
        return $this;
    }

    /**
     * Get interno
     *
     * @return boolean
     */
    public function getInterno()
    {
        return $this->interno;
    }

    /**
     * Set numcgmGerenciador
     *
     * @param integer $numcgmGerenciador
     * @return LoteRegistroPrecos
     */
    public function setNumcgmGerenciador($numcgmGerenciador)
    {
        $this->numcgmGerenciador = $numcgmGerenciador;
        return $this;
    }

    /**
     * Get numcgmGerenciador
     *
     * @return integer
     */
    public function getNumcgmGerenciador()
    {
        return $this->numcgmGerenciador;
    }

    /**
     * Set descricaoLote
     *
     * @param string $descricaoLote
     * @return LoteRegistroPrecos
     */
    public function setDescricaoLote($descricaoLote)
    {
        $this->descricaoLote = $descricaoLote;
        return $this;
    }

    /**
     * Get descricaoLote
     *
     * @return string
     */
    public function getDescricaoLote()
    {
        return $this->descricaoLote;
    }

    /**
     * Set percentualDescontoLote
     *
     * @param integer $percentualDescontoLote
     * @return LoteRegistroPrecos
     */
    public function setPercentualDescontoLote($percentualDescontoLote = null)
    {
        $this->percentualDescontoLote = $percentualDescontoLote;
        return $this;
    }

    /**
     * Get percentualDescontoLote
     *
     * @return integer
     */
    public function getPercentualDescontoLote()
    {
        return $this->percentualDescontoLote;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgItemRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos $fkTcemgItemRegistroPrecos
     * @return LoteRegistroPrecos
     */
    public function addFkTcemgItemRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos $fkTcemgItemRegistroPrecos)
    {
        if (false === $this->fkTcemgItemRegistroPrecos->contains($fkTcemgItemRegistroPrecos)) {
            $fkTcemgItemRegistroPrecos->setFkTcemgLoteRegistroPrecos($this);
            $this->fkTcemgItemRegistroPrecos->add($fkTcemgItemRegistroPrecos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgItemRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos $fkTcemgItemRegistroPrecos
     */
    public function removeFkTcemgItemRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos $fkTcemgItemRegistroPrecos)
    {
        $this->fkTcemgItemRegistroPrecos->removeElement($fkTcemgItemRegistroPrecos);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgItemRegistroPrecos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos
     */
    public function getFkTcemgItemRegistroPrecos()
    {
        return $this->fkTcemgItemRegistroPrecos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos $fkTcemgRegistroPrecos
     * @return LoteRegistroPrecos
     */
    public function setFkTcemgRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos $fkTcemgRegistroPrecos)
    {
        $this->codEntidade = $fkTcemgRegistroPrecos->getCodEntidade();
        $this->numeroRegistroPrecos = $fkTcemgRegistroPrecos->getNumeroRegistroPrecos();
        $this->exercicio = $fkTcemgRegistroPrecos->getExercicio();
        $this->numcgmGerenciador = $fkTcemgRegistroPrecos->getNumcgmGerenciador();
        $this->interno = $fkTcemgRegistroPrecos->getInterno();
        $this->fkTcemgRegistroPrecos = $fkTcemgRegistroPrecos;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgRegistroPrecos
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos
     */
    public function getFkTcemgRegistroPrecos()
    {
        return $this->fkTcemgRegistroPrecos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->codLote, $this->exercicio);
    }
}
