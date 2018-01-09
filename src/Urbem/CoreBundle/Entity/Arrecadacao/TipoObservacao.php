<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * TipoObservacao
 */
class TipoObservacao
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
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoPagamento
     */
    private $fkArrecadacaoObservacaoPagamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoObservacaoPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoObservacao
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
     * @return TipoObservacao
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
     * OneToMany (owning side)
     * Add ArrecadacaoObservacaoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoPagamento $fkArrecadacaoObservacaoPagamento
     * @return TipoObservacao
     */
    public function addFkArrecadacaoObservacaoPagamentos(\Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoPagamento $fkArrecadacaoObservacaoPagamento)
    {
        if (false === $this->fkArrecadacaoObservacaoPagamentos->contains($fkArrecadacaoObservacaoPagamento)) {
            $fkArrecadacaoObservacaoPagamento->setFkArrecadacaoTipoObservacao($this);
            $this->fkArrecadacaoObservacaoPagamentos->add($fkArrecadacaoObservacaoPagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoObservacaoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoPagamento $fkArrecadacaoObservacaoPagamento
     */
    public function removeFkArrecadacaoObservacaoPagamentos(\Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoPagamento $fkArrecadacaoObservacaoPagamento)
    {
        $this->fkArrecadacaoObservacaoPagamentos->removeElement($fkArrecadacaoObservacaoPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoObservacaoPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoPagamento
     */
    public function getFkArrecadacaoObservacaoPagamentos()
    {
        return $this->fkArrecadacaoObservacaoPagamentos;
    }
}
