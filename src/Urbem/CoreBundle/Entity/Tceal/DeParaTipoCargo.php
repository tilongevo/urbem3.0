<?php
 
namespace Urbem\CoreBundle\Entity\Tceal;

/**
 * DeParaTipoCargo
 */
class DeParaTipoCargo
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codSubDivisao;

    /**
     * @var integer
     */
    private $codTipoCargoTce;

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
     * @var \Urbem\CoreBundle\Entity\Tceal\TipoCargo
     */
    private $fkTcealTipoCargo;


    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return DeParaTipoCargo
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return DeParaTipoCargo
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
     * Set codSubDivisao
     *
     * @param integer $codSubDivisao
     * @return DeParaTipoCargo
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
     * Set codTipoCargoTce
     *
     * @param integer $codTipoCargoTce
     * @return DeParaTipoCargo
     */
    public function setCodTipoCargoTce($codTipoCargoTce)
    {
        $this->codTipoCargoTce = $codTipoCargoTce;
        return $this;
    }

    /**
     * Get codTipoCargoTce
     *
     * @return integer
     */
    public function getCodTipoCargoTce()
    {
        return $this->codTipoCargoTce;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return DeParaTipoCargo
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
     * @return DeParaTipoCargo
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
     * Set fkTcealTipoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\TipoCargo $fkTcealTipoCargo
     * @return DeParaTipoCargo
     */
    public function setFkTcealTipoCargo(\Urbem\CoreBundle\Entity\Tceal\TipoCargo $fkTcealTipoCargo)
    {
        $this->codTipoCargoTce = $fkTcealTipoCargo->getCodTipoCargo();
        $this->fkTcealTipoCargo = $fkTcealTipoCargo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcealTipoCargo
     *
     * @return \Urbem\CoreBundle\Entity\Tceal\TipoCargo
     */
    public function getFkTcealTipoCargo()
    {
        return $this->fkTcealTipoCargo;
    }
}
