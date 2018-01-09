<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AtributoContratoPensionista
 */
class AtributoContratoPensionista
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

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
    private $codModulo;

    /**
     * @var string
     */
    private $valor;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista
     */
    private $fkPessoalContratoPensionista;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return AtributoContratoPensionista
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoContratoPensionista
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
     * @return AtributoContratoPensionista
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoContratoPensionista
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
     * @return AtributoContratoPensionista
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AtributoContratoPensionista
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
     * ManyToOne (inverse side)
     * Set fkPessoalContratoPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista
     * @return AtributoContratoPensionista
     */
    public function setFkPessoalContratoPensionista(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista)
    {
        $this->codContrato = $fkPessoalContratoPensionista->getCodContrato();
        $this->fkPessoalContratoPensionista = $fkPessoalContratoPensionista;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContratoPensionista
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista
     */
    public function getFkPessoalContratoPensionista()
    {
        return $this->fkPessoalContratoPensionista;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoContratoPensionista
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
}
