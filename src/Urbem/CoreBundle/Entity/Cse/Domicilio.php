<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * Domicilio
 */
class Domicilio
{
    /**
     * PK
     * @var integer
     */
    private $codDomicilio;

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
    private $codTipoLogradouro;

    /**
     * @var integer
     */
    private $codCobertura;

    /**
     * @var integer
     */
    private $codAbastecimento;

    /**
     * @var integer
     */
    private $codTratamento;

    /**
     * @var integer
     */
    private $codEsgotamento;

    /**
     * @var integer
     */
    private $codDestinoLixo;

    /**
     * @var integer
     */
    private $codLocalidade;

    /**
     * @var integer
     */
    private $codTipoDomicilio;

    /**
     * @var integer
     */
    private $codConstrucao;

    /**
     * @var integer
     */
    private $codSituacao;

    /**
     * @var string
     */
    private $logradouro;

    /**
     * @var string
     */
    private $numero;

    /**
     * @var string
     */
    private $complemento;

    /**
     * @var string
     */
    private $bairro;

    /**
     * @var string
     */
    private $cep;

    /**
     * @var string
     */
    private $telefone;

    /**
     * @var integer
     */
    private $qtdComodos;

    /**
     * @var boolean
     */
    private $energiaEletrica = true;

    /**
     * @var integer
     */
    private $qtdResidentes = 0;

    /**
     * @var integer
     */
    private $qtdGravidas = 0;

    /**
     * @var integer
     */
    private $qtdMaesAmamentando = 0;

    /**
     * @var integer
     */
    private $qtdDeficientes = 0;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\CidadaoDomicilio
     */
    private $fkCseCidadaoDomicilios;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwMunicipio
     */
    private $fkSwMunicipio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwTipoLogradouro
     */
    private $fkSwTipoLogradouro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\TipoCobertura
     */
    private $fkCseTipoCobertura;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\TipoAbastecimento
     */
    private $fkCseTipoAbastecimento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\TipoTratamentoAgua
     */
    private $fkCseTipoTratamentoAgua;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\TipoEsgotamento
     */
    private $fkCseTipoEsgotamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\TipoDestinoLixo
     */
    private $fkCseTipoDestinoLixo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\TipoLocalidade
     */
    private $fkCseTipoLocalidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\TipoDomicilio
     */
    private $fkCseTipoDomicilio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\TipoConstrucao
     */
    private $fkCseTipoConstrucao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\SituacaoDomicilio
     */
    private $fkCseSituacaoDomicilio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCseCidadaoDomicilios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDomicilio
     *
     * @param integer $codDomicilio
     * @return Domicilio
     */
    public function setCodDomicilio($codDomicilio)
    {
        $this->codDomicilio = $codDomicilio;
        return $this;
    }

    /**
     * Get codDomicilio
     *
     * @return integer
     */
    public function getCodDomicilio()
    {
        return $this->codDomicilio;
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return Domicilio
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
     * @return Domicilio
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
     * Set codTipoLogradouro
     *
     * @param integer $codTipoLogradouro
     * @return Domicilio
     */
    public function setCodTipoLogradouro($codTipoLogradouro)
    {
        $this->codTipoLogradouro = $codTipoLogradouro;
        return $this;
    }

    /**
     * Get codTipoLogradouro
     *
     * @return integer
     */
    public function getCodTipoLogradouro()
    {
        return $this->codTipoLogradouro;
    }

    /**
     * Set codCobertura
     *
     * @param integer $codCobertura
     * @return Domicilio
     */
    public function setCodCobertura($codCobertura)
    {
        $this->codCobertura = $codCobertura;
        return $this;
    }

    /**
     * Get codCobertura
     *
     * @return integer
     */
    public function getCodCobertura()
    {
        return $this->codCobertura;
    }

    /**
     * Set codAbastecimento
     *
     * @param integer $codAbastecimento
     * @return Domicilio
     */
    public function setCodAbastecimento($codAbastecimento)
    {
        $this->codAbastecimento = $codAbastecimento;
        return $this;
    }

    /**
     * Get codAbastecimento
     *
     * @return integer
     */
    public function getCodAbastecimento()
    {
        return $this->codAbastecimento;
    }

    /**
     * Set codTratamento
     *
     * @param integer $codTratamento
     * @return Domicilio
     */
    public function setCodTratamento($codTratamento)
    {
        $this->codTratamento = $codTratamento;
        return $this;
    }

    /**
     * Get codTratamento
     *
     * @return integer
     */
    public function getCodTratamento()
    {
        return $this->codTratamento;
    }

    /**
     * Set codEsgotamento
     *
     * @param integer $codEsgotamento
     * @return Domicilio
     */
    public function setCodEsgotamento($codEsgotamento)
    {
        $this->codEsgotamento = $codEsgotamento;
        return $this;
    }

    /**
     * Get codEsgotamento
     *
     * @return integer
     */
    public function getCodEsgotamento()
    {
        return $this->codEsgotamento;
    }

    /**
     * Set codDestinoLixo
     *
     * @param integer $codDestinoLixo
     * @return Domicilio
     */
    public function setCodDestinoLixo($codDestinoLixo)
    {
        $this->codDestinoLixo = $codDestinoLixo;
        return $this;
    }

    /**
     * Get codDestinoLixo
     *
     * @return integer
     */
    public function getCodDestinoLixo()
    {
        return $this->codDestinoLixo;
    }

    /**
     * Set codLocalidade
     *
     * @param integer $codLocalidade
     * @return Domicilio
     */
    public function setCodLocalidade($codLocalidade)
    {
        $this->codLocalidade = $codLocalidade;
        return $this;
    }

    /**
     * Get codLocalidade
     *
     * @return integer
     */
    public function getCodLocalidade()
    {
        return $this->codLocalidade;
    }

    /**
     * Set codTipoDomicilio
     *
     * @param integer $codTipoDomicilio
     * @return Domicilio
     */
    public function setCodTipoDomicilio($codTipoDomicilio)
    {
        $this->codTipoDomicilio = $codTipoDomicilio;
        return $this;
    }

    /**
     * Get codTipoDomicilio
     *
     * @return integer
     */
    public function getCodTipoDomicilio()
    {
        return $this->codTipoDomicilio;
    }

    /**
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return Domicilio
     */
    public function setCodConstrucao($codConstrucao)
    {
        $this->codConstrucao = $codConstrucao;
        return $this;
    }

    /**
     * Get codConstrucao
     *
     * @return integer
     */
    public function getCodConstrucao()
    {
        return $this->codConstrucao;
    }

    /**
     * Set codSituacao
     *
     * @param integer $codSituacao
     * @return Domicilio
     */
    public function setCodSituacao($codSituacao)
    {
        $this->codSituacao = $codSituacao;
        return $this;
    }

    /**
     * Get codSituacao
     *
     * @return integer
     */
    public function getCodSituacao()
    {
        return $this->codSituacao;
    }

    /**
     * Set logradouro
     *
     * @param string $logradouro
     * @return Domicilio
     */
    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;
        return $this;
    }

    /**
     * Get logradouro
     *
     * @return string
     */
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return Domicilio
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set complemento
     *
     * @param string $complemento
     * @return Domicilio
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
        return $this;
    }

    /**
     * Get complemento
     *
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Set bairro
     *
     * @param string $bairro
     * @return Domicilio
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
        return $this;
    }

    /**
     * Get bairro
     *
     * @return string
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * Set cep
     *
     * @param string $cep
     * @return Domicilio
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
     * Set telefone
     *
     * @param string $telefone
     * @return Domicilio
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
        return $this;
    }

    /**
     * Get telefone
     *
     * @return string
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set qtdComodos
     *
     * @param integer $qtdComodos
     * @return Domicilio
     */
    public function setQtdComodos($qtdComodos)
    {
        $this->qtdComodos = $qtdComodos;
        return $this;
    }

    /**
     * Get qtdComodos
     *
     * @return integer
     */
    public function getQtdComodos()
    {
        return $this->qtdComodos;
    }

    /**
     * Set energiaEletrica
     *
     * @param boolean $energiaEletrica
     * @return Domicilio
     */
    public function setEnergiaEletrica($energiaEletrica)
    {
        $this->energiaEletrica = $energiaEletrica;
        return $this;
    }

    /**
     * Get energiaEletrica
     *
     * @return boolean
     */
    public function getEnergiaEletrica()
    {
        return $this->energiaEletrica;
    }

    /**
     * Set qtdResidentes
     *
     * @param integer $qtdResidentes
     * @return Domicilio
     */
    public function setQtdResidentes($qtdResidentes)
    {
        $this->qtdResidentes = $qtdResidentes;
        return $this;
    }

    /**
     * Get qtdResidentes
     *
     * @return integer
     */
    public function getQtdResidentes()
    {
        return $this->qtdResidentes;
    }

    /**
     * Set qtdGravidas
     *
     * @param integer $qtdGravidas
     * @return Domicilio
     */
    public function setQtdGravidas($qtdGravidas)
    {
        $this->qtdGravidas = $qtdGravidas;
        return $this;
    }

    /**
     * Get qtdGravidas
     *
     * @return integer
     */
    public function getQtdGravidas()
    {
        return $this->qtdGravidas;
    }

    /**
     * Set qtdMaesAmamentando
     *
     * @param integer $qtdMaesAmamentando
     * @return Domicilio
     */
    public function setQtdMaesAmamentando($qtdMaesAmamentando)
    {
        $this->qtdMaesAmamentando = $qtdMaesAmamentando;
        return $this;
    }

    /**
     * Get qtdMaesAmamentando
     *
     * @return integer
     */
    public function getQtdMaesAmamentando()
    {
        return $this->qtdMaesAmamentando;
    }

    /**
     * Set qtdDeficientes
     *
     * @param integer $qtdDeficientes
     * @return Domicilio
     */
    public function setQtdDeficientes($qtdDeficientes)
    {
        $this->qtdDeficientes = $qtdDeficientes;
        return $this;
    }

    /**
     * Get qtdDeficientes
     *
     * @return integer
     */
    public function getQtdDeficientes()
    {
        return $this->qtdDeficientes;
    }

    /**
     * OneToMany (owning side)
     * Add CseCidadaoDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\CidadaoDomicilio $fkCseCidadaoDomicilio
     * @return Domicilio
     */
    public function addFkCseCidadaoDomicilios(\Urbem\CoreBundle\Entity\Cse\CidadaoDomicilio $fkCseCidadaoDomicilio)
    {
        if (false === $this->fkCseCidadaoDomicilios->contains($fkCseCidadaoDomicilio)) {
            $fkCseCidadaoDomicilio->setFkCseDomicilio($this);
            $this->fkCseCidadaoDomicilios->add($fkCseCidadaoDomicilio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseCidadaoDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\CidadaoDomicilio $fkCseCidadaoDomicilio
     */
    public function removeFkCseCidadaoDomicilios(\Urbem\CoreBundle\Entity\Cse\CidadaoDomicilio $fkCseCidadaoDomicilio)
    {
        $this->fkCseCidadaoDomicilios->removeElement($fkCseCidadaoDomicilio);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseCidadaoDomicilios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\CidadaoDomicilio
     */
    public function getFkCseCidadaoDomicilios()
    {
        return $this->fkCseCidadaoDomicilios;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwMunicipio
     *
     * @param \Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio
     * @return Domicilio
     */
    public function setFkSwMunicipio(\Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio)
    {
        $this->codMunicipio = $fkSwMunicipio->getCodMunicipio();
        $this->codUf = $fkSwMunicipio->getCodUf();
        $this->fkSwMunicipio = $fkSwMunicipio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwMunicipio
     *
     * @return \Urbem\CoreBundle\Entity\SwMunicipio
     */
    public function getFkSwMunicipio()
    {
        return $this->fkSwMunicipio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwTipoLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwTipoLogradouro $fkSwTipoLogradouro
     * @return Domicilio
     */
    public function setFkSwTipoLogradouro(\Urbem\CoreBundle\Entity\SwTipoLogradouro $fkSwTipoLogradouro)
    {
        $this->codTipoLogradouro = $fkSwTipoLogradouro->getCodTipo();
        $this->fkSwTipoLogradouro = $fkSwTipoLogradouro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwTipoLogradouro
     *
     * @return \Urbem\CoreBundle\Entity\SwTipoLogradouro
     */
    public function getFkSwTipoLogradouro()
    {
        return $this->fkSwTipoLogradouro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseTipoCobertura
     *
     * @param \Urbem\CoreBundle\Entity\Cse\TipoCobertura $fkCseTipoCobertura
     * @return Domicilio
     */
    public function setFkCseTipoCobertura(\Urbem\CoreBundle\Entity\Cse\TipoCobertura $fkCseTipoCobertura)
    {
        $this->codCobertura = $fkCseTipoCobertura->getCodCobertura();
        $this->fkCseTipoCobertura = $fkCseTipoCobertura;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseTipoCobertura
     *
     * @return \Urbem\CoreBundle\Entity\Cse\TipoCobertura
     */
    public function getFkCseTipoCobertura()
    {
        return $this->fkCseTipoCobertura;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseTipoAbastecimento
     *
     * @param \Urbem\CoreBundle\Entity\Cse\TipoAbastecimento $fkCseTipoAbastecimento
     * @return Domicilio
     */
    public function setFkCseTipoAbastecimento(\Urbem\CoreBundle\Entity\Cse\TipoAbastecimento $fkCseTipoAbastecimento)
    {
        $this->codAbastecimento = $fkCseTipoAbastecimento->getCodAbastecimento();
        $this->fkCseTipoAbastecimento = $fkCseTipoAbastecimento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseTipoAbastecimento
     *
     * @return \Urbem\CoreBundle\Entity\Cse\TipoAbastecimento
     */
    public function getFkCseTipoAbastecimento()
    {
        return $this->fkCseTipoAbastecimento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseTipoTratamentoAgua
     *
     * @param \Urbem\CoreBundle\Entity\Cse\TipoTratamentoAgua $fkCseTipoTratamentoAgua
     * @return Domicilio
     */
    public function setFkCseTipoTratamentoAgua(\Urbem\CoreBundle\Entity\Cse\TipoTratamentoAgua $fkCseTipoTratamentoAgua)
    {
        $this->codTratamento = $fkCseTipoTratamentoAgua->getCodTratamento();
        $this->fkCseTipoTratamentoAgua = $fkCseTipoTratamentoAgua;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseTipoTratamentoAgua
     *
     * @return \Urbem\CoreBundle\Entity\Cse\TipoTratamentoAgua
     */
    public function getFkCseTipoTratamentoAgua()
    {
        return $this->fkCseTipoTratamentoAgua;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseTipoEsgotamento
     *
     * @param \Urbem\CoreBundle\Entity\Cse\TipoEsgotamento $fkCseTipoEsgotamento
     * @return Domicilio
     */
    public function setFkCseTipoEsgotamento(\Urbem\CoreBundle\Entity\Cse\TipoEsgotamento $fkCseTipoEsgotamento)
    {
        $this->codEsgotamento = $fkCseTipoEsgotamento->getCodEsgotamento();
        $this->fkCseTipoEsgotamento = $fkCseTipoEsgotamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseTipoEsgotamento
     *
     * @return \Urbem\CoreBundle\Entity\Cse\TipoEsgotamento
     */
    public function getFkCseTipoEsgotamento()
    {
        return $this->fkCseTipoEsgotamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseTipoDestinoLixo
     *
     * @param \Urbem\CoreBundle\Entity\Cse\TipoDestinoLixo $fkCseTipoDestinoLixo
     * @return Domicilio
     */
    public function setFkCseTipoDestinoLixo(\Urbem\CoreBundle\Entity\Cse\TipoDestinoLixo $fkCseTipoDestinoLixo)
    {
        $this->codDestinoLixo = $fkCseTipoDestinoLixo->getCodDestinoLixo();
        $this->fkCseTipoDestinoLixo = $fkCseTipoDestinoLixo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseTipoDestinoLixo
     *
     * @return \Urbem\CoreBundle\Entity\Cse\TipoDestinoLixo
     */
    public function getFkCseTipoDestinoLixo()
    {
        return $this->fkCseTipoDestinoLixo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseTipoLocalidade
     *
     * @param \Urbem\CoreBundle\Entity\Cse\TipoLocalidade $fkCseTipoLocalidade
     * @return Domicilio
     */
    public function setFkCseTipoLocalidade(\Urbem\CoreBundle\Entity\Cse\TipoLocalidade $fkCseTipoLocalidade)
    {
        $this->codLocalidade = $fkCseTipoLocalidade->getCodLocalidade();
        $this->fkCseTipoLocalidade = $fkCseTipoLocalidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseTipoLocalidade
     *
     * @return \Urbem\CoreBundle\Entity\Cse\TipoLocalidade
     */
    public function getFkCseTipoLocalidade()
    {
        return $this->fkCseTipoLocalidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseTipoDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\TipoDomicilio $fkCseTipoDomicilio
     * @return Domicilio
     */
    public function setFkCseTipoDomicilio(\Urbem\CoreBundle\Entity\Cse\TipoDomicilio $fkCseTipoDomicilio)
    {
        $this->codTipoDomicilio = $fkCseTipoDomicilio->getCodDomicilio();
        $this->fkCseTipoDomicilio = $fkCseTipoDomicilio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseTipoDomicilio
     *
     * @return \Urbem\CoreBundle\Entity\Cse\TipoDomicilio
     */
    public function getFkCseTipoDomicilio()
    {
        return $this->fkCseTipoDomicilio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseTipoConstrucao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\TipoConstrucao $fkCseTipoConstrucao
     * @return Domicilio
     */
    public function setFkCseTipoConstrucao(\Urbem\CoreBundle\Entity\Cse\TipoConstrucao $fkCseTipoConstrucao)
    {
        $this->codConstrucao = $fkCseTipoConstrucao->getCodConstrucao();
        $this->fkCseTipoConstrucao = $fkCseTipoConstrucao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseTipoConstrucao
     *
     * @return \Urbem\CoreBundle\Entity\Cse\TipoConstrucao
     */
    public function getFkCseTipoConstrucao()
    {
        return $this->fkCseTipoConstrucao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseSituacaoDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\SituacaoDomicilio $fkCseSituacaoDomicilio
     * @return Domicilio
     */
    public function setFkCseSituacaoDomicilio(\Urbem\CoreBundle\Entity\Cse\SituacaoDomicilio $fkCseSituacaoDomicilio)
    {
        $this->codSituacao = $fkCseSituacaoDomicilio->getCodSituacao();
        $this->fkCseSituacaoDomicilio = $fkCseSituacaoDomicilio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseSituacaoDomicilio
     *
     * @return \Urbem\CoreBundle\Entity\Cse\SituacaoDomicilio
     */
    public function getFkCseSituacaoDomicilio()
    {
        return $this->fkCseSituacaoDomicilio;
    }
}
