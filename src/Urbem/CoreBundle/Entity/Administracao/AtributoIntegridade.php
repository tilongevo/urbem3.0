<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * AtributoIntegridade
 */
class AtributoIntegridade
{
    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * PK
     * @var integer
     */
    private $codIntegridade;

    /**
     * @var string
     */
    private $regra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\RestricaoIntegridade
     */
    private $fkAdministracaoRestricaoIntegridade;


    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoIntegridade
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
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoIntegridade
     */
    public function setCodCadastro($codCadastro)
    {
        $this->codCadastro = $codCadastro;
        return $this;
    }

    /**
     * Get codCadastro
     *
     * @return integer
     */
    public function getCodCadastro()
    {
        return $this->codCadastro;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoIntegridade
     */
    public function setCodAtributo($codAtributo)
    {
        $this->codAtributo = $codAtributo;
        return $this;
    }

    /**
     * Get codAtributo
     *
     * @return integer
     */
    public function getCodAtributo()
    {
        return $this->codAtributo;
    }

    /**
     * Set codIntegridade
     *
     * @param integer $codIntegridade
     * @return AtributoIntegridade
     */
    public function setCodIntegridade($codIntegridade)
    {
        $this->codIntegridade = $codIntegridade;
        return $this;
    }

    /**
     * Get codIntegridade
     *
     * @return integer
     */
    public function getCodIntegridade()
    {
        return $this->codIntegridade;
    }

    /**
     * Set regra
     *
     * @param string $regra
     * @return AtributoIntegridade
     */
    public function setRegra($regra = null)
    {
        $this->regra = $regra;
        return $this;
    }

    /**
     * Get regra
     *
     * @return string
     */
    public function getRegra()
    {
        return $this->regra;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoIntegridade
     */
    public function setFkAdministracaoAtributoDinamico(\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico)
    {
        $this->codModulo = $fkAdministracaoAtributoDinamico->getCodModulo();
        $this->codCadastro = $fkAdministracaoAtributoDinamico->getCodCadastro();
        $this->codAtributo = $fkAdministracaoAtributoDinamico->getCodAtributo();
        $this->fkAdministracaoAtributoDinamico = $fkAdministracaoAtributoDinamico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoAtributoDinamico
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    public function getFkAdministracaoAtributoDinamico()
    {
        return $this->fkAdministracaoAtributoDinamico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoRestricaoIntegridade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\RestricaoIntegridade $fkAdministracaoRestricaoIntegridade
     * @return AtributoIntegridade
     */
    public function setFkAdministracaoRestricaoIntegridade(\Urbem\CoreBundle\Entity\Administracao\RestricaoIntegridade $fkAdministracaoRestricaoIntegridade)
    {
        $this->codIntegridade = $fkAdministracaoRestricaoIntegridade->getCodIntegridade();
        $this->fkAdministracaoRestricaoIntegridade = $fkAdministracaoRestricaoIntegridade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoRestricaoIntegridade
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\RestricaoIntegridade
     */
    public function getFkAdministracaoRestricaoIntegridade()
    {
        return $this->fkAdministracaoRestricaoIntegridade;
    }
}
