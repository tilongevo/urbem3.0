<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Configuracao
 */
class Configuracao
{
    const PARAMETRO_DATA_IMPLANTACAO = 'data_implantacao';
    const PARAMETRO_ENTIDADE_GESTAO_EXERCICIO = 'entidade_gestao_exercicio';
    const PARAMETRO_ENTIDADE_GESTAO_COD_ENTIDADE = 'entidade_gestao_cod_entidade';
    const PARAMETRO_ID_ENTIDADE_TCE = 'id_entidade_tce';

    /**
     * PK
     * @var string
     */
    private $exercicio;

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
     * @var \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    private $fkAdministracaoModulo;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Configuracao
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return Configuracao
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
     * @return Configuracao
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
     * @return Configuracao
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
     * Set fkAdministracaoModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo
     * @return Configuracao
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
}
