<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * Suplementacao
 */
class Suplementacao
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
    private $codSuplementacao;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var \DateTime
     */
    private $dtSuplementacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\SuplementacaoAnulada
     */
    private $fkOrcamentoSuplementacaoAnulada;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\TransferenciaDespesa
     */
    private $fkContabilidadeTransferenciaDespesas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoSuplementada
     */
    private $fkOrcamentoSuplementacaoSuplementadas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoReducao
     */
    private $fkOrcamentoSuplementacaoReducoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoAnulada
     */
    private $fkOrcamentoSuplementacaoAnuladas1;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\TipoTransferencia
     */
    private $fkContabilidadeTipoTransferencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadeTransferenciaDespesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoSuplementacaoSuplementadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoSuplementacaoReducoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoSuplementacaoAnuladas1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtSuplementacao = new \DateTime;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Suplementacao
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
     * Set codSuplementacao
     *
     * @param integer $codSuplementacao
     * @return Suplementacao
     */
    public function setCodSuplementacao($codSuplementacao)
    {
        $this->codSuplementacao = $codSuplementacao;
        return $this;
    }

    /**
     * Get codSuplementacao
     *
     * @return integer
     */
    public function getCodSuplementacao()
    {
        return $this->codSuplementacao;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Suplementacao
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
     * Set codNorma
     *
     * @param integer $codNorma
     * @return Suplementacao
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return Suplementacao
     */
    public function setMotivo($motivo = null)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set dtSuplementacao
     *
     * @param \DateTime $dtSuplementacao
     * @return Suplementacao
     */
    public function setDtSuplementacao(\DateTime $dtSuplementacao)
    {
        $this->dtSuplementacao = $dtSuplementacao;
        return $this;
    }

    /**
     * Get dtSuplementacao
     *
     * @return \DateTime
     */
    public function getDtSuplementacao()
    {
        return $this->dtSuplementacao;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeTransferenciaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\TransferenciaDespesa $fkContabilidadeTransferenciaDespesa
     * @return Suplementacao
     */
    public function addFkContabilidadeTransferenciaDespesas(\Urbem\CoreBundle\Entity\Contabilidade\TransferenciaDespesa $fkContabilidadeTransferenciaDespesa)
    {
        if (false === $this->fkContabilidadeTransferenciaDespesas->contains($fkContabilidadeTransferenciaDespesa)) {
            $fkContabilidadeTransferenciaDespesa->setFkOrcamentoSuplementacao($this);
            $this->fkContabilidadeTransferenciaDespesas->add($fkContabilidadeTransferenciaDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeTransferenciaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\TransferenciaDespesa $fkContabilidadeTransferenciaDespesa
     */
    public function removeFkContabilidadeTransferenciaDespesas(\Urbem\CoreBundle\Entity\Contabilidade\TransferenciaDespesa $fkContabilidadeTransferenciaDespesa)
    {
        $this->fkContabilidadeTransferenciaDespesas->removeElement($fkContabilidadeTransferenciaDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeTransferenciaDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\TransferenciaDespesa
     */
    public function getFkContabilidadeTransferenciaDespesas()
    {
        return $this->fkContabilidadeTransferenciaDespesas;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoSuplementacaoSuplementada
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\SuplementacaoSuplementada $fkOrcamentoSuplementacaoSuplementada
     * @return Suplementacao
     */
    public function addFkOrcamentoSuplementacaoSuplementadas(\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoSuplementada $fkOrcamentoSuplementacaoSuplementada)
    {
        if (false === $this->fkOrcamentoSuplementacaoSuplementadas->contains($fkOrcamentoSuplementacaoSuplementada)) {
            $fkOrcamentoSuplementacaoSuplementada->setFkOrcamentoSuplementacao($this);
            $this->fkOrcamentoSuplementacaoSuplementadas->add($fkOrcamentoSuplementacaoSuplementada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoSuplementacaoSuplementada
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\SuplementacaoSuplementada $fkOrcamentoSuplementacaoSuplementada
     */
    public function removeFkOrcamentoSuplementacaoSuplementadas(\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoSuplementada $fkOrcamentoSuplementacaoSuplementada)
    {
        $this->fkOrcamentoSuplementacaoSuplementadas->removeElement($fkOrcamentoSuplementacaoSuplementada);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoSuplementacaoSuplementadas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoSuplementada
     */
    public function getFkOrcamentoSuplementacaoSuplementadas()
    {
        return $this->fkOrcamentoSuplementacaoSuplementadas;
    }

    /**
     * @param $fkOrcamentoSuplementacaoSuplementadas
     * @return $this
     */
    public function setFkOrcamentoSuplementacaoSuplementadas($fkOrcamentoSuplementacaoSuplementadas)
    {
        foreach ($fkOrcamentoSuplementacaoSuplementadas as $fkOrcamentoSuplementacaoSuplementada) {
            $this->addFkOrcamentoSuplementacaoSuplementadas($fkOrcamentoSuplementacaoSuplementada);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoSuplementacaoReducao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\SuplementacaoReducao $fkOrcamentoSuplementacaoReducao
     * @return Suplementacao
     */
    public function addFkOrcamentoSuplementacaoReducoes(\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoReducao $fkOrcamentoSuplementacaoReducao)
    {
        if (false === $this->fkOrcamentoSuplementacaoReducoes->contains($fkOrcamentoSuplementacaoReducao)) {
            $fkOrcamentoSuplementacaoReducao->setFkOrcamentoSuplementacao($this);
            $this->fkOrcamentoSuplementacaoReducoes->add($fkOrcamentoSuplementacaoReducao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoSuplementacaoReducao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\SuplementacaoReducao $fkOrcamentoSuplementacaoReducao
     */
    public function removeFkOrcamentoSuplementacaoReducoes(\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoReducao $fkOrcamentoSuplementacaoReducao)
    {
        $this->fkOrcamentoSuplementacaoReducoes->removeElement($fkOrcamentoSuplementacaoReducao);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoSuplementacaoReducoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoReducao
     */
    public function getFkOrcamentoSuplementacaoReducoes()
    {
        return $this->fkOrcamentoSuplementacaoReducoes;
    }

    /**
     * @param $fkOrcamentoSuplementacaoReducoes
     * @return $this
     */
    public function setFkOrcamentoSuplementacaoReducoes($fkOrcamentoSuplementacaoReducoes)
    {
        foreach ($fkOrcamentoSuplementacaoReducoes as $fkOrcamentoSuplementacaoReducao) {
            $this->addFkOrcamentoSuplementacaoReducoes($fkOrcamentoSuplementacaoReducao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoSuplementacaoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\SuplementacaoAnulada $fkOrcamentoSuplementacaoAnulada
     * @return Suplementacao
     */
    public function addFkOrcamentoSuplementacaoAnuladas1(\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoAnulada $fkOrcamentoSuplementacaoAnulada)
    {
        if (false === $this->fkOrcamentoSuplementacaoAnuladas1->contains($fkOrcamentoSuplementacaoAnulada)) {
            $fkOrcamentoSuplementacaoAnulada->setFkOrcamentoSuplementacao1($this);
            $this->fkOrcamentoSuplementacaoAnuladas1->add($fkOrcamentoSuplementacaoAnulada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoSuplementacaoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\SuplementacaoAnulada $fkOrcamentoSuplementacaoAnulada
     */
    public function removeFkOrcamentoSuplementacaoAnuladas1(\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoAnulada $fkOrcamentoSuplementacaoAnulada)
    {
        $this->fkOrcamentoSuplementacaoAnuladas1->removeElement($fkOrcamentoSuplementacaoAnulada);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoSuplementacaoAnuladas1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoAnulada
     */
    public function getFkOrcamentoSuplementacaoAnuladas1()
    {
        return $this->fkOrcamentoSuplementacaoAnuladas1;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeTipoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\TipoTransferencia $fkContabilidadeTipoTransferencia
     * @return Suplementacao
     */
    public function setFkContabilidadeTipoTransferencia(\Urbem\CoreBundle\Entity\Contabilidade\TipoTransferencia $fkContabilidadeTipoTransferencia)
    {
        $this->codTipo = $fkContabilidadeTipoTransferencia->getCodTipo();
        $this->exercicio = $fkContabilidadeTipoTransferencia->getExercicio();
        $this->fkContabilidadeTipoTransferencia = $fkContabilidadeTipoTransferencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadeTipoTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\TipoTransferencia
     */
    public function getFkContabilidadeTipoTransferencia()
    {
        return $this->fkContabilidadeTipoTransferencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return Suplementacao
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * OneToOne (inverse side)
     * Set OrcamentoSuplementacaoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\SuplementacaoAnulada $fkOrcamentoSuplementacaoAnulada
     * @return Suplementacao
     */
    public function setFkOrcamentoSuplementacaoAnulada(\Urbem\CoreBundle\Entity\Orcamento\SuplementacaoAnulada $fkOrcamentoSuplementacaoAnulada)
    {
        $fkOrcamentoSuplementacaoAnulada->setFkOrcamentoSuplementacao($this);
        $this->fkOrcamentoSuplementacaoAnulada = $fkOrcamentoSuplementacaoAnulada;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkOrcamentoSuplementacaoAnulada
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\SuplementacaoAnulada
     */
    public function getFkOrcamentoSuplementacaoAnulada()
    {
        return $this->fkOrcamentoSuplementacaoAnulada;
    }
}
