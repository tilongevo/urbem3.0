<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

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
     * @var integer
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
     * @var integer
     */
    private $vlNota;

    /**
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * @var integer
     */
    private $inscricaoEstadual;

    /**
     * @var integer
     */
    private $nroSequencial;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $chaveAcesso;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenhoLiquidacao
     */
    private $fkTcmgoNotaFiscalEmpenhoLiquidacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenho
     */
    private $fkTcmgoNotaFiscalEmpenhos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoNotaFiscalEmpenhoLiquidacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoNotaFiscalEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nroNota
     *
     * @param integer $nroNota
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
     * @return integer
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
    public function setAidf($aidf)
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
    public function setDataEmissao(\DateTime $dataEmissao)
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
     * Set vlNota
     *
     * @param integer $vlNota
     * @return NotaFiscal
     */
    public function setVlNota($vlNota)
    {
        $this->vlNota = $vlNota;
        return $this;
    }

    /**
     * Get vlNota
     *
     * @return integer
     */
    public function getVlNota()
    {
        return $this->vlNota;
    }

    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
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
     * @return integer
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * Set inscricaoEstadual
     *
     * @param integer $inscricaoEstadual
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
     * @return integer
     */
    public function getInscricaoEstadual()
    {
        return $this->inscricaoEstadual;
    }

    /**
     * Set nroSequencial
     *
     * @param integer $nroSequencial
     * @return NotaFiscal
     */
    public function setNroSequencial($nroSequencial)
    {
        $this->nroSequencial = $nroSequencial;
        return $this;
    }

    /**
     * Get nroSequencial
     *
     * @return integer
     */
    public function getNroSequencial()
    {
        return $this->nroSequencial;
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
     * OneToMany (owning side)
     * Add TcmgoNotaFiscalEmpenhoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenhoLiquidacao $fkTcmgoNotaFiscalEmpenhoLiquidacao
     * @return NotaFiscal
     */
    public function addFkTcmgoNotaFiscalEmpenhoLiquidacoes(\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenhoLiquidacao $fkTcmgoNotaFiscalEmpenhoLiquidacao)
    {
        if (false === $this->fkTcmgoNotaFiscalEmpenhoLiquidacoes->contains($fkTcmgoNotaFiscalEmpenhoLiquidacao)) {
            $fkTcmgoNotaFiscalEmpenhoLiquidacao->setFkTcmgoNotaFiscal($this);
            $this->fkTcmgoNotaFiscalEmpenhoLiquidacoes->add($fkTcmgoNotaFiscalEmpenhoLiquidacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoNotaFiscalEmpenhoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenhoLiquidacao $fkTcmgoNotaFiscalEmpenhoLiquidacao
     */
    public function removeFkTcmgoNotaFiscalEmpenhoLiquidacoes(\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenhoLiquidacao $fkTcmgoNotaFiscalEmpenhoLiquidacao)
    {
        $this->fkTcmgoNotaFiscalEmpenhoLiquidacoes->removeElement($fkTcmgoNotaFiscalEmpenhoLiquidacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoNotaFiscalEmpenhoLiquidacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenhoLiquidacao
     */
    public function getFkTcmgoNotaFiscalEmpenhoLiquidacoes()
    {
        return $this->fkTcmgoNotaFiscalEmpenhoLiquidacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoNotaFiscalEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenho $fkTcmgoNotaFiscalEmpenho
     * @return NotaFiscal
     */
    public function addFkTcmgoNotaFiscalEmpenhos(\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenho $fkTcmgoNotaFiscalEmpenho)
    {
        if (false === $this->fkTcmgoNotaFiscalEmpenhos->contains($fkTcmgoNotaFiscalEmpenho)) {
            $fkTcmgoNotaFiscalEmpenho->setFkTcmgoNotaFiscal($this);
            $this->fkTcmgoNotaFiscalEmpenhos->add($fkTcmgoNotaFiscalEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoNotaFiscalEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenho $fkTcmgoNotaFiscalEmpenho
     */
    public function removeFkTcmgoNotaFiscalEmpenhos(\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenho $fkTcmgoNotaFiscalEmpenho)
    {
        $this->fkTcmgoNotaFiscalEmpenhos->removeElement($fkTcmgoNotaFiscalEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoNotaFiscalEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenho
     */
    public function getFkTcmgoNotaFiscalEmpenhos()
    {
        return $this->fkTcmgoNotaFiscalEmpenhos;
    }
}
