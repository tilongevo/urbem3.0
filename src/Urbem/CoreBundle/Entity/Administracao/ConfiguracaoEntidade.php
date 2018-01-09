<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * ConfiguracaoEntidade
 */
class ConfiguracaoEntidade
{
    const PARAMETRO_TCE_MG_CODIGO_ORGAO_ENTIDADE_SICOM = 'tcemg_codigo_orgao_entidade_sicom';
    const PARAMETRO_TCE_MG_TIPO_ORGAO_ENTIDADE_SICOM = 'tcemg_tipo_orgao_entidade_sicom';

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
    private $codModulo;

    /**
     * PK
     * @var string
     */
    private $parametro;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    private $fkAdministracaoModulo;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoEntidade
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
     * @return ConfiguracaoEntidade
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return ConfiguracaoEntidade
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set parametro
     *
     * @param string $parametro
     * @return ConfiguracaoEntidade
     */
    public function setParametro($parametro)
    {
        $this->parametro = $parametro;
        return $this;
    }

    /**
     * Get parametro
     *
     * @return string
     */
    public function getParametro()
    {
        return $this->parametro;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return ConfiguracaoEntidade
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return ConfiguracaoEntidade
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
     * Set fkAdministracaoModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo
     * @return ConfiguracaoEntidade
     */
    public function setFkAdministracaoModulo(\Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo)
    {
        $this->codModulo = $fkAdministracaoModulo->getCodModulo();
        $this->fkAdministracaoModulo = $fkAdministracaoModulo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModulo
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    public function getFkAdministracaoModulo()
    {
        return $this->fkAdministracaoModulo;
    }


    public function __toString()
    {
        return (string) "Configuração da Entidade";
    }
}
