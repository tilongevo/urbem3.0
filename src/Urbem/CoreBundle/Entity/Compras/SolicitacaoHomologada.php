<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * SolicitacaoHomologada
 */
class SolicitacaoHomologada
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
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaAnulacao
     */
    private $fkComprasSolicitacaoHomologadaAnulacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Compras\Solicitacao
     */
    private $fkComprasSolicitacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaSolicitacao
     */
    private $fkComprasMapaSolicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva
     */
    private $fkComprasSolicitacaoHomologadaReservas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasMapaSolicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacaoHomologadaReservas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SolicitacaoHomologada
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
     * @return SolicitacaoHomologada
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
     * @return SolicitacaoHomologada
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
     * @return SolicitacaoHomologada
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return SolicitacaoHomologada
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp = null)
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
     * OneToMany (owning side)
     * Add ComprasMapaSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaSolicitacao $fkComprasMapaSolicitacao
     * @return SolicitacaoHomologada
     */
    public function addFkComprasMapaSolicitacoes(\Urbem\CoreBundle\Entity\Compras\MapaSolicitacao $fkComprasMapaSolicitacao)
    {
        if (false === $this->fkComprasMapaSolicitacoes->contains($fkComprasMapaSolicitacao)) {
            $fkComprasMapaSolicitacao->setFkComprasSolicitacaoHomologada($this);
            $this->fkComprasMapaSolicitacoes->add($fkComprasMapaSolicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasMapaSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaSolicitacao $fkComprasMapaSolicitacao
     */
    public function removeFkComprasMapaSolicitacoes(\Urbem\CoreBundle\Entity\Compras\MapaSolicitacao $fkComprasMapaSolicitacao)
    {
        $this->fkComprasMapaSolicitacoes->removeElement($fkComprasMapaSolicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasMapaSolicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaSolicitacao
     */
    public function getFkComprasMapaSolicitacoes()
    {
        return $this->fkComprasMapaSolicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoHomologadaReserva
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva $fkComprasSolicitacaoHomologadaReserva
     * @return SolicitacaoHomologada
     */
    public function addFkComprasSolicitacaoHomologadaReservas(\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva $fkComprasSolicitacaoHomologadaReserva)
    {
        if (false === $this->fkComprasSolicitacaoHomologadaReservas->contains($fkComprasSolicitacaoHomologadaReserva)) {
            $fkComprasSolicitacaoHomologadaReserva->setFkComprasSolicitacaoHomologada($this);
            $this->fkComprasSolicitacaoHomologadaReservas->add($fkComprasSolicitacaoHomologadaReserva);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacaoHomologadaReserva
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva $fkComprasSolicitacaoHomologadaReserva
     */
    public function removeFkComprasSolicitacaoHomologadaReservas(\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva $fkComprasSolicitacaoHomologadaReserva)
    {
        $this->fkComprasSolicitacaoHomologadaReservas->removeElement($fkComprasSolicitacaoHomologadaReserva);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacaoHomologadaReservas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva
     */
    public function getFkComprasSolicitacaoHomologadaReservas()
    {
        return $this->fkComprasSolicitacaoHomologadaReservas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return SolicitacaoHomologada
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgm = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * OneToOne (inverse side)
     * Set ComprasSolicitacaoHomologadaAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaAnulacao $fkComprasSolicitacaoHomologadaAnulacao
     * @return SolicitacaoHomologada
     */
    public function setFkComprasSolicitacaoHomologadaAnulacao(\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaAnulacao $fkComprasSolicitacaoHomologadaAnulacao)
    {
        $fkComprasSolicitacaoHomologadaAnulacao->setFkComprasSolicitacaoHomologada($this);
        $this->fkComprasSolicitacaoHomologadaAnulacao = $fkComprasSolicitacaoHomologadaAnulacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkComprasSolicitacaoHomologadaAnulacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaAnulacao
     */
    public function getFkComprasSolicitacaoHomologadaAnulacao()
    {
        return $this->fkComprasSolicitacaoHomologadaAnulacao;
    }

    /**
     * OneToOne (owning side)
     * Set ComprasSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao
     * @return SolicitacaoHomologada
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
