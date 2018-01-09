<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * BemAtributoEspecie
 */
class BemAtributoEspecie
{
    /**
     * PK
     * @var integer
     */
    private $codBem;

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
    private $codEspecie;

    /**
     * PK
     * @var integer
     */
    private $codGrupo;

    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    private $fkPatrimonioBem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo
     */
    private $fkPatrimonioEspecieAtributo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return BemAtributoEspecie
     */
    public function setCodBem($codBem)
    {
        $this->codBem = $codBem;
        return $this;
    }

    /**
     * Get codBem
     *
     * @return integer
     */
    public function getCodBem()
    {
        return $this->codBem;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return BemAtributoEspecie
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
     * @return BemAtributoEspecie
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
     * @return BemAtributoEspecie
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
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return BemAtributoEspecie
     */
    public function setCodEspecie($codEspecie)
    {
        $this->codEspecie = $codEspecie;
        return $this;
    }

    /**
     * Get codEspecie
     *
     * @return integer
     */
    public function getCodEspecie()
    {
        return $this->codEspecie;
    }

    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return BemAtributoEspecie
     */
    public function setCodGrupo($codGrupo)
    {
        $this->codGrupo = $codGrupo;
        return $this;
    }

    /**
     * Get codGrupo
     *
     * @return integer
     */
    public function getCodGrupo()
    {
        return $this->codGrupo;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return BemAtributoEspecie
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return BemAtributoEspecie
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return BemAtributoEspecie
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
     * Set fkPatrimonioBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem
     * @return BemAtributoEspecie
     */
    public function setFkPatrimonioBem(\Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem)
    {
        $this->codBem = $fkPatrimonioBem->getCodBem();
        $this->fkPatrimonioBem = $fkPatrimonioBem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioBem
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    public function getFkPatrimonioBem()
    {
        return $this->fkPatrimonioBem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioEspecieAtributo
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo $fkPatrimonioEspecieAtributo
     * @return BemAtributoEspecie
     */
    public function setFkPatrimonioEspecieAtributo(\Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo $fkPatrimonioEspecieAtributo)
    {
        $this->codModulo = $fkPatrimonioEspecieAtributo->getCodModulo();
        $this->codCadastro = $fkPatrimonioEspecieAtributo->getCodCadastro();
        $this->codAtributo = $fkPatrimonioEspecieAtributo->getCodAtributo();
        $this->codEspecie = $fkPatrimonioEspecieAtributo->getCodEspecie();
        $this->codNatureza = $fkPatrimonioEspecieAtributo->getCodNatureza();
        $this->codGrupo = $fkPatrimonioEspecieAtributo->getCodGrupo();
        $this->fkPatrimonioEspecieAtributo = $fkPatrimonioEspecieAtributo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioEspecieAtributo
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo
     */
    public function getFkPatrimonioEspecieAtributo()
    {
        return $this->fkPatrimonioEspecieAtributo;
    }
}
