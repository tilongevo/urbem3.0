<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * SolicitacaoConvenio
 */
class SolicitacaoConvenio
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
    private $numConvenio;

    /**
     * @var string
     */
    private $exercicioConvenio;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Compras\Solicitacao
     */
    private $fkComprasSolicitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    private $fkLicitacaoConvenio;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SolicitacaoConvenio
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
     * @return SolicitacaoConvenio
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
     * @return SolicitacaoConvenio
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
     * Set numConvenio
     *
     * @param integer $numConvenio
     * @return SolicitacaoConvenio
     */
    public function setNumConvenio($numConvenio)
    {
        $this->numConvenio = $numConvenio;
        return $this;
    }

    /**
     * Get numConvenio
     *
     * @return integer
     */
    public function getNumConvenio()
    {
        return $this->numConvenio;
    }

    /**
     * Set exercicioConvenio
     *
     * @param string $exercicioConvenio
     * @return SolicitacaoConvenio
     */
    public function setExercicioConvenio($exercicioConvenio)
    {
        $this->exercicioConvenio = $exercicioConvenio;
        return $this;
    }

    /**
     * Get exercicioConvenio
     *
     * @return string
     */
    public function getExercicioConvenio()
    {
        return $this->exercicioConvenio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio
     * @return SolicitacaoConvenio
     */
    public function setFkLicitacaoConvenio(\Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio)
    {
        $this->numConvenio = $fkLicitacaoConvenio->getNumConvenio();
        $this->exercicioConvenio = $fkLicitacaoConvenio->getExercicio();
        $this->fkLicitacaoConvenio = $fkLicitacaoConvenio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    public function getFkLicitacaoConvenio()
    {
        return $this->fkLicitacaoConvenio;
    }

    /**
     * OneToOne (owning side)
     * Set ComprasSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao
     * @return SolicitacaoConvenio
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
