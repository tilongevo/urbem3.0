<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * Receita
 */
class Receita
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
    private $codReceita;

    /**
     * @var integer
     */
    private $codConta;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codRecurso;

    /**
     * @var \DateTime
     */
    private $dtCriacao;

    /**
     * @var integer
     */
    private $vlOriginal = 0;

    /**
     * @var boolean
     */
    private $creditoTributario = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Manad\ReceitaCaracPeculiarReceita
     */
    private $fkManadReceitaCaracPeculiarReceita;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoTributario
     */
    private $fkOrcamentoReceitaCreditoTributario;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\ReceitaIndentificadoresPeculiarReceita
     */
    private $fkTcemgReceitaIndentificadoresPeculiarReceita;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcers\ReceitaCaracPeculiarReceita
     */
    private $fkTcersReceitaCaracPeculiarReceita;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tceto\ReceitaIndentificadoresPeculiarReceita
     */
    private $fkTcetoReceitaIndentificadoresPeculiarReceita;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcern\ReceitaTc
     */
    private $fkTcernReceitaTc;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\DesdobramentoReceita
     */
    private $fkContabilidadeDesdobramentoReceitas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\DesdobramentoReceita
     */
    private $fkContabilidadeDesdobramentoReceitas1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoReceita
     */
    private $fkContabilidadeLancamentoReceitas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\TransferenciaReceita
     */
    private $fkContabilidadeTransferenciaReceitas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao
     */
    private $fkEmpenhoOrdemPagamentoRetencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ReceitaCredito
     */
    private $fkOrcamentoReceitaCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoAcrescimo
     */
    private $fkOrcamentoReceitaCreditoAcrescimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\PrevisaoReceita
     */
    private $fkOrcamentoPrevisaoReceitas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoStnReceita
     */
    private $fkStnVinculoStnReceitas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoSaudeRreo12
     */
    private $fkStnVinculoSaudeRreo12s;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\AporteRecursoRppsReceita
     */
    private $fkStnAporteRecursoRppsReceitas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita
     */
    private $fkTesourariaArrecadacaoReceitas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutora
     */
    private $fkTesourariaArrecadacaoReceitaDedutoras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\ContaDedutoraTributos
     */
    private $fkStnContaDedutoraTributos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoDesconto
     */
    private $fkOrcamentoReceitaCreditoDescontos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    private $fkOrcamentoRecurso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\ContaReceita
     */
    private $fkOrcamentoContaReceita;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadeDesdobramentoReceitas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeDesdobramentoReceitas1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeLancamentoReceitas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeTransferenciaReceitas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoOrdemPagamentoRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoReceitaCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoReceitaCreditoAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoPrevisaoReceitas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkStnVinculoStnReceitas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkStnVinculoSaudeRreo12s = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkStnAporteRecursoRppsReceitas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaArrecadacaoReceitas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaArrecadacaoReceitaDedutoras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkStnContaDedutoraTributos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoReceitaCreditoDescontos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtCriacao = new \DateTime;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Receita
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
     * Set codReceita
     *
     * @param integer $codReceita
     * @return Receita
     */
    public function setCodReceita($codReceita)
    {
        $this->codReceita = $codReceita;
        return $this;
    }

    /**
     * Get codReceita
     *
     * @return integer
     */
    public function getCodReceita()
    {
        return $this->codReceita;
    }

    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return Receita
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Receita
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
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return Receita
     */
    public function setCodRecurso($codRecurso)
    {
        $this->codRecurso = $codRecurso;
        return $this;
    }

    /**
     * Get codRecurso
     *
     * @return integer
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }

    /**
     * Set dtCriacao
     *
     * @param \DateTime $dtCriacao
     * @return Receita
     */
    public function setDtCriacao(\DateTime $dtCriacao = null)
    {
        $this->dtCriacao = $dtCriacao;
        return $this;
    }

    /**
     * Get dtCriacao
     *
     * @return \DateTime
     */
    public function getDtCriacao()
    {
        return $this->dtCriacao;
    }

    /**
     * Set vlOriginal
     *
     * @param integer $vlOriginal
     * @return Receita
     */
    public function setVlOriginal($vlOriginal)
    {
        $this->vlOriginal = $vlOriginal;
        return $this;
    }

    /**
     * Get vlOriginal
     *
     * @return integer
     */
    public function getVlOriginal()
    {
        return $this->vlOriginal;
    }

    /**
     * Set creditoTributario
     *
     * @param boolean $creditoTributario
     * @return Receita
     */
    public function setCreditoTributario($creditoTributario)
    {
        $this->creditoTributario = $creditoTributario;
        return $this;
    }

    /**
     * Get creditoTributario
     *
     * @return boolean
     */
    public function getCreditoTributario()
    {
        return $this->creditoTributario;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeDesdobramentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\DesdobramentoReceita $fkContabilidadeDesdobramentoReceita
     * @return Receita
     */
    public function addFkContabilidadeDesdobramentoReceitas(\Urbem\CoreBundle\Entity\Contabilidade\DesdobramentoReceita $fkContabilidadeDesdobramentoReceita)
    {
        if (false === $this->fkContabilidadeDesdobramentoReceitas->contains($fkContabilidadeDesdobramentoReceita)) {
            $fkContabilidadeDesdobramentoReceita->setFkOrcamentoReceita($this);
            $this->fkContabilidadeDesdobramentoReceitas->add($fkContabilidadeDesdobramentoReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeDesdobramentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\DesdobramentoReceita $fkContabilidadeDesdobramentoReceita
     */
    public function removeFkContabilidadeDesdobramentoReceitas(\Urbem\CoreBundle\Entity\Contabilidade\DesdobramentoReceita $fkContabilidadeDesdobramentoReceita)
    {
        $this->fkContabilidadeDesdobramentoReceitas->removeElement($fkContabilidadeDesdobramentoReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeDesdobramentoReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\DesdobramentoReceita
     */
    public function getFkContabilidadeDesdobramentoReceitas()
    {
        return $this->fkContabilidadeDesdobramentoReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeDesdobramentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\DesdobramentoReceita $fkContabilidadeDesdobramentoReceita
     * @return Receita
     */
    public function addFkContabilidadeDesdobramentoReceitas1(\Urbem\CoreBundle\Entity\Contabilidade\DesdobramentoReceita $fkContabilidadeDesdobramentoReceita)
    {
        if (false === $this->fkContabilidadeDesdobramentoReceitas1->contains($fkContabilidadeDesdobramentoReceita)) {
            $fkContabilidadeDesdobramentoReceita->setFkOrcamentoReceita1($this);
            $this->fkContabilidadeDesdobramentoReceitas1->add($fkContabilidadeDesdobramentoReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeDesdobramentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\DesdobramentoReceita $fkContabilidadeDesdobramentoReceita
     */
    public function removeFkContabilidadeDesdobramentoReceitas1(\Urbem\CoreBundle\Entity\Contabilidade\DesdobramentoReceita $fkContabilidadeDesdobramentoReceita)
    {
        $this->fkContabilidadeDesdobramentoReceitas1->removeElement($fkContabilidadeDesdobramentoReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeDesdobramentoReceitas1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\DesdobramentoReceita
     */
    public function getFkContabilidadeDesdobramentoReceitas1()
    {
        return $this->fkContabilidadeDesdobramentoReceitas1;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLancamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoReceita $fkContabilidadeLancamentoReceita
     * @return Receita
     */
    public function addFkContabilidadeLancamentoReceitas(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoReceita $fkContabilidadeLancamentoReceita)
    {
        if (false === $this->fkContabilidadeLancamentoReceitas->contains($fkContabilidadeLancamentoReceita)) {
            $fkContabilidadeLancamentoReceita->setFkOrcamentoReceita($this);
            $this->fkContabilidadeLancamentoReceitas->add($fkContabilidadeLancamentoReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLancamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoReceita $fkContabilidadeLancamentoReceita
     */
    public function removeFkContabilidadeLancamentoReceitas(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoReceita $fkContabilidadeLancamentoReceita)
    {
        $this->fkContabilidadeLancamentoReceitas->removeElement($fkContabilidadeLancamentoReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLancamentoReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoReceita
     */
    public function getFkContabilidadeLancamentoReceitas()
    {
        return $this->fkContabilidadeLancamentoReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeTransferenciaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\TransferenciaReceita $fkContabilidadeTransferenciaReceita
     * @return Receita
     */
    public function addFkContabilidadeTransferenciaReceitas(\Urbem\CoreBundle\Entity\Contabilidade\TransferenciaReceita $fkContabilidadeTransferenciaReceita)
    {
        if (false === $this->fkContabilidadeTransferenciaReceitas->contains($fkContabilidadeTransferenciaReceita)) {
            $fkContabilidadeTransferenciaReceita->setFkOrcamentoReceita($this);
            $this->fkContabilidadeTransferenciaReceitas->add($fkContabilidadeTransferenciaReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeTransferenciaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\TransferenciaReceita $fkContabilidadeTransferenciaReceita
     */
    public function removeFkContabilidadeTransferenciaReceitas(\Urbem\CoreBundle\Entity\Contabilidade\TransferenciaReceita $fkContabilidadeTransferenciaReceita)
    {
        $this->fkContabilidadeTransferenciaReceitas->removeElement($fkContabilidadeTransferenciaReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeTransferenciaReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\TransferenciaReceita
     */
    public function getFkContabilidadeTransferenciaReceitas()
    {
        return $this->fkContabilidadeTransferenciaReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao
     * @return Receita
     */
    public function addFkEmpenhoOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao)
    {
        if (false === $this->fkEmpenhoOrdemPagamentoRetencoes->contains($fkEmpenhoOrdemPagamentoRetencao)) {
            $fkEmpenhoOrdemPagamentoRetencao->setFkOrcamentoReceita($this);
            $this->fkEmpenhoOrdemPagamentoRetencoes->add($fkEmpenhoOrdemPagamentoRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao
     */
    public function removeFkEmpenhoOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao)
    {
        $this->fkEmpenhoOrdemPagamentoRetencoes->removeElement($fkEmpenhoOrdemPagamentoRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoOrdemPagamentoRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao
     */
    public function getFkEmpenhoOrdemPagamentoRetencoes()
    {
        return $this->fkEmpenhoOrdemPagamentoRetencoes;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoReceitaCredito
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReceitaCredito $fkOrcamentoReceitaCredito
     * @return Receita
     */
    public function addFkOrcamentoReceitaCreditos(\Urbem\CoreBundle\Entity\Orcamento\ReceitaCredito $fkOrcamentoReceitaCredito)
    {
        if (false === $this->fkOrcamentoReceitaCreditos->contains($fkOrcamentoReceitaCredito)) {
            $fkOrcamentoReceitaCredito->setFkOrcamentoReceita($this);
            $this->fkOrcamentoReceitaCreditos->add($fkOrcamentoReceitaCredito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoReceitaCredito
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReceitaCredito $fkOrcamentoReceitaCredito
     */
    public function removeFkOrcamentoReceitaCreditos(\Urbem\CoreBundle\Entity\Orcamento\ReceitaCredito $fkOrcamentoReceitaCredito)
    {
        $this->fkOrcamentoReceitaCreditos->removeElement($fkOrcamentoReceitaCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoReceitaCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ReceitaCredito
     */
    public function getFkOrcamentoReceitaCreditos()
    {
        return $this->fkOrcamentoReceitaCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoReceitaCreditoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoAcrescimo $fkOrcamentoReceitaCreditoAcrescimo
     * @return Receita
     */
    public function addFkOrcamentoReceitaCreditoAcrescimos(\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoAcrescimo $fkOrcamentoReceitaCreditoAcrescimo)
    {
        if (false === $this->fkOrcamentoReceitaCreditoAcrescimos->contains($fkOrcamentoReceitaCreditoAcrescimo)) {
            $fkOrcamentoReceitaCreditoAcrescimo->setFkOrcamentoReceita($this);
            $this->fkOrcamentoReceitaCreditoAcrescimos->add($fkOrcamentoReceitaCreditoAcrescimo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoReceitaCreditoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoAcrescimo $fkOrcamentoReceitaCreditoAcrescimo
     */
    public function removeFkOrcamentoReceitaCreditoAcrescimos(\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoAcrescimo $fkOrcamentoReceitaCreditoAcrescimo)
    {
        $this->fkOrcamentoReceitaCreditoAcrescimos->removeElement($fkOrcamentoReceitaCreditoAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoReceitaCreditoAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoAcrescimo
     */
    public function getFkOrcamentoReceitaCreditoAcrescimos()
    {
        return $this->fkOrcamentoReceitaCreditoAcrescimos;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoPrevisaoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\PrevisaoReceita $fkOrcamentoPrevisaoReceita
     * @return Receita
     */
    public function addFkOrcamentoPrevisaoReceitas(\Urbem\CoreBundle\Entity\Orcamento\PrevisaoReceita $fkOrcamentoPrevisaoReceita)
    {
        if (false === $this->fkOrcamentoPrevisaoReceitas->contains($fkOrcamentoPrevisaoReceita)) {
            $fkOrcamentoPrevisaoReceita->setFkOrcamentoReceita($this);
            $this->fkOrcamentoPrevisaoReceitas->add($fkOrcamentoPrevisaoReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoPrevisaoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\PrevisaoReceita $fkOrcamentoPrevisaoReceita
     */
    public function removeFkOrcamentoPrevisaoReceitas(\Urbem\CoreBundle\Entity\Orcamento\PrevisaoReceita $fkOrcamentoPrevisaoReceita)
    {
        $this->fkOrcamentoPrevisaoReceitas->removeElement($fkOrcamentoPrevisaoReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoPrevisaoReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\PrevisaoReceita
     */
    public function getFkOrcamentoPrevisaoReceitas()
    {
        return $this->fkOrcamentoPrevisaoReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add StnVinculoStnReceita
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoStnReceita $fkStnVinculoStnReceita
     * @return Receita
     */
    public function addFkStnVinculoStnReceitas(\Urbem\CoreBundle\Entity\Stn\VinculoStnReceita $fkStnVinculoStnReceita)
    {
        if (false === $this->fkStnVinculoStnReceitas->contains($fkStnVinculoStnReceita)) {
            $fkStnVinculoStnReceita->setFkOrcamentoReceita($this);
            $this->fkStnVinculoStnReceitas->add($fkStnVinculoStnReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnVinculoStnReceita
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoStnReceita $fkStnVinculoStnReceita
     */
    public function removeFkStnVinculoStnReceitas(\Urbem\CoreBundle\Entity\Stn\VinculoStnReceita $fkStnVinculoStnReceita)
    {
        $this->fkStnVinculoStnReceitas->removeElement($fkStnVinculoStnReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnVinculoStnReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoStnReceita
     */
    public function getFkStnVinculoStnReceitas()
    {
        return $this->fkStnVinculoStnReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add VinculoSaudeRreo12
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoSaudeRreo12 $fkStnVinculoSaudeRreo12
     * @return Receita
     */
    public function addFkStnVinculoSaudeRreo12s(\Urbem\CoreBundle\Entity\Stn\VinculoSaudeRreo12 $fkStnVinculoSaudeRreo12)
    {
        if (false === $this->fkStnVinculoSaudeRreo12s->contains($fkStnVinculoSaudeRreo12)) {
            $fkStnVinculoSaudeRreo12->setFkOrcamentoReceita($this);
            $this->fkStnVinculoSaudeRreo12s->add($fkStnVinculoSaudeRreo12);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove VinculoSaudeRreo12
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoSaudeRreo12 $fkStnVinculoSaudeRreo12
     */
    public function removeFkStnVinculoSaudeRreo12s(\Urbem\CoreBundle\Entity\Stn\VinculoSaudeRreo12 $fkStnVinculoSaudeRreo12)
    {
        $this->fkStnVinculoSaudeRreo12s->removeElement($fkStnVinculoSaudeRreo12);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnVinculoSaudeRreo12s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoSaudeRreo12
     */
    public function getFkStnVinculoSaudeRreo12s()
    {
        return $this->fkStnVinculoSaudeRreo12s;
    }

    /**
     * OneToMany (owning side)
     * Add StnAporteRecursoRppsReceita
     *
     * @param \Urbem\CoreBundle\Entity\Stn\AporteRecursoRppsReceita $fkStnAporteRecursoRppsReceita
     * @return Receita
     */
    public function addFkStnAporteRecursoRppsReceitas(\Urbem\CoreBundle\Entity\Stn\AporteRecursoRppsReceita $fkStnAporteRecursoRppsReceita)
    {
        if (false === $this->fkStnAporteRecursoRppsReceitas->contains($fkStnAporteRecursoRppsReceita)) {
            $fkStnAporteRecursoRppsReceita->setFkOrcamentoReceita($this);
            $this->fkStnAporteRecursoRppsReceitas->add($fkStnAporteRecursoRppsReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnAporteRecursoRppsReceita
     *
     * @param \Urbem\CoreBundle\Entity\Stn\AporteRecursoRppsReceita $fkStnAporteRecursoRppsReceita
     */
    public function removeFkStnAporteRecursoRppsReceitas(\Urbem\CoreBundle\Entity\Stn\AporteRecursoRppsReceita $fkStnAporteRecursoRppsReceita)
    {
        $this->fkStnAporteRecursoRppsReceitas->removeElement($fkStnAporteRecursoRppsReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnAporteRecursoRppsReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\AporteRecursoRppsReceita
     */
    public function getFkStnAporteRecursoRppsReceitas()
    {
        return $this->fkStnAporteRecursoRppsReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaArrecadacaoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita $fkTesourariaArrecadacaoReceita
     * @return Receita
     */
    public function addFkTesourariaArrecadacaoReceitas(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita $fkTesourariaArrecadacaoReceita)
    {
        if (false === $this->fkTesourariaArrecadacaoReceitas->contains($fkTesourariaArrecadacaoReceita)) {
            $fkTesourariaArrecadacaoReceita->setFkOrcamentoReceita($this);
            $this->fkTesourariaArrecadacaoReceitas->add($fkTesourariaArrecadacaoReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaArrecadacaoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita $fkTesourariaArrecadacaoReceita
     */
    public function removeFkTesourariaArrecadacaoReceitas(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita $fkTesourariaArrecadacaoReceita)
    {
        $this->fkTesourariaArrecadacaoReceitas->removeElement($fkTesourariaArrecadacaoReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaArrecadacaoReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita
     */
    public function getFkTesourariaArrecadacaoReceitas()
    {
        return $this->fkTesourariaArrecadacaoReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaArrecadacaoReceitaDedutora
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutora $fkTesourariaArrecadacaoReceitaDedutora
     * @return Receita
     */
    public function addFkTesourariaArrecadacaoReceitaDedutoras(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutora $fkTesourariaArrecadacaoReceitaDedutora)
    {
        if (false === $this->fkTesourariaArrecadacaoReceitaDedutoras->contains($fkTesourariaArrecadacaoReceitaDedutora)) {
            $fkTesourariaArrecadacaoReceitaDedutora->setFkOrcamentoReceita($this);
            $this->fkTesourariaArrecadacaoReceitaDedutoras->add($fkTesourariaArrecadacaoReceitaDedutora);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaArrecadacaoReceitaDedutora
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutora $fkTesourariaArrecadacaoReceitaDedutora
     */
    public function removeFkTesourariaArrecadacaoReceitaDedutoras(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutora $fkTesourariaArrecadacaoReceitaDedutora)
    {
        $this->fkTesourariaArrecadacaoReceitaDedutoras->removeElement($fkTesourariaArrecadacaoReceitaDedutora);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaArrecadacaoReceitaDedutoras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutora
     */
    public function getFkTesourariaArrecadacaoReceitaDedutoras()
    {
        return $this->fkTesourariaArrecadacaoReceitaDedutoras;
    }

    /**
     * OneToMany (owning side)
     * Add StnContaDedutoraTributos
     *
     * @param \Urbem\CoreBundle\Entity\Stn\ContaDedutoraTributos $fkStnContaDedutoraTributos
     * @return Receita
     */
    public function addFkStnContaDedutoraTributos(\Urbem\CoreBundle\Entity\Stn\ContaDedutoraTributos $fkStnContaDedutoraTributos)
    {
        if (false === $this->fkStnContaDedutoraTributos->contains($fkStnContaDedutoraTributos)) {
            $fkStnContaDedutoraTributos->setFkOrcamentoReceita($this);
            $this->fkStnContaDedutoraTributos->add($fkStnContaDedutoraTributos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnContaDedutoraTributos
     *
     * @param \Urbem\CoreBundle\Entity\Stn\ContaDedutoraTributos $fkStnContaDedutoraTributos
     */
    public function removeFkStnContaDedutoraTributos(\Urbem\CoreBundle\Entity\Stn\ContaDedutoraTributos $fkStnContaDedutoraTributos)
    {
        $this->fkStnContaDedutoraTributos->removeElement($fkStnContaDedutoraTributos);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnContaDedutoraTributos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\ContaDedutoraTributos
     */
    public function getFkStnContaDedutoraTributos()
    {
        return $this->fkStnContaDedutoraTributos;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoReceitaCreditoDesconto
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoDesconto $fkOrcamentoReceitaCreditoDesconto
     * @return Receita
     */
    public function addFkOrcamentoReceitaCreditoDescontos(\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoDesconto $fkOrcamentoReceitaCreditoDesconto)
    {
        if (false === $this->fkOrcamentoReceitaCreditoDescontos->contains($fkOrcamentoReceitaCreditoDesconto)) {
            $fkOrcamentoReceitaCreditoDesconto->setFkOrcamentoReceita($this);
            $this->fkOrcamentoReceitaCreditoDescontos->add($fkOrcamentoReceitaCreditoDesconto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoReceitaCreditoDesconto
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoDesconto $fkOrcamentoReceitaCreditoDesconto
     */
    public function removeFkOrcamentoReceitaCreditoDescontos(\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoDesconto $fkOrcamentoReceitaCreditoDesconto)
    {
        $this->fkOrcamentoReceitaCreditoDescontos->removeElement($fkOrcamentoReceitaCreditoDesconto);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoReceitaCreditoDescontos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoDesconto
     */
    public function getFkOrcamentoReceitaCreditoDescontos()
    {
        return $this->fkOrcamentoReceitaCreditoDescontos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return Receita
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
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

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso
     * @return Receita
     */
    public function setFkOrcamentoRecurso(\Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso)
    {
        $this->exercicio = $fkOrcamentoRecurso->getExercicio();
        $this->codRecurso = $fkOrcamentoRecurso->getCodRecurso();
        $this->fkOrcamentoRecurso = $fkOrcamentoRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    public function getFkOrcamentoRecurso()
    {
        return $this->fkOrcamentoRecurso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoContaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaReceita $fkOrcamentoContaReceita
     * @return Receita
     */
    public function setFkOrcamentoContaReceita(\Urbem\CoreBundle\Entity\Orcamento\ContaReceita $fkOrcamentoContaReceita)
    {
        $this->exercicio = $fkOrcamentoContaReceita->getExercicio();
        $this->codConta = $fkOrcamentoContaReceita->getCodConta();
        $this->fkOrcamentoContaReceita = $fkOrcamentoContaReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoContaReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ContaReceita
     */
    public function getFkOrcamentoContaReceita()
    {
        return $this->fkOrcamentoContaReceita;
    }

    /**
     * OneToOne (inverse side)
     * Set ManadReceitaCaracPeculiarReceita
     *
     * @param \Urbem\CoreBundle\Entity\Manad\ReceitaCaracPeculiarReceita $fkManadReceitaCaracPeculiarReceita
     * @return Receita
     */
    public function setFkManadReceitaCaracPeculiarReceita(\Urbem\CoreBundle\Entity\Manad\ReceitaCaracPeculiarReceita $fkManadReceitaCaracPeculiarReceita)
    {
        $fkManadReceitaCaracPeculiarReceita->setFkOrcamentoReceita($this);
        $this->fkManadReceitaCaracPeculiarReceita = $fkManadReceitaCaracPeculiarReceita;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkManadReceitaCaracPeculiarReceita
     *
     * @return \Urbem\CoreBundle\Entity\Manad\ReceitaCaracPeculiarReceita
     */
    public function getFkManadReceitaCaracPeculiarReceita()
    {
        return $this->fkManadReceitaCaracPeculiarReceita;
    }

    /**
     * OneToOne (inverse side)
     * Set OrcamentoReceitaCreditoTributario
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoTributario $fkOrcamentoReceitaCreditoTributario
     * @return Receita
     */
    public function setFkOrcamentoReceitaCreditoTributario(\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoTributario $fkOrcamentoReceitaCreditoTributario)
    {
        $fkOrcamentoReceitaCreditoTributario->setFkOrcamentoReceita($this);
        $this->fkOrcamentoReceitaCreditoTributario = $fkOrcamentoReceitaCreditoTributario;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkOrcamentoReceitaCreditoTributario
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoTributario
     */
    public function getFkOrcamentoReceitaCreditoTributario()
    {
        return $this->fkOrcamentoReceitaCreditoTributario;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgReceitaIndentificadoresPeculiarReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ReceitaIndentificadoresPeculiarReceita $fkTcemgReceitaIndentificadoresPeculiarReceita
     * @return Receita
     */
    public function setFkTcemgReceitaIndentificadoresPeculiarReceita(\Urbem\CoreBundle\Entity\Tcemg\ReceitaIndentificadoresPeculiarReceita $fkTcemgReceitaIndentificadoresPeculiarReceita)
    {
        $fkTcemgReceitaIndentificadoresPeculiarReceita->setFkOrcamentoReceita($this);
        $this->fkTcemgReceitaIndentificadoresPeculiarReceita = $fkTcemgReceitaIndentificadoresPeculiarReceita;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgReceitaIndentificadoresPeculiarReceita
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ReceitaIndentificadoresPeculiarReceita
     */
    public function getFkTcemgReceitaIndentificadoresPeculiarReceita()
    {
        return $this->fkTcemgReceitaIndentificadoresPeculiarReceita;
    }

    /**
     * OneToOne (inverse side)
     * Set TcersReceitaCaracPeculiarReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\ReceitaCaracPeculiarReceita $fkTcersReceitaCaracPeculiarReceita
     * @return Receita
     */
    public function setFkTcersReceitaCaracPeculiarReceita(\Urbem\CoreBundle\Entity\Tcers\ReceitaCaracPeculiarReceita $fkTcersReceitaCaracPeculiarReceita)
    {
        $fkTcersReceitaCaracPeculiarReceita->setFkOrcamentoReceita($this);
        $this->fkTcersReceitaCaracPeculiarReceita = $fkTcersReceitaCaracPeculiarReceita;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcersReceitaCaracPeculiarReceita
     *
     * @return \Urbem\CoreBundle\Entity\Tcers\ReceitaCaracPeculiarReceita
     */
    public function getFkTcersReceitaCaracPeculiarReceita()
    {
        return $this->fkTcersReceitaCaracPeculiarReceita;
    }

    /**
     * OneToOne (inverse side)
     * Set TcetoReceitaIndentificadoresPeculiarReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\ReceitaIndentificadoresPeculiarReceita $fkTcetoReceitaIndentificadoresPeculiarReceita
     * @return Receita
     */
    public function setFkTcetoReceitaIndentificadoresPeculiarReceita(\Urbem\CoreBundle\Entity\Tceto\ReceitaIndentificadoresPeculiarReceita $fkTcetoReceitaIndentificadoresPeculiarReceita)
    {
        $fkTcetoReceitaIndentificadoresPeculiarReceita->setFkOrcamentoReceita($this);
        $this->fkTcetoReceitaIndentificadoresPeculiarReceita = $fkTcetoReceitaIndentificadoresPeculiarReceita;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcetoReceitaIndentificadoresPeculiarReceita
     *
     * @return \Urbem\CoreBundle\Entity\Tceto\ReceitaIndentificadoresPeculiarReceita
     */
    public function getFkTcetoReceitaIndentificadoresPeculiarReceita()
    {
        return $this->fkTcetoReceitaIndentificadoresPeculiarReceita;
    }

    /**
     * OneToOne (inverse side)
     * Set TcernReceitaTc
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ReceitaTc $fkTcernReceitaTc
     * @return Receita
     */
    public function setFkTcernReceitaTc(\Urbem\CoreBundle\Entity\Tcern\ReceitaTc $fkTcernReceitaTc)
    {
        $fkTcernReceitaTc->setFkOrcamentoReceita($this);
        $this->fkTcernReceitaTc = $fkTcernReceitaTc;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcernReceitaTc
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\ReceitaTc
     */
    public function getFkTcernReceitaTc()
    {
        return $this->fkTcernReceitaTc;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codReceita, (is_null($this->getFkOrcamentoContaReceita()) ? "" : $this->getFkOrcamentoContaReceita()->getDescricao()));
    }
}
