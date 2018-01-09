<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * Prescricao
 */
class Prescricao
{
    /**
     * PK
     * @var integer
     */
    private $codPrescricao;

    /**
     * PK
     * @var integer
     */
    private $codCidadao;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * @var string
     */
    private $periodicidade;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\PrescricaoExame
     */
    private $fkCsePrescricaoExames;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\PrescricaoInternacao
     */
    private $fkCsePrescricaoInternacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    private $fkCseCidadao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\TipoTratamento
     */
    private $fkCseTipoTratamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCsePrescricaoExames = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkCsePrescricaoInternacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPrescricao
     *
     * @param integer $codPrescricao
     * @return Prescricao
     */
    public function setCodPrescricao($codPrescricao)
    {
        $this->codPrescricao = $codPrescricao;
        return $this;
    }

    /**
     * Get codPrescricao
     *
     * @return integer
     */
    public function getCodPrescricao()
    {
        return $this->codPrescricao;
    }

    /**
     * Set codCidadao
     *
     * @param integer $codCidadao
     * @return Prescricao
     */
    public function setCodCidadao($codCidadao)
    {
        $this->codCidadao = $codCidadao;
        return $this;
    }

    /**
     * Get codCidadao
     *
     * @return integer
     */
    public function getCodCidadao()
    {
        return $this->codCidadao;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Prescricao
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
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return Prescricao
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return Prescricao
     */
    public function setDtInicio(\DateTime $dtInicio)
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
     * Set dtTermino
     *
     * @param \DateTime $dtTermino
     * @return Prescricao
     */
    public function setDtTermino(\DateTime $dtTermino = null)
    {
        $this->dtTermino = $dtTermino;
        return $this;
    }

    /**
     * Get dtTermino
     *
     * @return \DateTime
     */
    public function getDtTermino()
    {
        return $this->dtTermino;
    }

    /**
     * Set periodicidade
     *
     * @param string $periodicidade
     * @return Prescricao
     */
    public function setPeriodicidade($periodicidade)
    {
        $this->periodicidade = $periodicidade;
        return $this;
    }

    /**
     * Get periodicidade
     *
     * @return string
     */
    public function getPeriodicidade()
    {
        return $this->periodicidade;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Prescricao
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
     * OneToMany (owning side)
     * Add CsePrescricaoExame
     *
     * @param \Urbem\CoreBundle\Entity\Cse\PrescricaoExame $fkCsePrescricaoExame
     * @return Prescricao
     */
    public function addFkCsePrescricaoExames(\Urbem\CoreBundle\Entity\Cse\PrescricaoExame $fkCsePrescricaoExame)
    {
        if (false === $this->fkCsePrescricaoExames->contains($fkCsePrescricaoExame)) {
            $fkCsePrescricaoExame->setFkCsePrescricao($this);
            $this->fkCsePrescricaoExames->add($fkCsePrescricaoExame);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CsePrescricaoExame
     *
     * @param \Urbem\CoreBundle\Entity\Cse\PrescricaoExame $fkCsePrescricaoExame
     */
    public function removeFkCsePrescricaoExames(\Urbem\CoreBundle\Entity\Cse\PrescricaoExame $fkCsePrescricaoExame)
    {
        $this->fkCsePrescricaoExames->removeElement($fkCsePrescricaoExame);
    }

    /**
     * OneToMany (owning side)
     * Get fkCsePrescricaoExames
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\PrescricaoExame
     */
    public function getFkCsePrescricaoExames()
    {
        return $this->fkCsePrescricaoExames;
    }

    /**
     * OneToMany (owning side)
     * Add CsePrescricaoInternacao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\PrescricaoInternacao $fkCsePrescricaoInternacao
     * @return Prescricao
     */
    public function addFkCsePrescricaoInternacoes(\Urbem\CoreBundle\Entity\Cse\PrescricaoInternacao $fkCsePrescricaoInternacao)
    {
        if (false === $this->fkCsePrescricaoInternacoes->contains($fkCsePrescricaoInternacao)) {
            $fkCsePrescricaoInternacao->setFkCsePrescricao($this);
            $this->fkCsePrescricaoInternacoes->add($fkCsePrescricaoInternacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CsePrescricaoInternacao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\PrescricaoInternacao $fkCsePrescricaoInternacao
     */
    public function removeFkCsePrescricaoInternacoes(\Urbem\CoreBundle\Entity\Cse\PrescricaoInternacao $fkCsePrescricaoInternacao)
    {
        $this->fkCsePrescricaoInternacoes->removeElement($fkCsePrescricaoInternacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkCsePrescricaoInternacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\PrescricaoInternacao
     */
    public function getFkCsePrescricaoInternacoes()
    {
        return $this->fkCsePrescricaoInternacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     * @return Prescricao
     */
    public function setFkCseCidadao(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        $this->codCidadao = $fkCseCidadao->getCodCidadao();
        $this->fkCseCidadao = $fkCseCidadao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseCidadao
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    public function getFkCseCidadao()
    {
        return $this->fkCseCidadao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseTipoTratamento
     *
     * @param \Urbem\CoreBundle\Entity\Cse\TipoTratamento $fkCseTipoTratamento
     * @return Prescricao
     */
    public function setFkCseTipoTratamento(\Urbem\CoreBundle\Entity\Cse\TipoTratamento $fkCseTipoTratamento)
    {
        $this->codTipo = $fkCseTipoTratamento->getCodTratamento();
        $this->codClassificacao = $fkCseTipoTratamento->getCodClassificacao();
        $this->fkCseTipoTratamento = $fkCseTipoTratamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseTipoTratamento
     *
     * @return \Urbem\CoreBundle\Entity\Cse\TipoTratamento
     */
    public function getFkCseTipoTratamento()
    {
        return $this->fkCseTipoTratamento;
    }
}
