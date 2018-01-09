<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * Providencias
 */
class Providencias
{
    /**
     * PK
     * @var integer
     */
    private $codProvidencia;

    /**
     * PK
     * @var integer
     */
    private $codRisco;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Stn\RiscosFiscais
     */
    private $fkStnRiscosFiscais;


    /**
     * Set codProvidencia
     *
     * @param integer $codProvidencia
     * @return Providencias
     */
    public function setCodProvidencia($codProvidencia)
    {
        $this->codProvidencia = $codProvidencia;
        return $this;
    }

    /**
     * Get codProvidencia
     *
     * @return integer
     */
    public function getCodProvidencia()
    {
        return $this->codProvidencia;
    }

    /**
     * Set codRisco
     *
     * @param integer $codRisco
     * @return Providencias
     */
    public function setCodRisco($codRisco)
    {
        $this->codRisco = $codRisco;
        return $this;
    }

    /**
     * Get codRisco
     *
     * @return integer
     */
    public function getCodRisco()
    {
        return $this->codRisco;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Providencias
     */
    public function setCodEntidade($codEntidade)
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return Providencias
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
     * Set descricao
     *
     * @param string $descricao
     * @return Providencias
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return Providencias
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
     * Set fkStnRiscosFiscais
     *
     * @param \Urbem\CoreBundle\Entity\Stn\RiscosFiscais $fkStnRiscosFiscais
     * @return Providencias
     */
    public function setFkStnRiscosFiscais(\Urbem\CoreBundle\Entity\Stn\RiscosFiscais $fkStnRiscosFiscais)
    {
        $this->codRisco = $fkStnRiscosFiscais->getCodRisco();
        $this->codEntidade = $fkStnRiscosFiscais->getCodEntidade();
        $this->exercicio = $fkStnRiscosFiscais->getExercicio();
        $this->fkStnRiscosFiscais = $fkStnRiscosFiscais;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkStnRiscosFiscais
     *
     * @return \Urbem\CoreBundle\Entity\Stn\RiscosFiscais
     */
    public function getFkStnRiscosFiscais()
    {
        return $this->fkStnRiscosFiscais;
    }
}
