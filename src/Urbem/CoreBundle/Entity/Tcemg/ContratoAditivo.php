<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ContratoAditivo
 */
class ContratoAditivo
{
    CONST COD_TIPO_VALOR_ACRESCIMO = 1;
    CONST COD_TIPO_VALOR_DECRESCIMO = 2;

    /**
     * PK
     * @var integer
     */
    private $codContratoAditivo;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codContrato;

    /**
     * @var string
     */
    private $exercicioContrato;

    /**
     * @var integer
     */
    private $codEntidadeContrato;

    /**
     * @var integer
     */
    private $nroAditivo;

    /**
     * @var integer
     */
    private $numOrgao;

    /**
     * @var integer
     */
    private $numUnidade;

    /**
     * @var \DateTime
     */
    private $dataAssinatura;

    /**
     * @var integer
     */
    private $codTipoValor;

    /**
     * @var integer
     */
    private $codTipoAditivo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var \DateTime
     */
    private $dataTermino;

    /**
     * @var \DateTime
     */
    private $dataPublicacao;

    /**
     * @var integer
     */
    private $cgmPublicacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem
     */
    private $fkTcemgContratoAditivoItens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    private $fkTcemgContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoTipo
     */
    private $fkTcemgContratoAditivoTipo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    private $fkLicitacaoVeiculosPublicidade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgContratoAditivoItens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codContratoAditivo
     *
     * @param integer $codContratoAditivo
     * @return ContratoAditivo
     */
    public function setCodContratoAditivo($codContratoAditivo)
    {
        $this->codContratoAditivo = $codContratoAditivo;
        return $this;
    }

    /**
     * Get codContratoAditivo
     *
     * @return integer
     */
    public function getCodContratoAditivo()
    {
        return $this->codContratoAditivo;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContratoAditivo
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ContratoAditivo
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
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoAditivo
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set exercicioContrato
     *
     * @param string $exercicioContrato
     * @return ContratoAditivo
     */
    public function setExercicioContrato($exercicioContrato)
    {
        $this->exercicioContrato = $exercicioContrato;
        return $this;
    }

    /**
     * Get exercicioContrato
     *
     * @return string
     */
    public function getExercicioContrato()
    {
        return $this->exercicioContrato;
    }

    /**
     * Set codEntidadeContrato
     *
     * @param integer $codEntidadeContrato
     * @return ContratoAditivo
     */
    public function setCodEntidadeContrato($codEntidadeContrato)
    {
        $this->codEntidadeContrato = $codEntidadeContrato;
        return $this;
    }

    /**
     * Get codEntidadeContrato
     *
     * @return integer
     */
    public function getCodEntidadeContrato()
    {
        return $this->codEntidadeContrato;
    }

    /**
     * Set nroAditivo
     *
     * @param integer $nroAditivo
     * @return ContratoAditivo
     */
    public function setNroAditivo($nroAditivo)
    {
        $this->nroAditivo = $nroAditivo;
        return $this;
    }

    /**
     * Get nroAditivo
     *
     * @return integer
     */
    public function getNroAditivo()
    {
        return $this->nroAditivo;
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return ContratoAditivo
     */
    public function setNumOrgao($numOrgao = null)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return ContratoAditivo
     */
    public function setNumUnidade($numUnidade = null)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }

    /**
     * Get numUnidade
     *
     * @return integer
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * Set dataAssinatura
     *
     * @param \DateTime $dataAssinatura
     * @return ContratoAditivo
     */
    public function setDataAssinatura(\DateTime $dataAssinatura = null)
    {
        $this->dataAssinatura = $dataAssinatura;
        return $this;
    }

    /**
     * Get dataAssinatura
     *
     * @return \DateTime
     */
    public function getDataAssinatura()
    {
        return $this->dataAssinatura;
    }

    /**
     * Set codTipoValor
     *
     * @param integer $codTipoValor
     * @return ContratoAditivo
     */
    public function setCodTipoValor($codTipoValor)
    {
        $this->codTipoValor = $codTipoValor;
        return $this;
    }

    /**
     * Get codTipoValor
     *
     * @return integer
     */
    public function getCodTipoValor()
    {
        return $this->codTipoValor;
    }

    /**
     * Set codTipoAditivo
     *
     * @param integer $codTipoAditivo
     * @return ContratoAditivo
     */
    public function setCodTipoAditivo($codTipoAditivo)
    {
        $this->codTipoAditivo = $codTipoAditivo;
        return $this;
    }

    /**
     * Get codTipoAditivo
     *
     * @return integer
     */
    public function getCodTipoAditivo()
    {
        return $this->codTipoAditivo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ContratoAditivo
     */
    public function setDescricao($descricao = null)
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
     * @return ContratoAditivo
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
     * Set dataTermino
     *
     * @param \DateTime $dataTermino
     * @return ContratoAditivo
     */
    public function setDataTermino(\DateTime $dataTermino = null)
    {
        $this->dataTermino = $dataTermino;
        return $this;
    }

    /**
     * Get dataTermino
     *
     * @return \DateTime
     */
    public function getDataTermino()
    {
        return $this->dataTermino;
    }

    /**
     * Set dataPublicacao
     *
     * @param \DateTime $dataPublicacao
     * @return ContratoAditivo
     */
    public function setDataPublicacao(\DateTime $dataPublicacao = null)
    {
        $this->dataPublicacao = $dataPublicacao;
        return $this;
    }

    /**
     * Get dataPublicacao
     *
     * @return \DateTime
     */
    public function getDataPublicacao()
    {
        return $this->dataPublicacao;
    }

    /**
     * Set cgmPublicacao
     *
     * @param integer $cgmPublicacao
     * @return ContratoAditivo
     */
    public function setCgmPublicacao($cgmPublicacao)
    {
        $this->cgmPublicacao = $cgmPublicacao;
        return $this;
    }

    /**
     * Get cgmPublicacao
     *
     * @return integer
     */
    public function getCgmPublicacao()
    {
        return $this->cgmPublicacao;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgContratoAditivoItem
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem $fkTcemgContratoAditivoItem
     * @return ContratoAditivo
     */
    public function addFkTcemgContratoAditivoItens(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem $fkTcemgContratoAditivoItem)
    {
        if (false === $this->fkTcemgContratoAditivoItens->contains($fkTcemgContratoAditivoItem)) {
            $fkTcemgContratoAditivoItem->setFkTcemgContratoAditivo($this);
            $this->fkTcemgContratoAditivoItens->add($fkTcemgContratoAditivoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContratoAditivoItem
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem $fkTcemgContratoAditivoItem
     */
    public function removeFkTcemgContratoAditivoItens(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem $fkTcemgContratoAditivoItem)
    {
        $this->fkTcemgContratoAditivoItens->removeElement($fkTcemgContratoAditivoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratoAditivoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem
     */
    public function getFkTcemgContratoAditivoItens()
    {
        return $this->fkTcemgContratoAditivoItens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato
     * @return ContratoAditivo
     */
    public function setFkTcemgContrato(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        $this->codContrato = $fkTcemgContrato->getCodContrato();
        $this->codEntidadeContrato = $fkTcemgContrato->getCodEntidade();
        $this->exercicioContrato = $fkTcemgContrato->getExercicio();
        $this->fkTcemgContrato = $fkTcemgContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgContrato
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    public function getFkTcemgContrato()
    {
        return $this->fkTcemgContrato;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return ContratoAditivo
     */
    public function setFkOrcamentoUnidade(\Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade)
    {
        $this->exercicio = $fkOrcamentoUnidade->getExercicio();
        $this->numUnidade = $fkOrcamentoUnidade->getNumUnidade();
        $this->numOrgao = $fkOrcamentoUnidade->getNumOrgao();
        $this->fkOrcamentoUnidade = $fkOrcamentoUnidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoUnidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    public function getFkOrcamentoUnidade()
    {
        return $this->fkOrcamentoUnidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgContratoAditivoTipo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoTipo $fkTcemgContratoAditivoTipo
     * @return ContratoAditivo
     */
    public function setFkTcemgContratoAditivoTipo(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoTipo $fkTcemgContratoAditivoTipo)
    {
        $this->codTipoAditivo = $fkTcemgContratoAditivoTipo->getCodTipoAditivo();
        $this->fkTcemgContratoAditivoTipo = $fkTcemgContratoAditivoTipo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgContratoAditivoTipo
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoTipo
     */
    public function getFkTcemgContratoAditivoTipo()
    {
        return $this->fkTcemgContratoAditivoTipo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoVeiculosPublicidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade
     * @return ContratoAditivo
     */
    public function setFkLicitacaoVeiculosPublicidade(\Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade)
    {
        $this->cgmPublicacao = $fkLicitacaoVeiculosPublicidade->getNumcgm();
        $this->fkLicitacaoVeiculosPublicidade = $fkLicitacaoVeiculosPublicidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoVeiculosPublicidade
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    public function getFkLicitacaoVeiculosPublicidade()
    {
        return $this->fkLicitacaoVeiculosPublicidade;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->nroAditivo, $this->exercicio);
    }
}
