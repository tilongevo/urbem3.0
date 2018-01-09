<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * FonteRecursoLotacao
 */
class FonteRecursoLotacao
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
    private $codOrgao;

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
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;


    /**
     * Set codFonte
     *
     * @param integer $codFonte
     * @return FonteRecursoLotacao
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
     * @return FonteRecursoLotacao
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
     * @return FonteRecursoLotacao
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
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return FonteRecursoLotacao
     */
    public function setCodOrgao($codOrgao)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepeFonteRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\FonteRecurso $fkTcepeFonteRecurso
     * @return FonteRecursoLotacao
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
     * @return FonteRecursoLotacao
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
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return FonteRecursoLotacao
     */
    public function setFkOrganogramaOrgao(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        $this->codOrgao = $fkOrganogramaOrgao->getCodOrgao();
        $this->fkOrganogramaOrgao = $fkOrganogramaOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    public function getFkOrganogramaOrgao()
    {
        return $this->fkOrganogramaOrgao;
    }
}
