<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * SolicitacaoEntrega
 */
class SolicitacaoEntrega
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
     * @var integer
     */
    private $numcgm;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Compras\Solicitacao
     */
    private $fkComprasSolicitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SolicitacaoEntrega
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
     * @return SolicitacaoEntrega
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
     * @return SolicitacaoEntrega
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return SolicitacaoEntrega
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return SolicitacaoEntrega
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * OneToOne (owning side)
     * Set ComprasSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao
     * @return SolicitacaoEntrega
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
     * OneToOne (owning side)
     * Get fkComprasSolicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Solicitacao
     */
    public function getFkComprasSolicitacao()
    {
        return $this->fkComprasSolicitacao;
    }
}
