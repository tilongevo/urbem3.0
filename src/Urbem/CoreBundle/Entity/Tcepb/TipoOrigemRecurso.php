<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

/**
 * TipoOrigemRecurso
 */
class TipoOrigemRecurso
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\PagamentoOrigemRecursosInterna
     */
    private $fkTcepbPagamentoOrigemRecursosInternas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\RelacaoContaCorrenteFontePagadora
     */
    private $fkTcepbRelacaoContaCorrenteFontePagadoras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\Recurso
     */
    private $fkTcepbRecursos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepbPagamentoOrigemRecursosInternas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepbRelacaoContaCorrenteFontePagadoras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepbRecursos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoOrigemRecurso
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TipoOrigemRecurso
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
     * Set descricao
     *
     * @param string $descricao
     * @return TipoOrigemRecurso
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
     * Add TcepbPagamentoOrigemRecursosInterna
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\PagamentoOrigemRecursosInterna $fkTcepbPagamentoOrigemRecursosInterna
     * @return TipoOrigemRecurso
     */
    public function addFkTcepbPagamentoOrigemRecursosInternas(\Urbem\CoreBundle\Entity\Tcepb\PagamentoOrigemRecursosInterna $fkTcepbPagamentoOrigemRecursosInterna)
    {
        if (false === $this->fkTcepbPagamentoOrigemRecursosInternas->contains($fkTcepbPagamentoOrigemRecursosInterna)) {
            $fkTcepbPagamentoOrigemRecursosInterna->setFkTcepbTipoOrigemRecurso($this);
            $this->fkTcepbPagamentoOrigemRecursosInternas->add($fkTcepbPagamentoOrigemRecursosInterna);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepbPagamentoOrigemRecursosInterna
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\PagamentoOrigemRecursosInterna $fkTcepbPagamentoOrigemRecursosInterna
     */
    public function removeFkTcepbPagamentoOrigemRecursosInternas(\Urbem\CoreBundle\Entity\Tcepb\PagamentoOrigemRecursosInterna $fkTcepbPagamentoOrigemRecursosInterna)
    {
        $this->fkTcepbPagamentoOrigemRecursosInternas->removeElement($fkTcepbPagamentoOrigemRecursosInterna);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepbPagamentoOrigemRecursosInternas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\PagamentoOrigemRecursosInterna
     */
    public function getFkTcepbPagamentoOrigemRecursosInternas()
    {
        return $this->fkTcepbPagamentoOrigemRecursosInternas;
    }

    /**
     * OneToMany (owning side)
     * Add TcepbRelacaoContaCorrenteFontePagadora
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\RelacaoContaCorrenteFontePagadora $fkTcepbRelacaoContaCorrenteFontePagadora
     * @return TipoOrigemRecurso
     */
    public function addFkTcepbRelacaoContaCorrenteFontePagadoras(\Urbem\CoreBundle\Entity\Tcepb\RelacaoContaCorrenteFontePagadora $fkTcepbRelacaoContaCorrenteFontePagadora)
    {
        if (false === $this->fkTcepbRelacaoContaCorrenteFontePagadoras->contains($fkTcepbRelacaoContaCorrenteFontePagadora)) {
            $fkTcepbRelacaoContaCorrenteFontePagadora->setFkTcepbTipoOrigemRecurso($this);
            $this->fkTcepbRelacaoContaCorrenteFontePagadoras->add($fkTcepbRelacaoContaCorrenteFontePagadora);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepbRelacaoContaCorrenteFontePagadora
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\RelacaoContaCorrenteFontePagadora $fkTcepbRelacaoContaCorrenteFontePagadora
     */
    public function removeFkTcepbRelacaoContaCorrenteFontePagadoras(\Urbem\CoreBundle\Entity\Tcepb\RelacaoContaCorrenteFontePagadora $fkTcepbRelacaoContaCorrenteFontePagadora)
    {
        $this->fkTcepbRelacaoContaCorrenteFontePagadoras->removeElement($fkTcepbRelacaoContaCorrenteFontePagadora);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepbRelacaoContaCorrenteFontePagadoras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\RelacaoContaCorrenteFontePagadora
     */
    public function getFkTcepbRelacaoContaCorrenteFontePagadoras()
    {
        return $this->fkTcepbRelacaoContaCorrenteFontePagadoras;
    }

    /**
     * OneToMany (owning side)
     * Add TcepbRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\Recurso $fkTcepbRecurso
     * @return TipoOrigemRecurso
     */
    public function addFkTcepbRecursos(\Urbem\CoreBundle\Entity\Tcepb\Recurso $fkTcepbRecurso)
    {
        if (false === $this->fkTcepbRecursos->contains($fkTcepbRecurso)) {
            $fkTcepbRecurso->setFkTcepbTipoOrigemRecurso($this);
            $this->fkTcepbRecursos->add($fkTcepbRecurso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepbRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\Recurso $fkTcepbRecurso
     */
    public function removeFkTcepbRecursos(\Urbem\CoreBundle\Entity\Tcepb\Recurso $fkTcepbRecurso)
    {
        $this->fkTcepbRecursos->removeElement($fkTcepbRecurso);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepbRecursos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\Recurso
     */
    public function getFkTcepbRecursos()
    {
        return $this->fkTcepbRecursos;
    }
}
