<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * Contrato
 */
class Contrato
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

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
    private $numOrgao;

    /**
     * @var integer
     */
    private $numUnidade;

    /**
     * @var integer
     */
    private $nroContrato;

    /**
     * @var integer
     */
    private $codModalidadeLicitacao;

    /**
     * @var integer
     */
    private $codObjeto;

    /**
     * @var integer
     */
    private $codInstrumento;

    /**
     * @var string
     */
    private $objetoContrato;

    /**
     * @var integer
     */
    private $vlContrato;

    /**
     * @var integer
     */
    private $numcgmContratante;

    /**
     * @var integer
     */
    private $numcgmPublicidade;

    /**
     * @var \DateTime
     */
    private $dataAssinatura;

    /**
     * @var \DateTime
     */
    private $dataPublicacao;

    /**
     * @var \DateTime
     */
    private $dataInicio;

    /**
     * @var \DateTime
     */
    private $dataFinal;

    /**
     * @var integer
     */
    private $codEntidadeModalidade;

    /**
     * @var integer
     */
    private $codTipoProcesso;

    /**
     * @var integer
     */
    private $codGarantia;

    /**
     * @var integer
     */
    private $numOrgaoModalidade;

    /**
     * @var integer
     */
    private $numUnidadeModalidade;

    /**
     * @var integer
     */
    private $nroProcesso;

    /**
     * @var string
     */
    private $exercicioProcesso;

    /**
     * @var string
     */
    private $fornecimento;

    /**
     * @var string
     */
    private $pagamento;

    /**
     * @var string
     */
    private $execucao;

    /**
     * @var string
     */
    private $multa;

    /**
     * @var integer
     */
    private $cgmSignatario;

    /**
     * @var string
     */
    private $multaInadimplemento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\ContratoRescisao
     */
    private $fkTcemgContratoRescisao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoApostila
     */
    private $fkTcemgContratoApostilas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoEmpenho
     */
    private $fkTcemgContratoEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo
     */
    private $fkTcemgContratoAditivos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor
     */
    private $fkTcemgContratoFornecedores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Orgao
     */
    private $fkOrcamentoOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\ContratoModalidadeLicitacao
     */
    private $fkTcemgContratoModalidadeLicitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\ContratoObjeto
     */
    private $fkTcemgContratoObjeto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\ContratoInstrumento
     */
    private $fkTcemgContratoInstrumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    private $fkLicitacaoVeiculosPublicidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\ContratoTipoProcesso
     */
    private $fkTcemgContratoTipoProcesso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\ContratoGarantia
     */
    private $fkTcemgContratoGarantia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgContratoApostilas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgContratoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgContratoAditivos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgContratoFornecedores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return Contrato
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Contrato
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
     * @return Contrato
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
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return Contrato
     */
    public function setNumOrgao($numOrgao)
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
     * @return Contrato
     */
    public function setNumUnidade($numUnidade)
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
     * Set nroContrato
     *
     * @param integer $nroContrato
     * @return Contrato
     */
    public function setNroContrato($nroContrato)
    {
        $this->nroContrato = $nroContrato;
        return $this;
    }

    /**
     * Get nroContrato
     *
     * @return integer
     */
    public function getNroContrato()
    {
        return $this->nroContrato;
    }

    /**
     * Set codModalidadeLicitacao
     *
     * @param integer $codModalidadeLicitacao
     * @return Contrato
     */
    public function setCodModalidadeLicitacao($codModalidadeLicitacao)
    {
        $this->codModalidadeLicitacao = $codModalidadeLicitacao;
        return $this;
    }

    /**
     * Get codModalidadeLicitacao
     *
     * @return integer
     */
    public function getCodModalidadeLicitacao()
    {
        return $this->codModalidadeLicitacao;
    }

    /**
     * Set codObjeto
     *
     * @param integer $codObjeto
     * @return Contrato
     */
    public function setCodObjeto($codObjeto)
    {
        $this->codObjeto = $codObjeto;
        return $this;
    }

    /**
     * Get codObjeto
     *
     * @return integer
     */
    public function getCodObjeto()
    {
        return $this->codObjeto;
    }

    /**
     * Set codInstrumento
     *
     * @param integer $codInstrumento
     * @return Contrato
     */
    public function setCodInstrumento($codInstrumento)
    {
        $this->codInstrumento = $codInstrumento;
        return $this;
    }

    /**
     * Get codInstrumento
     *
     * @return integer
     */
    public function getCodInstrumento()
    {
        return $this->codInstrumento;
    }

    /**
     * Set objetoContrato
     *
     * @param string $objetoContrato
     * @return Contrato
     */
    public function setObjetoContrato($objetoContrato)
    {
        $this->objetoContrato = $objetoContrato;
        return $this;
    }

    /**
     * Get objetoContrato
     *
     * @return string
     */
    public function getObjetoContrato()
    {
        return $this->objetoContrato;
    }

    /**
     * Set vlContrato
     *
     * @param integer $vlContrato
     * @return Contrato
     */
    public function setVlContrato($vlContrato)
    {
        $this->vlContrato = $vlContrato;
        return $this;
    }

    /**
     * Get vlContrato
     *
     * @return integer
     */
    public function getVlContrato()
    {
        return $this->vlContrato;
    }

    /**
     * Set numcgmContratante
     *
     * @param integer $numcgmContratante
     * @return Contrato
     */
    public function setNumcgmContratante($numcgmContratante)
    {
        $this->numcgmContratante = $numcgmContratante;
        return $this;
    }

    /**
     * Get numcgmContratante
     *
     * @return integer
     */
    public function getNumcgmContratante()
    {
        return $this->numcgmContratante;
    }

    /**
     * Set numcgmPublicidade
     *
     * @param integer $numcgmPublicidade
     * @return Contrato
     */
    public function setNumcgmPublicidade($numcgmPublicidade)
    {
        $this->numcgmPublicidade = $numcgmPublicidade;
        return $this;
    }

    /**
     * Get numcgmPublicidade
     *
     * @return integer
     */
    public function getNumcgmPublicidade()
    {
        return $this->numcgmPublicidade;
    }

    /**
     * Set dataAssinatura
     *
     * @param \DateTime $dataAssinatura
     * @return Contrato
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
     * Set dataPublicacao
     *
     * @param \DateTime $dataPublicacao
     * @return Contrato
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
     * Set dataInicio
     *
     * @param \DateTime $dataInicio
     * @return Contrato
     */
    public function setDataInicio(\DateTime $dataInicio = null)
    {
        $this->dataInicio = $dataInicio;
        return $this;
    }

    /**
     * Get dataInicio
     *
     * @return \DateTime
     */
    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    /**
     * Set dataFinal
     *
     * @param \DateTime $dataFinal
     * @return Contrato
     */
    public function setDataFinal(\DateTime $dataFinal = null)
    {
        $this->dataFinal = $dataFinal;
        return $this;
    }

    /**
     * Get dataFinal
     *
     * @return \DateTime
     */
    public function getDataFinal()
    {
        return $this->dataFinal;
    }

    /**
     * Set codEntidadeModalidade
     *
     * @param integer $codEntidadeModalidade
     * @return Contrato
     */
    public function setCodEntidadeModalidade($codEntidadeModalidade = null)
    {
        $this->codEntidadeModalidade = $codEntidadeModalidade;
        return $this;
    }

    /**
     * Get codEntidadeModalidade
     *
     * @return integer
     */
    public function getCodEntidadeModalidade()
    {
        return $this->codEntidadeModalidade;
    }

    /**
     * Set codTipoProcesso
     *
     * @param integer $codTipoProcesso
     * @return Contrato
     */
    public function setCodTipoProcesso($codTipoProcesso = null)
    {
        $this->codTipoProcesso = $codTipoProcesso;
        return $this;
    }

    /**
     * Get codTipoProcesso
     *
     * @return integer
     */
    public function getCodTipoProcesso()
    {
        return $this->codTipoProcesso;
    }

    /**
     * Set codGarantia
     *
     * @param integer $codGarantia
     * @return Contrato
     */
    public function setCodGarantia($codGarantia = null)
    {
        $this->codGarantia = $codGarantia;
        return $this;
    }

    /**
     * Get codGarantia
     *
     * @return integer
     */
    public function getCodGarantia()
    {
        return $this->codGarantia;
    }

    /**
     * Set numOrgaoModalidade
     *
     * @param integer $numOrgaoModalidade
     * @return Contrato
     */
    public function setNumOrgaoModalidade($numOrgaoModalidade = null)
    {
        $this->numOrgaoModalidade = $numOrgaoModalidade;
        return $this;
    }

    /**
     * Get numOrgaoModalidade
     *
     * @return integer
     */
    public function getNumOrgaoModalidade()
    {
        return $this->numOrgaoModalidade;
    }

    /**
     * Set numUnidadeModalidade
     *
     * @param integer $numUnidadeModalidade
     * @return Contrato
     */
    public function setNumUnidadeModalidade($numUnidadeModalidade = null)
    {
        $this->numUnidadeModalidade = $numUnidadeModalidade;
        return $this;
    }

    /**
     * Get numUnidadeModalidade
     *
     * @return integer
     */
    public function getNumUnidadeModalidade()
    {
        return $this->numUnidadeModalidade;
    }

    /**
     * Set nroProcesso
     *
     * @param integer $nroProcesso
     * @return Contrato
     */
    public function setNroProcesso($nroProcesso = null)
    {
        $this->nroProcesso = $nroProcesso;
        return $this;
    }

    /**
     * Get nroProcesso
     *
     * @return integer
     */
    public function getNroProcesso()
    {
        return $this->nroProcesso;
    }

    /**
     * Set exercicioProcesso
     *
     * @param string $exercicioProcesso
     * @return Contrato
     */
    public function setExercicioProcesso($exercicioProcesso = null)
    {
        $this->exercicioProcesso = $exercicioProcesso;
        return $this;
    }

    /**
     * Get exercicioProcesso
     *
     * @return string
     */
    public function getExercicioProcesso()
    {
        return $this->exercicioProcesso;
    }

    /**
     * Set fornecimento
     *
     * @param string $fornecimento
     * @return Contrato
     */
    public function setFornecimento($fornecimento = null)
    {
        $this->fornecimento = $fornecimento;
        return $this;
    }

    /**
     * Get fornecimento
     *
     * @return string
     */
    public function getFornecimento()
    {
        return $this->fornecimento;
    }

    /**
     * Set pagamento
     *
     * @param string $pagamento
     * @return Contrato
     */
    public function setPagamento($pagamento = null)
    {
        $this->pagamento = $pagamento;
        return $this;
    }

    /**
     * Get pagamento
     *
     * @return string
     */
    public function getPagamento()
    {
        return $this->pagamento;
    }

    /**
     * Set execucao
     *
     * @param string $execucao
     * @return Contrato
     */
    public function setExecucao($execucao = null)
    {
        $this->execucao = $execucao;
        return $this;
    }

    /**
     * Get execucao
     *
     * @return string
     */
    public function getExecucao()
    {
        return $this->execucao;
    }

    /**
     * Set multa
     *
     * @param string $multa
     * @return Contrato
     */
    public function setMulta($multa = null)
    {
        $this->multa = $multa;
        return $this;
    }

    /**
     * Get multa
     *
     * @return string
     */
    public function getMulta()
    {
        return $this->multa;
    }

    /**
     * Set cgmSignatario
     *
     * @param integer $cgmSignatario
     * @return Contrato
     */
    public function setCgmSignatario($cgmSignatario)
    {
        $this->cgmSignatario = $cgmSignatario;
        return $this;
    }

    /**
     * Get cgmSignatario
     *
     * @return integer
     */
    public function getCgmSignatario()
    {
        return $this->cgmSignatario;
    }

    /**
     * Set multaInadimplemento
     *
     * @param string $multaInadimplemento
     * @return Contrato
     */
    public function setMultaInadimplemento($multaInadimplemento = null)
    {
        $this->multaInadimplemento = $multaInadimplemento;
        return $this;
    }

    /**
     * Get multaInadimplemento
     *
     * @return string
     */
    public function getMultaInadimplemento()
    {
        return $this->multaInadimplemento;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgContratoApostila
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoApostila $fkTcemgContratoApostila
     * @return Contrato
     */
    public function addFkTcemgContratoApostilas(\Urbem\CoreBundle\Entity\Tcemg\ContratoApostila $fkTcemgContratoApostila)
    {
        if (false === $this->fkTcemgContratoApostilas->contains($fkTcemgContratoApostila)) {
            $fkTcemgContratoApostila->setFkTcemgContrato($this);
            $this->fkTcemgContratoApostilas->add($fkTcemgContratoApostila);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContratoApostila
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoApostila $fkTcemgContratoApostila
     */
    public function removeFkTcemgContratoApostilas(\Urbem\CoreBundle\Entity\Tcemg\ContratoApostila $fkTcemgContratoApostila)
    {
        $this->fkTcemgContratoApostilas->removeElement($fkTcemgContratoApostila);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratoApostilas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoApostila
     */
    public function getFkTcemgContratoApostilas()
    {
        return $this->fkTcemgContratoApostilas;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgContratoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoEmpenho $fkTcemgContratoEmpenho
     * @return Contrato
     */
    public function addFkTcemgContratoEmpenhos(\Urbem\CoreBundle\Entity\Tcemg\ContratoEmpenho $fkTcemgContratoEmpenho)
    {
        if (false === $this->fkTcemgContratoEmpenhos->contains($fkTcemgContratoEmpenho)) {
            $fkTcemgContratoEmpenho->setFkTcemgContrato($this);
            $this->fkTcemgContratoEmpenhos->add($fkTcemgContratoEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContratoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoEmpenho $fkTcemgContratoEmpenho
     */
    public function removeFkTcemgContratoEmpenhos(\Urbem\CoreBundle\Entity\Tcemg\ContratoEmpenho $fkTcemgContratoEmpenho)
    {
        $this->fkTcemgContratoEmpenhos->removeElement($fkTcemgContratoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoEmpenho
     */
    public function getFkTcemgContratoEmpenhos()
    {
        return $this->fkTcemgContratoEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgContratoAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo
     * @return Contrato
     */
    public function addFkTcemgContratoAditivos(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo)
    {
        if (false === $this->fkTcemgContratoAditivos->contains($fkTcemgContratoAditivo)) {
            $fkTcemgContratoAditivo->setFkTcemgContrato($this);
            $this->fkTcemgContratoAditivos->add($fkTcemgContratoAditivo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContratoAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo
     */
    public function removeFkTcemgContratoAditivos(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo)
    {
        $this->fkTcemgContratoAditivos->removeElement($fkTcemgContratoAditivo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratoAditivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo
     */
    public function getFkTcemgContratoAditivos()
    {
        return $this->fkTcemgContratoAditivos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgContratoFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor $fkTcemgContratoFornecedor
     * @return Contrato
     */
    public function addFkTcemgContratoFornecedores(\Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor $fkTcemgContratoFornecedor)
    {
        if (false === $this->fkTcemgContratoFornecedores->contains($fkTcemgContratoFornecedor)) {
            $fkTcemgContratoFornecedor->setFkTcemgContrato($this);
            $this->fkTcemgContratoFornecedores->add($fkTcemgContratoFornecedor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContratoFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor $fkTcemgContratoFornecedor
     */
    public function removeFkTcemgContratoFornecedores(\Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor $fkTcemgContratoFornecedor)
    {
        $this->fkTcemgContratoFornecedores->removeElement($fkTcemgContratoFornecedor);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratoFornecedores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor
     */
    public function getFkTcemgContratoFornecedores()
    {
        return $this->fkTcemgContratoFornecedores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return Contrato
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
     * Set fkOrcamentoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Orgao $fkOrcamentoOrgao
     * @return Contrato
     */
    public function setFkOrcamentoOrgao(\Urbem\CoreBundle\Entity\Orcamento\Orgao $fkOrcamentoOrgao)
    {
        $this->exercicio = $fkOrcamentoOrgao->getExercicio();
        $this->numOrgao = $fkOrcamentoOrgao->getNumOrgao();
        $this->fkOrcamentoOrgao = $fkOrcamentoOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Orgao
     */
    public function getFkOrcamentoOrgao()
    {
        return $this->fkOrcamentoOrgao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return Contrato
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
     * Set fkTcemgContratoModalidadeLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoModalidadeLicitacao $fkTcemgContratoModalidadeLicitacao
     * @return Contrato
     */
    public function setFkTcemgContratoModalidadeLicitacao(\Urbem\CoreBundle\Entity\Tcemg\ContratoModalidadeLicitacao $fkTcemgContratoModalidadeLicitacao)
    {
        $this->codModalidadeLicitacao = $fkTcemgContratoModalidadeLicitacao->getCodModalidadeLicitacao();
        $this->fkTcemgContratoModalidadeLicitacao = $fkTcemgContratoModalidadeLicitacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgContratoModalidadeLicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ContratoModalidadeLicitacao
     */
    public function getFkTcemgContratoModalidadeLicitacao()
    {
        return $this->fkTcemgContratoModalidadeLicitacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgContratoObjeto
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoObjeto $fkTcemgContratoObjeto
     * @return Contrato
     */
    public function setFkTcemgContratoObjeto(\Urbem\CoreBundle\Entity\Tcemg\ContratoObjeto $fkTcemgContratoObjeto)
    {
        $this->codObjeto = $fkTcemgContratoObjeto->getCodObjeto();
        $this->fkTcemgContratoObjeto = $fkTcemgContratoObjeto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgContratoObjeto
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ContratoObjeto
     */
    public function getFkTcemgContratoObjeto()
    {
        return $this->fkTcemgContratoObjeto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgContratoInstrumento
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoInstrumento $fkTcemgContratoInstrumento
     * @return Contrato
     */
    public function setFkTcemgContratoInstrumento(\Urbem\CoreBundle\Entity\Tcemg\ContratoInstrumento $fkTcemgContratoInstrumento)
    {
        $this->codInstrumento = $fkTcemgContratoInstrumento->getCodInstrumento();
        $this->fkTcemgContratoInstrumento = $fkTcemgContratoInstrumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgContratoInstrumento
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ContratoInstrumento
     */
    public function getFkTcemgContratoInstrumento()
    {
        return $this->fkTcemgContratoInstrumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Contrato
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgmContratante = $fkSwCgm->getNumcgm();
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
     * Set fkLicitacaoVeiculosPublicidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade
     * @return Contrato
     */
    public function setFkLicitacaoVeiculosPublicidade(\Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade)
    {
        $this->numcgmPublicidade = $fkLicitacaoVeiculosPublicidade->getNumcgm();
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
     * ManyToOne (inverse side)
     * Set fkTcemgContratoTipoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoTipoProcesso $fkTcemgContratoTipoProcesso
     * @return Contrato
     */
    public function setFkTcemgContratoTipoProcesso(\Urbem\CoreBundle\Entity\Tcemg\ContratoTipoProcesso $fkTcemgContratoTipoProcesso)
    {
        $this->codTipoProcesso = $fkTcemgContratoTipoProcesso->getCodTipoProcesso();
        $this->fkTcemgContratoTipoProcesso = $fkTcemgContratoTipoProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgContratoTipoProcesso
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ContratoTipoProcesso
     */
    public function getFkTcemgContratoTipoProcesso()
    {
        return $this->fkTcemgContratoTipoProcesso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgContratoGarantia
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoGarantia $fkTcemgContratoGarantia
     * @return Contrato
     */
    public function setFkTcemgContratoGarantia(\Urbem\CoreBundle\Entity\Tcemg\ContratoGarantia $fkTcemgContratoGarantia)
    {
        $this->codGarantia = $fkTcemgContratoGarantia->getCodGarantia();
        $this->fkTcemgContratoGarantia = $fkTcemgContratoGarantia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgContratoGarantia
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ContratoGarantia
     */
    public function getFkTcemgContratoGarantia()
    {
        return $this->fkTcemgContratoGarantia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return Contrato
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->cgmSignatario = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgContratoRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoRescisao $fkTcemgContratoRescisao
     * @return Contrato
     */
    public function setFkTcemgContratoRescisao(\Urbem\CoreBundle\Entity\Tcemg\ContratoRescisao $fkTcemgContratoRescisao)
    {
        $fkTcemgContratoRescisao->setFkTcemgContrato($this);
        $this->fkTcemgContratoRescisao = $fkTcemgContratoRescisao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgContratoRescisao
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ContratoRescisao
     */
    public function getFkTcemgContratoRescisao()
    {
        return $this->fkTcemgContratoRescisao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->nroContrato, $this->exercicio);
    }
}
