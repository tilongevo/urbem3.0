<?php
 
namespace Urbem\CoreBundle\Entity\Ldo;

/**
 * ConfiguracaoDivida
 */
class ConfiguracaoDivida
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
     * @var \Urbem\CoreBundle\Entity\Ldo\TipoDivida
     */
    private $fkLdoTipoDivida;


    /**
     * Set codPpa
     *
     * @param integer $codPpa
     * @return ConfiguracaoDivida
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
     * @return ConfiguracaoDivida
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
     * @return ConfiguracaoDivida
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoDivida
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
     * @return ConfiguracaoDivida
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
     * @return ConfiguracaoDivida
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
     * Set fkLdoTipoDivida
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\TipoDivida $fkLdoTipoDivida
     * @return ConfiguracaoDivida
     */
    public function setFkLdoTipoDivida(\Urbem\CoreBundle\Entity\Ldo\TipoDivida $fkLdoTipoDivida)
    {
        $this->codTipo = $fkLdoTipoDivida->getCodTipo();
        $this->fkLdoTipoDivida = $fkLdoTipoDivida;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLdoTipoDivida
     *
     * @return \Urbem\CoreBundle\Entity\Ldo\TipoDivida
     */
    public function getFkLdoTipoDivida()
    {
        return $this->fkLdoTipoDivida;
    }
}
