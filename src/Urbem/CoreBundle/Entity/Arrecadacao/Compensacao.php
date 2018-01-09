<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * Compensacao
 */
class Compensacao
{
    /**
     * PK
     * @var integer
     */
    private $codCompensacao;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var boolean
     */
    private $aplicarAcrescimos;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoUtilizaResto
     */
    private $fkArrecadacaoCompensacaoUtilizaResto;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoResto
     */
    private $fkArrecadacaoCompensacaoResto;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferencaCompensacao
     */
    private $fkArrecadacaoPagamentoDiferencaCompensacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacaoPagas
     */
    private $fkArrecadacaoPagamentoCompensacaoPagas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacao
     */
    private $fkArrecadacaoPagamentoCompensacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\TipoCompensacao
     */
    private $fkArrecadacaoTipoCompensacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoPagamentoDiferencaCompensacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPagamentoCompensacaoPagas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPagamentoCompensacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codCompensacao
     *
     * @param integer $codCompensacao
     * @return Compensacao
     */
    public function setCodCompensacao($codCompensacao)
    {
        $this->codCompensacao = $codCompensacao;
        return $this;
    }

    /**
     * Get codCompensacao
     *
     * @return integer
     */
    public function getCodCompensacao()
    {
        return $this->codCompensacao;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Compensacao
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
     * @param \DateTime $timestamp
     * @return Compensacao
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return Compensacao
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
     * Set aplicarAcrescimos
     *
     * @param boolean $aplicarAcrescimos
     * @return Compensacao
     */
    public function setAplicarAcrescimos($aplicarAcrescimos)
    {
        $this->aplicarAcrescimos = $aplicarAcrescimos;
        return $this;
    }

    /**
     * Get aplicarAcrescimos
     *
     * @return boolean
     */
    public function getAplicarAcrescimos()
    {
        return $this->aplicarAcrescimos;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Compensacao
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
     * OneToMany (owning side)
     * Add ArrecadacaoPagamentoDiferencaCompensacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferencaCompensacao $fkArrecadacaoPagamentoDiferencaCompensacao
     * @return Compensacao
     */
    public function addFkArrecadacaoPagamentoDiferencaCompensacoes(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferencaCompensacao $fkArrecadacaoPagamentoDiferencaCompensacao)
    {
        if (false === $this->fkArrecadacaoPagamentoDiferencaCompensacoes->contains($fkArrecadacaoPagamentoDiferencaCompensacao)) {
            $fkArrecadacaoPagamentoDiferencaCompensacao->setFkArrecadacaoCompensacao($this);
            $this->fkArrecadacaoPagamentoDiferencaCompensacoes->add($fkArrecadacaoPagamentoDiferencaCompensacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPagamentoDiferencaCompensacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferencaCompensacao $fkArrecadacaoPagamentoDiferencaCompensacao
     */
    public function removeFkArrecadacaoPagamentoDiferencaCompensacoes(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferencaCompensacao $fkArrecadacaoPagamentoDiferencaCompensacao)
    {
        $this->fkArrecadacaoPagamentoDiferencaCompensacoes->removeElement($fkArrecadacaoPagamentoDiferencaCompensacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPagamentoDiferencaCompensacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferencaCompensacao
     */
    public function getFkArrecadacaoPagamentoDiferencaCompensacoes()
    {
        return $this->fkArrecadacaoPagamentoDiferencaCompensacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPagamentoCompensacaoPagas
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacaoPagas $fkArrecadacaoPagamentoCompensacaoPagas
     * @return Compensacao
     */
    public function addFkArrecadacaoPagamentoCompensacaoPagas(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacaoPagas $fkArrecadacaoPagamentoCompensacaoPagas)
    {
        if (false === $this->fkArrecadacaoPagamentoCompensacaoPagas->contains($fkArrecadacaoPagamentoCompensacaoPagas)) {
            $fkArrecadacaoPagamentoCompensacaoPagas->setFkArrecadacaoCompensacao($this);
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
     * Add ArrecadacaoPagamentoCompensacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacao $fkArrecadacaoPagamentoCompensacao
     * @return Compensacao
     */
    public function addFkArrecadacaoPagamentoCompensacoes(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCompensacao $fkArrecadacaoPagamentoCompensacao)
    {
        if (false === $this->fkArrecadacaoPagamentoCompensacoes->contains($fkArrecadacaoPagamentoCompensacao)) {
            $fkArrecadacaoPagamentoCompensacao->setFkArrecadacaoCompensacao($this);
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
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Compensacao
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
     * ManyToOne (inverse side)
     * Set fkArrecadacaoTipoCompensacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\TipoCompensacao $fkArrecadacaoTipoCompensacao
     * @return Compensacao
     */
    public function setFkArrecadacaoTipoCompensacao(\Urbem\CoreBundle\Entity\Arrecadacao\TipoCompensacao $fkArrecadacaoTipoCompensacao)
    {
        $this->codTipo = $fkArrecadacaoTipoCompensacao->getCodTipo();
        $this->fkArrecadacaoTipoCompensacao = $fkArrecadacaoTipoCompensacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoTipoCompensacao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\TipoCompensacao
     */
    public function getFkArrecadacaoTipoCompensacao()
    {
        return $this->fkArrecadacaoTipoCompensacao;
    }

    /**
     * OneToOne (inverse side)
     * Set ArrecadacaoCompensacaoUtilizaResto
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoUtilizaResto $fkArrecadacaoCompensacaoUtilizaResto
     * @return Compensacao
     */
    public function setFkArrecadacaoCompensacaoUtilizaResto(\Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoUtilizaResto $fkArrecadacaoCompensacaoUtilizaResto)
    {
        $fkArrecadacaoCompensacaoUtilizaResto->setFkArrecadacaoCompensacao($this);
        $this->fkArrecadacaoCompensacaoUtilizaResto = $fkArrecadacaoCompensacaoUtilizaResto;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoCompensacaoUtilizaResto
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoUtilizaResto
     */
    public function getFkArrecadacaoCompensacaoUtilizaResto()
    {
        return $this->fkArrecadacaoCompensacaoUtilizaResto;
    }

    /**
     * OneToOne (inverse side)
     * Set ArrecadacaoCompensacaoResto
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoResto $fkArrecadacaoCompensacaoResto
     * @return Compensacao
     */
    public function setFkArrecadacaoCompensacaoResto(\Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoResto $fkArrecadacaoCompensacaoResto)
    {
        $fkArrecadacaoCompensacaoResto->setFkArrecadacaoCompensacao($this);
        $this->fkArrecadacaoCompensacaoResto = $fkArrecadacaoCompensacaoResto;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoCompensacaoResto
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoResto
     */
    public function getFkArrecadacaoCompensacaoResto()
    {
        return $this->fkArrecadacaoCompensacaoResto;
    }
}
