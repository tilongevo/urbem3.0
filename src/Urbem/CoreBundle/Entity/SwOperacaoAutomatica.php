<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwOperacaoAutomatica
 */
class SwOperacaoAutomatica
{
    /**
     * PK
     * @var integer
     */
    private $codOperacao;

    /**
     * @var string
     */
    private $nomOperacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwTransacaoOperacao
     */
    private $fkSwTransacaoOperacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwTransacaoOperacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codOperacao
     *
     * @param integer $codOperacao
     * @return SwOperacaoAutomatica
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
     * Set nomOperacao
     *
     * @param string $nomOperacao
     * @return SwOperacaoAutomatica
     */
    public function setNomOperacao($nomOperacao)
    {
        $this->nomOperacao = $nomOperacao;
        return $this;
    }

    /**
     * Get nomOperacao
     *
     * @return string
     */
    public function getNomOperacao()
    {
        return $this->nomOperacao;
    }

    /**
     * OneToMany (owning side)
     * Add SwTransacaoOperacao
     *
     * @param \Urbem\CoreBundle\Entity\SwTransacaoOperacao $fkSwTransacaoOperacao
     * @return SwOperacaoAutomatica
     */
    public function addFkSwTransacaoOperacoes(\Urbem\CoreBundle\Entity\SwTransacaoOperacao $fkSwTransacaoOperacao)
    {
        if (false === $this->fkSwTransacaoOperacoes->contains($fkSwTransacaoOperacao)) {
            $fkSwTransacaoOperacao->setFkSwOperacaoAutomatica($this);
            $this->fkSwTransacaoOperacoes->add($fkSwTransacaoOperacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwTransacaoOperacao
     *
     * @param \Urbem\CoreBundle\Entity\SwTransacaoOperacao $fkSwTransacaoOperacao
     */
    public function removeFkSwTransacaoOperacoes(\Urbem\CoreBundle\Entity\SwTransacaoOperacao $fkSwTransacaoOperacao)
    {
        $this->fkSwTransacaoOperacoes->removeElement($fkSwTransacaoOperacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwTransacaoOperacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwTransacaoOperacao
     */
    public function getFkSwTransacaoOperacoes()
    {
        return $this->fkSwTransacaoOperacoes;
    }
}
