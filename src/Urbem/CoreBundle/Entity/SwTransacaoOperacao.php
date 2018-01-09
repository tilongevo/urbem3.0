<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwTransacaoOperacao
 */
class SwTransacaoOperacao
{
    /**
     * PK
     * @var integer
     */
    private $codOperacao;

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
     * @var \Urbem\CoreBundle\Entity\SwOperacaoAutomatica
     */
    private $fkSwOperacaoAutomatica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwTransacao
     */
    private $fkSwTransacao;


    /**
     * Set codOperacao
     *
     * @param integer $codOperacao
     * @return SwTransacaoOperacao
     */
    public function setCodOperacao($codOperacao)
    {
        $this->codOperacao = $codOperacao;
        return $this;
    }

    /**
     * Get codOperacao
     *
     * @return integer
     */
    public function getCodOperacao()
    {
        return $this->codOperacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwTransacaoOperacao
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
     * @return SwTransacaoOperacao
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
     * Set fkSwOperacaoAutomatica
     *
     * @param \Urbem\CoreBundle\Entity\SwOperacaoAutomatica $fkSwOperacaoAutomatica
     * @return SwTransacaoOperacao
     */
    public function setFkSwOperacaoAutomatica(\Urbem\CoreBundle\Entity\SwOperacaoAutomatica $fkSwOperacaoAutomatica)
    {
        $this->codOperacao = $fkSwOperacaoAutomatica->getCodOperacao();
        $this->fkSwOperacaoAutomatica = $fkSwOperacaoAutomatica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwOperacaoAutomatica
     *
     * @return \Urbem\CoreBundle\Entity\SwOperacaoAutomatica
     */
    public function getFkSwOperacaoAutomatica()
    {
        return $this->fkSwOperacaoAutomatica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwTransacao
     *
     * @param \Urbem\CoreBundle\Entity\SwTransacao $fkSwTransacao
     * @return SwTransacaoOperacao
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
