<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * SolicitacaoAnulacao
 */
class SolicitacaoAnulacao
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codSolicitacao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao
     */
    private $fkComprasSolicitacaoItemAnulacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Solicitacao
     */
    private $fkComprasSolicitacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasSolicitacaoItemAnulacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SolicitacaoAnulacao
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return SolicitacaoAnulacao
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
     * Set codSolicitacao
     *
     * @param integer $codSolicitacao
     * @return SolicitacaoAnulacao
     */
    public function setCodSolicitacao($codSolicitacao)
    {
        $this->codSolicitacao = $codSolicitacao;
        return $this;
    }

    /**
     * Get codSolicitacao
     *
     * @return integer
     */
    public function getCodSolicitacao()
    {
        return $this->codSolicitacao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return SolicitacaoAnulacao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return SolicitacaoAnulacao
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoItemAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao $fkComprasSolicitacaoItemAnulacao
     * @return SolicitacaoAnulacao
     */
    public function addFkComprasSolicitacaoItemAnulacoes(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao $fkComprasSolicitacaoItemAnulacao)
    {
        if (false === $this->fkComprasSolicitacaoItemAnulacoes->contains($fkComprasSolicitacaoItemAnulacao)) {
            $fkComprasSolicitacaoItemAnulacao->setFkComprasSolicitacaoAnulacao($this);
            $this->fkComprasSolicitacaoItemAnulacoes->add($fkComprasSolicitacaoItemAnulacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacaoItemAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao $fkComprasSolicitacaoItemAnulacao
     */
    public function removeFkComprasSolicitacaoItemAnulacoes(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao $fkComprasSolicitacaoItemAnulacao)
    {
        $this->fkComprasSolicitacaoItemAnulacoes->removeElement($fkComprasSolicitacaoItemAnulacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacaoItemAnulacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao
     */
    public function getFkComprasSolicitacaoItemAnulacoes()
    {
        return $this->fkComprasSolicitacaoItemAnulacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao
     * @return SolicitacaoAnulacao
     */
    public function setFkComprasSolicitacao(\Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao)
    {
        $this->exercicio = $fkComprasSolicitacao->getExercicio();
        $this->codEntidade = $fkComprasSolicitacao->getCodEntidade();
        $this->codSolicitacao = $fkComprasSolicitacao->getCodSolicitacao();
        $this->fkComprasSolicitacao = $fkComprasSolicitacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasSolicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Solicitacao
     */
    public function getFkComprasSolicitacao()
    {
        return $this->fkComprasSolicitacao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s - %s', $this->exercicio, $this->codSolicitacao, $this->motivo);
    }
}
