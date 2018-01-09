<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * AtributoDesoneracaoValor
 */
class AtributoDesoneracaoValor
{
    /**
     * PK
     * @var integer
     */
    private $codDesoneracao;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

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
     * @var integer
     */
    private $ocorrencia;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracao
     */
    private $fkArrecadacaoAtributoDesoneracao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Desonerado
     */
    private $fkArrecadacaoDesonerado;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codDesoneracao
     *
     * @param integer $codDesoneracao
     * @return AtributoDesoneracaoValor
     */
    public function setCodDesoneracao($codDesoneracao)
    {
        $this->codDesoneracao = $codDesoneracao;
        return $this;
    }

    /**
     * Get codDesoneracao
     *
     * @return integer
     */
    public function getCodDesoneracao()
    {
        return $this->codDesoneracao;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return AtributoDesoneracaoValor
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoDesoneracaoValor
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
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoDesoneracaoValor
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
     * @return AtributoDesoneracaoValor
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
     * @return AtributoDesoneracaoValor
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
     * Set ocorrencia
     *
     * @param integer $ocorrencia
     * @return AtributoDesoneracaoValor
     */
    public function setOcorrencia($ocorrencia)
    {
        $this->ocorrencia = $ocorrencia;
        return $this;
    }

    /**
     * Get ocorrencia
     *
     * @return integer
     */
    public function getOcorrencia()
    {
        return $this->ocorrencia;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return AtributoDesoneracaoValor
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
     * Set fkArrecadacaoAtributoDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracao $fkArrecadacaoAtributoDesoneracao
     * @return AtributoDesoneracaoValor
     */
    public function setFkArrecadacaoAtributoDesoneracao(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracao $fkArrecadacaoAtributoDesoneracao)
    {
        $this->codDesoneracao = $fkArrecadacaoAtributoDesoneracao->getCodDesoneracao();
        $this->codModulo = $fkArrecadacaoAtributoDesoneracao->getCodModulo();
        $this->codCadastro = $fkArrecadacaoAtributoDesoneracao->getCodCadastro();
        $this->codAtributo = $fkArrecadacaoAtributoDesoneracao->getCodAtributo();
        $this->fkArrecadacaoAtributoDesoneracao = $fkArrecadacaoAtributoDesoneracao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoAtributoDesoneracao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracao
     */
    public function getFkArrecadacaoAtributoDesoneracao()
    {
        return $this->fkArrecadacaoAtributoDesoneracao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoDesonerado
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desonerado $fkArrecadacaoDesonerado
     * @return AtributoDesoneracaoValor
     */
    public function setFkArrecadacaoDesonerado(\Urbem\CoreBundle\Entity\Arrecadacao\Desonerado $fkArrecadacaoDesonerado)
    {
        $this->codDesoneracao = $fkArrecadacaoDesonerado->getCodDesoneracao();
        $this->numcgm = $fkArrecadacaoDesonerado->getNumcgm();
        $this->ocorrencia = $fkArrecadacaoDesonerado->getOcorrencia();
        $this->fkArrecadacaoDesonerado = $fkArrecadacaoDesonerado;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoDesonerado
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Desonerado
     */
    public function getFkArrecadacaoDesonerado()
    {
        return $this->fkArrecadacaoDesonerado;
    }
}
