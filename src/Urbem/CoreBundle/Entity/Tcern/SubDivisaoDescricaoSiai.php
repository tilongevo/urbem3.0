<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * SubDivisaoDescricaoSiai
 */
class SubDivisaoDescricaoSiai
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
    private $codSubDivisao;

    /**
     * PK
     * @var integer
     */
    private $codSiai;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    private $fkPessoalSubDivisao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcern\DescricaoSiai
     */
    private $fkTcernDescricaoSiai;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SubDivisaoDescricaoSiai
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
     * @return SubDivisaoDescricaoSiai
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
     * Set codSubDivisao
     *
     * @param integer $codSubDivisao
     * @return SubDivisaoDescricaoSiai
     */
    public function setCodSubDivisao($codSubDivisao)
    {
        $this->codSubDivisao = $codSubDivisao;
        return $this;
    }

    /**
     * Get codSubDivisao
     *
     * @return integer
     */
    public function getCodSubDivisao()
    {
        return $this->codSubDivisao;
    }

    /**
     * Set codSiai
     *
     * @param integer $codSiai
     * @return SubDivisaoDescricaoSiai
     */
    public function setCodSiai($codSiai)
    {
        $this->codSiai = $codSiai;
        return $this;
    }

    /**
     * Get codSiai
     *
     * @return integer
     */
    public function getCodSiai()
    {
        return $this->codSiai;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return SubDivisaoDescricaoSiai
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
     * Set fkPessoalSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao
     * @return SubDivisaoDescricaoSiai
     */
    public function setFkPessoalSubDivisao(\Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao)
    {
        $this->codSubDivisao = $fkPessoalSubDivisao->getCodSubDivisao();
        $this->fkPessoalSubDivisao = $fkPessoalSubDivisao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalSubDivisao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    public function getFkPessoalSubDivisao()
    {
        return $this->fkPessoalSubDivisao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcernDescricaoSiai
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\DescricaoSiai $fkTcernDescricaoSiai
     * @return SubDivisaoDescricaoSiai
     */
    public function setFkTcernDescricaoSiai(\Urbem\CoreBundle\Entity\Tcern\DescricaoSiai $fkTcernDescricaoSiai)
    {
        $this->codSiai = $fkTcernDescricaoSiai->getCodSiai();
        $this->fkTcernDescricaoSiai = $fkTcernDescricaoSiai;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcernDescricaoSiai
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\DescricaoSiai
     */
    public function getFkTcernDescricaoSiai()
    {
        return $this->fkTcernDescricaoSiai;
    }
}
