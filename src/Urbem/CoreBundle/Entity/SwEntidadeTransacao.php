<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwEntidadeTransacao
 */
class SwEntidadeTransacao
{
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
     * PK
     * @var integer
     */
    private $codTransacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwTransacao
     */
    private $fkSwTransacao;


    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return SwEntidadeTransacao
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
     * @return SwEntidadeTransacao
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
     * Set codTransacao
     *
     * @param integer $codTransacao
     * @return SwEntidadeTransacao
     */
    public function setCodTransacao($codTransacao)
    {
        $this->codTransacao = $codTransacao;
        return $this;
    }

    /**
     * Get codTransacao
     *
     * @return integer
     */
    public function getCodTransacao()
    {
        return $this->codTransacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwTransacao
     *
     * @param \Urbem\CoreBundle\Entity\SwTransacao $fkSwTransacao
     * @return SwEntidadeTransacao
     */
    public function setFkSwTransacao(\Urbem\CoreBundle\Entity\SwTransacao $fkSwTransacao)
    {
        $this->codTransacao = $fkSwTransacao->getCodTransacao();
        $this->exercicio = $fkSwTransacao->getExercicio();
        $this->fkSwTransacao = $fkSwTransacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwTransacao
     *
     * @return \Urbem\CoreBundle\Entity\SwTransacao
     */
    public function getFkSwTransacao()
    {
        return $this->fkSwTransacao;
    }
}
