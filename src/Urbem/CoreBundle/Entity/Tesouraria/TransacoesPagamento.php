<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * TransacoesPagamento
 */
class TransacoesPagamento
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
    private $codOrdem;

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
    private $codTipo;

    /**
     * @var integer
     */
    private $codBanco;

    /**
     * @var integer
     */
    private $codAgencia;

    /**
     * @var string
     */
    private $contaCorrente;

    /**
     * @var string
     */
    private $documento;

    /**
     * @var string
     */
    private $descricao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Bordero
     */
    private $fkTesourariaBordero;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento
     */
    private $fkEmpenhoOrdemPagamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    private $fkMonetarioAgencia;


    /**
     * Set codBordero
     *
     * @param integer $codBordero
     * @return TransacoesPagamento
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
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return TransacoesPagamento
     */
    public function setCodOrdem($codOrdem)
    {
        $this->codOrdem = $codOrdem;
        return $this;
    }

    /**
     * Get codOrdem
     *
     * @return integer
     */
    public function getCodOrdem()
    {
        return $this->codOrdem;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return TransacoesPagamento
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
     * @return TransacoesPagamento
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
     * @return TransacoesPagamento
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
     * Set codBanco
     *
     * @param integer $codBanco
     * @return TransacoesPagamento
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
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return TransacoesPagamento
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
     * Set contaCorrente
     *
     * @param string $contaCorrente
     * @return TransacoesPagamento
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
     * Set documento
     *
     * @param string $documento
     * @return TransacoesPagamento
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
     * Set descricao
     *
     * @param string $descricao
     * @return TransacoesPagamento
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
     * ManyToOne (inverse side)
     * Set fkTesourariaBordero
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero
     * @return TransacoesPagamento
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
     * Set fkEmpenhoOrdemPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento $fkEmpenhoOrdemPagamento
     * @return TransacoesPagamento
     */
    public function setFkEmpenhoOrdemPagamento(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamento $fkEmpenhoOrdemPagamento)
    {
        $this->codOrdem = $fkEmpenhoOrdemPagamento->getCodOrdem();
        $this->exercicio = $fkEmpenhoOrdemPagamento->getExercicio();
        $this->codEntidade = $fkEmpenhoOrdemPagamento->getCodEntidade();
        $this->fkEmpenhoOrdemPagamento = $fkEmpenhoOrdemPagamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoOrdemPagamento
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento
     */
    public function getFkEmpenhoOrdemPagamento()
    {
        return $this->fkEmpenhoOrdemPagamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioAgencia
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia
     * @return TransacoesPagamento
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
