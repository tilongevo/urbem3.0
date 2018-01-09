<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * AtributoGrupoValor
 */
class AtributoGrupoValor
{
    /**
     * PK
     * @var integer
     */
    private $codCalculo;

    /**
     * PK
     * @var integer
     */
    private $codGrupo;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    private $fkArrecadacaoCalculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupo
     */
    private $fkArrecadacaoAtributoGrupo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codCalculo
     *
     * @param integer $codCalculo
     * @return AtributoGrupoValor
     */
    public function setCodCalculo($codCalculo)
    {
        $this->codCalculo = $codCalculo;
        return $this;
    }

    /**
     * Get codCalculo
     *
     * @return integer
     */
    public function getCodCalculo()
    {
        return $this->codCalculo;
    }

    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return AtributoGrupoValor
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
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoGrupoValor
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
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoGrupoValor
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return AtributoGrupoValor
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return AtributoGrupoValor
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoGrupoValor
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
     * Set valor
     *
     * @param string $valor
     * @return AtributoGrupoValor
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
     * Set fkArrecadacaoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo
     * @return AtributoGrupoValor
     */
    public function setFkArrecadacaoCalculo(\Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo)
    {
        $this->codCalculo = $fkArrecadacaoCalculo->getCodCalculo();
        $this->fkArrecadacaoCalculo = $fkArrecadacaoCalculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoCalculo
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    public function getFkArrecadacaoCalculo()
    {
        return $this->fkArrecadacaoCalculo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoAtributoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupo $fkArrecadacaoAtributoGrupo
     * @return AtributoGrupoValor
     */
    public function setFkArrecadacaoAtributoGrupo(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupo $fkArrecadacaoAtributoGrupo)
    {
        $this->codModulo = $fkArrecadacaoAtributoGrupo->getCodModulo();
        $this->codGrupo = $fkArrecadacaoAtributoGrupo->getCodGrupo();
        $this->codCadastro = $fkArrecadacaoAtributoGrupo->getCodCadastro();
        $this->codAtributo = $fkArrecadacaoAtributoGrupo->getCodAtributo();
        $this->anoExercicio = $fkArrecadacaoAtributoGrupo->getAnoExercicio();
        $this->fkArrecadacaoAtributoGrupo = $fkArrecadacaoAtributoGrupo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoAtributoGrupo
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupo
     */
    public function getFkArrecadacaoAtributoGrupo()
    {
        return $this->fkArrecadacaoAtributoGrupo;
    }
}
