<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * AtributoImovelVVenalValor
 */
class AtributoImovelVVenalValor
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

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
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal
     */
    private $fkArrecadacaoImovelVVenal;

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
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return AtributoImovelVVenalValor
     */
    public function setInscricaoMunicipal($inscricaoMunicipal)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /**
     * Get inscricaoMunicipal
     *
     * @return integer
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AtributoImovelVVenalValor
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoImovelVVenalValor
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
     * @return AtributoImovelVVenalValor
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
     * @return AtributoImovelVVenalValor
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
     * Set valor
     *
     * @param string $valor
     * @return AtributoImovelVVenalValor
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
     * Set fkArrecadacaoImovelVVenal
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal $fkArrecadacaoImovelVVenal
     * @return AtributoImovelVVenalValor
     */
    public function setFkArrecadacaoImovelVVenal(\Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal $fkArrecadacaoImovelVVenal)
    {
        $this->inscricaoMunicipal = $fkArrecadacaoImovelVVenal->getInscricaoMunicipal();
        $this->timestamp = $fkArrecadacaoImovelVVenal->getTimestamp();
        $this->fkArrecadacaoImovelVVenal = $fkArrecadacaoImovelVVenal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoImovelVVenal
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal
     */
    public function getFkArrecadacaoImovelVVenal()
    {
        return $this->fkArrecadacaoImovelVVenal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoImovelVVenalValor
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
