<?php
 
namespace Urbem\CoreBundle\Entity\Ldo;

/**
 * ConfiguracaoEvolucaoPatrimonioLiquido
 */
class ConfiguracaoEvolucaoPatrimonioLiquido
{
    /**
     * PK
     * @var integer
     */
    private $codPpa;

    /**
     * PK
     * @var string
     */
    private $ano;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var boolean
     */
    private $rpps;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ldo\Ldo
     */
    private $fkLdoLdo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ldo\TipoEvolucaoPatrimonioLiquido
     */
    private $fkLdoTipoEvolucaoPatrimonioLiquido;


    /**
     * Set codPpa
     *
     * @param integer $codPpa
     * @return ConfiguracaoEvolucaoPatrimonioLiquido
     */
    public function setCodPpa($codPpa)
    {
        $this->codPpa = $codPpa;
        return $this;
    }

    /**
     * Get codPpa
     *
     * @return integer
     */
    public function getCodPpa()
    {
        return $this->codPpa;
    }

    /**
     * Set ano
     *
     * @param string $ano
     * @return ConfiguracaoEvolucaoPatrimonioLiquido
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
        return $this;
    }

    /**
     * Get ano
     *
     * @return string
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ConfiguracaoEvolucaoPatrimonioLiquido
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set rpps
     *
     * @param boolean $rpps
     * @return ConfiguracaoEvolucaoPatrimonioLiquido
     */
    public function setRpps($rpps)
    {
        $this->rpps = $rpps;
        return $this;
    }

    /**
     * Get rpps
     *
     * @return boolean
     */
    public function getRpps()
    {
        return $this->rpps;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoEvolucaoPatrimonioLiquido
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return ConfiguracaoEvolucaoPatrimonioLiquido
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLdoLdo
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\Ldo $fkLdoLdo
     * @return ConfiguracaoEvolucaoPatrimonioLiquido
     */
    public function setFkLdoLdo(\Urbem\CoreBundle\Entity\Ldo\Ldo $fkLdoLdo)
    {
        $this->codPpa = $fkLdoLdo->getCodPpa();
        $this->ano = $fkLdoLdo->getAno();
        $this->fkLdoLdo = $fkLdoLdo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLdoLdo
     *
     * @return \Urbem\CoreBundle\Entity\Ldo\Ldo
     */
    public function getFkLdoLdo()
    {
        return $this->fkLdoLdo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLdoTipoEvolucaoPatrimonioLiquido
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\TipoEvolucaoPatrimonioLiquido $fkLdoTipoEvolucaoPatrimonioLiquido
     * @return ConfiguracaoEvolucaoPatrimonioLiquido
     */
    public function setFkLdoTipoEvolucaoPatrimonioLiquido(\Urbem\CoreBundle\Entity\Ldo\TipoEvolucaoPatrimonioLiquido $fkLdoTipoEvolucaoPatrimonioLiquido)
    {
        $this->codTipo = $fkLdoTipoEvolucaoPatrimonioLiquido->getCodTipo();
        $this->rpps = $fkLdoTipoEvolucaoPatrimonioLiquido->getRpps();
        $this->fkLdoTipoEvolucaoPatrimonioLiquido = $fkLdoTipoEvolucaoPatrimonioLiquido;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLdoTipoEvolucaoPatrimonioLiquido
     *
     * @return \Urbem\CoreBundle\Entity\Ldo\TipoEvolucaoPatrimonioLiquido
     */
    public function getFkLdoTipoEvolucaoPatrimonioLiquido()
    {
        return $this->fkLdoTipoEvolucaoPatrimonioLiquido;
    }
}
