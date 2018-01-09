<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

use Urbem\CoreBundle\Entity\Exception\Deprecated;

/**
 * Bem
 */
class Bem
{
    /**
     * PK
     * @var integer
     */
    private $codBem;

    /**
     * @var integer
     */
    private $codNatureza;

    /**
     * @var integer
     */
    private $codGrupo;

    /**
     * @var integer
     */
    private $codEspecie;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $detalhamento;

    /**
     * @var \DateTime
     */
    private $dtAquisicao;

    /**
     * @var \DateTime
     */
    private $dtDepreciacao;

    /**
     * @var \DateTime
     */
    private $dtGarantia;

    /**
     * @var boolean
     */
    private $identificacao = false;

    /**
     * @var string
     */
    private $numPlaca;

    /**
     * @var integer
     */
    private $vlBem;

    /**
     * @var integer
     */
    private $vlDepreciacao;

    /**
     * @var \DateTime
     */
    private $dtIncorporacao;

    /**
     * @var integer
     */
    private $vidaUtil;

    /**
     * @var boolean
     */
    private $depreciavel = false;

    /**
     * @var boolean
     */
    private $depreciacaoAcelerada = false;

    /**
     * @var integer
     */
    private $quotaDepreciacaoAnual = 0;

    /**
     * @var integer
     */
    private $quotaDepreciacaoAnualAcelerada = 0;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\BemComprado
     */
    private $fkPatrimonioBemComprado;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\BemProcesso
     */
    private $fkPatrimonioBemProcesso;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\BemBaixado
     */
    private $fkPatrimonioBemBaixado;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\BemCompradoEmpenho
     */
    private $fkPatrimonioBemCompradoEmpenho;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\BemMarca
     */
    private $fkPatrimonioBemMarca;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoBem
     */
    private $fkAlmoxarifadoLancamentoBens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonio
     */
    private $fkContabilidadeLancamentoBaixaPatrimonios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioAlienacao
     */
    private $fkContabilidadeLancamentoBaixaPatrimonioAlienacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioDepreciacao
     */
    private $fkContabilidadeLancamentoBaixaPatrimonioDepreciacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\ApoliceBem
     */
    private $fkPatrimonioApoliceBens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemAtributoEspecie
     */
    private $fkPatrimonioBemAtributoEspecies;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemPlanoAnalitica
     */
    private $fkPatrimonioBemPlanoAnaliticas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemPlanoDepreciacao
     */
    private $fkPatrimonioBemPlanoDepreciacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemResponsavel
     */
    private $fkPatrimonioBemResponsaveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Manutencao
     */
    private $fkPatrimonioManutencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Reavaliacao
     */
    private $fkPatrimonioReavaliacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\PatrimonioBemObra
     */
    private $fkTcmgoPatrimonioBemObras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Proprio
     */
    private $fkFrotaProprios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem
     */
    private $fkPatrimonioInventarioHistoricoBens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem
     */
    private $fkPatrimonioHistoricoBens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Depreciacao
     */
    private $fkPatrimonioDepreciacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Especie
     */
    private $fkPatrimonioEspecie;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Propriedade para aplicar a regra de negócio referente a esse item
     * @var BemAtributoEspecie
     */
    protected $atributoEspecie;

    /**
     * Propriedade para aplicar a regra de negócio referente a esse item
     * @var BemPlanoDepreciacao
     */
    protected $planoDepreciacao;

    /**
     * Propriedade para aplicar a regra de negócio referente a esse item
     * @var BemPlanoAnalitica
     */
    protected $planoAnalitica;

    /**
     * Propriedade para aplicar a regra de negócio referente a esse item
     * @var BemResponsavel
     */
    protected $bemResponsavel;

    /**
     * Propriedade para aplicar a regra de negócio referente a esse item
     * @var HistoricoBem
     */
    protected $historicoBem;

    /**
     * Propriedade para aplicar a regra de negócio referente a esse item
     * @var ApoliceBem
     */
    protected $apoliceBem;

    /**
     * Propriedade para aplicar a regra de negócio referente a esse item
     * @var Manutencao
     */
    protected $manutencao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoLancamentoBens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeLancamentoBaixaPatrimonios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeLancamentoBaixaPatrimonioAlienacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeLancamentoBaixaPatrimonioDepreciacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioApoliceBens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioBemAtributoEspecies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioBemPlanoAnaliticas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioBemPlanoDepreciacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioBemResponsaveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioManutencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioReavaliacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoPatrimonioBemObras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaProprios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioInventarioHistoricoBens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioHistoricoBens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioDepreciacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return Bem
     */
    public function setCodBem($codBem)
    {
        $this->codBem = $codBem;
        return $this;
    }

    /**
     * Get codBem
     *
     * @return integer
     */
    public function getCodBem()
    {
        return $this->codBem;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return Bem
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return Bem
     */
    public function setCodGrupo($codGrupo)
    {
        $this->codGrupo = $codGrupo;
        return $this;
    }

    /**
     * Get codGrupo
     *
     * @return integer
     */
    public function getCodGrupo()
    {
        return $this->codGrupo;
    }

    /**
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return Bem
     */
    public function setCodEspecie($codEspecie)
    {
        $this->codEspecie = $codEspecie;
        return $this;
    }

    /**
     * Get codEspecie
     *
     * @return integer
     */
    public function getCodEspecie()
    {
        return $this->codEspecie;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Bem
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
     * Set descricao
     *
     * @param string $descricao
     * @return Bem
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
     * Set detalhamento
     *
     * @param string $detalhamento
     * @return Bem
     */
    public function setDetalhamento($detalhamento)
    {
        $this->detalhamento = $detalhamento;
        return $this;
    }

    /**
     * Get detalhamento
     *
     * @return string
     */
    public function getDetalhamento()
    {
        return $this->detalhamento;
    }

    /**
     * Set dtAquisicao
     *
     * @param \DateTime $dtAquisicao
     * @return Bem
     */
    public function setDtAquisicao(\DateTime $dtAquisicao)
    {
        $this->dtAquisicao = $dtAquisicao;
        return $this;
    }

    /**
     * Get dtAquisicao
     *
     * @return \DateTime
     */
    public function getDtAquisicao()
    {
        return $this->dtAquisicao;
    }

    /**
     * Set dtDepreciacao
     *
     * @param \DateTime $dtDepreciacao
     * @return Bem
     */
    public function setDtDepreciacao(\DateTime $dtDepreciacao = null)
    {
        $this->dtDepreciacao = $dtDepreciacao;
        return $this;
    }

    /**
     * Get dtDepreciacao
     *
     * @return \DateTime
     */
    public function getDtDepreciacao()
    {
        return $this->dtDepreciacao;
    }

    /**
     * Set dtGarantia
     *
     * @param \DateTime $dtGarantia
     * @return Bem
     */
    public function setDtGarantia(\DateTime $dtGarantia = null)
    {
        $this->dtGarantia = $dtGarantia;
        return $this;
    }

    /**
     * Get dtGarantia
     *
     * @return \DateTime
     */
    public function getDtGarantia()
    {
        return $this->dtGarantia;
    }

    /**
     * Set identificacao
     *
     * @param boolean $identificacao
     * @return Bem
     */
    public function setIdentificacao($identificacao)
    {
        $this->identificacao = $identificacao;
        return $this;
    }

    /**
     * Get identificacao
     *
     * @return boolean
     */
    public function getIdentificacao()
    {
        return $this->identificacao;
    }

    /**
     * Set numPlaca
     *
     * @param string $numPlaca
     * @return Bem
     */
    public function setNumPlaca($numPlaca = null)
    {
        $this->numPlaca = $numPlaca;
        return $this;
    }

    /**
     * Get numPlaca
     *
     * @return string
     */
    public function getNumPlaca()
    {
        return $this->numPlaca;
    }

    /**
     * Set vlBem
     *
     * @param integer $vlBem
     * @return Bem
     */
    public function setVlBem($vlBem)
    {
        $this->vlBem = $vlBem;
        return $this;
    }

    /**
     * Get vlBem
     *
     * @return integer
     */
    public function getVlBem()
    {
        return $this->vlBem;
    }

    /**
     * Set vlDepreciacao
     *
     * @param integer $vlDepreciacao
     * @return Bem
     */
    public function setVlDepreciacao($vlDepreciacao)
    {
        $this->vlDepreciacao = $vlDepreciacao;
        return $this;
    }

    /**
     * Get vlDepreciacao
     *
     * @return integer
     */
    public function getVlDepreciacao()
    {
        return $this->vlDepreciacao;
    }

    /**
     * Set dtIncorporacao
     *
     * @param \DateTime $dtIncorporacao
     * @return Bem
     */
    public function setDtIncorporacao(\DateTime $dtIncorporacao = null)
    {
        $this->dtIncorporacao = $dtIncorporacao;
        return $this;
    }

    /**
     * Get dtIncorporacao
     *
     * @return \DateTime
     */
    public function getDtIncorporacao()
    {
        return $this->dtIncorporacao;
    }

    /**
     * Set vidaUtil
     *
     * @param integer $vidaUtil
     * @return Bem
     */
    public function setVidaUtil($vidaUtil = null)
    {
        $this->vidaUtil = $vidaUtil;
        return $this;
    }

    /**
     * Get vidaUtil
     *
     * @return integer
     */
    public function getVidaUtil()
    {
        return $this->vidaUtil;
    }

    /**
     * Set depreciavel
     *
     * @param boolean $depreciavel
     * @return Bem
     */
    public function setDepreciavel($depreciavel)
    {
        $this->depreciavel = $depreciavel;
        return $this;
    }

    /**
     * Get depreciavel
     *
     * @return boolean
     */
    public function getDepreciavel()
    {
        return $this->depreciavel;
    }

    /**
     * Set depreciacaoAcelerada
     *
     * @param boolean $depreciacaoAcelerada
     * @return Bem
     */
    public function setDepreciacaoAcelerada($depreciacaoAcelerada)
    {
        $this->depreciacaoAcelerada = $depreciacaoAcelerada;
        return $this;
    }

    /**
     * Get depreciacaoAcelerada
     *
     * @return boolean
     */
    public function getDepreciacaoAcelerada()
    {
        return $this->depreciacaoAcelerada;
    }

    /**
     * Set quotaDepreciacaoAnual
     *
     * @param integer $quotaDepreciacaoAnual
     * @return Bem
     */
    public function setQuotaDepreciacaoAnual($quotaDepreciacaoAnual)
    {
        $this->quotaDepreciacaoAnual = $quotaDepreciacaoAnual;
        return $this;
    }

    /**
     * Get quotaDepreciacaoAnual
     *
     * @return integer
     */
    public function getQuotaDepreciacaoAnual()
    {
        return $this->quotaDepreciacaoAnual;
    }

    /**
     * Set quotaDepreciacaoAnualAcelerada
     *
     * @param integer $quotaDepreciacaoAnualAcelerada
     * @return Bem
     */
    public function setQuotaDepreciacaoAnualAcelerada($quotaDepreciacaoAnualAcelerada)
    {
        $this->quotaDepreciacaoAnualAcelerada = $quotaDepreciacaoAnualAcelerada;
        return $this;
    }

    /**
     * Get quotaDepreciacaoAnualAcelerada
     *
     * @return integer
     */
    public function getQuotaDepreciacaoAnualAcelerada()
    {
        return $this->quotaDepreciacaoAnualAcelerada;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoLancamentoBem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoBem $fkAlmoxarifadoLancamentoBem
     * @return Bem
     */
    public function addFkAlmoxarifadoLancamentoBens(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoBem $fkAlmoxarifadoLancamentoBem)
    {
        if (false === $this->fkAlmoxarifadoLancamentoBens->contains($fkAlmoxarifadoLancamentoBem)) {
            $fkAlmoxarifadoLancamentoBem->setFkPatrimonioBem($this);
            $this->fkAlmoxarifadoLancamentoBens->add($fkAlmoxarifadoLancamentoBem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoLancamentoBem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoBem $fkAlmoxarifadoLancamentoBem
     */
    public function removeFkAlmoxarifadoLancamentoBens(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoBem $fkAlmoxarifadoLancamentoBem)
    {
        $this->fkAlmoxarifadoLancamentoBens->removeElement($fkAlmoxarifadoLancamentoBem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoLancamentoBens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoBem
     */
    public function getFkAlmoxarifadoLancamentoBens()
    {
        return $this->fkAlmoxarifadoLancamentoBens;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLancamentoBaixaPatrimonio
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonio $fkContabilidadeLancamentoBaixaPatrimonio
     * @return Bem
     */
    public function addFkContabilidadeLancamentoBaixaPatrimonios(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonio $fkContabilidadeLancamentoBaixaPatrimonio)
    {
        if (false === $this->fkContabilidadeLancamentoBaixaPatrimonios->contains($fkContabilidadeLancamentoBaixaPatrimonio)) {
            $fkContabilidadeLancamentoBaixaPatrimonio->setFkPatrimonioBem($this);
            $this->fkContabilidadeLancamentoBaixaPatrimonios->add($fkContabilidadeLancamentoBaixaPatrimonio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLancamentoBaixaPatrimonio
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonio $fkContabilidadeLancamentoBaixaPatrimonio
     */
    public function removeFkContabilidadeLancamentoBaixaPatrimonios(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonio $fkContabilidadeLancamentoBaixaPatrimonio)
    {
        $this->fkContabilidadeLancamentoBaixaPatrimonios->removeElement($fkContabilidadeLancamentoBaixaPatrimonio);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLancamentoBaixaPatrimonios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonio
     */
    public function getFkContabilidadeLancamentoBaixaPatrimonios()
    {
        return $this->fkContabilidadeLancamentoBaixaPatrimonios;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLancamentoBaixaPatrimonioAlienacao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioAlienacao $fkContabilidadeLancamentoBaixaPatrimonioAlienacao
     * @return Bem
     */
    public function addFkContabilidadeLancamentoBaixaPatrimonioAlienacoes(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioAlienacao $fkContabilidadeLancamentoBaixaPatrimonioAlienacao)
    {
        if (false === $this->fkContabilidadeLancamentoBaixaPatrimonioAlienacoes->contains($fkContabilidadeLancamentoBaixaPatrimonioAlienacao)) {
            $fkContabilidadeLancamentoBaixaPatrimonioAlienacao->setFkPatrimonioBem($this);
            $this->fkContabilidadeLancamentoBaixaPatrimonioAlienacoes->add($fkContabilidadeLancamentoBaixaPatrimonioAlienacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLancamentoBaixaPatrimonioAlienacao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioAlienacao $fkContabilidadeLancamentoBaixaPatrimonioAlienacao
     */
    public function removeFkContabilidadeLancamentoBaixaPatrimonioAlienacoes(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioAlienacao $fkContabilidadeLancamentoBaixaPatrimonioAlienacao)
    {
        $this->fkContabilidadeLancamentoBaixaPatrimonioAlienacoes->removeElement($fkContabilidadeLancamentoBaixaPatrimonioAlienacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLancamentoBaixaPatrimonioAlienacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioAlienacao
     */
    public function getFkContabilidadeLancamentoBaixaPatrimonioAlienacoes()
    {
        return $this->fkContabilidadeLancamentoBaixaPatrimonioAlienacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLancamentoBaixaPatrimonioDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioDepreciacao $fkContabilidadeLancamentoBaixaPatrimonioDepreciacao
     * @return Bem
     */
    public function addFkContabilidadeLancamentoBaixaPatrimonioDepreciacoes(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioDepreciacao $fkContabilidadeLancamentoBaixaPatrimonioDepreciacao)
    {
        if (false === $this->fkContabilidadeLancamentoBaixaPatrimonioDepreciacoes->contains($fkContabilidadeLancamentoBaixaPatrimonioDepreciacao)) {
            $fkContabilidadeLancamentoBaixaPatrimonioDepreciacao->setFkPatrimonioBem($this);
            $this->fkContabilidadeLancamentoBaixaPatrimonioDepreciacoes->add($fkContabilidadeLancamentoBaixaPatrimonioDepreciacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLancamentoBaixaPatrimonioDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioDepreciacao $fkContabilidadeLancamentoBaixaPatrimonioDepreciacao
     */
    public function removeFkContabilidadeLancamentoBaixaPatrimonioDepreciacoes(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioDepreciacao $fkContabilidadeLancamentoBaixaPatrimonioDepreciacao)
    {
        $this->fkContabilidadeLancamentoBaixaPatrimonioDepreciacoes->removeElement($fkContabilidadeLancamentoBaixaPatrimonioDepreciacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLancamentoBaixaPatrimonioDepreciacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioDepreciacao
     */
    public function getFkContabilidadeLancamentoBaixaPatrimonioDepreciacoes()
    {
        return $this->fkContabilidadeLancamentoBaixaPatrimonioDepreciacoes;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioApoliceBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\ApoliceBem $fkPatrimonioApoliceBem
     * @return Bem
     */
    public function addFkPatrimonioApoliceBens(\Urbem\CoreBundle\Entity\Patrimonio\ApoliceBem $fkPatrimonioApoliceBem)
    {
        if (false === $this->fkPatrimonioApoliceBens->contains($fkPatrimonioApoliceBem)) {
            $fkPatrimonioApoliceBem->setFkPatrimonioBem($this);
            $this->fkPatrimonioApoliceBens->add($fkPatrimonioApoliceBem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioApoliceBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\ApoliceBem $fkPatrimonioApoliceBem
     */
    public function removeFkPatrimonioApoliceBens(\Urbem\CoreBundle\Entity\Patrimonio\ApoliceBem $fkPatrimonioApoliceBem)
    {
        $this->fkPatrimonioApoliceBens->removeElement($fkPatrimonioApoliceBem);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioApoliceBens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\ApoliceBem
     */
    public function getFkPatrimonioApoliceBens()
    {
        return $this->fkPatrimonioApoliceBens;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioBemAtributoEspecie
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemAtributoEspecie $fkPatrimonioBemAtributoEspecie
     * @return Bem
     */
    public function addFkPatrimonioBemAtributoEspecies(\Urbem\CoreBundle\Entity\Patrimonio\BemAtributoEspecie $fkPatrimonioBemAtributoEspecie)
    {
        if (false === $this->fkPatrimonioBemAtributoEspecies->contains($fkPatrimonioBemAtributoEspecie)) {
            $fkPatrimonioBemAtributoEspecie->setFkPatrimonioBem($this);
            $this->fkPatrimonioBemAtributoEspecies->add($fkPatrimonioBemAtributoEspecie);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioBemAtributoEspecie
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemAtributoEspecie $fkPatrimonioBemAtributoEspecie
     */
    public function removeFkPatrimonioBemAtributoEspecies(\Urbem\CoreBundle\Entity\Patrimonio\BemAtributoEspecie $fkPatrimonioBemAtributoEspecie)
    {
        $this->fkPatrimonioBemAtributoEspecies->removeElement($fkPatrimonioBemAtributoEspecie);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioBemAtributoEspecies
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemAtributoEspecie
     */
    public function getFkPatrimonioBemAtributoEspecies()
    {
        return $this->fkPatrimonioBemAtributoEspecies;
    }

    /**
     * OneToMany (owning side)
     * Set $fkPatrimonioBemAtributoEspecies
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemAtributoEspecie $fkPatrimonioBemAtributoEspecies
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemAtributoEspecie
     */
    public function setFkPatrimonioBemAtributoEspecies($fkPatrimonioBemAtributoEspecies)
    {
        return $this->fkPatrimonioBemAtributoEspecies = $fkPatrimonioBemAtributoEspecies;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioBemPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemPlanoAnalitica $fkPatrimonioBemPlanoAnalitica
     * @return Bem
     */
    public function addFkPatrimonioBemPlanoAnaliticas(\Urbem\CoreBundle\Entity\Patrimonio\BemPlanoAnalitica $fkPatrimonioBemPlanoAnalitica)
    {
        if (false === $this->fkPatrimonioBemPlanoAnaliticas->contains($fkPatrimonioBemPlanoAnalitica)) {
            $fkPatrimonioBemPlanoAnalitica->setFkPatrimonioBem($this);
            $this->fkPatrimonioBemPlanoAnaliticas->add($fkPatrimonioBemPlanoAnalitica);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioBemPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemPlanoAnalitica $fkPatrimonioBemPlanoAnalitica
     */
    public function removeFkPatrimonioBemPlanoAnaliticas(\Urbem\CoreBundle\Entity\Patrimonio\BemPlanoAnalitica $fkPatrimonioBemPlanoAnalitica)
    {
        $this->fkPatrimonioBemPlanoAnaliticas->removeElement($fkPatrimonioBemPlanoAnalitica);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioBemPlanoAnaliticas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemPlanoAnalitica
     */
    public function getFkPatrimonioBemPlanoAnaliticas()
    {
        return $this->fkPatrimonioBemPlanoAnaliticas;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioBemPlanoDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemPlanoDepreciacao $fkPatrimonioBemPlanoDepreciacao
     * @return Bem
     */
    public function addFkPatrimonioBemPlanoDepreciacoes(\Urbem\CoreBundle\Entity\Patrimonio\BemPlanoDepreciacao $fkPatrimonioBemPlanoDepreciacao)
    {
        if (false === $this->fkPatrimonioBemPlanoDepreciacoes->contains($fkPatrimonioBemPlanoDepreciacao)) {
            $fkPatrimonioBemPlanoDepreciacao->setFkPatrimonioBem($this);
            $this->fkPatrimonioBemPlanoDepreciacoes->add($fkPatrimonioBemPlanoDepreciacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioBemPlanoDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemPlanoDepreciacao $fkPatrimonioBemPlanoDepreciacao
     */
    public function removeFkPatrimonioBemPlanoDepreciacoes(\Urbem\CoreBundle\Entity\Patrimonio\BemPlanoDepreciacao $fkPatrimonioBemPlanoDepreciacao)
    {
        $this->fkPatrimonioBemPlanoDepreciacoes->removeElement($fkPatrimonioBemPlanoDepreciacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioBemPlanoDepreciacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemPlanoDepreciacao
     */
    public function getFkPatrimonioBemPlanoDepreciacoes()
    {
        return $this->fkPatrimonioBemPlanoDepreciacoes;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioBemResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemResponsavel $fkPatrimonioBemResponsavel
     * @return Bem
     */
    public function addFkPatrimonioBemResponsaveis(\Urbem\CoreBundle\Entity\Patrimonio\BemResponsavel $fkPatrimonioBemResponsavel)
    {
        if (false === $this->fkPatrimonioBemResponsaveis->contains($fkPatrimonioBemResponsavel)) {
            $fkPatrimonioBemResponsavel->setFkPatrimonioBem($this);
            $this->fkPatrimonioBemResponsaveis->add($fkPatrimonioBemResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioBemResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemResponsavel $fkPatrimonioBemResponsavel
     */
    public function removeFkPatrimonioBemResponsaveis(\Urbem\CoreBundle\Entity\Patrimonio\BemResponsavel $fkPatrimonioBemResponsavel)
    {
        $this->fkPatrimonioBemResponsaveis->removeElement($fkPatrimonioBemResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioBemResponsaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemResponsavel
     */
    public function getFkPatrimonioBemResponsaveis()
    {
        return $this->fkPatrimonioBemResponsaveis;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioManutencao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Manutencao $fkPatrimonioManutencao
     * @return Bem
     */
    public function addFkPatrimonioManutencoes(\Urbem\CoreBundle\Entity\Patrimonio\Manutencao $fkPatrimonioManutencao)
    {
        if (false === $this->fkPatrimonioManutencoes->contains($fkPatrimonioManutencao)) {
            $fkPatrimonioManutencao->setFkPatrimonioBem($this);
            $this->fkPatrimonioManutencoes->add($fkPatrimonioManutencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioManutencao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Manutencao $fkPatrimonioManutencao
     */
    public function removeFkPatrimonioManutencoes(\Urbem\CoreBundle\Entity\Patrimonio\Manutencao $fkPatrimonioManutencao)
    {
        $this->fkPatrimonioManutencoes->removeElement($fkPatrimonioManutencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioManutencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Manutencao
     */
    public function getFkPatrimonioManutencoes()
    {
        return $this->fkPatrimonioManutencoes;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioReavaliacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Reavaliacao $fkPatrimonioReavaliacao
     * @return Bem
     */
    public function addFkPatrimonioReavaliacoes(\Urbem\CoreBundle\Entity\Patrimonio\Reavaliacao $fkPatrimonioReavaliacao)
    {
        if (false === $this->fkPatrimonioReavaliacoes->contains($fkPatrimonioReavaliacao)) {
            $fkPatrimonioReavaliacao->setFkPatrimonioBem($this);
            $this->fkPatrimonioReavaliacoes->add($fkPatrimonioReavaliacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioReavaliacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Reavaliacao $fkPatrimonioReavaliacao
     */
    public function removeFkPatrimonioReavaliacoes(\Urbem\CoreBundle\Entity\Patrimonio\Reavaliacao $fkPatrimonioReavaliacao)
    {
        $this->fkPatrimonioReavaliacoes->removeElement($fkPatrimonioReavaliacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioReavaliacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Reavaliacao
     */
    public function getFkPatrimonioReavaliacoes()
    {
        return $this->fkPatrimonioReavaliacoes;
    }

    /**
     * OneToMany (owning side)
     * Set fkPatrimonioReaviacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Reavaliacao
     */
    public function setFkPatrimonioReavaliacoes($fkPatrimonioReavaliacao)
    {
        return $this->fkPatrimonioReavaliacoes = $fkPatrimonioReavaliacao;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoPatrimonioBemObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\PatrimonioBemObra $fkTcmgoPatrimonioBemObra
     * @return Bem
     */
    public function addFkTcmgoPatrimonioBemObras(\Urbem\CoreBundle\Entity\Tcmgo\PatrimonioBemObra $fkTcmgoPatrimonioBemObra)
    {
        if (false === $this->fkTcmgoPatrimonioBemObras->contains($fkTcmgoPatrimonioBemObra)) {
            $fkTcmgoPatrimonioBemObra->setFkPatrimonioBem($this);
            $this->fkTcmgoPatrimonioBemObras->add($fkTcmgoPatrimonioBemObra);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoPatrimonioBemObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\PatrimonioBemObra $fkTcmgoPatrimonioBemObra
     */
    public function removeFkTcmgoPatrimonioBemObras(\Urbem\CoreBundle\Entity\Tcmgo\PatrimonioBemObra $fkTcmgoPatrimonioBemObra)
    {
        $this->fkTcmgoPatrimonioBemObras->removeElement($fkTcmgoPatrimonioBemObra);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoPatrimonioBemObras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\PatrimonioBemObra
     */
    public function getFkTcmgoPatrimonioBemObras()
    {
        return $this->fkTcmgoPatrimonioBemObras;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaProprio
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Proprio $fkFrotaProprio
     * @return Bem
     */
    public function addFkFrotaProprios(\Urbem\CoreBundle\Entity\Frota\Proprio $fkFrotaProprio)
    {
        if (false === $this->fkFrotaProprios->contains($fkFrotaProprio)) {
            $fkFrotaProprio->setFkPatrimonioBem($this);
            $this->fkFrotaProprios->add($fkFrotaProprio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaProprio
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Proprio $fkFrotaProprio
     */
    public function removeFkFrotaProprios(\Urbem\CoreBundle\Entity\Frota\Proprio $fkFrotaProprio)
    {
        $this->fkFrotaProprios->removeElement($fkFrotaProprio);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaProprios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Proprio
     */
    public function getFkFrotaProprios()
    {
        return $this->fkFrotaProprios;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioInventarioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem
     * @return Bem
     */
    public function addFkPatrimonioInventarioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem)
    {
        if (false === $this->fkPatrimonioInventarioHistoricoBens->contains($fkPatrimonioInventarioHistoricoBem)) {
            $fkPatrimonioInventarioHistoricoBem->setFkPatrimonioBem($this);
            $this->fkPatrimonioInventarioHistoricoBens->add($fkPatrimonioInventarioHistoricoBem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioInventarioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem
     */
    public function removeFkPatrimonioInventarioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem)
    {
        $this->fkPatrimonioInventarioHistoricoBens->removeElement($fkPatrimonioInventarioHistoricoBem);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioInventarioHistoricoBens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem
     */
    public function getFkPatrimonioInventarioHistoricoBens()
    {
        return $this->fkPatrimonioInventarioHistoricoBens;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem
     * @return Bem
     */
    public function addFkPatrimonioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem)
    {
        if (false === $this->fkPatrimonioHistoricoBens->contains($fkPatrimonioHistoricoBem)) {
            $fkPatrimonioHistoricoBem->setFkPatrimonioBem($this);
            $this->fkPatrimonioHistoricoBens->add($fkPatrimonioHistoricoBem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem
     */
    public function removeFkPatrimonioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem)
    {
        $this->fkPatrimonioHistoricoBens->removeElement($fkPatrimonioHistoricoBem);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioHistoricoBens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem
     */
    public function getFkPatrimonioHistoricoBens()
    {
        return $this->fkPatrimonioHistoricoBens;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Depreciacao $fkPatrimonioDepreciacao
     * @return Bem
     */
    public function addFkPatrimonioDepreciacoes(\Urbem\CoreBundle\Entity\Patrimonio\Depreciacao $fkPatrimonioDepreciacao)
    {
        if (false === $this->fkPatrimonioDepreciacoes->contains($fkPatrimonioDepreciacao)) {
            $fkPatrimonioDepreciacao->setFkPatrimonioBem($this);
            $this->fkPatrimonioDepreciacoes->add($fkPatrimonioDepreciacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Depreciacao $fkPatrimonioDepreciacao
     */
    public function removeFkPatrimonioDepreciacoes(\Urbem\CoreBundle\Entity\Patrimonio\Depreciacao $fkPatrimonioDepreciacao)
    {
        $this->fkPatrimonioDepreciacoes->removeElement($fkPatrimonioDepreciacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioDepreciacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Depreciacao
     */
    public function getFkPatrimonioDepreciacoes()
    {
        return $this->fkPatrimonioDepreciacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioEspecie
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Especie $fkPatrimonioEspecie
     * @return Bem
     */
    public function setFkPatrimonioEspecie(\Urbem\CoreBundle\Entity\Patrimonio\Especie $fkPatrimonioEspecie)
    {
        $this->codEspecie = $fkPatrimonioEspecie->getCodEspecie();
        $this->codGrupo = $fkPatrimonioEspecie->getCodGrupo();
        $this->codNatureza = $fkPatrimonioEspecie->getCodNatureza();
        $this->fkPatrimonioEspecie = $fkPatrimonioEspecie;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioEspecie
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Especie
     */
    public function getFkPatrimonioEspecie()
    {
        return $this->fkPatrimonioEspecie;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Bem
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
     * OneToOne (inverse side)
     * Set PatrimonioBemComprado
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemComprado $fkPatrimonioBemComprado
     * @return Bem
     */
    public function setFkPatrimonioBemComprado(\Urbem\CoreBundle\Entity\Patrimonio\BemComprado $fkPatrimonioBemComprado)
    {
        $fkPatrimonioBemComprado->setFkPatrimonioBem($this);
        $this->fkPatrimonioBemComprado = $fkPatrimonioBemComprado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPatrimonioBemComprado
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\BemComprado
     */
    public function getFkPatrimonioBemComprado()
    {
        return $this->fkPatrimonioBemComprado;
    }

    /**
     * OneToOne (inverse side)
     * Set PatrimonioBemProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemProcesso $fkPatrimonioBemProcesso
     * @return Bem
     */
    public function setFkPatrimonioBemProcesso(\Urbem\CoreBundle\Entity\Patrimonio\BemProcesso $fkPatrimonioBemProcesso)
    {
        $fkPatrimonioBemProcesso->setFkPatrimonioBem($this);
        $this->fkPatrimonioBemProcesso = $fkPatrimonioBemProcesso;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPatrimonioBemProcesso
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\BemProcesso
     */
    public function getFkPatrimonioBemProcesso()
    {
        return $this->fkPatrimonioBemProcesso;
    }

    /**
     * OneToOne (inverse side)
     * Set PatrimonioBemBaixado
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemBaixado $fkPatrimonioBemBaixado
     * @return Bem
     */
    public function setFkPatrimonioBemBaixado(\Urbem\CoreBundle\Entity\Patrimonio\BemBaixado $fkPatrimonioBemBaixado)
    {
        $fkPatrimonioBemBaixado->setFkPatrimonioBem($this);
        $this->fkPatrimonioBemBaixado = $fkPatrimonioBemBaixado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPatrimonioBemBaixado
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\BemBaixado
     */
    public function getFkPatrimonioBemBaixado()
    {
        return $this->fkPatrimonioBemBaixado;
    }

    /**
     * OneToOne (inverse side)
     * Set PatrimonioBemCompradoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemCompradoEmpenho $fkPatrimonioBemCompradoEmpenho
     * @return Bem
     */
    public function setFkPatrimonioBemCompradoEmpenho(\Urbem\CoreBundle\Entity\Patrimonio\BemCompradoEmpenho $fkPatrimonioBemCompradoEmpenho)
    {
        $fkPatrimonioBemCompradoEmpenho->setFkPatrimonioBem($this);
        $this->fkPatrimonioBemCompradoEmpenho = $fkPatrimonioBemCompradoEmpenho;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPatrimonioBemCompradoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\BemCompradoEmpenho
     */
    public function getFkPatrimonioBemCompradoEmpenho()
    {
        return $this->fkPatrimonioBemCompradoEmpenho;
    }

    /**
     * OneToOne (inverse side)
     * Set PatrimonioBemMarca
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemMarca $fkPatrimonioBemMarca
     * @return Bem
     */
    public function setFkPatrimonioBemMarca(\Urbem\CoreBundle\Entity\Patrimonio\BemMarca $fkPatrimonioBemMarca)
    {
        $fkPatrimonioBemMarca->setFkPatrimonioBem($this);
        $this->fkPatrimonioBemMarca = $fkPatrimonioBemMarca;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPatrimonioBemMarca
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\BemMarca
     */
    public function getFkPatrimonioBemMarca()
    {
        return $this->fkPatrimonioBemMarca;
    }

    /**
     * @return BemAtributoEspecie
     */
    public function getAtributoEspecie()
    {
        return $this->fkPatrimonioBemAtributoEspecies->last();
    }

    /**
     * @return BemPlanoDepreciacao
     */
    public function getPlanoDepreciacao()
    {
        return $this->fkPatrimonioBemPlanoDepreciacoes->last();
    }

    /**
     * @return BemPlanoAnalitica
     */
    public function getPlanoAnalitica()
    {
        return $this->fkPatrimonioBemPlanoAnaliticas->last();
    }

    /**
     * @return BemResponsavel
     */
    public function getBemResponsavel()
    {
        return $this->fkPatrimonioBemResponsaveis->last();
    }

    /**
     * @deprecated Usar HistoricoBemRepository::getHistoricoBem
     * @return HistoricoBem
     */
    public function getHistoricoBem()
    {
        throw new Deprecated('Usar BemModel::getHistoricoBem');
        return $this->fkPatrimonioHistoricoBens->last();
    }

    /**
     * @return ApoliceBem
     */
    public function getApoliceBem()
    {
        return $this->fkPatrimonioApoliceBens->last();
    }

    /**
     * @return Manutencao
     */
    public function getManutencao()
    {
        return $this->fkPatrimonioManutencoes->last();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            "%s - %s",
            $this->codBem,
            $this->descricao
        );
    }
}
