<?php
 
namespace Urbem\CoreBundle\Entity\Concurso;

/**
 * AtributoCandidatoValor
 */
class AtributoCandidatoValor
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
    private $codCandidato;

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
     * @var \Urbem\CoreBundle\Entity\Concurso\Candidato
     */
    private $fkConcursoCandidato;

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
     * @return AtributoCandidatoValor
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
     * @return AtributoCandidatoValor
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
     * Set codCandidato
     *
     * @param integer $codCandidato
     * @return AtributoCandidatoValor
     */
    public function setCodCandidato($codCandidato)
    {
        $this->codCandidato = $codCandidato;
        return $this;
    }

    /**
     * Get codCandidato
     *
     * @return integer
     */
    public function getCodCandidato()
    {
        return $this->codCandidato;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoCandidatoValor
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
     * @return AtributoCandidatoValor
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
     * @return AtributoCandidatoValor
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
     * @return AtributoCandidatoValor
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
     * Set fkConcursoCandidato
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\Candidato $fkConcursoCandidato
     * @return AtributoCandidatoValor
     */
    public function setFkConcursoCandidato(\Urbem\CoreBundle\Entity\Concurso\Candidato $fkConcursoCandidato)
    {
        $this->codCandidato = $fkConcursoCandidato->getCodCandidato();
        $this->fkConcursoCandidato = $fkConcursoCandidato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkConcursoCandidato
     *
     * @return \Urbem\CoreBundle\Entity\Concurso\Candidato
     */
    public function getFkConcursoCandidato()
    {
        return $this->fkConcursoCandidato;
    }
}
