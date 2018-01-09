<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ComplementarSituacao
 */
class ComplementarSituacao
{
    const SITUACAO_ABERTO = 'a';
    const SITUACAO_FECHADO = 'f';
    /**
     * PK
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * PK
     * @var integer
     */
    private $codComplementar;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $situacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacaoFechada
     */
    private $fkFolhapagamentoComplementarSituacaoFechadas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Complementar
     */
    private $fkFolhapagamentoComplementar;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoComplementarSituacaoFechadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return ComplementarSituacao
     */
    public function setCodPeriodoMovimentacao($codPeriodoMovimentacao)
    {
        $this->codPeriodoMovimentacao = $codPeriodoMovimentacao;
        return $this;
    }

    /**
     * Get codPeriodoMovimentacao
     *
     * @return integer
     */
    public function getCodPeriodoMovimentacao()
    {
        return $this->codPeriodoMovimentacao;
    }

    /**
     * Set codComplementar
     *
     * @param integer $codComplementar
     * @return ComplementarSituacao
     */
    public function setCodComplementar($codComplementar)
    {
        $this->codComplementar = $codComplementar;
        return $this;
    }

    /**
     * Get codComplementar
     *
     * @return integer
     */
    public function getCodComplementar()
    {
        return $this->codComplementar;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ComplementarSituacao
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
     * Set situacao
     *
     * @param string $situacao
     * @return ComplementarSituacao
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
        return $this;
    }

    /**
     * Get situacao
     *
     * @return string
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoComplementarSituacaoFechada
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacaoFechada $fkFolhapagamentoComplementarSituacaoFechada
     * @return ComplementarSituacao
     */
    public function addFkFolhapagamentoComplementarSituacaoFechadas(\Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacaoFechada $fkFolhapagamentoComplementarSituacaoFechada)
    {
        if (false === $this->fkFolhapagamentoComplementarSituacaoFechadas->contains($fkFolhapagamentoComplementarSituacaoFechada)) {
            $fkFolhapagamentoComplementarSituacaoFechada->setFkFolhapagamentoComplementarSituacao($this);
            $this->fkFolhapagamentoComplementarSituacaoFechadas->add($fkFolhapagamentoComplementarSituacaoFechada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoComplementarSituacaoFechada
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacaoFechada $fkFolhapagamentoComplementarSituacaoFechada
     */
    public function removeFkFolhapagamentoComplementarSituacaoFechadas(\Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacaoFechada $fkFolhapagamentoComplementarSituacaoFechada)
    {
        $this->fkFolhapagamentoComplementarSituacaoFechadas->removeElement($fkFolhapagamentoComplementarSituacaoFechada);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoComplementarSituacaoFechadas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacaoFechada
     */
    public function getFkFolhapagamentoComplementarSituacaoFechadas()
    {
        return $this->fkFolhapagamentoComplementarSituacaoFechadas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Complementar $fkFolhapagamentoComplementar
     * @return ComplementarSituacao
     */
    public function setFkFolhapagamentoComplementar(\Urbem\CoreBundle\Entity\Folhapagamento\Complementar $fkFolhapagamentoComplementar)
    {
        $this->codComplementar = $fkFolhapagamentoComplementar->getCodComplementar();
        $this->codPeriodoMovimentacao = $fkFolhapagamentoComplementar->getCodPeriodoMovimentacao();
        $this->fkFolhapagamentoComplementar = $fkFolhapagamentoComplementar;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoComplementar
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Complementar
     */
    public function getFkFolhapagamentoComplementar()
    {
        return $this->fkFolhapagamentoComplementar;
    }
}
