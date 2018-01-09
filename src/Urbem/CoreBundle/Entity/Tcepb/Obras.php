<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

/**
 * Obras
 */
class Obras
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numObra;

    /**
     * @var \DateTime
     */
    private $dtCadastro;

    /**
     * @var string
     */
    private $patrimonio;

    /**
     * @var string
     */
    private $localidade;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $codTipoObra;

    /**
     * @var integer
     */
    private $codTipoCategoria;

    /**
     * @var integer
     */
    private $codTipoFonte;

    /**
     * @var string
     */
    private $mesAnoEstimadoFim;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtConclusao;

    /**
     * @var \DateTime
     */
    private $dtRecebimento;

    /**
     * @var integer
     */
    private $codTipoSituacao;

    /**
     * @var integer
     */
    private $vlObra;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\EmpenhoObras
     */
    private $fkTcepbEmpenhoObras;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepb\TipoSituacao
     */
    private $fkTcepbTipoSituacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepb\TipoObra
     */
    private $fkTcepbTipoObra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepb\TipoCategoriaObra
     */
    private $fkTcepbTipoCategoriaObra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepb\TipoFonteObras
     */
    private $fkTcepbTipoFonteObras;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepbEmpenhoObras = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Obras
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
     * Set numObra
     *
     * @param integer $numObra
     * @return Obras
     */
    public function setNumObra($numObra)
    {
        $this->numObra = $numObra;
        return $this;
    }

    /**
     * Get numObra
     *
     * @return integer
     */
    public function getNumObra()
    {
        return $this->numObra;
    }

    /**
     * Set dtCadastro
     *
     * @param \DateTime $dtCadastro
     * @return Obras
     */
    public function setDtCadastro(\DateTime $dtCadastro = null)
    {
        $this->dtCadastro = $dtCadastro;
        return $this;
    }

    /**
     * Get dtCadastro
     *
     * @return \DateTime
     */
    public function getDtCadastro()
    {
        return $this->dtCadastro;
    }

    /**
     * Set patrimonio
     *
     * @param string $patrimonio
     * @return Obras
     */
    public function setPatrimonio($patrimonio = null)
    {
        $this->patrimonio = $patrimonio;
        return $this;
    }

    /**
     * Get patrimonio
     *
     * @return string
     */
    public function getPatrimonio()
    {
        return $this->patrimonio;
    }

    /**
     * Set localidade
     *
     * @param string $localidade
     * @return Obras
     */
    public function setLocalidade($localidade = null)
    {
        $this->localidade = $localidade;
        return $this;
    }

    /**
     * Get localidade
     *
     * @return string
     */
    public function getLocalidade()
    {
        return $this->localidade;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Obras
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
     * Set codTipoObra
     *
     * @param integer $codTipoObra
     * @return Obras
     */
    public function setCodTipoObra($codTipoObra = null)
    {
        $this->codTipoObra = $codTipoObra;
        return $this;
    }

    /**
     * Get codTipoObra
     *
     * @return integer
     */
    public function getCodTipoObra()
    {
        return $this->codTipoObra;
    }

    /**
     * Set codTipoCategoria
     *
     * @param integer $codTipoCategoria
     * @return Obras
     */
    public function setCodTipoCategoria($codTipoCategoria = null)
    {
        $this->codTipoCategoria = $codTipoCategoria;
        return $this;
    }

    /**
     * Get codTipoCategoria
     *
     * @return integer
     */
    public function getCodTipoCategoria()
    {
        return $this->codTipoCategoria;
    }

    /**
     * Set codTipoFonte
     *
     * @param integer $codTipoFonte
     * @return Obras
     */
    public function setCodTipoFonte($codTipoFonte = null)
    {
        $this->codTipoFonte = $codTipoFonte;
        return $this;
    }

    /**
     * Get codTipoFonte
     *
     * @return integer
     */
    public function getCodTipoFonte()
    {
        return $this->codTipoFonte;
    }

    /**
     * Set mesAnoEstimadoFim
     *
     * @param string $mesAnoEstimadoFim
     * @return Obras
     */
    public function setMesAnoEstimadoFim($mesAnoEstimadoFim = null)
    {
        $this->mesAnoEstimadoFim = $mesAnoEstimadoFim;
        return $this;
    }

    /**
     * Get mesAnoEstimadoFim
     *
     * @return string
     */
    public function getMesAnoEstimadoFim()
    {
        return $this->mesAnoEstimadoFim;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return Obras
     */
    public function setDtInicio(\DateTime $dtInicio = null)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtConclusao
     *
     * @param \DateTime $dtConclusao
     * @return Obras
     */
    public function setDtConclusao(\DateTime $dtConclusao = null)
    {
        $this->dtConclusao = $dtConclusao;
        return $this;
    }

    /**
     * Get dtConclusao
     *
     * @return \DateTime
     */
    public function getDtConclusao()
    {
        return $this->dtConclusao;
    }

    /**
     * Set dtRecebimento
     *
     * @param \DateTime $dtRecebimento
     * @return Obras
     */
    public function setDtRecebimento(\DateTime $dtRecebimento = null)
    {
        $this->dtRecebimento = $dtRecebimento;
        return $this;
    }

    /**
     * Get dtRecebimento
     *
     * @return \DateTime
     */
    public function getDtRecebimento()
    {
        return $this->dtRecebimento;
    }

    /**
     * Set codTipoSituacao
     *
     * @param integer $codTipoSituacao
     * @return Obras
     */
    public function setCodTipoSituacao($codTipoSituacao = null)
    {
        $this->codTipoSituacao = $codTipoSituacao;
        return $this;
    }

    /**
     * Get codTipoSituacao
     *
     * @return integer
     */
    public function getCodTipoSituacao()
    {
        return $this->codTipoSituacao;
    }

    /**
     * Set vlObra
     *
     * @param integer $vlObra
     * @return Obras
     */
    public function setVlObra($vlObra = null)
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
     * OneToMany (owning side)
     * Add TcepbEmpenhoObras
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\EmpenhoObras $fkTcepbEmpenhoObras
     * @return Obras
     */
    public function addFkTcepbEmpenhoObras(\Urbem\CoreBundle\Entity\Tcepb\EmpenhoObras $fkTcepbEmpenhoObras)
    {
        if (false === $this->fkTcepbEmpenhoObras->contains($fkTcepbEmpenhoObras)) {
            $fkTcepbEmpenhoObras->setFkTcepbObras($this);
            $this->fkTcepbEmpenhoObras->add($fkTcepbEmpenhoObras);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepbEmpenhoObras
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\EmpenhoObras $fkTcepbEmpenhoObras
     */
    public function removeFkTcepbEmpenhoObras(\Urbem\CoreBundle\Entity\Tcepb\EmpenhoObras $fkTcepbEmpenhoObras)
    {
        $this->fkTcepbEmpenhoObras->removeElement($fkTcepbEmpenhoObras);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepbEmpenhoObras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\EmpenhoObras
     */
    public function getFkTcepbEmpenhoObras()
    {
        return $this->fkTcepbEmpenhoObras;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepbTipoSituacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\TipoSituacao $fkTcepbTipoSituacao
     * @return Obras
     */
    public function setFkTcepbTipoSituacao(\Urbem\CoreBundle\Entity\Tcepb\TipoSituacao $fkTcepbTipoSituacao)
    {
        $this->exercicio = $fkTcepbTipoSituacao->getExercicio();
        $this->codTipoSituacao = $fkTcepbTipoSituacao->getCodTipo();
        $this->fkTcepbTipoSituacao = $fkTcepbTipoSituacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepbTipoSituacao
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\TipoSituacao
     */
    public function getFkTcepbTipoSituacao()
    {
        return $this->fkTcepbTipoSituacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepbTipoObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\TipoObra $fkTcepbTipoObra
     * @return Obras
     */
    public function setFkTcepbTipoObra(\Urbem\CoreBundle\Entity\Tcepb\TipoObra $fkTcepbTipoObra)
    {
        $this->exercicio = $fkTcepbTipoObra->getExercicio();
        $this->codTipoObra = $fkTcepbTipoObra->getCodTipo();
        $this->fkTcepbTipoObra = $fkTcepbTipoObra;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepbTipoObra
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\TipoObra
     */
    public function getFkTcepbTipoObra()
    {
        return $this->fkTcepbTipoObra;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepbTipoCategoriaObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\TipoCategoriaObra $fkTcepbTipoCategoriaObra
     * @return Obras
     */
    public function setFkTcepbTipoCategoriaObra(\Urbem\CoreBundle\Entity\Tcepb\TipoCategoriaObra $fkTcepbTipoCategoriaObra)
    {
        $this->exercicio = $fkTcepbTipoCategoriaObra->getExercicio();
        $this->codTipoCategoria = $fkTcepbTipoCategoriaObra->getCodTipo();
        $this->fkTcepbTipoCategoriaObra = $fkTcepbTipoCategoriaObra;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepbTipoCategoriaObra
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\TipoCategoriaObra
     */
    public function getFkTcepbTipoCategoriaObra()
    {
        return $this->fkTcepbTipoCategoriaObra;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepbTipoFonteObras
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\TipoFonteObras $fkTcepbTipoFonteObras
     * @return Obras
     */
    public function setFkTcepbTipoFonteObras(\Urbem\CoreBundle\Entity\Tcepb\TipoFonteObras $fkTcepbTipoFonteObras)
    {
        $this->exercicio = $fkTcepbTipoFonteObras->getExercicio();
        $this->codTipoFonte = $fkTcepbTipoFonteObras->getCodTipo();
        $this->fkTcepbTipoFonteObras = $fkTcepbTipoFonteObras;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepbTipoFonteObras
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\TipoFonteObras
     */
    public function getFkTcepbTipoFonteObras()
    {
        return $this->fkTcepbTipoFonteObras;
    }
}
