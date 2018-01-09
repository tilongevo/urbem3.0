<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

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
    private $nroContrato;

    /**
     * @var integer
     */
    private $codAssunto;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codModalidade;

    /**
     * @var integer
     */
    private $vlContrato;

    /**
     * @var string
     */
    private $objetoContrato;

    /**
     * @var \DateTime
     */
    private $dataInicio;

    /**
     * @var \DateTime
     */
    private $dataFinal;

    /**
     * @var \DateTime
     */
    private $dataPublicacao;

    /**
     * @var integer
     */
    private $nroSequencial;

    /**
     * @var integer
     */
    private $nroProcesso;

    /**
     * @var string
     */
    private $anoProcesso;

    /**
     * @var integer
     */
    private $codSubAssunto;

    /**
     * @var string
     */
    private $detalhamentosubassunto;

    /**
     * @var \DateTime
     */
    private $dtFirmatura;

    /**
     * @var \DateTime
     */
    private $dtLancamento;

    /**
     * @var integer
     */
    private $vlAcrescimo;

    /**
     * @var integer
     */
    private $vlDecrescimo;

    /**
     * @var integer
     */
    private $vlContratual;

    /**
     * @var \DateTime
     */
    private $dtRescisao;

    /**
     * @var integer
     */
    private $vlFinalContrato;

    /**
     * @var integer
     */
    private $prazo;

    /**
     * @var string
     */
    private $numeroTermo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ContratoEmpenho
     */
    private $fkTcmgoContratoEmpenhos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\ContratoAssunto
     */
    private $fkTcmgoContratoAssunto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\ContratoTipo
     */
    private $fkTcmgoContratoTipo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\ContratoModalidadeLicitacao
     */
    private $fkTcmgoContratoModalidadeLicitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\ContratoSubAssunto
     */
    private $fkTcmgoContratoSubAssunto;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoContratoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set codAssunto
     *
     * @param integer $codAssunto
     * @return Contrato
     */
    public function setCodAssunto($codAssunto)
    {
        $this->codAssunto = $codAssunto;
        return $this;
    }

    /**
     * Get codAssunto
     *
     * @return integer
     */
    public function getCodAssunto()
    {
        return $this->codAssunto;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Contrato
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
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return Contrato
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
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
     * Set dataInicio
     *
     * @param \DateTime $dataInicio
     * @return Contrato
     */
    public function setDataInicio(\DateTime $dataInicio)
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
    public function setDataFinal(\DateTime $dataFinal)
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
     * Set dataPublicacao
     *
     * @param \DateTime $dataPublicacao
     * @return Contrato
     */
    public function setDataPublicacao(\DateTime $dataPublicacao)
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
     * Set nroSequencial
     *
     * @param integer $nroSequencial
     * @return Contrato
     */
    public function setNroSequencial($nroSequencial)
    {
        $this->nroSequencial = $nroSequencial;
        return $this;
    }

    /**
     * Get nroSequencial
     *
     * @return integer
     */
    public function getNroSequencial()
    {
        return $this->nroSequencial;
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
     * Set anoProcesso
     *
     * @param string $anoProcesso
     * @return Contrato
     */
    public function setAnoProcesso($anoProcesso = null)
    {
        $this->anoProcesso = $anoProcesso;
        return $this;
    }

    /**
     * Get anoProcesso
     *
     * @return string
     */
    public function getAnoProcesso()
    {
        return $this->anoProcesso;
    }

    /**
     * Set codSubAssunto
     *
     * @param integer $codSubAssunto
     * @return Contrato
     */
    public function setCodSubAssunto($codSubAssunto = null)
    {
        $this->codSubAssunto = $codSubAssunto;
        return $this;
    }

    /**
     * Get codSubAssunto
     *
     * @return integer
     */
    public function getCodSubAssunto()
    {
        return $this->codSubAssunto;
    }

    /**
     * Set detalhamentosubassunto
     *
     * @param string $detalhamentosubassunto
     * @return Contrato
     */
    public function setDetalhamentosubassunto($detalhamentosubassunto = null)
    {
        $this->detalhamentosubassunto = $detalhamentosubassunto;
        return $this;
    }

    /**
     * Get detalhamentosubassunto
     *
     * @return string
     */
    public function getDetalhamentosubassunto()
    {
        return $this->detalhamentosubassunto;
    }

    /**
     * Set dtFirmatura
     *
     * @param \DateTime $dtFirmatura
     * @return Contrato
     */
    public function setDtFirmatura(\DateTime $dtFirmatura = null)
    {
        $this->dtFirmatura = $dtFirmatura;
        return $this;
    }

    /**
     * Get dtFirmatura
     *
     * @return \DateTime
     */
    public function getDtFirmatura()
    {
        return $this->dtFirmatura;
    }

    /**
     * Set dtLancamento
     *
     * @param \DateTime $dtLancamento
     * @return Contrato
     */
    public function setDtLancamento(\DateTime $dtLancamento = null)
    {
        $this->dtLancamento = $dtLancamento;
        return $this;
    }

    /**
     * Get dtLancamento
     *
     * @return \DateTime
     */
    public function getDtLancamento()
    {
        return $this->dtLancamento;
    }

    /**
     * Set vlAcrescimo
     *
     * @param integer $vlAcrescimo
     * @return Contrato
     */
    public function setVlAcrescimo($vlAcrescimo = null)
    {
        $this->vlAcrescimo = $vlAcrescimo;
        return $this;
    }

    /**
     * Get vlAcrescimo
     *
     * @return integer
     */
    public function getVlAcrescimo()
    {
        return $this->vlAcrescimo;
    }

    /**
     * Set vlDecrescimo
     *
     * @param integer $vlDecrescimo
     * @return Contrato
     */
    public function setVlDecrescimo($vlDecrescimo = null)
    {
        $this->vlDecrescimo = $vlDecrescimo;
        return $this;
    }

    /**
     * Get vlDecrescimo
     *
     * @return integer
     */
    public function getVlDecrescimo()
    {
        return $this->vlDecrescimo;
    }

    /**
     * Set vlContratual
     *
     * @param integer $vlContratual
     * @return Contrato
     */
    public function setVlContratual($vlContratual = null)
    {
        $this->vlContratual = $vlContratual;
        return $this;
    }

    /**
     * Get vlContratual
     *
     * @return integer
     */
    public function getVlContratual()
    {
        return $this->vlContratual;
    }

    /**
     * Set dtRescisao
     *
     * @param \DateTime $dtRescisao
     * @return Contrato
     */
    public function setDtRescisao(\DateTime $dtRescisao = null)
    {
        $this->dtRescisao = $dtRescisao;
        return $this;
    }

    /**
     * Get dtRescisao
     *
     * @return \DateTime
     */
    public function getDtRescisao()
    {
        return $this->dtRescisao;
    }

    /**
     * Set vlFinalContrato
     *
     * @param integer $vlFinalContrato
     * @return Contrato
     */
    public function setVlFinalContrato($vlFinalContrato = null)
    {
        $this->vlFinalContrato = $vlFinalContrato;
        return $this;
    }

    /**
     * Get vlFinalContrato
     *
     * @return integer
     */
    public function getVlFinalContrato()
    {
        return $this->vlFinalContrato;
    }

    /**
     * Set prazo
     *
     * @param integer $prazo
     * @return Contrato
     */
    public function setPrazo($prazo = null)
    {
        $this->prazo = $prazo;
        return $this;
    }

    /**
     * Get prazo
     *
     * @return integer
     */
    public function getPrazo()
    {
        return $this->prazo;
    }

    /**
     * Set numeroTermo
     *
     * @param string $numeroTermo
     * @return Contrato
     */
    public function setNumeroTermo($numeroTermo = null)
    {
        $this->numeroTermo = $numeroTermo;
        return $this;
    }

    /**
     * Get numeroTermo
     *
     * @return string
     */
    public function getNumeroTermo()
    {
        return $this->numeroTermo;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoContratoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ContratoEmpenho $fkTcmgoContratoEmpenho
     * @return Contrato
     */
    public function addFkTcmgoContratoEmpenhos(\Urbem\CoreBundle\Entity\Tcmgo\ContratoEmpenho $fkTcmgoContratoEmpenho)
    {
        if (false === $this->fkTcmgoContratoEmpenhos->contains($fkTcmgoContratoEmpenho)) {
            $fkTcmgoContratoEmpenho->setFkTcmgoContrato($this);
            $this->fkTcmgoContratoEmpenhos->add($fkTcmgoContratoEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoContratoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ContratoEmpenho $fkTcmgoContratoEmpenho
     */
    public function removeFkTcmgoContratoEmpenhos(\Urbem\CoreBundle\Entity\Tcmgo\ContratoEmpenho $fkTcmgoContratoEmpenho)
    {
        $this->fkTcmgoContratoEmpenhos->removeElement($fkTcmgoContratoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoContratoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ContratoEmpenho
     */
    public function getFkTcmgoContratoEmpenhos()
    {
        return $this->fkTcmgoContratoEmpenhos;
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
     * Set fkTcmgoContratoAssunto
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ContratoAssunto $fkTcmgoContratoAssunto
     * @return Contrato
     */
    public function setFkTcmgoContratoAssunto(\Urbem\CoreBundle\Entity\Tcmgo\ContratoAssunto $fkTcmgoContratoAssunto)
    {
        $this->codAssunto = $fkTcmgoContratoAssunto->getCodAssunto();
        $this->fkTcmgoContratoAssunto = $fkTcmgoContratoAssunto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoContratoAssunto
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\ContratoAssunto
     */
    public function getFkTcmgoContratoAssunto()
    {
        return $this->fkTcmgoContratoAssunto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoContratoTipo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ContratoTipo $fkTcmgoContratoTipo
     * @return Contrato
     */
    public function setFkTcmgoContratoTipo(\Urbem\CoreBundle\Entity\Tcmgo\ContratoTipo $fkTcmgoContratoTipo)
    {
        $this->codTipo = $fkTcmgoContratoTipo->getCodTipo();
        $this->fkTcmgoContratoTipo = $fkTcmgoContratoTipo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoContratoTipo
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\ContratoTipo
     */
    public function getFkTcmgoContratoTipo()
    {
        return $this->fkTcmgoContratoTipo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoContratoModalidadeLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ContratoModalidadeLicitacao $fkTcmgoContratoModalidadeLicitacao
     * @return Contrato
     */
    public function setFkTcmgoContratoModalidadeLicitacao(\Urbem\CoreBundle\Entity\Tcmgo\ContratoModalidadeLicitacao $fkTcmgoContratoModalidadeLicitacao)
    {
        $this->codModalidade = $fkTcmgoContratoModalidadeLicitacao->getCodModalidade();
        $this->fkTcmgoContratoModalidadeLicitacao = $fkTcmgoContratoModalidadeLicitacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoContratoModalidadeLicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\ContratoModalidadeLicitacao
     */
    public function getFkTcmgoContratoModalidadeLicitacao()
    {
        return $this->fkTcmgoContratoModalidadeLicitacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoContratoSubAssunto
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ContratoSubAssunto $fkTcmgoContratoSubAssunto
     * @return Contrato
     */
    public function setFkTcmgoContratoSubAssunto(\Urbem\CoreBundle\Entity\Tcmgo\ContratoSubAssunto $fkTcmgoContratoSubAssunto)
    {
        $this->codSubAssunto = $fkTcmgoContratoSubAssunto->getCodSubAssunto();
        $this->fkTcmgoContratoSubAssunto = $fkTcmgoContratoSubAssunto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoContratoSubAssunto
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\ContratoSubAssunto
     */
    public function getFkTcmgoContratoSubAssunto()
    {
        return $this->fkTcmgoContratoSubAssunto;
    }
}
