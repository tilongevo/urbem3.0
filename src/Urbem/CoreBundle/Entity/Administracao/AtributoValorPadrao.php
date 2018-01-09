<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * AtributoValorPadrao
 */
class AtributoValorPadrao
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
    private $codValor;

    /**
     * @var boolean
     */
    private $ativo;

    /**
     * @var string
     */
    private $valorPadrao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;


    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoValorPadrao
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
     * @return AtributoValorPadrao
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
     * @return AtributoValorPadrao
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
     * Set codValor
     *
     * @param integer $codValor
     * @return AtributoValorPadrao
     */
    public function setCodValor($codValor)
    {
        $this->codValor = $codValor;
        return $this;
    }

    /**
     * Get codValor
     *
     * @return integer
     */
    public function getCodValor()
    {
        return $this->codValor;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return AtributoValorPadrao
     */
    public function setAtivo($ativo = null)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * Set valorPadrao
     *
     * @param string $valorPadrao
     * @return AtributoValorPadrao
     */
    public function setValorPadrao($valorPadrao = null)
    {
        $this->valorPadrao = $valorPadrao;
        return $this;
    }

    /**
     * Get valorPadrao
     *
     * @return string
     */
    public function getValorPadrao()
    {
        return $this->valorPadrao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoValorPadrao
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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getValorPadrao();
    }
}
