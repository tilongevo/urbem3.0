<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * LimiteAlteracaoCredito
 */
class LimiteAlteracaoCredito
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
     * PK
     * @var integer
     */
    private $codTipoAlteracao;

    /**
     * @var integer
     */
    private $valorAlteracao;

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
     * @var \Urbem\CoreBundle\Entity\Tcmba\TipoAlteracaoOrcamentaria
     */
    private $fkTcmbaTipoAlteracaoOrcamentaria;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return LimiteAlteracaoCredito
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
     * @return LimiteAlteracaoCredito
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
     * @return LimiteAlteracaoCredito
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
     * Set codTipoAlteracao
     *
     * @param integer $codTipoAlteracao
     * @return LimiteAlteracaoCredito
     */
    public function setCodTipoAlteracao($codTipoAlteracao)
    {
        $this->codTipoAlteracao = $codTipoAlteracao;
        return $this;
    }

    /**
     * Get codTipoAlteracao
     *
     * @return integer
     */
    public function getCodTipoAlteracao()
    {
        return $this->codTipoAlteracao;
    }

    /**
     * Set valorAlteracao
     *
     * @param integer $valorAlteracao
     * @return LimiteAlteracaoCredito
     */
    public function setValorAlteracao($valorAlteracao)
    {
        $this->valorAlteracao = $valorAlteracao;
        return $this;
    }

    /**
     * Get valorAlteracao
     *
     * @return integer
     */
    public function getValorAlteracao()
    {
        return $this->valorAlteracao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return LimiteAlteracaoCredito
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
     * @return LimiteAlteracaoCredito
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
     * Set fkTcmbaTipoAlteracaoOrcamentaria
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoAlteracaoOrcamentaria $fkTcmbaTipoAlteracaoOrcamentaria
     * @return LimiteAlteracaoCredito
     */
    public function setFkTcmbaTipoAlteracaoOrcamentaria(\Urbem\CoreBundle\Entity\Tcmba\TipoAlteracaoOrcamentaria $fkTcmbaTipoAlteracaoOrcamentaria)
    {
        $this->codTipoAlteracao = $fkTcmbaTipoAlteracaoOrcamentaria->getCodTipo();
        $this->fkTcmbaTipoAlteracaoOrcamentaria = $fkTcmbaTipoAlteracaoOrcamentaria;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaTipoAlteracaoOrcamentaria
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TipoAlteracaoOrcamentaria
     */
    public function getFkTcmbaTipoAlteracaoOrcamentaria()
    {
        return $this->fkTcmbaTipoAlteracaoOrcamentaria;
    }
}
