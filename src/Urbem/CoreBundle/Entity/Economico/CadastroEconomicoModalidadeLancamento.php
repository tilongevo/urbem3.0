<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * CadastroEconomicoModalidadeLancamento
 */
class CadastroEconomicoModalidadeLancamento
{
    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var integer
     */
    private $ocorrenciaAtividade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtBaixa;

    /**
     * @var string
     */
    private $motivoBaixa;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var boolean
     */
    private $percentual;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadEconModalidadeIndicador
     */
    private $fkEconomicoCadEconModalidadeIndicadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadEconModalidadeMoeda
     */
    private $fkEconomicoCadEconModalidadeMoedas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoModLancInscEcon
     */
    private $fkEconomicoProcessoModLancInscEcons;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\ModalidadeLancamento
     */
    private $fkEconomicoModalidadeLancamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico
     */
    private $fkEconomicoAtividadeCadastroEconomico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoCadEconModalidadeIndicadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoCadEconModalidadeMoedas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoProcessoModLancInscEcons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtInicio = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return CadastroEconomicoModalidadeLancamento
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
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return CadastroEconomicoModalidadeLancamento
     */
    public function setCodAtividade($codAtividade)
    {
        $this->codAtividade = $codAtividade;
        return $this;
    }

    /**
     * Get codAtividade
     *
     * @return integer
     */
    public function getCodAtividade()
    {
        return $this->codAtividade;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return CadastroEconomicoModalidadeLancamento
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set ocorrenciaAtividade
     *
     * @param integer $ocorrenciaAtividade
     * @return CadastroEconomicoModalidadeLancamento
     */
    public function setOcorrenciaAtividade($ocorrenciaAtividade)
    {
        $this->ocorrenciaAtividade = $ocorrenciaAtividade;
        return $this;
    }

    /**
     * Get ocorrenciaAtividade
     *
     * @return integer
     */
    public function getOcorrenciaAtividade()
    {
        return $this->ocorrenciaAtividade;
    }

    /**
     * Set dtInicio
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtInicio
     * @return CadastroEconomicoModalidadeLancamento
     */
    public function setDtInicio(\Urbem\CoreBundle\Helper\DatePK $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtBaixa
     *
     * @param \DateTime $dtBaixa
     * @return CadastroEconomicoModalidadeLancamento
     */
    public function setDtBaixa(\DateTime $dtBaixa = null)
    {
        $this->dtBaixa = $dtBaixa;
        return $this;
    }

    /**
     * Get dtBaixa
     *
     * @return \DateTime
     */
    public function getDtBaixa()
    {
        return $this->dtBaixa;
    }

    /**
     * Set motivoBaixa
     *
     * @param string $motivoBaixa
     * @return CadastroEconomicoModalidadeLancamento
     */
    public function setMotivoBaixa($motivoBaixa = null)
    {
        $this->motivoBaixa = $motivoBaixa;
        return $this;
    }

    /**
     * Get motivoBaixa
     *
     * @return string
     */
    public function getMotivoBaixa()
    {
        return $this->motivoBaixa;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return CadastroEconomicoModalidadeLancamento
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
     * Set percentual
     *
     * @param boolean $percentual
     * @return CadastroEconomicoModalidadeLancamento
     */
    public function setPercentual($percentual = null)
    {
        $this->percentual = $percentual;
        return $this;
    }

    /**
     * Get percentual
     *
     * @return boolean
     */
    public function getPercentual()
    {
        return $this->percentual;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoCadEconModalidadeIndicador
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadEconModalidadeIndicador $fkEconomicoCadEconModalidadeIndicador
     * @return CadastroEconomicoModalidadeLancamento
     */
    public function addFkEconomicoCadEconModalidadeIndicadores(\Urbem\CoreBundle\Entity\Economico\CadEconModalidadeIndicador $fkEconomicoCadEconModalidadeIndicador)
    {
        if (false === $this->fkEconomicoCadEconModalidadeIndicadores->contains($fkEconomicoCadEconModalidadeIndicador)) {
            $fkEconomicoCadEconModalidadeIndicador->setFkEconomicoCadastroEconomicoModalidadeLancamento($this);
            $this->fkEconomicoCadEconModalidadeIndicadores->add($fkEconomicoCadEconModalidadeIndicador);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoCadEconModalidadeIndicador
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadEconModalidadeIndicador $fkEconomicoCadEconModalidadeIndicador
     */
    public function removeFkEconomicoCadEconModalidadeIndicadores(\Urbem\CoreBundle\Entity\Economico\CadEconModalidadeIndicador $fkEconomicoCadEconModalidadeIndicador)
    {
        $this->fkEconomicoCadEconModalidadeIndicadores->removeElement($fkEconomicoCadEconModalidadeIndicador);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoCadEconModalidadeIndicadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadEconModalidadeIndicador
     */
    public function getFkEconomicoCadEconModalidadeIndicadores()
    {
        return $this->fkEconomicoCadEconModalidadeIndicadores;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoCadEconModalidadeMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadEconModalidadeMoeda $fkEconomicoCadEconModalidadeMoeda
     * @return CadastroEconomicoModalidadeLancamento
     */
    public function addFkEconomicoCadEconModalidadeMoedas(\Urbem\CoreBundle\Entity\Economico\CadEconModalidadeMoeda $fkEconomicoCadEconModalidadeMoeda)
    {
        if (false === $this->fkEconomicoCadEconModalidadeMoedas->contains($fkEconomicoCadEconModalidadeMoeda)) {
            $fkEconomicoCadEconModalidadeMoeda->setFkEconomicoCadastroEconomicoModalidadeLancamento($this);
            $this->fkEconomicoCadEconModalidadeMoedas->add($fkEconomicoCadEconModalidadeMoeda);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoCadEconModalidadeMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadEconModalidadeMoeda $fkEconomicoCadEconModalidadeMoeda
     */
    public function removeFkEconomicoCadEconModalidadeMoedas(\Urbem\CoreBundle\Entity\Economico\CadEconModalidadeMoeda $fkEconomicoCadEconModalidadeMoeda)
    {
        $this->fkEconomicoCadEconModalidadeMoedas->removeElement($fkEconomicoCadEconModalidadeMoeda);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoCadEconModalidadeMoedas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadEconModalidadeMoeda
     */
    public function getFkEconomicoCadEconModalidadeMoedas()
    {
        return $this->fkEconomicoCadEconModalidadeMoedas;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoModLancInscEcon
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoModLancInscEcon $fkEconomicoProcessoModLancInscEcon
     * @return CadastroEconomicoModalidadeLancamento
     */
    public function addFkEconomicoProcessoModLancInscEcons(\Urbem\CoreBundle\Entity\Economico\ProcessoModLancInscEcon $fkEconomicoProcessoModLancInscEcon)
    {
        if (false === $this->fkEconomicoProcessoModLancInscEcons->contains($fkEconomicoProcessoModLancInscEcon)) {
            $fkEconomicoProcessoModLancInscEcon->setFkEconomicoCadastroEconomicoModalidadeLancamento($this);
            $this->fkEconomicoProcessoModLancInscEcons->add($fkEconomicoProcessoModLancInscEcon);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoModLancInscEcon
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoModLancInscEcon $fkEconomicoProcessoModLancInscEcon
     */
    public function removeFkEconomicoProcessoModLancInscEcons(\Urbem\CoreBundle\Entity\Economico\ProcessoModLancInscEcon $fkEconomicoProcessoModLancInscEcon)
    {
        $this->fkEconomicoProcessoModLancInscEcons->removeElement($fkEconomicoProcessoModLancInscEcon);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoModLancInscEcons
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoModLancInscEcon
     */
    public function getFkEconomicoProcessoModLancInscEcons()
    {
        return $this->fkEconomicoProcessoModLancInscEcons;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoModalidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ModalidadeLancamento $fkEconomicoModalidadeLancamento
     * @return CadastroEconomicoModalidadeLancamento
     */
    public function setFkEconomicoModalidadeLancamento(\Urbem\CoreBundle\Entity\Economico\ModalidadeLancamento $fkEconomicoModalidadeLancamento)
    {
        $this->codModalidade = $fkEconomicoModalidadeLancamento->getCodModalidade();
        $this->fkEconomicoModalidadeLancamento = $fkEconomicoModalidadeLancamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoModalidadeLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Economico\ModalidadeLancamento
     */
    public function getFkEconomicoModalidadeLancamento()
    {
        return $this->fkEconomicoModalidadeLancamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoAtividadeCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico $fkEconomicoAtividadeCadastroEconomico
     * @return CadastroEconomicoModalidadeLancamento
     */
    public function setFkEconomicoAtividadeCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico $fkEconomicoAtividadeCadastroEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoAtividadeCadastroEconomico->getInscricaoEconomica();
        $this->codAtividade = $fkEconomicoAtividadeCadastroEconomico->getCodAtividade();
        $this->ocorrenciaAtividade = $fkEconomicoAtividadeCadastroEconomico->getOcorrenciaAtividade();
        $this->fkEconomicoAtividadeCadastroEconomico = $fkEconomicoAtividadeCadastroEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoAtividadeCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico
     */
    public function getFkEconomicoAtividadeCadastroEconomico()
    {
        return $this->fkEconomicoAtividadeCadastroEconomico;
    }
}
