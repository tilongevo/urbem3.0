<?php

namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * Calculo
 */
class Calculo
{
    /**
     * PK
     * @var integer
     */
    private $codCalculo;

    /**
     * @var integer
     */
    private $codCredito;

    /**
     * @var integer
     */
    private $codNatureza;

    /**
     * @var integer
     */
    private $codGenero;

    /**
     * @var integer
     */
    private $codEspecie;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $nroParcelas;

    /**
     * @var boolean
     */
    private $ativo;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var boolean
     */
    private $calculado = true;

    /**
     * @var integer
     */
    private $iLancto;

    /**
     * @var string
     */
    private $iImovel;

    /**
     * @var boolean
     */
    private $simulado = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\CalculoGrupoCredito
     */
    private $fkArrecadacaoCalculoGrupoCredito;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoCalculo
     */
    private $fkArrecadacaoCadastroEconomicoCalculo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\ImovelCalculo
     */
    private $fkArrecadacaoImovelCalculo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupoValor
     */
    private $fkArrecadacaoAtributoGrupoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo
     */
    private $fkArrecadacaoLancamentoCalculos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LogCalculo
     */
    private $fkArrecadacaoLogCalculos;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ParcelaCalculo
     */
    private $fkDividaParcelaCalculos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CalculoCgm
     */
    private $fkArrecadacaoCalculoCgns;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Credito
     */
    private $fkMonetarioCredito;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoAtributoGrupoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoLancamentoCalculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoLogCalculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPagamentoAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPagamentoCalculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPagamentoDiferencas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaParcelaCalculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoCalculoCgns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codCalculo
     *
     * @param integer $codCalculo
     * @return Calculo
     */
    public function setCodCalculo($codCalculo)
    {
        $this->codCalculo = $codCalculo;
        return $this;
    }

    /**
     * Get codCalculo
     *
     * @return integer
     */
    public function getCodCalculo()
    {
        return $this->codCalculo;
    }

    /**
     * Set codCredito
     *
     * @param integer $codCredito
     * @return Calculo
     */
    public function setCodCredito($codCredito)
    {
        $this->codCredito = $codCredito;
        return $this;
    }

    /**
     * Get codCredito
     *
     * @return integer
     */
    public function getCodCredito()
    {
        return $this->codCredito;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return Calculo
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set codGenero
     *
     * @param integer $codGenero
     * @return Calculo
     */
    public function setCodGenero($codGenero)
    {
        $this->codGenero = $codGenero;
        return $this;
    }

    /**
     * Get codGenero
     *
     * @return integer
     */
    public function getCodGenero()
    {
        return $this->codGenero;
    }

    /**
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return Calculo
     */
    public function setCodEspecie($codEspecie)
    {
        $this->codEspecie = $codEspecie;
        return $this;
    }

    /**
     * Get codEspecie
     *
     * @return integer
     */
    public function getCodEspecie()
    {
        return $this->codEspecie;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Calculo
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
     * Set valor
     *
     * @param integer $valor
     * @return Calculo
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
     * Set nroParcelas
     *
     * @param integer $nroParcelas
     * @return Calculo
     */
    public function setNroParcelas($nroParcelas)
    {
        $this->nroParcelas = $nroParcelas;
        return $this;
    }

    /**
     * Get nroParcelas
     *
     * @return integer
     */
    public function getNroParcelas()
    {
        return $this->nroParcelas;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Calculo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Calculo
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
     * Set calculado
     *
     * @param boolean $calculado
     * @return Calculo
     */
    public function setCalculado($calculado)
    {
        $this->calculado = $calculado;
        return $this;
    }

    /**
     * Get calculado
     *
     * @return boolean
     */
    public function getCalculado()
    {
        return $this->calculado;
    }

    /**
     * Set iLancto
     *
     * @param integer $iLancto
     * @return Calculo
     */
    public function setILancto($iLancto = null)
    {
        $this->iLancto = $iLancto;
        return $this;
    }

    /**
     * Get iLancto
     *
     * @return integer
     */
    public function getILancto()
    {
        return $this->iLancto;
    }

    /**
     * Set iImovel
     *
     * @param string $iImovel
     * @return Calculo
     */
    public function setIImovel($iImovel = null)
    {
        $this->iImovel = $iImovel;
        return $this;
    }

    /**
     * Get iImovel
     *
     * @return string
     */
    public function getIImovel()
    {
        return $this->iImovel;
    }

    /**
     * Set simulado
     *
     * @param boolean $simulado
     * @return Calculo
     */
    public function setSimulado($simulado)
    {
        $this->simulado = $simulado;
        return $this;
    }

    /**
     * Get simulado
     *
     * @return boolean
     */
    public function getSimulado()
    {
        return $this->simulado;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoAtributoGrupoValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupoValor $fkArrecadacaoAtributoGrupoValor
     * @return Calculo
     */
    public function addFkArrecadacaoAtributoGrupoValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupoValor $fkArrecadacaoAtributoGrupoValor)
    {
        if (false === $this->fkArrecadacaoAtributoGrupoValores->contains($fkArrecadacaoAtributoGrupoValor)) {
            $fkArrecadacaoAtributoGrupoValor->setFkArrecadacaoCalculo($this);
            $this->fkArrecadacaoAtributoGrupoValores->add($fkArrecadacaoAtributoGrupoValor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAtributoGrupoValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupoValor $fkArrecadacaoAtributoGrupoValor
     */
    public function removeFkArrecadacaoAtributoGrupoValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupoValor $fkArrecadacaoAtributoGrupoValor)
    {
        $this->fkArrecadacaoAtributoGrupoValores->removeElement($fkArrecadacaoAtributoGrupoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAtributoGrupoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupoValor
     */
    public function getFkArrecadacaoAtributoGrupoValores()
    {
        return $this->fkArrecadacaoAtributoGrupoValores;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoLancamentoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo $fkArrecadacaoLancamentoCalculo
     * @return Calculo
     */
    public function addFkArrecadacaoLancamentoCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo $fkArrecadacaoLancamentoCalculo)
    {
        if (false === $this->fkArrecadacaoLancamentoCalculos->contains($fkArrecadacaoLancamentoCalculo)) {
            $fkArrecadacaoLancamentoCalculo->setFkArrecadacaoCalculo($this);
            $this->fkArrecadacaoLancamentoCalculos->add($fkArrecadacaoLancamentoCalculo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoLancamentoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo $fkArrecadacaoLancamentoCalculo
     */
    public function removeFkArrecadacaoLancamentoCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo $fkArrecadacaoLancamentoCalculo)
    {
        $this->fkArrecadacaoLancamentoCalculos->removeElement($fkArrecadacaoLancamentoCalculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoLancamentoCalculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo
     */
    public function getFkArrecadacaoLancamentoCalculos()
    {
        return $this->fkArrecadacaoLancamentoCalculos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoLogCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LogCalculo $fkArrecadacaoLogCalculo
     * @return Calculo
     */
    public function addFkArrecadacaoLogCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\LogCalculo $fkArrecadacaoLogCalculo)
    {
        if (false === $this->fkArrecadacaoLogCalculos->contains($fkArrecadacaoLogCalculo)) {
            $fkArrecadacaoLogCalculo->setFkArrecadacaoCalculo($this);
            $this->fkArrecadacaoLogCalculos->add($fkArrecadacaoLogCalculo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoLogCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LogCalculo $fkArrecadacaoLogCalculo
     */
    public function removeFkArrecadacaoLogCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\LogCalculo $fkArrecadacaoLogCalculo)
    {
        $this->fkArrecadacaoLogCalculos->removeElement($fkArrecadacaoLogCalculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoLogCalculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LogCalculo
     */
    public function getFkArrecadacaoLogCalculos()
    {
        return $this->fkArrecadacaoLogCalculos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPagamentoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoAcrescimo $fkArrecadacaoPagamentoAcrescimo
     * @return Calculo
     */
    public function addFkArrecadacaoPagamentoAcrescimos(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoAcrescimo $fkArrecadacaoPagamentoAcrescimo)
    {
        if (false === $this->fkArrecadacaoPagamentoAcrescimos->contains($fkArrecadacaoPagamentoAcrescimo)) {
            $fkArrecadacaoPagamentoAcrescimo->setFkArrecadacaoCalculo($this);
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
     * @return Calculo
     */
    public function addFkArrecadacaoPagamentoCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoCalculo $fkArrecadacaoPagamentoCalculo)
    {
        if (false === $this->fkArrecadacaoPagamentoCalculos->contains($fkArrecadacaoPagamentoCalculo)) {
            $fkArrecadacaoPagamentoCalculo->setFkArrecadacaoCalculo($this);
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
     * @return Calculo
     */
    public function addFkArrecadacaoPagamentoDiferencas(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferenca $fkArrecadacaoPagamentoDiferenca)
    {
        if (false === $this->fkArrecadacaoPagamentoDiferencas->contains($fkArrecadacaoPagamentoDiferenca)) {
            $fkArrecadacaoPagamentoDiferenca->setFkArrecadacaoCalculo($this);
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
     * Add DividaParcelaCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ParcelaCalculo $fkDividaParcelaCalculo
     * @return Calculo
     */
    public function addFkDividaParcelaCalculos(\Urbem\CoreBundle\Entity\Divida\ParcelaCalculo $fkDividaParcelaCalculo)
    {
        if (false === $this->fkDividaParcelaCalculos->contains($fkDividaParcelaCalculo)) {
            $fkDividaParcelaCalculo->setFkArrecadacaoCalculo($this);
            $this->fkDividaParcelaCalculos->add($fkDividaParcelaCalculo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaParcelaCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ParcelaCalculo $fkDividaParcelaCalculo
     */
    public function removeFkDividaParcelaCalculos(\Urbem\CoreBundle\Entity\Divida\ParcelaCalculo $fkDividaParcelaCalculo)
    {
        $this->fkDividaParcelaCalculos->removeElement($fkDividaParcelaCalculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaParcelaCalculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ParcelaCalculo
     */
    public function getFkDividaParcelaCalculos()
    {
        return $this->fkDividaParcelaCalculos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoCalculoCgm
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CalculoCgm $fkArrecadacaoCalculoCgm
     * @return Calculo
     */
    public function addFkArrecadacaoCalculoCgns(\Urbem\CoreBundle\Entity\Arrecadacao\CalculoCgm $fkArrecadacaoCalculoCgm)
    {
        if (false === $this->fkArrecadacaoCalculoCgns->contains($fkArrecadacaoCalculoCgm)) {
            $fkArrecadacaoCalculoCgm->setFkArrecadacaoCalculo($this);
            $this->fkArrecadacaoCalculoCgns->add($fkArrecadacaoCalculoCgm);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCalculoCgm
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CalculoCgm $fkArrecadacaoCalculoCgm
     */
    public function removeFkArrecadacaoCalculoCgns(\Urbem\CoreBundle\Entity\Arrecadacao\CalculoCgm $fkArrecadacaoCalculoCgm)
    {
        $this->fkArrecadacaoCalculoCgns->removeElement($fkArrecadacaoCalculoCgm);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCalculoCgns
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CalculoCgm
     */
    public function getFkArrecadacaoCalculoCgns()
    {
        return $this->fkArrecadacaoCalculoCgns;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito
     * @return Calculo
     */
    public function setFkMonetarioCredito(\Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito)
    {
        $this->codCredito = $fkMonetarioCredito->getCodCredito();
        $this->codNatureza = $fkMonetarioCredito->getCodNatureza();
        $this->codGenero = $fkMonetarioCredito->getCodGenero();
        $this->codEspecie = $fkMonetarioCredito->getCodEspecie();
        $this->fkMonetarioCredito = $fkMonetarioCredito;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioCredito
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Credito
     */
    public function getFkMonetarioCredito()
    {
        return $this->fkMonetarioCredito;
    }

    /**
     * OneToOne (inverse side)
     * Set ArrecadacaoCalculoGrupoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CalculoGrupoCredito $fkArrecadacaoCalculoGrupoCredito
     * @return Calculo
     */
    public function setFkArrecadacaoCalculoGrupoCredito(\Urbem\CoreBundle\Entity\Arrecadacao\CalculoGrupoCredito $fkArrecadacaoCalculoGrupoCredito)
    {
        $fkArrecadacaoCalculoGrupoCredito->setFkArrecadacaoCalculo($this);
        $this->fkArrecadacaoCalculoGrupoCredito = $fkArrecadacaoCalculoGrupoCredito;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoCalculoGrupoCredito
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\CalculoGrupoCredito
     */
    public function getFkArrecadacaoCalculoGrupoCredito()
    {
        return $this->fkArrecadacaoCalculoGrupoCredito;
    }

    /**
     * OneToOne (inverse side)
     * Set ArrecadacaoCadastroEconomicoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoCalculo $fkArrecadacaoCadastroEconomicoCalculo
     * @return Calculo
     */
    public function setFkArrecadacaoCadastroEconomicoCalculo(\Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoCalculo $fkArrecadacaoCadastroEconomicoCalculo)
    {
        $fkArrecadacaoCadastroEconomicoCalculo->setFkArrecadacaoCalculo($this);
        $this->fkArrecadacaoCadastroEconomicoCalculo = $fkArrecadacaoCadastroEconomicoCalculo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoCadastroEconomicoCalculo
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoCalculo
     */
    public function getFkArrecadacaoCadastroEconomicoCalculo()
    {
        return $this->fkArrecadacaoCadastroEconomicoCalculo;
    }

    /**
     * OneToOne (inverse side)
     * Set ArrecadacaoImovelCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ImovelCalculo $fkArrecadacaoImovelCalculo
     * @return Calculo
     */
    public function setFkArrecadacaoImovelCalculo(\Urbem\CoreBundle\Entity\Arrecadacao\ImovelCalculo $fkArrecadacaoImovelCalculo)
    {
        $fkArrecadacaoImovelCalculo->setFkArrecadacaoCalculo($this);
        $this->fkArrecadacaoImovelCalculo = $fkArrecadacaoImovelCalculo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoImovelCalculo
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\ImovelCalculo
     */
    public function getFkArrecadacaoImovelCalculo()
    {
        return $this->fkArrecadacaoImovelCalculo;
    }
}
