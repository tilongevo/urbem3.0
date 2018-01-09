<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * CodigoFonteRecurso
 */
class CodigoFonteRecurso
{
    /**
     * PK
     * @var integer
     */
    private $codRecurso;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codFonte;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    private $fkOrcamentoRecurso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepe\CodigoFonteTce
     */
    private $fkTcepeCodigoFonteTce;


    /**
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return CodigoFonteRecurso
     */
    public function setCodRecurso($codRecurso)
    {
        $this->codRecurso = $codRecurso;
        return $this;
    }

    /**
     * Get codRecurso
     *
     * @return integer
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return CodigoFonteRecurso
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
     * Set codFonte
     *
     * @param integer $codFonte
     * @return CodigoFonteRecurso
     */
    public function setCodFonte($codFonte)
    {
        $this->codFonte = $codFonte;
        return $this;
    }

    /**
     * Get codFonte
     *
     * @return integer
     */
    public function getCodFonte()
    {
        return $this->codFonte;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepeCodigoFonteTce
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\CodigoFonteTce $fkTcepeCodigoFonteTce
     * @return CodigoFonteRecurso
     */
    public function setFkTcepeCodigoFonteTce(\Urbem\CoreBundle\Entity\Tcepe\CodigoFonteTce $fkTcepeCodigoFonteTce)
    {
        $this->codFonte = $fkTcepeCodigoFonteTce->getCodFonte();
        $this->fkTcepeCodigoFonteTce = $fkTcepeCodigoFonteTce;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepeCodigoFonteTce
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\CodigoFonteTce
     */
    public function getFkTcepeCodigoFonteTce()
    {
        return $this->fkTcepeCodigoFonteTce;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso
     * @return CodigoFonteRecurso
     */
    public function setFkOrcamentoRecurso(\Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso)
    {
        $this->exercicio = $fkOrcamentoRecurso->getExercicio();
        $this->codRecurso = $fkOrcamentoRecurso->getCodRecurso();
        $this->fkOrcamentoRecurso = $fkOrcamentoRecurso;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    public function getFkOrcamentoRecurso()
    {
        return $this->fkOrcamentoRecurso;
    }
}
