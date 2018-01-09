<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * NotaLiquidacao
 */
class NotaLiquidacao
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
    private $codNota;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var string
     */
    private $exercicioEmpenho;

    /**
     * @var integer
     */
    private $codEmpenho;

    /**
     * @var \DateTime
     */
    private $dtVencimento;

    /**
     * @var \DateTime
     */
    private $dtLiquidacao;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var \Urbem\CoreBundle\Helper\TimeMicrosecondPK
     */
    private $hora;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\IncorporacaoPatrimonio
     */
    private $fkEmpenhoIncorporacaoPatrimonio;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tceal\Documento
     */
    private $fkTcealDocumento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcepe\Documento
     */
    private $fkTcepeDocumento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcern\NotaFiscal
     */
    private $fkTcernNotaFiscal;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcers\NotaFiscal
     */
    private $fkTcersNotaFiscal;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tceto\NotaLiquidacaoDocumento
     */
    private $fkTcetoNotaLiquidacaoDocumento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmba\NotaFiscalLiquidacao
     */
    private $fkTcmbaNotaFiscalLiquidacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\Liquidacao
     */
    private $fkContabilidadeLiquidacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AtributoLiquidacaoValor
     */
    private $fkEmpenhoAtributoLiquidacaoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoAssinatura
     */
    private $fkEmpenhoNotaLiquidacaoAssinaturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem
     */
    private $fkEmpenhoNotaLiquidacaoItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga
     */
    private $fkEmpenhoNotaLiquidacaoPagas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao
     */
    private $fkEmpenhoPagamentoLiquidacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\Documento
     */
    private $fkTceamDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenhoLiquidacao
     */
    private $fkTcemgNotaFiscalEmpenhoLiquidacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\NotaFiscal
     */
    private $fkTcepbNotaFiscais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenhoLiquidacao
     */
    private $fkTcmgoNotaFiscalEmpenhoLiquidacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\DocumentoLiquidacao
     */
    private $fkEmpenhoDocumentoLiquidacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadeLiquidacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoAtributoLiquidacaoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoNotaLiquidacaoAssinaturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoNotaLiquidacaoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoNotaLiquidacaoPagas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoPagamentoLiquidacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTceamDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgNotaFiscalEmpenhoLiquidacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepbNotaFiscais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoNotaFiscalEmpenhoLiquidacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoDocumentoLiquidacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->hora = new \Urbem\CoreBundle\Helper\TimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return NotaLiquidacao
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
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaLiquidacao
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return NotaLiquidacao
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
     * Set exercicioEmpenho
     *
     * @param string $exercicioEmpenho
     * @return NotaLiquidacao
     */
    public function setExercicioEmpenho($exercicioEmpenho)
    {
        $this->exercicioEmpenho = $exercicioEmpenho;
        return $this;
    }

    /**
     * Get exercicioEmpenho
     *
     * @return string
     */
    public function getExercicioEmpenho()
    {
        return $this->exercicioEmpenho;
    }

    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return NotaLiquidacao
     */
    public function setCodEmpenho($codEmpenho)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * Set dtVencimento
     *
     * @param \DateTime $dtVencimento
     * @return NotaLiquidacao
     */
    public function setDtVencimento(\DateTime $dtVencimento)
    {
        $this->dtVencimento = $dtVencimento;
        return $this;
    }

    /**
     * Get dtVencimento
     *
     * @return \DateTime
     */
    public function getDtVencimento()
    {
        return $this->dtVencimento;
    }

    /**
     * Set dtLiquidacao
     *
     * @param \DateTime $dtLiquidacao
     * @return NotaLiquidacao
     */
    public function setDtLiquidacao(\DateTime $dtLiquidacao)
    {
        $this->dtLiquidacao = $dtLiquidacao;
        return $this;
    }

    /**
     * Get dtLiquidacao
     *
     * @return \DateTime
     */
    public function getDtLiquidacao()
    {
        return $this->dtLiquidacao;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return NotaLiquidacao
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set hora
     *
     * @param \Urbem\CoreBundle\Helper\TimeMicrosecondPK $hora
     * @return NotaLiquidacao
     */
    public function setHora(\Urbem\CoreBundle\Helper\TimeMicrosecondPK $hora)
    {
        $this->hora = $hora;
        return $this;
    }

    /**
     * Get hora
     *
     * @return \Urbem\CoreBundle\Helper\TimeMicrosecondPK
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Liquidacao $fkContabilidadeLiquidacao
     * @return NotaLiquidacao
     */
    public function addFkContabilidadeLiquidacoes(\Urbem\CoreBundle\Entity\Contabilidade\Liquidacao $fkContabilidadeLiquidacao)
    {
        if (false === $this->fkContabilidadeLiquidacoes->contains($fkContabilidadeLiquidacao)) {
            $fkContabilidadeLiquidacao->setFkEmpenhoNotaLiquidacao($this);
            $this->fkContabilidadeLiquidacoes->add($fkContabilidadeLiquidacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Liquidacao $fkContabilidadeLiquidacao
     */
    public function removeFkContabilidadeLiquidacoes(\Urbem\CoreBundle\Entity\Contabilidade\Liquidacao $fkContabilidadeLiquidacao)
    {
        $this->fkContabilidadeLiquidacoes->removeElement($fkContabilidadeLiquidacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLiquidacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\Liquidacao
     */
    public function getFkContabilidadeLiquidacoes()
    {
        return $this->fkContabilidadeLiquidacoes;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoAtributoLiquidacaoValor
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AtributoLiquidacaoValor $fkEmpenhoAtributoLiquidacaoValor
     * @return NotaLiquidacao
     */
    public function addFkEmpenhoAtributoLiquidacaoValores(\Urbem\CoreBundle\Entity\Empenho\AtributoLiquidacaoValor $fkEmpenhoAtributoLiquidacaoValor)
    {
        if (false === $this->fkEmpenhoAtributoLiquidacaoValores->contains($fkEmpenhoAtributoLiquidacaoValor)) {
            $fkEmpenhoAtributoLiquidacaoValor->setFkEmpenhoNotaLiquidacao($this);
            $this->fkEmpenhoAtributoLiquidacaoValores->add($fkEmpenhoAtributoLiquidacaoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoAtributoLiquidacaoValor
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AtributoLiquidacaoValor $fkEmpenhoAtributoLiquidacaoValor
     */
    public function removeFkEmpenhoAtributoLiquidacaoValores(\Urbem\CoreBundle\Entity\Empenho\AtributoLiquidacaoValor $fkEmpenhoAtributoLiquidacaoValor)
    {
        $this->fkEmpenhoAtributoLiquidacaoValores->removeElement($fkEmpenhoAtributoLiquidacaoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoAtributoLiquidacaoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AtributoLiquidacaoValor
     */
    public function getFkEmpenhoAtributoLiquidacaoValores()
    {
        return $this->fkEmpenhoAtributoLiquidacaoValores;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoNotaLiquidacaoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoAssinatura $fkEmpenhoNotaLiquidacaoAssinatura
     * @return NotaLiquidacao
     */
    public function addFkEmpenhoNotaLiquidacaoAssinaturas(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoAssinatura $fkEmpenhoNotaLiquidacaoAssinatura)
    {
        if (false === $this->fkEmpenhoNotaLiquidacaoAssinaturas->contains($fkEmpenhoNotaLiquidacaoAssinatura)) {
            $fkEmpenhoNotaLiquidacaoAssinatura->setFkEmpenhoNotaLiquidacao($this);
            $this->fkEmpenhoNotaLiquidacaoAssinaturas->add($fkEmpenhoNotaLiquidacaoAssinatura);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoNotaLiquidacaoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoAssinatura $fkEmpenhoNotaLiquidacaoAssinatura
     */
    public function removeFkEmpenhoNotaLiquidacaoAssinaturas(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoAssinatura $fkEmpenhoNotaLiquidacaoAssinatura)
    {
        $this->fkEmpenhoNotaLiquidacaoAssinaturas->removeElement($fkEmpenhoNotaLiquidacaoAssinatura);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoNotaLiquidacaoAssinaturas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoAssinatura
     */
    public function getFkEmpenhoNotaLiquidacaoAssinaturas()
    {
        return $this->fkEmpenhoNotaLiquidacaoAssinaturas;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoNotaLiquidacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem $fkEmpenhoNotaLiquidacaoItem
     * @return NotaLiquidacao
     */
    public function addFkEmpenhoNotaLiquidacaoItens(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem $fkEmpenhoNotaLiquidacaoItem)
    {
        if (false === $this->fkEmpenhoNotaLiquidacaoItens->contains($fkEmpenhoNotaLiquidacaoItem)) {
            $fkEmpenhoNotaLiquidacaoItem->setFkEmpenhoNotaLiquidacao($this);
            $this->fkEmpenhoNotaLiquidacaoItens->add($fkEmpenhoNotaLiquidacaoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoNotaLiquidacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem $fkEmpenhoNotaLiquidacaoItem
     */
    public function removeFkEmpenhoNotaLiquidacaoItens(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem $fkEmpenhoNotaLiquidacaoItem)
    {
        $this->fkEmpenhoNotaLiquidacaoItens->removeElement($fkEmpenhoNotaLiquidacaoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoNotaLiquidacaoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem
     */
    public function getFkEmpenhoNotaLiquidacaoItens()
    {
        return $this->fkEmpenhoNotaLiquidacaoItens;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoNotaLiquidacaoPaga
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga $fkEmpenhoNotaLiquidacaoPaga
     * @return NotaLiquidacao
     */
    public function addFkEmpenhoNotaLiquidacaoPagas(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga $fkEmpenhoNotaLiquidacaoPaga)
    {
        if (false === $this->fkEmpenhoNotaLiquidacaoPagas->contains($fkEmpenhoNotaLiquidacaoPaga)) {
            $fkEmpenhoNotaLiquidacaoPaga->setFkEmpenhoNotaLiquidacao($this);
            $this->fkEmpenhoNotaLiquidacaoPagas->add($fkEmpenhoNotaLiquidacaoPaga);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoNotaLiquidacaoPaga
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga $fkEmpenhoNotaLiquidacaoPaga
     */
    public function removeFkEmpenhoNotaLiquidacaoPagas(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga $fkEmpenhoNotaLiquidacaoPaga)
    {
        $this->fkEmpenhoNotaLiquidacaoPagas->removeElement($fkEmpenhoNotaLiquidacaoPaga);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoNotaLiquidacaoPagas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga
     */
    public function getFkEmpenhoNotaLiquidacaoPagas()
    {
        return $this->fkEmpenhoNotaLiquidacaoPagas;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoPagamentoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao $fkEmpenhoPagamentoLiquidacao
     * @return NotaLiquidacao
     */
    public function addFkEmpenhoPagamentoLiquidacoes(\Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao $fkEmpenhoPagamentoLiquidacao)
    {
        if (false === $this->fkEmpenhoPagamentoLiquidacoes->contains($fkEmpenhoPagamentoLiquidacao)) {
            $fkEmpenhoPagamentoLiquidacao->setFkEmpenhoNotaLiquidacao($this);
            $this->fkEmpenhoPagamentoLiquidacoes->add($fkEmpenhoPagamentoLiquidacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoPagamentoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao $fkEmpenhoPagamentoLiquidacao
     */
    public function removeFkEmpenhoPagamentoLiquidacoes(\Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao $fkEmpenhoPagamentoLiquidacao)
    {
        $this->fkEmpenhoPagamentoLiquidacoes->removeElement($fkEmpenhoPagamentoLiquidacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoPagamentoLiquidacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao
     */
    public function getFkEmpenhoPagamentoLiquidacoes()
    {
        return $this->fkEmpenhoPagamentoLiquidacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TceamDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\Documento $fkTceamDocumento
     * @return NotaLiquidacao
     */
    public function addFkTceamDocumentos(\Urbem\CoreBundle\Entity\Tceam\Documento $fkTceamDocumento)
    {
        if (false === $this->fkTceamDocumentos->contains($fkTceamDocumento)) {
            $fkTceamDocumento->setFkEmpenhoNotaLiquidacao($this);
            $this->fkTceamDocumentos->add($fkTceamDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TceamDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\Documento $fkTceamDocumento
     */
    public function removeFkTceamDocumentos(\Urbem\CoreBundle\Entity\Tceam\Documento $fkTceamDocumento)
    {
        $this->fkTceamDocumentos->removeElement($fkTceamDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTceamDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\Documento
     */
    public function getFkTceamDocumentos()
    {
        return $this->fkTceamDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgNotaFiscalEmpenhoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenhoLiquidacao $fkTcemgNotaFiscalEmpenhoLiquidacao
     * @return NotaLiquidacao
     */
    public function addFkTcemgNotaFiscalEmpenhoLiquidacoes(\Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenhoLiquidacao $fkTcemgNotaFiscalEmpenhoLiquidacao)
    {
        if (false === $this->fkTcemgNotaFiscalEmpenhoLiquidacoes->contains($fkTcemgNotaFiscalEmpenhoLiquidacao)) {
            $fkTcemgNotaFiscalEmpenhoLiquidacao->setFkEmpenhoNotaLiquidacao($this);
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
     * OneToMany (owning side)
     * Add TcepbNotaFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\NotaFiscal $fkTcepbNotaFiscal
     * @return NotaLiquidacao
     */
    public function addFkTcepbNotaFiscais(\Urbem\CoreBundle\Entity\Tcepb\NotaFiscal $fkTcepbNotaFiscal)
    {
        if (false === $this->fkTcepbNotaFiscais->contains($fkTcepbNotaFiscal)) {
            $fkTcepbNotaFiscal->setFkEmpenhoNotaLiquidacao($this);
            $this->fkTcepbNotaFiscais->add($fkTcepbNotaFiscal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepbNotaFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\NotaFiscal $fkTcepbNotaFiscal
     */
    public function removeFkTcepbNotaFiscais(\Urbem\CoreBundle\Entity\Tcepb\NotaFiscal $fkTcepbNotaFiscal)
    {
        $this->fkTcepbNotaFiscais->removeElement($fkTcepbNotaFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepbNotaFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\NotaFiscal
     */
    public function getFkTcepbNotaFiscais()
    {
        return $this->fkTcepbNotaFiscais;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoNotaFiscalEmpenhoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenhoLiquidacao $fkTcmgoNotaFiscalEmpenhoLiquidacao
     * @return NotaLiquidacao
     */
    public function addFkTcmgoNotaFiscalEmpenhoLiquidacoes(\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscalEmpenhoLiquidacao $fkTcmgoNotaFiscalEmpenhoLiquidacao)
    {
        if (false === $this->fkTcmgoNotaFiscalEmpenhoLiquidacoes->contains($fkTcmgoNotaFiscalEmpenhoLiquidacao)) {
            $fkTcmgoNotaFiscalEmpenhoLiquidacao->setFkEmpenhoNotaLiquidacao($this);
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
     * Add EmpenhoDocumentoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\DocumentoLiquidacao $fkEmpenhoDocumentoLiquidacao
     * @return NotaLiquidacao
     */
    public function addFkEmpenhoDocumentoLiquidacoes(\Urbem\CoreBundle\Entity\Empenho\DocumentoLiquidacao $fkEmpenhoDocumentoLiquidacao)
    {
        if (false === $this->fkEmpenhoDocumentoLiquidacoes->contains($fkEmpenhoDocumentoLiquidacao)) {
            $fkEmpenhoDocumentoLiquidacao->setFkEmpenhoNotaLiquidacao($this);
            $this->fkEmpenhoDocumentoLiquidacoes->add($fkEmpenhoDocumentoLiquidacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoDocumentoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\DocumentoLiquidacao $fkEmpenhoDocumentoLiquidacao
     */
    public function removeFkEmpenhoDocumentoLiquidacoes(\Urbem\CoreBundle\Entity\Empenho\DocumentoLiquidacao $fkEmpenhoDocumentoLiquidacao)
    {
        $this->fkEmpenhoDocumentoLiquidacoes->removeElement($fkEmpenhoDocumentoLiquidacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoDocumentoLiquidacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\DocumentoLiquidacao
     */
    public function getFkEmpenhoDocumentoLiquidacoes()
    {
        return $this->fkEmpenhoDocumentoLiquidacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return NotaLiquidacao
     */
    public function setFkEmpenhoEmpenho(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        $this->codEmpenho = $fkEmpenhoEmpenho->getCodEmpenho();
        $this->exercicioEmpenho = $fkEmpenhoEmpenho->getExercicio();
        $this->codEntidade = $fkEmpenhoEmpenho->getCodEntidade();
        $this->fkEmpenhoEmpenho = $fkEmpenhoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenho()
    {
        return $this->fkEmpenhoEmpenho;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoIncorporacaoPatrimonio
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\IncorporacaoPatrimonio $fkEmpenhoIncorporacaoPatrimonio
     * @return NotaLiquidacao
     */
    public function setFkEmpenhoIncorporacaoPatrimonio(\Urbem\CoreBundle\Entity\Empenho\IncorporacaoPatrimonio $fkEmpenhoIncorporacaoPatrimonio)
    {
        $fkEmpenhoIncorporacaoPatrimonio->setFkEmpenhoNotaLiquidacao($this);
        $this->fkEmpenhoIncorporacaoPatrimonio = $fkEmpenhoIncorporacaoPatrimonio;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoIncorporacaoPatrimonio
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\IncorporacaoPatrimonio
     */
    public function getFkEmpenhoIncorporacaoPatrimonio()
    {
        return $this->fkEmpenhoIncorporacaoPatrimonio;
    }

    /**
     * OneToOne (inverse side)
     * Set TcealDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\Documento $fkTcealDocumento
     * @return NotaLiquidacao
     */
    public function setFkTcealDocumento(\Urbem\CoreBundle\Entity\Tceal\Documento $fkTcealDocumento)
    {
        $fkTcealDocumento->setFkEmpenhoNotaLiquidacao($this);
        $this->fkTcealDocumento = $fkTcealDocumento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcealDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Tceal\Documento
     */
    public function getFkTcealDocumento()
    {
        return $this->fkTcealDocumento;
    }

    /**
     * OneToOne (inverse side)
     * Set TcepeDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\Documento $fkTcepeDocumento
     * @return NotaLiquidacao
     */
    public function setFkTcepeDocumento(\Urbem\CoreBundle\Entity\Tcepe\Documento $fkTcepeDocumento)
    {
        $fkTcepeDocumento->setFkEmpenhoNotaLiquidacao($this);
        $this->fkTcepeDocumento = $fkTcepeDocumento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcepeDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\Documento
     */
    public function getFkTcepeDocumento()
    {
        return $this->fkTcepeDocumento;
    }

    /**
     * OneToOne (inverse side)
     * Set TcernNotaFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\NotaFiscal $fkTcernNotaFiscal
     * @return NotaLiquidacao
     */
    public function setFkTcernNotaFiscal(\Urbem\CoreBundle\Entity\Tcern\NotaFiscal $fkTcernNotaFiscal)
    {
        $fkTcernNotaFiscal->setFkEmpenhoNotaLiquidacao($this);
        $this->fkTcernNotaFiscal = $fkTcernNotaFiscal;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcernNotaFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\NotaFiscal
     */
    public function getFkTcernNotaFiscal()
    {
        return $this->fkTcernNotaFiscal;
    }

    /**
     * OneToOne (inverse side)
     * Set TcersNotaFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\NotaFiscal $fkTcersNotaFiscal
     * @return NotaLiquidacao
     */
    public function setFkTcersNotaFiscal(\Urbem\CoreBundle\Entity\Tcers\NotaFiscal $fkTcersNotaFiscal)
    {
        $fkTcersNotaFiscal->setFkEmpenhoNotaLiquidacao($this);
        $this->fkTcersNotaFiscal = $fkTcersNotaFiscal;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcersNotaFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Tcers\NotaFiscal
     */
    public function getFkTcersNotaFiscal()
    {
        return $this->fkTcersNotaFiscal;
    }

    /**
     * OneToOne (inverse side)
     * Set TcetoNotaLiquidacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\NotaLiquidacaoDocumento $fkTcetoNotaLiquidacaoDocumento
     * @return NotaLiquidacao
     */
    public function setFkTcetoNotaLiquidacaoDocumento(\Urbem\CoreBundle\Entity\Tceto\NotaLiquidacaoDocumento $fkTcetoNotaLiquidacaoDocumento)
    {
        $fkTcetoNotaLiquidacaoDocumento->setFkEmpenhoNotaLiquidacao($this);
        $this->fkTcetoNotaLiquidacaoDocumento = $fkTcetoNotaLiquidacaoDocumento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcetoNotaLiquidacaoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Tceto\NotaLiquidacaoDocumento
     */
    public function getFkTcetoNotaLiquidacaoDocumento()
    {
        return $this->fkTcetoNotaLiquidacaoDocumento;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmbaNotaFiscalLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\NotaFiscalLiquidacao $fkTcmbaNotaFiscalLiquidacao
     * @return NotaLiquidacao
     */
    public function setFkTcmbaNotaFiscalLiquidacao(\Urbem\CoreBundle\Entity\Tcmba\NotaFiscalLiquidacao $fkTcmbaNotaFiscalLiquidacao)
    {
        $fkTcmbaNotaFiscalLiquidacao->setFkEmpenhoNotaLiquidacao($this);
        $this->fkTcmbaNotaFiscalLiquidacao = $fkTcmbaNotaFiscalLiquidacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmbaNotaFiscalLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\NotaFiscalLiquidacao
     */
    public function getFkTcmbaNotaFiscalLiquidacao()
    {
        return $this->fkTcmbaNotaFiscalLiquidacao;
    }

    /**
     * @return string
     */
    public function getEmpenho()
    {
        return sprintf('%s/%s', $this->codEmpenho, $this->exercicioEmpenho);
    }

    /**
     * @return string
     */
    public function getNotaLiquidacao()
    {
        return sprintf('%s/%s', $this->codNota, $this->exercicio);
    }

    /**
     * @return string
     */
    public function getOrdemPagamento()
    {
        return ($this->getVlOrdemPagamento() > 0) ? $this->fkEmpenhoPagamentoLiquidacoes->last()->getFkEmpenhoOrdemPagamento() : null;
    }

    /**
     * @return string
     */
    public function getCredor()
    {
        return $this->fkEmpenhoEmpenho->getFkEmpenhoPreEmpenho()->getFkSwCgm()->getNomCgm();
    }

    /**
     * @return float
     */
    public function getVlNota()
    {
        $valor = 0.00;
        if (!$this->getOrdemPagamento()) {
            foreach ($this->getFkEmpenhoNotaLiquidacaoItens() as $item) {
                $valor += $item->getVlTotal();
                foreach ($item->getFkEmpenhoNotaLiquidacaoItemAnulados() as $itemAnulado) {
                    $valor -= $itemAnulado->getVlAnulado();
                }
            }
            $valor -= $this->getVlPago();
        }
        return $valor;
    }

    public function getVlPago()
    {
        $valor = 0.00;
        foreach ($this->fkEmpenhoNotaLiquidacaoPagas as $fkEmpenhoNotaLiquidacaoPaga) {
            $valor += (float) $fkEmpenhoNotaLiquidacaoPaga->getVlPago();
            foreach ($fkEmpenhoNotaLiquidacaoPaga->getFkEmpenhoNotaLiquidacaoPagaAnuladas() as $fkEmpenhoNotaLiquidacaoPagaAnulada) {
                $valor -= $fkEmpenhoNotaLiquidacaoPagaAnulada->getVlAnulado();
            }
        }
        return $valor;
    }

    /**
     * @return float
     */
    public function getVlOrdemPagamento()
    {
        $valor = 0.00;
        if ($this->fkEmpenhoPagamentoLiquidacoes->last()) {
            $ordemPagamento = $this->fkEmpenhoPagamentoLiquidacoes->last()->getFkEmpenhoOrdemPagamento();
            foreach ($ordemPagamento->getFkEmpenhoPagamentoLiquidacoes() as $pagamentoLiquidacao) {
                $valor += $pagamentoLiquidacao->getVlPagamento();
                foreach ($pagamentoLiquidacao->getFkEmpenhoOrdemPagamentoLiquidacaoAnuladas() as $ordemPagamentoLiquidacaoAnulada) {
                    $valor -= $ordemPagamentoLiquidacaoAnulada->getVlAnulado();
                }
            }
            $valor -= $this->getVlPago();
        }
        return $valor;
    }

    public function getOrdemPagamentoEstorno()
    {
        return $this->fkEmpenhoPagamentoLiquidacoes->last()->getFkEmpenhoOrdemPagamento();
    }

    /**
     * @return \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    public function getRecursoDespesa()
    {
        return $this
            ->fkEmpenhoEmpenho
            ->getFkEmpenhoPreEmpenho()
            ->getFkEmpenhoPreEmpenhoDespesa()
            ->getFkOrcamentoDespesa()
            ->getFkOrcamentoRecurso();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s-%s', $this->codNota, (!empty($this->dtLiquidacao) ? $this->dtLiquidacao->format('d/m/Y') : ''));
    }
}
