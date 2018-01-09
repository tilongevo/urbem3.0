<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * Bordero
 */
class Bordero
{
    /**
     * PK
     * @var integer
     */
    private $codBordero;

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
     * @var integer
     */
    private $codPlano;

    /**
     * @var integer
     */
    private $codBoletim;

    /**
     * @var string
     */
    private $exercicioBoletim;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $timestampBordero;

    /**
     * @var integer
     */
    private $codTerminal;

    /**
     * @var integer
     */
    private $cgmUsuario;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $timestampTerminal;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $timestampUsuario;

    /**
     * @var integer
     */
    private $codAutenticacao;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $dtAutenticacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia
     */
    private $fkTesourariaTransacoesTransferencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransacoesPagamento
     */
    private $fkTesourariaTransacoesPagamentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Boletim
     */
    private $fkTesourariaBoletim;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco
     */
    private $fkContabilidadePlanoBanco;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal
     */
    private $fkTesourariaUsuarioTerminal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Autenticacao
     */
    private $fkTesourariaAutenticacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTesourariaTransacoesTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransacoesPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampBordero = new DateTimeMicrosecondPK();
        $this->dtAutenticacao = new DateTimeMicrosecondPK();
    }

    /**
     * Set codBordero
     *
     * @param integer $codBordero
     * @return Bordero
     */
    public function setCodBordero($codBordero)
    {
        $this->codBordero = $codBordero;
        return $this;
    }

    /**
     * Get codBordero
     *
     * @return integer
     */
    public function getCodBordero()
    {
        return $this->codBordero;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Bordero
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
     * @return Bordero
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
     * Set codPlano
     *
     * @param integer $codPlano
     * @return Bordero
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
     * Set codBoletim
     *
     * @param integer $codBoletim
     * @return Bordero
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
     * @return Bordero
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
     * Set timestampBordero
     *
     * @param DateTimeMicrosecondPK $timestampBordero
     * @return Bordero
     */
    public function setTimestampBordero(DateTimeMicrosecondPK $timestampBordero)
    {
        $this->timestampBordero = $timestampBordero;
        return $this;
    }

    /**
     * Get timestampBordero
     *
     * @return DateTimeMicrosecondPK
     */
    public function getTimestampBordero()
    {
        return $this->timestampBordero;
    }

    /**
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return Bordero
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
     * Set cgmUsuario
     *
     * @param integer $cgmUsuario
     * @return Bordero
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
     * Set timestampTerminal
     *
     * @param DateTimeMicrosecondPK $timestampTerminal
     * @return Bordero
     */
    public function setTimestampTerminal(DateTimeMicrosecondPK $timestampTerminal)
    {
        $this->timestampTerminal = $timestampTerminal;
        return $this;
    }

    /**
     * Get timestampTerminal
     *
     * @return DateTimeMicrosecondPK
     */
    public function getTimestampTerminal()
    {
        return $this->timestampTerminal;
    }

    /**
     * Set timestampUsuario
     *
     * @param DateTimeMicrosecondPK $timestampUsuario
     * @return Bordero
     */
    public function setTimestampUsuario(DateTimeMicrosecondPK $timestampUsuario)
    {
        $this->timestampUsuario = $timestampUsuario;
        return $this;
    }

    /**
     * Get timestampUsuario
     *
     * @return DateTimeMicrosecondPK
     */
    public function getTimestampUsuario()
    {
        return $this->timestampUsuario;
    }

    /**
     * Set codAutenticacao
     *
     * @param integer $codAutenticacao
     * @return Bordero
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
     * @return Bordero
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
     * OneToMany (owning side)
     * Add TesourariaTransacoesTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia $fkTesourariaTransacoesTransferencia
     * @return Bordero
     */
    public function addFkTesourariaTransacoesTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia $fkTesourariaTransacoesTransferencia)
    {
        if (false === $this->fkTesourariaTransacoesTransferencias->contains($fkTesourariaTransacoesTransferencia)) {
            $fkTesourariaTransacoesTransferencia->setFkTesourariaBordero($this);
            $this->fkTesourariaTransacoesTransferencias->add($fkTesourariaTransacoesTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransacoesTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia $fkTesourariaTransacoesTransferencia
     */
    public function removeFkTesourariaTransacoesTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia $fkTesourariaTransacoesTransferencia)
    {
        $this->fkTesourariaTransacoesTransferencias->removeElement($fkTesourariaTransacoesTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransacoesTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia
     */
    public function getFkTesourariaTransacoesTransferencias()
    {
        return $this->fkTesourariaTransacoesTransferencias;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransacoesPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransacoesPagamento $fkTesourariaTransacoesPagamento
     * @return Bordero
     */
    public function addFkTesourariaTransacoesPagamentos(\Urbem\CoreBundle\Entity\Tesouraria\TransacoesPagamento $fkTesourariaTransacoesPagamento)
    {
        if (false === $this->fkTesourariaTransacoesPagamentos->contains($fkTesourariaTransacoesPagamento)) {
            $fkTesourariaTransacoesPagamento->setFkTesourariaBordero($this);
            $this->fkTesourariaTransacoesPagamentos->add($fkTesourariaTransacoesPagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransacoesPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransacoesPagamento $fkTesourariaTransacoesPagamento
     */
    public function removeFkTesourariaTransacoesPagamentos(\Urbem\CoreBundle\Entity\Tesouraria\TransacoesPagamento $fkTesourariaTransacoesPagamento)
    {
        $this->fkTesourariaTransacoesPagamentos->removeElement($fkTesourariaTransacoesPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransacoesPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransacoesPagamento
     */
    public function getFkTesourariaTransacoesPagamentos()
    {
        return $this->fkTesourariaTransacoesPagamentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaBoletim
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim
     * @return Bordero
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
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return Bordero
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
     * Set fkContabilidadePlanoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco $fkContabilidadePlanoBanco
     * @return Bordero
     */
    public function setFkContabilidadePlanoBanco(\Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco $fkContabilidadePlanoBanco)
    {
        $this->codPlano = $fkContabilidadePlanoBanco->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoBanco->getExercicio();
        $this->fkContabilidadePlanoBanco = $fkContabilidadePlanoBanco;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoBanco
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco
     */
    public function getFkContabilidadePlanoBanco()
    {
        return $this->fkContabilidadePlanoBanco;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaUsuarioTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal
     * @return Bordero
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
     * Set fkTesourariaAutenticacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Autenticacao $fkTesourariaAutenticacao
     * @return Bordero
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
}
