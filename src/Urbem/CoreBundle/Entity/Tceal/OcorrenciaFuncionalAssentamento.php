<?php
 
namespace Urbem\CoreBundle\Entity\Tceal;

/**
 * OcorrenciaFuncionalAssentamento
 */
class OcorrenciaFuncionalAssentamento
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
    private $codOcorrencia;

    /**
     * PK
     * @var integer
     */
    private $codAssentamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncional
     */
    private $fkTcealOcorrenciaFuncional;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    private $fkPessoalAssentamentoAssentamento;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return OcorrenciaFuncionalAssentamento
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
     * @return OcorrenciaFuncionalAssentamento
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
     * Set codOcorrencia
     *
     * @param integer $codOcorrencia
     * @return OcorrenciaFuncionalAssentamento
     */
    public function setCodOcorrencia($codOcorrencia)
    {
        $this->codOcorrencia = $codOcorrencia;
        return $this;
    }

    /**
     * Get codOcorrencia
     *
     * @return integer
     */
    public function getCodOcorrencia()
    {
        return $this->codOcorrencia;
    }

    /**
     * Set codAssentamento
     *
     * @param integer $codAssentamento
     * @return OcorrenciaFuncionalAssentamento
     */
    public function setCodAssentamento($codAssentamento)
    {
        $this->codAssentamento = $codAssentamento;
        return $this;
    }

    /**
     * Get codAssentamento
     *
     * @return integer
     */
    public function getCodAssentamento()
    {
        return $this->codAssentamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return OcorrenciaFuncionalAssentamento
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
     * Set fkTcealOcorrenciaFuncional
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncional $fkTcealOcorrenciaFuncional
     * @return OcorrenciaFuncionalAssentamento
     */
    public function setFkTcealOcorrenciaFuncional(\Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncional $fkTcealOcorrenciaFuncional)
    {
        $this->codOcorrencia = $fkTcealOcorrenciaFuncional->getCodOcorrencia();
        $this->exercicio = $fkTcealOcorrenciaFuncional->getExercicio();
        $this->fkTcealOcorrenciaFuncional = $fkTcealOcorrenciaFuncional;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcealOcorrenciaFuncional
     *
     * @return \Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncional
     */
    public function getFkTcealOcorrenciaFuncional()
    {
        return $this->fkTcealOcorrenciaFuncional;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalAssentamentoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento
     * @return OcorrenciaFuncionalAssentamento
     */
    public function setFkPessoalAssentamentoAssentamento(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento)
    {
        $this->codAssentamento = $fkPessoalAssentamentoAssentamento->getCodAssentamento();
        $this->fkPessoalAssentamentoAssentamento = $fkPessoalAssentamentoAssentamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalAssentamentoAssentamento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    public function getFkPessoalAssentamentoAssentamento()
    {
        return $this->fkPessoalAssentamentoAssentamento;
    }
}
