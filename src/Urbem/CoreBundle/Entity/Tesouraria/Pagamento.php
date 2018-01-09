<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * Pagamento
 */
class Pagamento
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * @var integer
     */
    private $codAutenticacao;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $dtAutenticacao;

    /**
     * @var integer
     */
    private $codBoletim;

    /**
     * @var string
     */
    private $exercicioBoletim;

    /**
     * @var integer
     */
    private $codTerminal;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $timestampTerminal;

    /**
     * @var integer
     */
    private $cgmUsuario;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $timestampUsuario;

    /**
     * @var integer
     */
    private $codPlano;

    /**
     * @var string
     */
    private $exercicioPlano;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcepb\PagamentoOrigemRecursosInterna
     */
    private $fkTcepbPagamentoOrigemRecursosInterna;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga
     */
    private $fkEmpenhoNotaLiquidacaoPaga;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\PagamentoTipoPagamento
     */
    private $fkTcetoPagamentoTipoPagamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\PagamentoTipoDocumentoPagamento
     */
    private $fkTcmbaPagamentoTipoDocumentoPagamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado
     */
    private $fkTesourariaPagamentoEstornados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\PagamentoTipoDocumento
     */
    private $fkTesourariaPagamentoTipoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\PagamentoTipoDocumento
     */
    private $fkTcealPagamentoTipoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\PagamentoTipoDocumento
     */
    private $fkTcemgPagamentoTipoDocumentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Boletim
     */
    private $fkTesourariaBoletim;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Autenticacao
     */
    private $fkTesourariaAutenticacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal
     */
    private $fkTesourariaUsuarioTerminal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcetoPagamentoTipoPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaPagamentoTipoDocumentoPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaPagamentoEstornados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaPagamentoTipoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcealPagamentoTipoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgPagamentoTipoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Pagamento
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return Pagamento
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Pagamento
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
     * Set codNota
     *
     * @param integer $codNota
     * @return Pagamento
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
     * Set codAutenticacao
     *
     * @param integer $codAutenticacao
     * @return Pagamento
     */
    public function setCodAutenticacao($codAutenticacao)
    {
        $this->codAutenticacao = $codAutenticacao;
        return $this;
    }

    /**
     * Get codAutenticacao
     *
     * @return integer
     */
    public function getCodAutenticacao()
    {
        return $this->codAutenticacao;
    }

    /**
     * Set dtAutenticacao
     *
     * @param DateTimeMicrosecondPK $dtAutenticacao
     * @return Pagamento
     */
    public function setDtAutenticacao(DateTimeMicrosecondPK $dtAutenticacao)
    {
        $this->dtAutenticacao = $dtAutenticacao;
        return $this;
    }

    /**
     * Get dtAutenticacao
     *
     * @return DateTimeMicrosecondPK
     */
    public function getDtAutenticacao()
    {
        return $this->dtAutenticacao;
    }

    /**
     * Set codBoletim
     *
     * @param integer $codBoletim
     * @return Pagamento
     */
    public function setCodBoletim($codBoletim)
    {
        $this->codBoletim = $codBoletim;
        return $this;
    }

    /**
     * Get codBoletim
     *
     * @return integer
     */
    public function getCodBoletim()
    {
        return $this->codBoletim;
    }

    /**
     * Set exercicioBoletim
     *
     * @param string $exercicioBoletim
     * @return Pagamento
     */
    public function setExercicioBoletim($exercicioBoletim)
    {
        $this->exercicioBoletim = $exercicioBoletim;
        return $this;
    }

    /**
     * Get exercicioBoletim
     *
     * @return string
     */
    public function getExercicioBoletim()
    {
        return $this->exercicioBoletim;
    }

    /**
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return Pagamento
     */
    public function setCodTerminal($codTerminal)
    {
        $this->codTerminal = $codTerminal;
        return $this;
    }

    /**
     * Get codTerminal
     *
     * @return integer
     */
    public function getCodTerminal()
    {
        return $this->codTerminal;
    }

    /**
     * Set timestampTerminal
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampTerminal
     * @return Pagamento
     */
    public function setTimestampTerminal(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampTerminal)
    {
        $this->timestampTerminal = $timestampTerminal;
        return $this;
    }

    /**
     * Get timestampTerminal
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampTerminal()
    {
        return $this->timestampTerminal;
    }

    /**
     * Set cgmUsuario
     *
     * @param integer $cgmUsuario
     * @return Pagamento
     */
    public function setCgmUsuario($cgmUsuario)
    {
        $this->cgmUsuario = $cgmUsuario;
        return $this;
    }

    /**
     * Get cgmUsuario
     *
     * @return integer
     */
    public function getCgmUsuario()
    {
        return $this->cgmUsuario;
    }

    /**
     * Set timestampUsuario
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampUsuario
     * @return Pagamento
     */
    public function setTimestampUsuario(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampUsuario)
    {
        $this->timestampUsuario = $timestampUsuario;
        return $this;
    }

    /**
     * Get timestampUsuario
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampUsuario()
    {
        return $this->timestampUsuario;
    }

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return Pagamento
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * Set exercicioPlano
     *
     * @param string $exercicioPlano
     * @return Pagamento
     */
    public function setExercicioPlano($exercicioPlano)
    {
        $this->exercicioPlano = $exercicioPlano;
        return $this;
    }

    /**
     * Get exercicioPlano
     *
     * @return string
     */
    public function getExercicioPlano()
    {
        return $this->exercicioPlano;
    }

    /**
     * OneToMany (owning side)
     * Add TcetoPagamentoTipoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\PagamentoTipoPagamento $fkTcetoPagamentoTipoPagamento
     * @return Pagamento
     */
    public function addFkTcetoPagamentoTipoPagamentos(\Urbem\CoreBundle\Entity\Tceto\PagamentoTipoPagamento $fkTcetoPagamentoTipoPagamento)
    {
        if (false === $this->fkTcetoPagamentoTipoPagamentos->contains($fkTcetoPagamentoTipoPagamento)) {
            $fkTcetoPagamentoTipoPagamento->setFkTesourariaPagamento($this);
            $this->fkTcetoPagamentoTipoPagamentos->add($fkTcetoPagamentoTipoPagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcetoPagamentoTipoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\PagamentoTipoPagamento $fkTcetoPagamentoTipoPagamento
     */
    public function removeFkTcetoPagamentoTipoPagamentos(\Urbem\CoreBundle\Entity\Tceto\PagamentoTipoPagamento $fkTcetoPagamentoTipoPagamento)
    {
        $this->fkTcetoPagamentoTipoPagamentos->removeElement($fkTcetoPagamentoTipoPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcetoPagamentoTipoPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\PagamentoTipoPagamento
     */
    public function getFkTcetoPagamentoTipoPagamentos()
    {
        return $this->fkTcetoPagamentoTipoPagamentos;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaPagamentoTipoDocumentoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\PagamentoTipoDocumentoPagamento $fkTcmbaPagamentoTipoDocumentoPagamento
     * @return Pagamento
     */
    public function addFkTcmbaPagamentoTipoDocumentoPagamentos(\Urbem\CoreBundle\Entity\Tcmba\PagamentoTipoDocumentoPagamento $fkTcmbaPagamentoTipoDocumentoPagamento)
    {
        if (false === $this->fkTcmbaPagamentoTipoDocumentoPagamentos->contains($fkTcmbaPagamentoTipoDocumentoPagamento)) {
            $fkTcmbaPagamentoTipoDocumentoPagamento->setFkTesourariaPagamento($this);
            $this->fkTcmbaPagamentoTipoDocumentoPagamentos->add($fkTcmbaPagamentoTipoDocumentoPagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaPagamentoTipoDocumentoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\PagamentoTipoDocumentoPagamento $fkTcmbaPagamentoTipoDocumentoPagamento
     */
    public function removeFkTcmbaPagamentoTipoDocumentoPagamentos(\Urbem\CoreBundle\Entity\Tcmba\PagamentoTipoDocumentoPagamento $fkTcmbaPagamentoTipoDocumentoPagamento)
    {
        $this->fkTcmbaPagamentoTipoDocumentoPagamentos->removeElement($fkTcmbaPagamentoTipoDocumentoPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaPagamentoTipoDocumentoPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\PagamentoTipoDocumentoPagamento
     */
    public function getFkTcmbaPagamentoTipoDocumentoPagamentos()
    {
        return $this->fkTcmbaPagamentoTipoDocumentoPagamentos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaPagamentoEstornado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado $fkTesourariaPagamentoEstornado
     * @return Pagamento
     */
    public function addFkTesourariaPagamentoEstornados(\Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado $fkTesourariaPagamentoEstornado)
    {
        if (false === $this->fkTesourariaPagamentoEstornados->contains($fkTesourariaPagamentoEstornado)) {
            $fkTesourariaPagamentoEstornado->setFkTesourariaPagamento($this);
            $this->fkTesourariaPagamentoEstornados->add($fkTesourariaPagamentoEstornado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaPagamentoEstornado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado $fkTesourariaPagamentoEstornado
     */
    public function removeFkTesourariaPagamentoEstornados(\Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado $fkTesourariaPagamentoEstornado)
    {
        $this->fkTesourariaPagamentoEstornados->removeElement($fkTesourariaPagamentoEstornado);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaPagamentoEstornados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado
     */
    public function getFkTesourariaPagamentoEstornados()
    {
        return $this->fkTesourariaPagamentoEstornados;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaPagamentoTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\PagamentoTipoDocumento $fkTesourariaPagamentoTipoDocumento
     * @return Pagamento
     */
    public function addFkTesourariaPagamentoTipoDocumentos(\Urbem\CoreBundle\Entity\Tesouraria\PagamentoTipoDocumento $fkTesourariaPagamentoTipoDocumento)
    {
        if (false === $this->fkTesourariaPagamentoTipoDocumentos->contains($fkTesourariaPagamentoTipoDocumento)) {
            $fkTesourariaPagamentoTipoDocumento->setFkTesourariaPagamento($this);
            $this->fkTesourariaPagamentoTipoDocumentos->add($fkTesourariaPagamentoTipoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaPagamentoTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\PagamentoTipoDocumento $fkTesourariaPagamentoTipoDocumento
     */
    public function removeFkTesourariaPagamentoTipoDocumentos(\Urbem\CoreBundle\Entity\Tesouraria\PagamentoTipoDocumento $fkTesourariaPagamentoTipoDocumento)
    {
        $this->fkTesourariaPagamentoTipoDocumentos->removeElement($fkTesourariaPagamentoTipoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaPagamentoTipoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\PagamentoTipoDocumento
     */
    public function getFkTesourariaPagamentoTipoDocumentos()
    {
        return $this->fkTesourariaPagamentoTipoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add TcealPagamentoTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\PagamentoTipoDocumento $fkTcealPagamentoTipoDocumento
     * @return Pagamento
     */
    public function addFkTcealPagamentoTipoDocumentos(\Urbem\CoreBundle\Entity\Tceal\PagamentoTipoDocumento $fkTcealPagamentoTipoDocumento)
    {
        if (false === $this->fkTcealPagamentoTipoDocumentos->contains($fkTcealPagamentoTipoDocumento)) {
            $fkTcealPagamentoTipoDocumento->setFkTesourariaPagamento($this);
            $this->fkTcealPagamentoTipoDocumentos->add($fkTcealPagamentoTipoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcealPagamentoTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\PagamentoTipoDocumento $fkTcealPagamentoTipoDocumento
     */
    public function removeFkTcealPagamentoTipoDocumentos(\Urbem\CoreBundle\Entity\Tceal\PagamentoTipoDocumento $fkTcealPagamentoTipoDocumento)
    {
        $this->fkTcealPagamentoTipoDocumentos->removeElement($fkTcealPagamentoTipoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcealPagamentoTipoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\PagamentoTipoDocumento
     */
    public function getFkTcealPagamentoTipoDocumentos()
    {
        return $this->fkTcealPagamentoTipoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgPagamentoTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\PagamentoTipoDocumento $fkTcemgPagamentoTipoDocumento
     * @return Pagamento
     */
    public function addFkTcemgPagamentoTipoDocumentos(\Urbem\CoreBundle\Entity\Tcemg\PagamentoTipoDocumento $fkTcemgPagamentoTipoDocumento)
    {
        if (false === $this->fkTcemgPagamentoTipoDocumentos->contains($fkTcemgPagamentoTipoDocumento)) {
            $fkTcemgPagamentoTipoDocumento->setFkTesourariaPagamento($this);
            $this->fkTcemgPagamentoTipoDocumentos->add($fkTcemgPagamentoTipoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgPagamentoTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\PagamentoTipoDocumento $fkTcemgPagamentoTipoDocumento
     */
    public function removeFkTcemgPagamentoTipoDocumentos(\Urbem\CoreBundle\Entity\Tcemg\PagamentoTipoDocumento $fkTcemgPagamentoTipoDocumento)
    {
        $this->fkTcemgPagamentoTipoDocumentos->removeElement($fkTcemgPagamentoTipoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgPagamentoTipoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\PagamentoTipoDocumento
     */
    public function getFkTcemgPagamentoTipoDocumentos()
    {
        return $this->fkTcemgPagamentoTipoDocumentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaBoletim
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim
     * @return Pagamento
     */
    public function setFkTesourariaBoletim(\Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim)
    {
        $this->codBoletim = $fkTesourariaBoletim->getCodBoletim();
        $this->codEntidade = $fkTesourariaBoletim->getCodEntidade();
        $this->exercicioBoletim = $fkTesourariaBoletim->getExercicio();
        $this->fkTesourariaBoletim = $fkTesourariaBoletim;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaBoletim
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Boletim
     */
    public function getFkTesourariaBoletim()
    {
        return $this->fkTesourariaBoletim;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaAutenticacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Autenticacao $fkTesourariaAutenticacao
     * @return Pagamento
     */
    public function setFkTesourariaAutenticacao(\Urbem\CoreBundle\Entity\Tesouraria\Autenticacao $fkTesourariaAutenticacao)
    {
        $this->codAutenticacao = $fkTesourariaAutenticacao->getCodAutenticacao();
        $this->dtAutenticacao = $fkTesourariaAutenticacao->getDtAutenticacao();
        $this->fkTesourariaAutenticacao = $fkTesourariaAutenticacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaAutenticacao
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Autenticacao
     */
    public function getFkTesourariaAutenticacao()
    {
        return $this->fkTesourariaAutenticacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaUsuarioTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal
     * @return Pagamento
     */
    public function setFkTesourariaUsuarioTerminal(\Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal)
    {
        $this->codTerminal = $fkTesourariaUsuarioTerminal->getCodTerminal();
        $this->timestampTerminal = $fkTesourariaUsuarioTerminal->getTimestampTerminal();
        $this->cgmUsuario = $fkTesourariaUsuarioTerminal->getCgmUsuario();
        $this->timestampUsuario = $fkTesourariaUsuarioTerminal->getTimestampUsuario();
        $this->fkTesourariaUsuarioTerminal = $fkTesourariaUsuarioTerminal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaUsuarioTerminal
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal
     */
    public function getFkTesourariaUsuarioTerminal()
    {
        return $this->fkTesourariaUsuarioTerminal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return Pagamento
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlano = $fkContabilidadePlanoAnalitica->getCodPlano();
        $this->exercicioPlano = $fkContabilidadePlanoAnalitica->getExercicio();
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }

    /**
     * OneToOne (inverse side)
     * Set TcepbPagamentoOrigemRecursosInterna
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\PagamentoOrigemRecursosInterna $fkTcepbPagamentoOrigemRecursosInterna
     * @return Pagamento
     */
    public function setFkTcepbPagamentoOrigemRecursosInterna(\Urbem\CoreBundle\Entity\Tcepb\PagamentoOrigemRecursosInterna $fkTcepbPagamentoOrigemRecursosInterna)
    {
        $fkTcepbPagamentoOrigemRecursosInterna->setFkTesourariaPagamento($this);
        $this->fkTcepbPagamentoOrigemRecursosInterna = $fkTcepbPagamentoOrigemRecursosInterna;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcepbPagamentoOrigemRecursosInterna
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\PagamentoOrigemRecursosInterna
     */
    public function getFkTcepbPagamentoOrigemRecursosInterna()
    {
        return $this->fkTcepbPagamentoOrigemRecursosInterna;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoNotaLiquidacaoPaga
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga $fkEmpenhoNotaLiquidacaoPaga
     * @return Pagamento
     */
    public function setFkEmpenhoNotaLiquidacaoPaga(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga $fkEmpenhoNotaLiquidacaoPaga)
    {
        $this->codEntidade = $fkEmpenhoNotaLiquidacaoPaga->getCodEntidade();
        $this->codNota = $fkEmpenhoNotaLiquidacaoPaga->getCodNota();
        $this->exercicio = $fkEmpenhoNotaLiquidacaoPaga->getExercicio();
        $this->timestamp = $fkEmpenhoNotaLiquidacaoPaga->getTimestamp();
        $this->fkEmpenhoNotaLiquidacaoPaga = $fkEmpenhoNotaLiquidacaoPaga;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoNotaLiquidacaoPaga
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga
     */
    public function getFkEmpenhoNotaLiquidacaoPaga()
    {
        return $this->fkEmpenhoNotaLiquidacaoPaga;
    }
}
