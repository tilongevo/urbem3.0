<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * Obra
 */
class Obra
{
    /**
     * PK
     * @var integer
     */
    private $codObra;

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
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nroObra;

    /**
     * @var string
     */
    private $local;

    /**
     * @var string
     */
    private $cep;

    /**
     * @var integer
     */
    private $codBairro;

    /**
     * @var integer
     */
    private $codUf;

    /**
     * @var integer
     */
    private $codMunicipio;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $vlObra;

    /**
     * @var \DateTime
     */
    private $dataCadastro;

    /**
     * @var \DateTime
     */
    private $dataInicio;

    /**
     * @var \DateTime
     */
    private $dataAceite;

    /**
     * @var integer
     */
    private $prazo;

    /**
     * @var \DateTime
     */
    private $dataRecebimento;

    /**
     * @var integer
     */
    private $codLicitacao;

    /**
     * @var integer
     */
    private $codModalidade;

    /**
     * @var string
     */
    private $exercicioLicitacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraMedicao
     */
    private $fkTcmbaObraMedicoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraAndamento
     */
    private $fkTcmbaObraAndamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraFiscal
     */
    private $fkTcmbaObraFiscais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraContratos
     */
    private $fkTcmbaObraContratos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\TipoObra
     */
    private $fkTcmbaTipoObra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCep
     */
    private $fkSwCep;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwBairro
     */
    private $fkSwBairro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\TipoFuncaoObra
     */
    private $fkTcmbaTipoFuncaoObra;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmbaObraMedicoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaObraAndamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaObraFiscais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaObraContratos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codObra
     *
     * @param integer $codObra
     * @return Obra
     */
    public function setCodObra($codObra)
    {
        $this->codObra = $codObra;
        return $this;
    }

    /**
     * Get codObra
     *
     * @return integer
     */
    public function getCodObra()
    {
        return $this->codObra;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Obra
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
     * @return Obra
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
     * @return Obra
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
     * Set nroObra
     *
     * @param string $nroObra
     * @return Obra
     */
    public function setNroObra($nroObra)
    {
        $this->nroObra = $nroObra;
        return $this;
    }

    /**
     * Get nroObra
     *
     * @return string
     */
    public function getNroObra()
    {
        return $this->nroObra;
    }

    /**
     * Set local
     *
     * @param string $local
     * @return Obra
     */
    public function setLocal($local)
    {
        $this->local = $local;
        return $this;
    }

    /**
     * Get local
     *
     * @return string
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * Set cep
     *
     * @param string $cep
     * @return Obra
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
        return $this;
    }

    /**
     * Get cep
     *
     * @return string
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set codBairro
     *
     * @param integer $codBairro
     * @return Obra
     */
    public function setCodBairro($codBairro)
    {
        $this->codBairro = $codBairro;
        return $this;
    }

    /**
     * Get codBairro
     *
     * @return integer
     */
    public function getCodBairro()
    {
        return $this->codBairro;
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return Obra
     */
    public function setCodUf($codUf)
    {
        $this->codUf = $codUf;
        return $this;
    }

    /**
     * Get codUf
     *
     * @return integer
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * Set codMunicipio
     *
     * @param integer $codMunicipio
     * @return Obra
     */
    public function setCodMunicipio($codMunicipio)
    {
        $this->codMunicipio = $codMunicipio;
        return $this;
    }

    /**
     * Get codMunicipio
     *
     * @return integer
     */
    public function getCodMunicipio()
    {
        return $this->codMunicipio;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return Obra
     */
    public function setCodFuncao($codFuncao)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Obra
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
     * Set vlObra
     *
     * @param integer $vlObra
     * @return Obra
     */
    public function setVlObra($vlObra)
    {
        $this->vlObra = $vlObra;
        return $this;
    }

    /**
     * Get vlObra
     *
     * @return integer
     */
    public function getVlObra()
    {
        return $this->vlObra;
    }

    /**
     * Set dataCadastro
     *
     * @param \DateTime $dataCadastro
     * @return Obra
     */
    public function setDataCadastro(\DateTime $dataCadastro)
    {
        $this->dataCadastro = $dataCadastro;
        return $this;
    }

    /**
     * Get dataCadastro
     *
     * @return \DateTime
     */
    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    /**
     * Set dataInicio
     *
     * @param \DateTime $dataInicio
     * @return Obra
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
     * Set dataAceite
     *
     * @param \DateTime $dataAceite
     * @return Obra
     */
    public function setDataAceite(\DateTime $dataAceite)
    {
        $this->dataAceite = $dataAceite;
        return $this;
    }

    /**
     * Get dataAceite
     *
     * @return \DateTime
     */
    public function getDataAceite()
    {
        return $this->dataAceite;
    }

    /**
     * Set prazo
     *
     * @param integer $prazo
     * @return Obra
     */
    public function setPrazo($prazo)
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
     * Set dataRecebimento
     *
     * @param \DateTime $dataRecebimento
     * @return Obra
     */
    public function setDataRecebimento(\DateTime $dataRecebimento)
    {
        $this->dataRecebimento = $dataRecebimento;
        return $this;
    }

    /**
     * Get dataRecebimento
     *
     * @return \DateTime
     */
    public function getDataRecebimento()
    {
        return $this->dataRecebimento;
    }

    /**
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return Obra
     */
    public function setCodLicitacao($codLicitacao = null)
    {
        $this->codLicitacao = $codLicitacao;
        return $this;
    }

    /**
     * Get codLicitacao
     *
     * @return integer
     */
    public function getCodLicitacao()
    {
        return $this->codLicitacao;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return Obra
     */
    public function setCodModalidade($codModalidade = null)
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
     * Set exercicioLicitacao
     *
     * @param string $exercicioLicitacao
     * @return Obra
     */
    public function setExercicioLicitacao($exercicioLicitacao = null)
    {
        $this->exercicioLicitacao = $exercicioLicitacao;
        return $this;
    }

    /**
     * Get exercicioLicitacao
     *
     * @return string
     */
    public function getExercicioLicitacao()
    {
        return $this->exercicioLicitacao;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaObraMedicao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraMedicao $fkTcmbaObraMedicao
     * @return Obra
     */
    public function addFkTcmbaObraMedicoes(\Urbem\CoreBundle\Entity\Tcmba\ObraMedicao $fkTcmbaObraMedicao)
    {
        if (false === $this->fkTcmbaObraMedicoes->contains($fkTcmbaObraMedicao)) {
            $fkTcmbaObraMedicao->setFkTcmbaObra($this);
            $this->fkTcmbaObraMedicoes->add($fkTcmbaObraMedicao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaObraMedicao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraMedicao $fkTcmbaObraMedicao
     */
    public function removeFkTcmbaObraMedicoes(\Urbem\CoreBundle\Entity\Tcmba\ObraMedicao $fkTcmbaObraMedicao)
    {
        $this->fkTcmbaObraMedicoes->removeElement($fkTcmbaObraMedicao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaObraMedicoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraMedicao
     */
    public function getFkTcmbaObraMedicoes()
    {
        return $this->fkTcmbaObraMedicoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaObraAndamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraAndamento $fkTcmbaObraAndamento
     * @return Obra
     */
    public function addFkTcmbaObraAndamentos(\Urbem\CoreBundle\Entity\Tcmba\ObraAndamento $fkTcmbaObraAndamento)
    {
        if (false === $this->fkTcmbaObraAndamentos->contains($fkTcmbaObraAndamento)) {
            $fkTcmbaObraAndamento->setFkTcmbaObra($this);
            $this->fkTcmbaObraAndamentos->add($fkTcmbaObraAndamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaObraAndamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraAndamento $fkTcmbaObraAndamento
     */
    public function removeFkTcmbaObraAndamentos(\Urbem\CoreBundle\Entity\Tcmba\ObraAndamento $fkTcmbaObraAndamento)
    {
        $this->fkTcmbaObraAndamentos->removeElement($fkTcmbaObraAndamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaObraAndamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraAndamento
     */
    public function getFkTcmbaObraAndamentos()
    {
        return $this->fkTcmbaObraAndamentos;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaObraFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraFiscal $fkTcmbaObraFiscal
     * @return Obra
     */
    public function addFkTcmbaObraFiscais(\Urbem\CoreBundle\Entity\Tcmba\ObraFiscal $fkTcmbaObraFiscal)
    {
        if (false === $this->fkTcmbaObraFiscais->contains($fkTcmbaObraFiscal)) {
            $fkTcmbaObraFiscal->setFkTcmbaObra($this);
            $this->fkTcmbaObraFiscais->add($fkTcmbaObraFiscal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaObraFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraFiscal $fkTcmbaObraFiscal
     */
    public function removeFkTcmbaObraFiscais(\Urbem\CoreBundle\Entity\Tcmba\ObraFiscal $fkTcmbaObraFiscal)
    {
        $this->fkTcmbaObraFiscais->removeElement($fkTcmbaObraFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaObraFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraFiscal
     */
    public function getFkTcmbaObraFiscais()
    {
        return $this->fkTcmbaObraFiscais;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaObraContratos
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraContratos $fkTcmbaObraContratos
     * @return Obra
     */
    public function addFkTcmbaObraContratos(\Urbem\CoreBundle\Entity\Tcmba\ObraContratos $fkTcmbaObraContratos)
    {
        if (false === $this->fkTcmbaObraContratos->contains($fkTcmbaObraContratos)) {
            $fkTcmbaObraContratos->setFkTcmbaObra($this);
            $this->fkTcmbaObraContratos->add($fkTcmbaObraContratos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaObraContratos
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraContratos $fkTcmbaObraContratos
     */
    public function removeFkTcmbaObraContratos(\Urbem\CoreBundle\Entity\Tcmba\ObraContratos $fkTcmbaObraContratos)
    {
        $this->fkTcmbaObraContratos->removeElement($fkTcmbaObraContratos);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaObraContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraContratos
     */
    public function getFkTcmbaObraContratos()
    {
        return $this->fkTcmbaObraContratos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return Obra
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
     * Set fkLicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return Obra
     */
    public function setFkLicitacaoLicitacao(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        $this->codLicitacao = $fkLicitacaoLicitacao->getCodLicitacao();
        $this->codModalidade = $fkLicitacaoLicitacao->getCodModalidade();
        $this->codEntidade = $fkLicitacaoLicitacao->getCodEntidade();
        $this->exercicioLicitacao = $fkLicitacaoLicitacao->getExercicio();
        $this->fkLicitacaoLicitacao = $fkLicitacaoLicitacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoLicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    public function getFkLicitacaoLicitacao()
    {
        return $this->fkLicitacaoLicitacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmbaTipoObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoObra $fkTcmbaTipoObra
     * @return Obra
     */
    public function setFkTcmbaTipoObra(\Urbem\CoreBundle\Entity\Tcmba\TipoObra $fkTcmbaTipoObra)
    {
        $this->codTipo = $fkTcmbaTipoObra->getCodTipo();
        $this->fkTcmbaTipoObra = $fkTcmbaTipoObra;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaTipoObra
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TipoObra
     */
    public function getFkTcmbaTipoObra()
    {
        return $this->fkTcmbaTipoObra;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCep
     *
     * @param \Urbem\CoreBundle\Entity\SwCep $fkSwCep
     * @return Obra
     */
    public function setFkSwCep(\Urbem\CoreBundle\Entity\SwCep $fkSwCep)
    {
        $this->cep = $fkSwCep->getCep();
        $this->fkSwCep = $fkSwCep;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCep
     *
     * @return \Urbem\CoreBundle\Entity\SwCep
     */
    public function getFkSwCep()
    {
        return $this->fkSwCep;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwBairro
     *
     * @param \Urbem\CoreBundle\Entity\SwBairro $fkSwBairro
     * @return Obra
     */
    public function setFkSwBairro(\Urbem\CoreBundle\Entity\SwBairro $fkSwBairro)
    {
        $this->codBairro = $fkSwBairro->getCodBairro();
        $this->codUf = $fkSwBairro->getCodUf();
        $this->codMunicipio = $fkSwBairro->getCodMunicipio();
        $this->fkSwBairro = $fkSwBairro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwBairro
     *
     * @return \Urbem\CoreBundle\Entity\SwBairro
     */
    public function getFkSwBairro()
    {
        return $this->fkSwBairro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmbaTipoFuncaoObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoFuncaoObra $fkTcmbaTipoFuncaoObra
     * @return Obra
     */
    public function setFkTcmbaTipoFuncaoObra(\Urbem\CoreBundle\Entity\Tcmba\TipoFuncaoObra $fkTcmbaTipoFuncaoObra)
    {
        $this->codFuncao = $fkTcmbaTipoFuncaoObra->getCodFuncao();
        $this->fkTcmbaTipoFuncaoObra = $fkTcmbaTipoFuncaoObra;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaTipoFuncaoObra
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TipoFuncaoObra
     */
    public function getFkTcmbaTipoFuncaoObra()
    {
        return $this->fkTcmbaTipoFuncaoObra;
    }
}
