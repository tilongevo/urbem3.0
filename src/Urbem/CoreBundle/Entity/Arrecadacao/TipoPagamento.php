<?php

namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * TipoPagamento
 */
class TipoPagamento
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * @var boolean
     */
    private $sistema = false;

    /**
     * @var string
     */
    private $nomResumido;

    /**
     * @var boolean
     */
    private $pagamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Pagamento
     */
    private $fkArrecadacaoPagamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoPagamento
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
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return TipoPagamento
     */
    public function setNomTipo($nomTipo)
    {
        $this->nomTipo = $nomTipo;
        return $this;
    }

    /**
     * Get nomTipo
     *
     * @return string
     */
    public function getNomTipo()
    {
        return $this->nomTipo;
    }

    /**
     * Set sistema
     *
     * @param boolean $sistema
     * @return TipoPagamento
     */
    public function setSistema($sistema = null)
    {
        $this->sistema = $sistema;
        return $this;
    }

    /**
     * Get sistema
     *
     * @return boolean
     */
    public function getSistema()
    {
        return $this->sistema;
    }

    /**
     * Set nomResumido
     *
     * @param string $nomResumido
     * @return TipoPagamento
     */
    public function setNomResumido($nomResumido)
    {
        $this->nomResumido = $nomResumido;
        return $this;
    }

    /**
     * Get nomResumido
     *
     * @return string
     */
    public function getNomResumido()
    {
        return $this->nomResumido;
    }

    /**
     * Set pagamento
     *
     * @param boolean $pagamento
     * @return TipoPagamento
     */
    public function setPagamento($pagamento)
    {
        $this->pagamento = $pagamento;
        return $this;
    }

    /**
     * Get pagamento
     *
     * @return boolean
     */
    public function getPagamento()
    {
        return $this->pagamento;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Pagamento $fkArrecadacaoPagamento
     * @return TipoPagamento
     */
    public function addFkArrecadacaoPagamentos(\Urbem\CoreBundle\Entity\Arrecadacao\Pagamento $fkArrecadacaoPagamento)
    {
        if (false === $this->fkArrecadacaoPagamentos->contains($fkArrecadacaoPagamento)) {
            $fkArrecadacaoPagamento->setFkArrecadacaoTipoPagamento($this);
            $this->fkArrecadacaoPagamentos->add($fkArrecadacaoPagamento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Pagamento $fkArrecadacaoPagamento
     */
    public function removeFkArrecadacaoPagamentos(\Urbem\CoreBundle\Entity\Arrecadacao\Pagamento $fkArrecadacaoPagamento)
    {
        $this->fkArrecadacaoPagamentos->removeElement($fkArrecadacaoPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Pagamento
     */
    public function getFkArrecadacaoPagamentos()
    {
        return $this->fkArrecadacaoPagamentos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomTipo;
    }
}
