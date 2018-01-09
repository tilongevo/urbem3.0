<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * AcaoDados
 */
class AcaoDados
{
    /**
     * PK
     * @var integer
     */
    private $codAcao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampAcaoDados;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codProduto;

    /**
     * @var integer
     */
    private $codRegiao;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * @var integer
     */
    private $codSubfuncao;

    /**
     * @var integer
     */
    private $codGrandeza;

    /**
     * @var integer
     */
    private $codUnidadeMedida;

    /**
     * @var string
     */
    private $titulo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $finalidade;

    /**
     * @var integer
     */
    private $codForma;

    /**
     * @var integer
     */
    private $codTipoOrcamento;

    /**
     * @var string
     */
    private $detalhamento;

    /**
     * @var integer
     */
    private $valorEstimado;

    /**
     * @var integer
     */
    private $metaEstimada;

    /**
     * @var integer
     */
    private $codNatureza;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ppa\AcaoPeriodo
     */
    private $fkPpaAcaoPeriodo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoUnidadeExecutora
     */
    private $fkPpaAcaoUnidadeExecutoras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoNorma
     */
    private $fkPpaAcaoNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoRecurso
     */
    private $fkPpaAcaoRecursos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\Acao
     */
    private $fkPpaAcao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\TipoAcao
     */
    private $fkPpaTipoAcao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\Produto
     */
    private $fkPpaProduto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\Regiao
     */
    private $fkPpaRegiao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Funcao
     */
    private $fkOrcamentoFuncao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Subfuncao
     */
    private $fkOrcamentoSubfuncao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    private $fkAdministracaoUnidadeMedida;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPpaAcaoUnidadeExecutoras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaAcaoNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaAcaoRecursos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampAcaoDados = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK();
    }

    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return AcaoDados
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
        return $this;
    }

    /**
     * Get codAcao
     *
     * @return integer
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * Set timestampAcaoDados
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAcaoDados
     * @return AcaoDados
     */
    public function setTimestampAcaoDados(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAcaoDados)
    {
        $this->timestampAcaoDados = $timestampAcaoDados;
        return $this;
    }

    /**
     * Get timestampAcaoDados
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampAcaoDados()
    {
        return $this->timestampAcaoDados;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return AcaoDados
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
     * Set codProduto
     *
     * @param integer $codProduto
     * @return AcaoDados
     */
    public function setCodProduto($codProduto = null)
    {
        $this->codProduto = $codProduto;
        return $this;
    }

    /**
     * Get codProduto
     *
     * @return integer
     */
    public function getCodProduto()
    {
        return $this->codProduto;
    }

    /**
     * Set codRegiao
     *
     * @param integer $codRegiao
     * @return AcaoDados
     */
    public function setCodRegiao($codRegiao)
    {
        $this->codRegiao = $codRegiao;
        return $this;
    }

    /**
     * Get codRegiao
     *
     * @return integer
     */
    public function getCodRegiao()
    {
        return $this->codRegiao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return AcaoDados
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
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return AcaoDados
     */
    public function setCodFuncao($codFuncao = null)
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
     * Set codSubfuncao
     *
     * @param integer $codSubfuncao
     * @return AcaoDados
     */
    public function setCodSubfuncao($codSubfuncao = null)
    {
        $this->codSubfuncao = $codSubfuncao;
        return $this;
    }

    /**
     * Get codSubfuncao
     *
     * @return integer
     */
    public function getCodSubfuncao()
    {
        return $this->codSubfuncao;
    }

    /**
     * Set codGrandeza
     *
     * @param integer $codGrandeza
     * @return AcaoDados
     */
    public function setCodGrandeza($codGrandeza)
    {
        $this->codGrandeza = $codGrandeza;
        return $this;
    }

    /**
     * Get codGrandeza
     *
     * @return integer
     */
    public function getCodGrandeza()
    {
        return $this->codGrandeza;
    }

    /**
     * Set codUnidadeMedida
     *
     * @param integer $codUnidadeMedida
     * @return AcaoDados
     */
    public function setCodUnidadeMedida($codUnidadeMedida = null)
    {
        $this->codUnidadeMedida = $codUnidadeMedida;
        return $this;
    }

    /**
     * Get codUnidadeMedida
     *
     * @return integer
     */
    public function getCodUnidadeMedida()
    {
        return $this->codUnidadeMedida;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return AcaoDados
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return AcaoDados
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
     * Set finalidade
     *
     * @param string $finalidade
     * @return AcaoDados
     */
    public function setFinalidade($finalidade)
    {
        $this->finalidade = $finalidade;
        return $this;
    }

    /**
     * Get finalidade
     *
     * @return string
     */
    public function getFinalidade()
    {
        return $this->finalidade;
    }

    /**
     * Set codForma
     *
     * @param integer $codForma
     * @return AcaoDados
     */
    public function setCodForma($codForma)
    {
        $this->codForma = $codForma;
        return $this;
    }

    /**
     * Get codForma
     *
     * @return integer
     */
    public function getCodForma()
    {
        return $this->codForma;
    }

    /**
     * Set codTipoOrcamento
     *
     * @param integer $codTipoOrcamento
     * @return AcaoDados
     */
    public function setCodTipoOrcamento($codTipoOrcamento)
    {
        $this->codTipoOrcamento = $codTipoOrcamento;
        return $this;
    }

    /**
     * Get codTipoOrcamento
     *
     * @return integer
     */
    public function getCodTipoOrcamento()
    {
        return $this->codTipoOrcamento;
    }

    /**
     * Set detalhamento
     *
     * @param string $detalhamento
     * @return AcaoDados
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
     * Set valorEstimado
     *
     * @param integer $valorEstimado
     * @return AcaoDados
     */
    public function setValorEstimado($valorEstimado)
    {
        $this->valorEstimado = $valorEstimado;
        return $this;
    }

    /**
     * Get valorEstimado
     *
     * @return integer
     */
    public function getValorEstimado()
    {
        return $this->valorEstimado;
    }

    /**
     * Set metaEstimada
     *
     * @param integer $metaEstimada
     * @return AcaoDados
     */
    public function setMetaEstimada($metaEstimada)
    {
        $this->metaEstimada = $metaEstimada;
        return $this;
    }

    /**
     * Get metaEstimada
     *
     * @return integer
     */
    public function getMetaEstimada()
    {
        return $this->metaEstimada;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return AcaoDados
     */
    public function setCodNatureza($codNatureza = null)
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
     * OneToMany (owning side)
     * Add PpaAcaoUnidadeExecutora
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoUnidadeExecutora $fkPpaAcaoUnidadeExecutora
     * @return AcaoDados
     */
    public function addFkPpaAcaoUnidadeExecutoras(\Urbem\CoreBundle\Entity\Ppa\AcaoUnidadeExecutora $fkPpaAcaoUnidadeExecutora)
    {
        if (false === $this->fkPpaAcaoUnidadeExecutoras->contains($fkPpaAcaoUnidadeExecutora)) {
            $fkPpaAcaoUnidadeExecutora->setFkPpaAcaoDados($this);
            $this->fkPpaAcaoUnidadeExecutoras->add($fkPpaAcaoUnidadeExecutora);
        }
        
        return $this;
    }

    public function clearFkPpaAcaoUnidadeExecutoras()
    {
        $this->fkPpaAcaoUnidadeExecutoras->clear();
    }

    /**
     * OneToMany (owning side)
     * Remove PpaAcaoUnidadeExecutora
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoUnidadeExecutora $fkPpaAcaoUnidadeExecutora
     */
    public function removeFkPpaAcaoUnidadeExecutoras(\Urbem\CoreBundle\Entity\Ppa\AcaoUnidadeExecutora $fkPpaAcaoUnidadeExecutora)
    {
        $this->fkPpaAcaoUnidadeExecutoras->removeElement($fkPpaAcaoUnidadeExecutora);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaAcaoUnidadeExecutoras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoUnidadeExecutora
     */
    public function getFkPpaAcaoUnidadeExecutoras()
    {
        return $this->fkPpaAcaoUnidadeExecutoras;
    }

    /**
     * OneToMany (owning side)
     * Add PpaAcaoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoNorma $fkPpaAcaoNorma
     * @return AcaoDados
     */
    public function addFkPpaAcaoNormas(\Urbem\CoreBundle\Entity\Ppa\AcaoNorma $fkPpaAcaoNorma)
    {
        if (false === $this->fkPpaAcaoNormas->contains($fkPpaAcaoNorma)) {
            $fkPpaAcaoNorma->setFkPpaAcaoDados($this);
            $this->fkPpaAcaoNormas->add($fkPpaAcaoNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaAcaoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoNorma $fkPpaAcaoNorma
     */
    public function removeFkPpaAcaoNormas(\Urbem\CoreBundle\Entity\Ppa\AcaoNorma $fkPpaAcaoNorma)
    {
        $this->fkPpaAcaoNormas->removeElement($fkPpaAcaoNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaAcaoNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoNorma
     */
    public function getFkPpaAcaoNormas()
    {
        return $this->fkPpaAcaoNormas;
    }

    /**
     * OneToMany (owning side)
     * Add PpaAcaoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoRecurso $fkPpaAcaoRecurso
     * @return AcaoDados
     */
    public function addFkPpaAcaoRecursos(\Urbem\CoreBundle\Entity\Ppa\AcaoRecurso $fkPpaAcaoRecurso)
    {
        if (false === $this->fkPpaAcaoRecursos->contains($fkPpaAcaoRecurso)) {
            $fkPpaAcaoRecurso->setFkPpaAcaoDados($this);
            $this->fkPpaAcaoRecursos->add($fkPpaAcaoRecurso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaAcaoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoRecurso $fkPpaAcaoRecurso
     */
    public function removeFkPpaAcaoRecursos(\Urbem\CoreBundle\Entity\Ppa\AcaoRecurso $fkPpaAcaoRecurso)
    {
        $this->fkPpaAcaoRecursos->removeElement($fkPpaAcaoRecurso);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaAcaoRecursos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoRecurso
     */
    public function getFkPpaAcaoRecursos()
    {
        return $this->fkPpaAcaoRecursos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaAcao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Acao $fkPpaAcao
     * @return AcaoDados
     */
    public function setFkPpaAcao(\Urbem\CoreBundle\Entity\Ppa\Acao $fkPpaAcao)
    {
        $this->codAcao = $fkPpaAcao->getCodAcao();
        $this->fkPpaAcao = $fkPpaAcao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaAcao
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Acao
     */
    public function getFkPpaAcao()
    {
        return $this->fkPpaAcao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaTipoAcao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\TipoAcao $fkPpaTipoAcao
     * @return AcaoDados
     */
    public function setFkPpaTipoAcao(\Urbem\CoreBundle\Entity\Ppa\TipoAcao $fkPpaTipoAcao)
    {
        $this->codTipo = $fkPpaTipoAcao->getCodTipo();
        $this->fkPpaTipoAcao = $fkPpaTipoAcao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaTipoAcao
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\TipoAcao
     */
    public function getFkPpaTipoAcao()
    {
        return $this->fkPpaTipoAcao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaProduto
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Produto $fkPpaProduto
     * @return AcaoDados
     */
    public function setFkPpaProduto(\Urbem\CoreBundle\Entity\Ppa\Produto $fkPpaProduto)
    {
        $this->codProduto = $fkPpaProduto->getCodProduto();
        $this->fkPpaProduto = $fkPpaProduto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaProduto
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Produto
     */
    public function getFkPpaProduto()
    {
        return $this->fkPpaProduto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaRegiao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Regiao $fkPpaRegiao
     * @return AcaoDados
     */
    public function setFkPpaRegiao(\Urbem\CoreBundle\Entity\Ppa\Regiao $fkPpaRegiao)
    {
        $this->codRegiao = $fkPpaRegiao->getCodRegiao();
        $this->fkPpaRegiao = $fkPpaRegiao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaRegiao
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Regiao
     */
    public function getFkPpaRegiao()
    {
        return $this->fkPpaRegiao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Funcao $fkOrcamentoFuncao
     * @return AcaoDados
     */
    public function setFkOrcamentoFuncao(\Urbem\CoreBundle\Entity\Orcamento\Funcao $fkOrcamentoFuncao)
    {
        $this->exercicio = $fkOrcamentoFuncao->getExercicio();
        $this->codFuncao = $fkOrcamentoFuncao->getCodFuncao();
        $this->fkOrcamentoFuncao = $fkOrcamentoFuncao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoFuncao
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Funcao
     */
    public function getFkOrcamentoFuncao()
    {
        return $this->fkOrcamentoFuncao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoSubfuncao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Subfuncao $fkOrcamentoSubfuncao
     * @return AcaoDados
     */
    public function setFkOrcamentoSubfuncao(\Urbem\CoreBundle\Entity\Orcamento\Subfuncao $fkOrcamentoSubfuncao)
    {
        $this->exercicio = $fkOrcamentoSubfuncao->getExercicio();
        $this->codSubfuncao = $fkOrcamentoSubfuncao->getCodSubfuncao();
        $this->fkOrcamentoSubfuncao = $fkOrcamentoSubfuncao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoSubfuncao
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Subfuncao
     */
    public function getFkOrcamentoSubfuncao()
    {
        return $this->fkOrcamentoSubfuncao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUnidadeMedida
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida
     * @return AcaoDados
     */
    public function setFkAdministracaoUnidadeMedida(\Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida)
    {
        $this->codUnidadeMedida = $fkAdministracaoUnidadeMedida->getCodUnidade();
        $this->codGrandeza = $fkAdministracaoUnidadeMedida->getCodGrandeza();
        $this->fkAdministracaoUnidadeMedida = $fkAdministracaoUnidadeMedida;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUnidadeMedida
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    public function getFkAdministracaoUnidadeMedida()
    {
        return $this->fkAdministracaoUnidadeMedida;
    }

    /**
     * OneToOne (inverse side)
     * Set PpaAcaoPeriodo
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoPeriodo $fkPpaAcaoPeriodo
     * @return AcaoDados
     */
    public function setFkPpaAcaoPeriodo(\Urbem\CoreBundle\Entity\Ppa\AcaoPeriodo $fkPpaAcaoPeriodo)
    {
        $fkPpaAcaoPeriodo->setFkPpaAcaoDados($this);
        $this->fkPpaAcaoPeriodo = $fkPpaAcaoPeriodo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPpaAcaoPeriodo
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\AcaoPeriodo
     */
    public function getFkPpaAcaoPeriodo()
    {
        return $this->fkPpaAcaoPeriodo;
    }
}
