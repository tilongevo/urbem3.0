<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * FonteRecursoLocal
 */
class FonteRecursoLocal
{
    /**
     * PK
     * @var integer
     */
    private $codFonte;

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
    private $codLocal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepe\FonteRecurso
     */
    private $fkTcepeFonteRecurso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Local
     */
    private $fkOrganogramaLocal;


    /**
     * Set codFonte
     *
     * @param integer $codFonte
     * @return FonteRecursoLocal
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return FonteRecursoLocal
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
     * @return FonteRecursoLocal
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
     * Set codLocal
     *
     * @param integer $codLocal
     * @return FonteRecursoLocal
     */
    public function setCodLocal($codLocal)
    {
        $this->codLocal = $codLocal;
        return $this;
    }

    /**
     * Get codLocal
     *
     * @return integer
     */
    public function getCodLocal()
    {
        return $this->codLocal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepeFonteRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\FonteRecurso $fkTcepeFonteRecurso
     * @return FonteRecursoLocal
     */
    public function setFkTcepeFonteRecurso(\Urbem\CoreBundle\Entity\Tcepe\FonteRecurso $fkTcepeFonteRecurso)
    {
        $this->codFonte = $fkTcepeFonteRecurso->getCodFonte();
        $this->fkTcepeFonteRecurso = $fkTcepeFonteRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepeFonteRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\FonteRecurso
     */
    public function getFkTcepeFonteRecurso()
    {
        return $this->fkTcepeFonteRecurso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return FonteRecursoLocal
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
     * Set fkOrganogramaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal
     * @return FonteRecursoLocal
     */
    public function setFkOrganogramaLocal(\Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal)
    {
        $this->codLocal = $fkOrganogramaLocal->getCodLocal();
        $this->fkOrganogramaLocal = $fkOrganogramaLocal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaLocal
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Local
     */
    public function getFkOrganogramaLocal()
    {
        return $this->fkOrganogramaLocal;
    }
}
