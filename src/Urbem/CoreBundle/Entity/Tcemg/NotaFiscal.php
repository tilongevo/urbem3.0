<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * NotaFiscal
 */
class NotaFiscal
{
    /**
     * PK
     * @var integer
     */
    private $codNota;

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
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nroNota;

    /**
     * @var string
     */
    private $nroSerie;

    /**
     * @var string
     */
    private $aidf;

    /**
     * @var \DateTime
     */
    private $dataEmissao;

    /**
     * @var string
     */
    private $inscricaoMunicipal;

    /**
     * @var string
     */
    private $inscricaoEstadual;

    /**
     * @var integer
     */
    private $chaveAcesso;

    /**
     * @var string
     */
    private $chaveAcessoMunicipal;

    /**
     * @var integer
     */
    private $vlTotal;

    /**
     * @var integer
     */
    private $vlDesconto;

    /**
     * @var integer
     */
    private $vlTotalLiquido;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenho
     */
    private $fkTcemgNotaFiscalEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenhoLiquidacao
     */
    private $fkTcemgNotaFiscalEmpenhoLiquidacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\TipoNotaFiscal
     */
    private $fkTcemgTipoNotaFiscal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgNotaFiscalEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgNotaFiscalEmpenhoLiquidacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaFiscal
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return NotaFiscal
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
     * @return NotaFiscal
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return NotaFiscal
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
     * Set nroNota
     *
     * @param string $nroNota
     * @return NotaFiscal
     */
    public function setNroNota($nroNota = null)
    {
        $this->nroNota = $nroNota;
        return $this;
    }

    /**
     * Get nroNota
     *
     * @return string
     */
    public function getNroNota()
    {
        return $this->nroNota;
    }

    /**
     * Set nroSerie
     *
     * @param string $nroSerie
     * @return NotaFiscal
     */
    public function setNroSerie($nroSerie = null)
    {
        $this->nroSerie = $nroSerie;
        return $this;
    }

    /**
     * Get nroSerie
     *
     * @return string
     */
    public function getNroSerie()
    {
        return $this->nroSerie;
    }

    /**
     * Set aidf
     *
     * @param string $aidf
     * @return NotaFiscal
     */
    public function setAidf($aidf = null)
    {
        $this->aidf = $aidf;
        return $this;
    }

    /**
     * Get aidf
     *
     * @return string
     */
    public function getAidf()
    {
        return $this->aidf;
    }

    /**
     * Set dataEmissao
     *
     * @param \DateTime $dataEmissao
     * @return NotaFiscal
     */
    public function setDataEmissao(\DateTime $dataEmissao = null)
    {
        $this->dataEmissao = $dataEmissao;
        return $this;
    }

    /**
     * Get dataEmissao
     *
     * @return \DateTime
     */
    public function getDataEmissao()
    {
        return $this->dataEmissao;
    }

    /**
     * Set inscricaoMunicipal
     *
     * @param string $inscricaoMunicipal
     * @return NotaFiscal
     */
    public function setInscricaoMunicipal($inscricaoMunicipal = null)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /**
     * Get inscricaoMunicipal
     *
     * @return string
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * Set inscricaoEstadual
     *
     * @param string $inscricaoEstadual
     * @return NotaFiscal
     */
    public function setInscricaoEstadual($inscricaoEstadual = null)
    {
        $this->inscricaoEstadual = $inscricaoEstadual;
        return $this;
    }

    /**
     * Get inscricaoEstadual
     *
     * @return string
     */
    public function getInscricaoEstadual()
    {
        return $this->inscricaoEstadual;
    }

    /**
     * Set chaveAcesso
     *
     * @param integer $chaveAcesso
     * @return NotaFiscal
     */
    public function setChaveAcesso($chaveAcesso = null)
    {
        $this->chaveAcesso = $chaveAcesso;
        return $this;
    }

    /**
     * Get chaveAcesso
     *
     * @return integer
     */
    public function getChaveAcesso()
    {
        return $this->chaveAcesso;
    }

    /**
     * Set chaveAcessoMunicipal
     *
     * @param string $chaveAcessoMunicipal
     * @return NotaFiscal
     */
    public function setChaveAcessoMunicipal($chaveAcessoMunicipal = null)
    {
        $this->chaveAcessoMunicipal = $chaveAcessoMunicipal;
        return $this;
    }

    /**
     * Get chaveAcessoMunicipal
     *
     * @return string
     */
    public function getChaveAcessoMunicipal()
    {
        return $this->chaveAcessoMunicipal;
    }

    /**
     * Set vlTotal
     *
     * @param integer $vlTotal
     * @return NotaFiscal
     */
    public function setVlTotal($vlTotal = null)
    {
        $this->vlTotal = $vlTotal;
        return $this;
    }

    /**
     * Get vlTotal
     *
     * @return integer
     */
    public function getVlTotal()
    {
        return $this->vlTotal;
    }

    /**
     * Set vlDesconto
     *
     * @param integer $vlDesconto
     * @return NotaFiscal
     */
    public function setVlDesconto($vlDesconto = null)
    {
        $this->vlDesconto = $vlDesconto;
        return $this;
    }

    /**
     * Get vlDesconto
     *
     * @return integer
     */
    public function getVlDesconto()
    {
        return $this->vlDesconto;
    }

    /**
     * Set vlTotalLiquido
     *
     * @param integer $vlTotalLiquido
     * @return NotaFiscal
     */
    public function setVlTotalLiquido($vlTotalLiquido = null)
    {
        $this->vlTotalLiquido = $vlTotalLiquido;
        return $this;
    }

    /**
     * Get vlTotalLiquido
     *
     * @return integer
     */
    public function getVlTotalLiquido()
    {
        return $this->vlTotalLiquido;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgNotaFiscalEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenho $fkTcemgNotaFiscalEmpenho
     * @return NotaFiscal
     */
    public function addFkTcemgNotaFiscalEmpenhos(\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenho $fkTcemgNotaFiscalEmpenho)
    {
        if (false === $this->fkTcemgNotaFiscalEmpenhos->contains($fkTcemgNotaFiscalEmpenho)) {
            $fkTcemgNotaFiscalEmpenho->setFkTcemgNotaFiscal($this);
            $this->fkTcemgNotaFiscalEmpenhos->add($fkTcemgNotaFiscalEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgNotaFiscalEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenho $fkTcemgNotaFiscalEmpenho
     */
    public function removeFkTcemgNotaFiscalEmpenhos(\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenho $fkTcemgNotaFiscalEmpenho)
    {
        $this->fkTcemgNotaFiscalEmpenhos->removeElement($fkTcemgNotaFiscalEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgNotaFiscalEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenho
     */
    public function getFkTcemgNotaFiscalEmpenhos()
    {
        return $this->fkTcemgNotaFiscalEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgNotaFiscalEmpenhoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenhoLiquidacao $fkTcemgNotaFiscalEmpenhoLiquidacao
     * @return NotaFiscal
     */
    public function addFkTcemgNotaFiscalEmpenhoLiquidacoes(\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenhoLiquidacao $fkTcemgNotaFiscalEmpenhoLiquidacao)
    {
        if (false === $this->fkTcemgNotaFiscalEmpenhoLiquidacoes->contains($fkTcemgNotaFiscalEmpenhoLiquidacao)) {
            $fkTcemgNotaFiscalEmpenhoLiquidacao->setFkTcemgNotaFiscal($this);
            $this->fkTcemgNotaFiscalEmpenhoLiquidacoes->add($fkTcemgNotaFiscalEmpenhoLiquidacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgNotaFiscalEmpenhoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenhoLiquidacao $fkTcemgNotaFiscalEmpenhoLiquidacao
     */
    public function removeFkTcemgNotaFiscalEmpenhoLiquidacoes(\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenhoLiquidacao $fkTcemgNotaFiscalEmpenhoLiquidacao)
    {
        $this->fkTcemgNotaFiscalEmpenhoLiquidacoes->removeElement($fkTcemgNotaFiscalEmpenhoLiquidacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgNotaFiscalEmpenhoLiquidacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenhoLiquidacao
     */
    public function getFkTcemgNotaFiscalEmpenhoLiquidacoes()
    {
        return $this->fkTcemgNotaFiscalEmpenhoLiquidacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgTipoNotaFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoNotaFiscal $fkTcemgTipoNotaFiscal
     * @return NotaFiscal
     */
    public function setFkTcemgTipoNotaFiscal(\Urbem\CoreBundle\Entity\Tcemg\TipoNotaFiscal $fkTcemgTipoNotaFiscal = null)
    {
        if (null === $fkTcemgTipoNotaFiscal) {
            return $this;
        }

        $this->codTipo = $fkTcemgTipoNotaFiscal->getCodTipo();
        $this->fkTcemgTipoNotaFiscal = $fkTcemgTipoNotaFiscal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgTipoNotaFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\TipoNotaFiscal
     */
    public function getFkTcemgTipoNotaFiscal()
    {
        return $this->fkTcemgTipoNotaFiscal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return NotaFiscal
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade = null)
    {
        if (null === $fkOrcamentoEntidade) {
            return $this;
        }

        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }
}
