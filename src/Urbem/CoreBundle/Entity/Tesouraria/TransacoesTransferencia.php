<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * TransacoesTransferencia
 */
class TransacoesTransferencia
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
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codAgencia;

    /**
     * PK
     * @var integer
     */
    private $codBanco;

    /**
     * PK
     * @var string
     */
    private $contaCorrente;

    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var string
     */
    private $documento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Bordero
     */
    private $fkTesourariaBordero;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco
     */
    private $fkContabilidadePlanoBanco;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    private $fkMonetarioAgencia;


    /**
     * Set codBordero
     *
     * @param integer $codBordero
     * @return TransacoesTransferencia
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
     * @return TransacoesTransferencia
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return TransacoesTransferencia
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return TransacoesTransferencia
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TransacoesTransferencia
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
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return TransacoesTransferencia
     */
    public function setCodAgencia($codAgencia)
    {
        $this->codAgencia = $codAgencia;
        return $this;
    }

    /**
     * Get codAgencia
     *
     * @return integer
     */
    public function getCodAgencia()
    {
        return $this->codAgencia;
    }

    /**
     * Set codBanco
     *
     * @param integer $codBanco
     * @return TransacoesTransferencia
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;
        return $this;
    }

    /**
     * Get codBanco
     *
     * @return integer
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * Set contaCorrente
     *
     * @param string $contaCorrente
     * @return TransacoesTransferencia
     */
    public function setContaCorrente($contaCorrente)
    {
        $this->contaCorrente = $contaCorrente;
        return $this;
    }

    /**
     * Get contaCorrente
     *
     * @return string
     */
    public function getContaCorrente()
    {
        return $this->contaCorrente;
    }

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return TransacoesTransferencia
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
     * Set descricao
     *
     * @param string $descricao
     * @return TransacoesTransferencia
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return TransacoesTransferencia
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
     * Set documento
     *
     * @param string $documento
     * @return TransacoesTransferencia
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;
        return $this;
    }

    /**
     * Get documento
     *
     * @return string
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaBordero
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero
     * @return TransacoesTransferencia
     */
    public function setFkTesourariaBordero(\Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero)
    {
        $this->codBordero = $fkTesourariaBordero->getCodBordero();
        $this->codEntidade = $fkTesourariaBordero->getCodEntidade();
        $this->exercicio = $fkTesourariaBordero->getExercicio();
        $this->fkTesourariaBordero = $fkTesourariaBordero;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaBordero
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Bordero
     */
    public function getFkTesourariaBordero()
    {
        return $this->fkTesourariaBordero;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return TransacoesTransferencia
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco $fkContabilidadePlanoBanco
     * @return TransacoesTransferencia
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
     * Set fkMonetarioAgencia
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia
     * @return TransacoesTransferencia
     */
    public function setFkMonetarioAgencia(\Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia)
    {
        $this->codBanco = $fkMonetarioAgencia->getCodBanco();
        $this->codAgencia = $fkMonetarioAgencia->getCodAgencia();
        $this->fkMonetarioAgencia = $fkMonetarioAgencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioAgencia
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    public function getFkMonetarioAgencia()
    {
        return $this->fkMonetarioAgencia;
    }
}
