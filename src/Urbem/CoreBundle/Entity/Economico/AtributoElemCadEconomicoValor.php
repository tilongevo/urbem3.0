<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * AtributoElemCadEconomicoValor
 */
class AtributoElemCadEconomicoValor
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * PK
     * @var integer
     */
    private $codElemento;

    /**
     * PK
     * @var integer
     */
    private $ocorrenciaElemento;

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
    private $ocorrenciaAtividade;

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
     * @var \Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico
     */
    private $fkEconomicoElementoAtivCadEconomico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\AtributoElemento
     */
    private $fkEconomicoAtributoElemento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return AtributoElemCadEconomicoValor
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return AtributoElemCadEconomicoValor
     */
    public function setCodAtividade($codAtividade)
    {
        $this->codAtividade = $codAtividade;
        return $this;
    }

    /**
     * Get codAtividade
     *
     * @return integer
     */
    public function getCodAtividade()
    {
        return $this->codAtividade;
    }

    /**
     * Set codElemento
     *
     * @param integer $codElemento
     * @return AtributoElemCadEconomicoValor
     */
    public function setCodElemento($codElemento)
    {
        $this->codElemento = $codElemento;
        return $this;
    }

    /**
     * Get codElemento
     *
     * @return integer
     */
    public function getCodElemento()
    {
        return $this->codElemento;
    }

    /**
     * Set ocorrenciaElemento
     *
     * @param integer $ocorrenciaElemento
     * @return AtributoElemCadEconomicoValor
     */
    public function setOcorrenciaElemento($ocorrenciaElemento)
    {
        $this->ocorrenciaElemento = $ocorrenciaElemento;
        return $this;
    }

    /**
     * Get ocorrenciaElemento
     *
     * @return integer
     */
    public function getOcorrenciaElemento()
    {
        return $this->ocorrenciaElemento;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoElemCadEconomicoValor
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
     * @return AtributoElemCadEconomicoValor
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
     * Set ocorrenciaAtividade
     *
     * @param integer $ocorrenciaAtividade
     * @return AtributoElemCadEconomicoValor
     */
    public function setOcorrenciaAtividade($ocorrenciaAtividade)
    {
        $this->ocorrenciaAtividade = $ocorrenciaAtividade;
        return $this;
    }

    /**
     * Get ocorrenciaAtividade
     *
     * @return integer
     */
    public function getOcorrenciaAtividade()
    {
        return $this->ocorrenciaAtividade;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoElemCadEconomicoValor
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
     * @return AtributoElemCadEconomicoValor
     */
    public function setTimestamp(\DateTime $timestamp)
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
     * @return AtributoElemCadEconomicoValor
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
     * Set fkEconomicoElementoAtivCadEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico $fkEconomicoElementoAtivCadEconomico
     * @return AtributoElemCadEconomicoValor
     */
    public function setFkEconomicoElementoAtivCadEconomico(\Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico $fkEconomicoElementoAtivCadEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoElementoAtivCadEconomico->getInscricaoEconomica();
        $this->codAtividade = $fkEconomicoElementoAtivCadEconomico->getCodAtividade();
        $this->ocorrenciaAtividade = $fkEconomicoElementoAtivCadEconomico->getOcorrenciaAtividade();
        $this->codElemento = $fkEconomicoElementoAtivCadEconomico->getCodElemento();
        $this->ocorrenciaElemento = $fkEconomicoElementoAtivCadEconomico->getOcorrenciaElemento();
        $this->fkEconomicoElementoAtivCadEconomico = $fkEconomicoElementoAtivCadEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoElementoAtivCadEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico
     */
    public function getFkEconomicoElementoAtivCadEconomico()
    {
        return $this->fkEconomicoElementoAtivCadEconomico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoAtributoElemento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoElemento $fkEconomicoAtributoElemento
     * @return AtributoElemCadEconomicoValor
     */
    public function setFkEconomicoAtributoElemento(\Urbem\CoreBundle\Entity\Economico\AtributoElemento $fkEconomicoAtributoElemento)
    {
        $this->codAtributo = $fkEconomicoAtributoElemento->getCodAtributo();
        $this->codCadastro = $fkEconomicoAtributoElemento->getCodCadastro();
        $this->codElemento = $fkEconomicoAtributoElemento->getCodElemento();
        $this->codModulo = $fkEconomicoAtributoElemento->getCodModulo();
        $this->fkEconomicoAtributoElemento = $fkEconomicoAtributoElemento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoAtributoElemento
     *
     * @return \Urbem\CoreBundle\Entity\Economico\AtributoElemento
     */
    public function getFkEconomicoAtributoElemento()
    {
        return $this->fkEconomicoAtributoElemento;
    }
}
