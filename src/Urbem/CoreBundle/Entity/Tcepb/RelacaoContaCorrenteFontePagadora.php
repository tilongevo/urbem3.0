<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

/**
 * RelacaoContaCorrenteFontePagadora
 */
class RelacaoContaCorrenteFontePagadora
{
    /**
     * PK
     * @var integer
     */
    private $codBanco;

    /**
     * PK
     * @var integer
     */
    private $codAgencia;

    /**
     * PK
     * @var integer
     */
    private $codContaCorrente;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\ContaCorrente
     */
    private $fkMonetarioContaCorrente;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepb\TipoOrigemRecurso
     */
    private $fkTcepbTipoOrigemRecurso;


    /**
     * Set codBanco
     *
     * @param integer $codBanco
     * @return RelacaoContaCorrenteFontePagadora
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;
        return $this;
    }

    /**
     * Get codBanco
     *
     * @return integer
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return RelacaoContaCorrenteFontePagadora
     */
    public function setCodAgencia($codAgencia)
    {
        $this->codAgencia = $codAgencia;
        return $this;
    }

    /**
     * Get codAgencia
     *
     * @return integer
     */
    public function getCodAgencia()
    {
        return $this->codAgencia;
    }

    /**
     * Set codContaCorrente
     *
     * @param integer $codContaCorrente
     * @return RelacaoContaCorrenteFontePagadora
     */
    public function setCodContaCorrente($codContaCorrente)
    {
        $this->codContaCorrente = $codContaCorrente;
        return $this;
    }

    /**
     * Get codContaCorrente
     *
     * @return integer
     */
    public function getCodContaCorrente()
    {
        return $this->codContaCorrente;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return RelacaoContaCorrenteFontePagadora
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
     * @return RelacaoContaCorrenteFontePagadora
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
     * ManyToOne (inverse side)
     * Set fkMonetarioContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente
     * @return RelacaoContaCorrenteFontePagadora
     */
    public function setFkMonetarioContaCorrente(\Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente)
    {
        $this->codBanco = $fkMonetarioContaCorrente->getCodBanco();
        $this->codAgencia = $fkMonetarioContaCorrente->getCodAgencia();
        $this->codContaCorrente = $fkMonetarioContaCorrente->getCodContaCorrente();
        $this->fkMonetarioContaCorrente = $fkMonetarioContaCorrente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioContaCorrente
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\ContaCorrente
     */
    public function getFkMonetarioContaCorrente()
    {
        return $this->fkMonetarioContaCorrente;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepbTipoOrigemRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\TipoOrigemRecurso $fkTcepbTipoOrigemRecurso
     * @return RelacaoContaCorrenteFontePagadora
     */
    public function setFkTcepbTipoOrigemRecurso(\Urbem\CoreBundle\Entity\Tcepb\TipoOrigemRecurso $fkTcepbTipoOrigemRecurso)
    {
        $this->codTipo = $fkTcepbTipoOrigemRecurso->getCodTipo();
        $this->exercicio = $fkTcepbTipoOrigemRecurso->getExercicio();
        $this->fkTcepbTipoOrigemRecurso = $fkTcepbTipoOrigemRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepbTipoOrigemRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\TipoOrigemRecurso
     */
    public function getFkTcepbTipoOrigemRecurso()
    {
        return $this->fkTcepbTipoOrigemRecurso;
    }
}
