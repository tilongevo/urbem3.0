<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * EmpenhoRegistroPrecos
 */
class EmpenhoRegistroPrecos
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $numeroRegistroPrecos;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * PK
     * @var string
     */
    private $exercicioEmpenho;

    /**
     * PK
     * @var boolean
     */
    private $interno;

    /**
     * PK
     * @var integer
     */
    private $codEntidadeEmpenho;

    /**
     * PK
     * @var integer
     */
    private $numcgmGerenciador;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos
     */
    private $fkTcemgRegistroPrecos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;


    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return EmpenhoRegistroPrecos
     */
    public function setCodEntidade($codEntidade = null)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set numeroRegistroPrecos
     *
     * @param integer $numeroRegistroPrecos
     * @return EmpenhoRegistroPrecos
     */
    public function setNumeroRegistroPrecos($numeroRegistroPrecos = null)
    {
        $this->numeroRegistroPrecos = $numeroRegistroPrecos;
        return $this;
    }

    /**
     * Get numeroRegistroPrecos
     *
     * @return integer
     */
    public function getNumeroRegistroPrecos()
    {
        return $this->numeroRegistroPrecos;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return EmpenhoRegistroPrecos
     */
    public function setExercicio($exercicio = null)
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
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return EmpenhoRegistroPrecos
     */
    public function setCodEmpenho($codEmpenho = null)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * Set exercicioEmpenho
     *
     * @param string $exercicioEmpenho
     * @return EmpenhoRegistroPrecos
     */
    public function setExercicioEmpenho($exercicioEmpenho = null)
    {
        $this->exercicioEmpenho = $exercicioEmpenho;
        return $this;
    }

    /**
     * Get exercicioEmpenho
     *
     * @return string
     */
    public function getExercicioEmpenho()
    {
        return $this->exercicioEmpenho;
    }

    /**
     * Set interno
     *
     * @param boolean $interno
     * @return EmpenhoRegistroPrecos
     */
    public function setInterno($interno = null)
    {
        $this->interno = $interno;
        return $this;
    }

    /**
     * Get interno
     *
     * @return boolean
     */
    public function getInterno()
    {
        return $this->interno;
    }

    /**
     * Set codEntidadeEmpenho
     *
     * @param integer $codEntidadeEmpenho
     * @return EmpenhoRegistroPrecos
     */
    public function setCodEntidadeEmpenho($codEntidadeEmpenho = null)
    {
        $this->codEntidadeEmpenho = $codEntidadeEmpenho;
        return $this;
    }

    /**
     * Get codEntidadeEmpenho
     *
     * @return integer
     */
    public function getCodEntidadeEmpenho()
    {
        return $this->codEntidadeEmpenho;
    }

    /**
     * Set numcgmGerenciador
     *
     * @param integer $numcgmGerenciador
     * @return EmpenhoRegistroPrecos
     */
    public function setNumcgmGerenciador($numcgmGerenciador = null)
    {
        $this->numcgmGerenciador = $numcgmGerenciador;
        return $this;
    }

    /**
     * Get numcgmGerenciador
     *
     * @return integer
     */
    public function getNumcgmGerenciador()
    {
        return $this->numcgmGerenciador;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos $fkTcemgRegistroPrecos
     * @return EmpenhoRegistroPrecos
     */
    public function setFkTcemgRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos $fkTcemgRegistroPrecos = null)
    {
        $this->codEntidade = $fkTcemgRegistroPrecos->getCodEntidade();
        $this->numeroRegistroPrecos = $fkTcemgRegistroPrecos->getNumeroRegistroPrecos();
        $this->exercicio = $fkTcemgRegistroPrecos->getExercicio();
        $this->numcgmGerenciador = $fkTcemgRegistroPrecos->getNumcgmGerenciador();
        $this->interno = $fkTcemgRegistroPrecos->getInterno();
        $this->fkTcemgRegistroPrecos = $fkTcemgRegistroPrecos;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgRegistroPrecos
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos
     */
    public function getFkTcemgRegistroPrecos()
    {
        return $this->fkTcemgRegistroPrecos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return EmpenhoRegistroPrecos
     */
    public function setFkEmpenhoEmpenho(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho = null)
    {
        $this->codEmpenho = $fkEmpenhoEmpenho->getCodEmpenho();
        $this->exercicioEmpenho = $fkEmpenhoEmpenho->getExercicio();
        $this->codEntidadeEmpenho = $fkEmpenhoEmpenho->getCodEntidade();
        $this->fkEmpenhoEmpenho = $fkEmpenhoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenho()
    {
        return $this->fkEmpenhoEmpenho;
    }
}
