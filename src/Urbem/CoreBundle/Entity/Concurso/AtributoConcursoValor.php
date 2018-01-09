<?php
 
namespace Urbem\CoreBundle\Entity\Concurso;

/**
 * AtributoConcursoValor
 */
class AtributoConcursoValor
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
    private $codCadastro;

    /**
     * PK
     * @var integer
     */
    private $codEdital;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Concurso\Edital
     */
    private $fkConcursoEdital;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoConcursoValor
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
     * @return AtributoConcursoValor
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
     * Set codEdital
     *
     * @param integer $codEdital
     * @return AtributoConcursoValor
     */
    public function setCodEdital($codEdital)
    {
        $this->codEdital = $codEdital;
        return $this;
    }

    /**
     * Get codEdital
     *
     * @return integer
     */
    public function getCodEdital()
    {
        return $this->codEdital;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoConcursoValor
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
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return AtributoConcursoValor
     */
    public function setTimestamp(\DateTime $timestamp = null)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return AtributoConcursoValor
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
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoConcursoValor
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
     * Set fkConcursoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\Edital $fkConcursoEdital
     * @return AtributoConcursoValor
     */
    public function setFkConcursoEdital(\Urbem\CoreBundle\Entity\Concurso\Edital $fkConcursoEdital)
    {
        $this->codEdital = $fkConcursoEdital->getCodEdital();
        $this->fkConcursoEdital = $fkConcursoEdital;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkConcursoEdital
     *
     * @return \Urbem\CoreBundle\Entity\Concurso\Edital
     */
    public function getFkConcursoEdital()
    {
        return $this->fkConcursoEdital;
    }
}
