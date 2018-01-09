<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwAtributoIntegridade
 */
class SwAtributoIntegridade
{
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
    private $regra = 't';

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwAtributoDinamico
     */
    private $fkSwAtributoDinamico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\RestricaoIntegridade
     */
    private $fkAdministracaoRestricaoIntegridade;


    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return SwAtributoIntegridade
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
     * @return SwAtributoIntegridade
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
     * @return SwAtributoIntegridade
     */
    public function setRegra($regra)
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
     * Set fkSwAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoDinamico $fkSwAtributoDinamico
     * @return SwAtributoIntegridade
     */
    public function setFkSwAtributoDinamico(\Urbem\CoreBundle\Entity\SwAtributoDinamico $fkSwAtributoDinamico)
    {
        $this->codAtributo = $fkSwAtributoDinamico->getCodAtributo();
        $this->fkSwAtributoDinamico = $fkSwAtributoDinamico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwAtributoDinamico
     *
     * @return \Urbem\CoreBundle\Entity\SwAtributoDinamico
     */
    public function getFkSwAtributoDinamico()
    {
        return $this->fkSwAtributoDinamico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoRestricaoIntegridade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\RestricaoIntegridade $fkAdministracaoRestricaoIntegridade
     * @return SwAtributoIntegridade
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
