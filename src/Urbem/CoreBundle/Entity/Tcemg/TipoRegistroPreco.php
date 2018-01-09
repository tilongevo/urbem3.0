<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * TipoRegistroPreco
 */
class TipoRegistroPreco
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $codTipoDecreto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\TipoDecreto
     */
    private $fkTcemgTipoDecreto;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TipoRegistroPreco
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return TipoRegistroPreco
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
     * Set codNorma
     *
     * @param integer $codNorma
     * @return TipoRegistroPreco
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set codTipoDecreto
     *
     * @param integer $codTipoDecreto
     * @return TipoRegistroPreco
     */
    public function setCodTipoDecreto($codTipoDecreto = null)
    {
        $this->codTipoDecreto = $codTipoDecreto;
        return $this;
    }

    /**
     * Get codTipoDecreto
     *
     * @return integer
     */
    public function getCodTipoDecreto()
    {
        return $this->codTipoDecreto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return TipoRegistroPreco
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return TipoRegistroPreco
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgTipoDecreto
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoDecreto $fkTcemgTipoDecreto
     * @return TipoRegistroPreco
     */
    public function setFkTcemgTipoDecreto(\Urbem\CoreBundle\Entity\Tcemg\TipoDecreto $fkTcemgTipoDecreto)
    {
        $this->codTipoDecreto = $fkTcemgTipoDecreto->getCodTipoDecreto();
        $this->fkTcemgTipoDecreto = $fkTcemgTipoDecreto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgTipoDecreto
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\TipoDecreto
     */
    public function getFkTcemgTipoDecreto()
    {
        return $this->fkTcemgTipoDecreto;
    }
}
