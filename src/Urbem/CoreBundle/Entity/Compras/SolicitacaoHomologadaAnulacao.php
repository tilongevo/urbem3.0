<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * SolicitacaoHomologadaAnulacao
 */
class SolicitacaoHomologadaAnulacao
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
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada
     */
    private $fkComprasSolicitacaoHomologada;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SolicitacaoHomologadaAnulacao
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
     * @return SolicitacaoHomologadaAnulacao
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
     * @return SolicitacaoHomologadaAnulacao
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
     * @return SolicitacaoHomologadaAnulacao
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
     * @return SolicitacaoHomologadaAnulacao
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
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return SolicitacaoHomologadaAnulacao
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
     * OneToOne (owning side)
     * Set ComprasSolicitacaoHomologada
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada $fkComprasSolicitacaoHomologada
     * @return SolicitacaoHomologadaAnulacao
     */
    public function setFkComprasSolicitacaoHomologada(\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada $fkComprasSolicitacaoHomologada)
    {
        $this->exercicio = $fkComprasSolicitacaoHomologada->getExercicio();
        $this->codEntidade = $fkComprasSolicitacaoHomologada->getCodEntidade();
        $this->codSolicitacao = $fkComprasSolicitacaoHomologada->getCodSolicitacao();
        $this->fkComprasSolicitacaoHomologada = $fkComprasSolicitacaoHomologada;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkComprasSolicitacaoHomologada
     *
     * @return \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada
     */
    public function getFkComprasSolicitacaoHomologada()
    {
        return $this->fkComprasSolicitacaoHomologada;
    }
}
