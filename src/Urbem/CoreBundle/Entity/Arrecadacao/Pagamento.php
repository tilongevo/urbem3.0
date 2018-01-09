<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * Pagamento
 */
class Pagamento
{
    /**
     * PK
     * @var string
     */
    private $numeracao;

    /**
     * PK
     * @var integer
     */
    private $ocorrenciaPagamento;

    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * @var \DateTime
     */
    private $dataPagamento;

    /**
     * @var boolean
     */
    private $inconsistente;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var \DateTime
     */
    private $dataBaixa;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoPagamento
     */
    private $fkArrecadacaoObservacaoPagamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacaoPagas
     */
    private $fkArrecadacaoPagamentoCompensacaoPagas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLote
     */
    private $fkArrecadacaoPagamentoLotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoAcrescimo
     */
    private $fkArrecadacaoPagamentoAcrescimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCalculo
     */
    private $fkArrecadacaoPagamentoCalculos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferenca
     */
    private $fkArrecadacaoPagamentoDiferencas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacao
     */
    private $fkArrecadacaoPagamentoCompensacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLoteManual
     */
    private $fkArrecadacaoPagamentoLoteManuais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ProcessoPagamento
     */
    private $fkArrecadacaoProcessoPagamentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Carne
     */
    private $fkArrecadacaoCarne;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\TipoPagamento
     */
    private $fkArrecadacaoTipoPagamento;

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
        $this->fkArrecadacaoObservacaoPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPagamentoCompensacaoPagas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPagamentoLotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPagamentoAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPagamentoCalculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPagamentoDiferencas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPagamentoCompensacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPagamentoLoteManuais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoProcessoPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dataBaixa = new \DateTime;
    }

    /**
     * Set numeracao
     *
     * @param string $numeracao
     * @return Pagamento
     */
    public function setNumeracao($numeracao)
    {
        $this->numeracao = $numeracao;
        return $this;
    }

    /**
     * Get numeracao
     *
     * @return string
     */
    public function getNumeracao()
    {
        return $this->numeracao;
    }

    /**
     * Set ocorrenciaPagamento
     *
     * @param integer $ocorrenciaPagamento
     * @return Pagamento
     */
    public function setOcorrenciaPagamento($ocorrenciaPagamento)
    {
        $this->ocorrenciaPagamento = $ocorrenciaPagamento;
        return $this;
    }

    /**
     * Get ocorrenciaPagamento
     *
     * @return integer
     */
    public function getOcorrenciaPagamento()
    {
        return $this->ocorrenciaPagamento;
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return Pagamento
     */
    public function setCodConvenio($codConvenio)
    {
        $this->codConvenio = $codConvenio;
        return $this;
    }

    /**
     * Get codConvenio
     *
     * @return integer
     */
    public function getCodConvenio()
    {
        return $this->codConvenio;
    }

    /**
     * Set dataPagamento
     *
     * @param \DateTime $dataPagamento
     * @return Pagamento
     */
    public function setDataPagamento(\DateTime $dataPagamento)
    {
        $this->dataPagamento = $dataPagamento;
        return $this;
    }

    /**
     * Get dataPagamento
     *
     * @return \DateTime
     */
    public function getDataPagamento()
    {
        return $this->dataPagamento;
    }

    /**
     * Set inconsistente
     *
     * @param boolean $inconsistente
     * @return Pagamento
     */
    public function setInconsistente($inconsistente)
    {
        $this->inconsistente = $inconsistente;
        return $this;
    }

    /**
     * Get inconsistente
     *
     * @return boolean
     */
    public function getInconsistente()
    {
        return $this->inconsistente;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return Pagamento
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return Pagamento
     */
    public function setObservacao($observacao = null)
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Pagamento
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
     * Set dataBaixa
     *
     * @param \DateTime $dataBaixa
     * @return Pagamento
     */
    public function setDataBaixa(\DateTime $dataBaixa)
    {
        $this->dataBaixa = $dataBaixa;
        return $this;
    }

    /**
     * Get dataBaixa
     *
     * @return \DateTime
     */
    public function getDataBaixa()
    {
        return $this->dataBaixa;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Pagamento
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
     * OneToMany (owning side)
     * Add ArrecadacaoObservacaoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoPagamento $fkArrecadacaoObservacaoPagamento
     * @return Pagamento
     */
    public function addFkArrecadacaoObservacaoPagamentos(\Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoPagamento $fkArrecadacaoObservacaoPagamento)
    {
        if (false === $this->fkArrecadacaoObservacaoPagamentos->contains($fkArrecadacaoObservacaoPagamento)) {
            $fkArrecadacaoObservacaoPagamento->setFkArrecadacaoPagamento($this);
            $this->fkArrecadacaoObservacaoPagamentos->add($fkArrecadacaoObservacaoPagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoObservacaoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoPagamento $fkArrecadacaoObservacaoPagamento
     */
    public function removeFkArrecadacaoObservacaoPagamentos(\Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoPagamento $fkArrecadacaoObservacaoPagamento)
    {
        $this->fkArrecadacaoObservacaoPagamentos->removeElement($fkArrecadacaoObservacaoPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoObservacaoPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoPagamento
     */
    public function getFkArrecadacaoObservacaoPagamentos()
    {
        return $this->fkArrecadacaoObservacaoPagamentos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPagamentoCompensacaoPagas
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacaoPagas $fkArrecadacaoPagamentoCompensacaoPagas
     * @return Pagamento
     */
    public function addFkArrecadacaoPagamentoCompensacaoPagas(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacaoPagas $fkArrecadacaoPagamentoCompensacaoPagas)
    {
        if (false === $this->fkArrecadacaoPagamentoCompensacaoPagas->contains($fkArrecadacaoPagamentoCompensacaoPagas)) {
            $fkArrecadacaoPagamentoCompensacaoPagas->setFkArrecadacaoPagamento($this);
            $this->fkArrecadacaoPagamentoCompensacaoPagas->add($fkArrecadacaoPagamentoCompensacaoPagas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPagamentoCompensacaoPagas
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacaoPagas $fkArrecadacaoPagamentoCompensacaoPagas
     */
    public function removeFkArrecadacaoPagamentoCompensacaoPagas(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacaoPagas $fkArrecadacaoPagamentoCompensacaoPagas)
    {
        $this->fkArrecadacaoPagamentoCompensacaoPagas->removeElement($fkArrecadacaoPagamentoCompensacaoPagas);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPagamentoCompensacaoPagas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacaoPagas
     */
    public function getFkArrecadacaoPagamentoCompensacaoPagas()
    {
        return $this->fkArrecadacaoPagamentoCompensacaoPagas;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPagamentoLote
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLote $fkArrecadacaoPagamentoLote
     * @return Pagamento
     */
    public function addFkArrecadacaoPagamentoLotes(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLote $fkArrecadacaoPagamentoLote)
    {
        if (false === $this->fkArrecadacaoPagamentoLotes->contains($fkArrecadacaoPagamentoLote)) {
            $fkArrecadacaoPagamentoLote->setFkArrecadacaoPagamento($this);
            $this->fkArrecadacaoPagamentoLotes->add($fkArrecadacaoPagamentoLote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPagamentoLote
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLote $fkArrecadacaoPagamentoLote
     */
    public function removeFkArrecadacaoPagamentoLotes(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLote $fkArrecadacaoPagamentoLote)
    {
        $this->fkArrecadacaoPagamentoLotes->removeElement($fkArrecadacaoPagamentoLote);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPagamentoLotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLote
     */
    public function getFkArrecadacaoPagamentoLotes()
    {
        return $this->fkArrecadacaoPagamentoLotes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPagamentoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoAcrescimo $fkArrecadacaoPagamentoAcrescimo
     * @return Pagamento
     */
    public function addFkArrecadacaoPagamentoAcrescimos(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoAcrescimo $fkArrecadacaoPagamentoAcrescimo)
    {
        if (false === $this->fkArrecadacaoPagamentoAcrescimos->contains($fkArrecadacaoPagamentoAcrescimo)) {
            $fkArrecadacaoPagamentoAcrescimo->setFkArrecadacaoPagamento($this);
            $this->fkArrecadacaoPagamentoAcrescimos->add($fkArrecadacaoPagamentoAcrescimo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPagamentoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoAcrescimo $fkArrecadacaoPagamentoAcrescimo
     */
    public function removeFkArrecadacaoPagamentoAcrescimos(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoAcrescimo $fkArrecadacaoPagamentoAcrescimo)
    {
        $this->fkArrecadacaoPagamentoAcrescimos->removeElement($fkArrecadacaoPagamentoAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPagamentoAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoAcrescimo
     */
    public function getFkArrecadacaoPagamentoAcrescimos()
    {
        return $this->fkArrecadacaoPagamentoAcrescimos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPagamentoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCalculo $fkArrecadacaoPagamentoCalculo
     * @return Pagamento
     */
    public function addFkArrecadacaoPagamentoCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCalculo $fkArrecadacaoPagamentoCalculo)
    {
        if (false === $this->fkArrecadacaoPagamentoCalculos->contains($fkArrecadacaoPagamentoCalculo)) {
            $fkArrecadacaoPagamentoCalculo->setFkArrecadacaoPagamento($this);
            $this->fkArrecadacaoPagamentoCalculos->add($fkArrecadacaoPagamentoCalculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPagamentoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCalculo $fkArrecadacaoPagamentoCalculo
     */
    public function removeFkArrecadacaoPagamentoCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCalculo $fkArrecadacaoPagamentoCalculo)
    {
        $this->fkArrecadacaoPagamentoCalculos->removeElement($fkArrecadacaoPagamentoCalculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPagamentoCalculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCalculo
     */
    public function getFkArrecadacaoPagamentoCalculos()
    {
        return $this->fkArrecadacaoPagamentoCalculos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPagamentoDiferenca
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferenca $fkArrecadacaoPagamentoDiferenca
     * @return Pagamento
     */
    public function addFkArrecadacaoPagamentoDiferencas(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferenca $fkArrecadacaoPagamentoDiferenca)
    {
        if (false === $this->fkArrecadacaoPagamentoDiferencas->contains($fkArrecadacaoPagamentoDiferenca)) {
            $fkArrecadacaoPagamentoDiferenca->setFkArrecadacaoPagamento($this);
            $this->fkArrecadacaoPagamentoDiferencas->add($fkArrecadacaoPagamentoDiferenca);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPagamentoDiferenca
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferenca $fkArrecadacaoPagamentoDiferenca
     */
    public function removeFkArrecadacaoPagamentoDiferencas(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferenca $fkArrecadacaoPagamentoDiferenca)
    {
        $this->fkArrecadacaoPagamentoDiferencas->removeElement($fkArrecadacaoPagamentoDiferenca);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPagamentoDiferencas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferenca
     */
    public function getFkArrecadacaoPagamentoDiferencas()
    {
        return $this->fkArrecadacaoPagamentoDiferencas;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPagamentoCompensacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacao $fkArrecadacaoPagamentoCompensacao
     * @return Pagamento
     */
    public function addFkArrecadacaoPagamentoCompensacoes(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacao $fkArrecadacaoPagamentoCompensacao)
    {
        if (false === $this->fkArrecadacaoPagamentoCompensacoes->contains($fkArrecadacaoPagamentoCompensacao)) {
            $fkArrecadacaoPagamentoCompensacao->setFkArrecadacaoPagamento($this);
            $this->fkArrecadacaoPagamentoCompensacoes->add($fkArrecadacaoPagamentoCompensacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPagamentoCompensacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacao $fkArrecadacaoPagamentoCompensacao
     */
    public function removeFkArrecadacaoPagamentoCompensacoes(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacao $fkArrecadacaoPagamentoCompensacao)
    {
        $this->fkArrecadacaoPagamentoCompensacoes->removeElement($fkArrecadacaoPagamentoCompensacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPagamentoCompensacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacao
     */
    public function getFkArrecadacaoPagamentoCompensacoes()
    {
        return $this->fkArrecadacaoPagamentoCompensacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPagamentoLoteManual
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLoteManual $fkArrecadacaoPagamentoLoteManual
     * @return Pagamento
     */
    public function addFkArrecadacaoPagamentoLoteManuais(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLoteManual $fkArrecadacaoPagamentoLoteManual)
    {
        if (false === $this->fkArrecadacaoPagamentoLoteManuais->contains($fkArrecadacaoPagamentoLoteManual)) {
            $fkArrecadacaoPagamentoLoteManual->setFkArrecadacaoPagamento($this);
            $this->fkArrecadacaoPagamentoLoteManuais->add($fkArrecadacaoPagamentoLoteManual);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPagamentoLoteManual
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLoteManual $fkArrecadacaoPagamentoLoteManual
     */
    public function removeFkArrecadacaoPagamentoLoteManuais(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLoteManual $fkArrecadacaoPagamentoLoteManual)
    {
        $this->fkArrecadacaoPagamentoLoteManuais->removeElement($fkArrecadacaoPagamentoLoteManual);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPagamentoLoteManuais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLoteManual
     */
    public function getFkArrecadacaoPagamentoLoteManuais()
    {
        return $this->fkArrecadacaoPagamentoLoteManuais;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoProcessoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ProcessoPagamento $fkArrecadacaoProcessoPagamento
     * @return Pagamento
     */
    public function addFkArrecadacaoProcessoPagamentos(\Urbem\CoreBundle\Entity\Arrecadacao\ProcessoPagamento $fkArrecadacaoProcessoPagamento)
    {
        if (false === $this->fkArrecadacaoProcessoPagamentos->contains($fkArrecadacaoProcessoPagamento)) {
            $fkArrecadacaoProcessoPagamento->setFkArrecadacaoPagamento($this);
            $this->fkArrecadacaoProcessoPagamentos->add($fkArrecadacaoProcessoPagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoProcessoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ProcessoPagamento $fkArrecadacaoProcessoPagamento
     */
    public function removeFkArrecadacaoProcessoPagamentos(\Urbem\CoreBundle\Entity\Arrecadacao\ProcessoPagamento $fkArrecadacaoProcessoPagamento)
    {
        $this->fkArrecadacaoProcessoPagamentos->removeElement($fkArrecadacaoProcessoPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoProcessoPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ProcessoPagamento
     */
    public function getFkArrecadacaoProcessoPagamentos()
    {
        return $this->fkArrecadacaoProcessoPagamentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne
     * @return Pagamento
     */
    public function setFkArrecadacaoCarne(\Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne)
    {
        $this->numeracao = $fkArrecadacaoCarne->getNumeracao();
        $this->codConvenio = $fkArrecadacaoCarne->getCodConvenio();
        $this->fkArrecadacaoCarne = $fkArrecadacaoCarne;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoCarne
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Carne
     */
    public function getFkArrecadacaoCarne()
    {
        return $this->fkArrecadacaoCarne;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoTipoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\TipoPagamento $fkArrecadacaoTipoPagamento
     * @return Pagamento
     */
    public function setFkArrecadacaoTipoPagamento(\Urbem\CoreBundle\Entity\Arrecadacao\TipoPagamento $fkArrecadacaoTipoPagamento)
    {
        $this->codTipo = $fkArrecadacaoTipoPagamento->getCodTipo();
        $this->fkArrecadacaoTipoPagamento = $fkArrecadacaoTipoPagamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoTipoPagamento
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\TipoPagamento
     */
    public function getFkArrecadacaoTipoPagamento()
    {
        return $this->fkArrecadacaoTipoPagamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Pagamento
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
}
