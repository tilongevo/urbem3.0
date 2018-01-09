<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * TipoTratamento
 */
class TipoTratamento
{
    /**
     * PK
     * @var integer
     */
    private $codTratamento;

    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * @var string
     */
    private $nomTratamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Prescricao
     */
    private $fkCsePrescricoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\TipoExame
     */
    private $fkCseTipoExames;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\ClassificacaoTratamento
     */
    private $fkCseClassificacaoTratamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCsePrescricoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkCseTipoExames = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTratamento
     *
     * @param integer $codTratamento
     * @return TipoTratamento
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
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return TipoTratamento
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
     * Set nomTratamento
     *
     * @param string $nomTratamento
     * @return TipoTratamento
     */
    public function setNomTratamento($nomTratamento)
    {
        $this->nomTratamento = $nomTratamento;
        return $this;
    }

    /**
     * Get nomTratamento
     *
     * @return string
     */
    public function getNomTratamento()
    {
        return $this->nomTratamento;
    }

    /**
     * OneToMany (owning side)
     * Add CsePrescricao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Prescricao $fkCsePrescricao
     * @return TipoTratamento
     */
    public function addFkCsePrescricoes(\Urbem\CoreBundle\Entity\Cse\Prescricao $fkCsePrescricao)
    {
        if (false === $this->fkCsePrescricoes->contains($fkCsePrescricao)) {
            $fkCsePrescricao->setFkCseTipoTratamento($this);
            $this->fkCsePrescricoes->add($fkCsePrescricao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CsePrescricao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Prescricao $fkCsePrescricao
     */
    public function removeFkCsePrescricoes(\Urbem\CoreBundle\Entity\Cse\Prescricao $fkCsePrescricao)
    {
        $this->fkCsePrescricoes->removeElement($fkCsePrescricao);
    }

    /**
     * OneToMany (owning side)
     * Get fkCsePrescricoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Prescricao
     */
    public function getFkCsePrescricoes()
    {
        return $this->fkCsePrescricoes;
    }

    /**
     * OneToMany (owning side)
     * Add CseTipoExame
     *
     * @param \Urbem\CoreBundle\Entity\Cse\TipoExame $fkCseTipoExame
     * @return TipoTratamento
     */
    public function addFkCseTipoExames(\Urbem\CoreBundle\Entity\Cse\TipoExame $fkCseTipoExame)
    {
        if (false === $this->fkCseTipoExames->contains($fkCseTipoExame)) {
            $fkCseTipoExame->setFkCseTipoTratamento($this);
            $this->fkCseTipoExames->add($fkCseTipoExame);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseTipoExame
     *
     * @param \Urbem\CoreBundle\Entity\Cse\TipoExame $fkCseTipoExame
     */
    public function removeFkCseTipoExames(\Urbem\CoreBundle\Entity\Cse\TipoExame $fkCseTipoExame)
    {
        $this->fkCseTipoExames->removeElement($fkCseTipoExame);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseTipoExames
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\TipoExame
     */
    public function getFkCseTipoExames()
    {
        return $this->fkCseTipoExames;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseClassificacaoTratamento
     *
     * @param \Urbem\CoreBundle\Entity\Cse\ClassificacaoTratamento $fkCseClassificacaoTratamento
     * @return TipoTratamento
     */
    public function setFkCseClassificacaoTratamento(\Urbem\CoreBundle\Entity\Cse\ClassificacaoTratamento $fkCseClassificacaoTratamento)
    {
        $this->codClassificacao = $fkCseClassificacaoTratamento->getCodClassificacao();
        $this->fkCseClassificacaoTratamento = $fkCseClassificacaoTratamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseClassificacaoTratamento
     *
     * @return \Urbem\CoreBundle\Entity\Cse\ClassificacaoTratamento
     */
    public function getFkCseClassificacaoTratamento()
    {
        return $this->fkCseClassificacaoTratamento;
    }
}
