<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * TipoExame
 */
class TipoExame
{
    /**
     * PK
     * @var integer
     */
    private $codExame;

    /**
     * @var string
     */
    private $nomExame;

    /**
     * @var integer
     */
    private $codTratamento;

    /**
     * @var integer
     */
    private $codClassificacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\PrescricaoExame
     */
    private $fkCsePrescricaoExames;

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
    }

    /**
     * Set codExame
     *
     * @param integer $codExame
     * @return TipoExame
     */
    public function setCodExame($codExame)
    {
        $this->codExame = $codExame;
        return $this;
    }

    /**
     * Get codExame
     *
     * @return integer
     */
    public function getCodExame()
    {
        return $this->codExame;
    }

    /**
     * Set nomExame
     *
     * @param string $nomExame
     * @return TipoExame
     */
    public function setNomExame($nomExame)
    {
        $this->nomExame = $nomExame;
        return $this;
    }

    /**
     * Get nomExame
     *
     * @return string
     */
    public function getNomExame()
    {
        return $this->nomExame;
    }

    /**
     * Set codTratamento
     *
     * @param integer $codTratamento
     * @return TipoExame
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
     * @return TipoExame
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
     * OneToMany (owning side)
     * Add CsePrescricaoExame
     *
     * @param \Urbem\CoreBundle\Entity\Cse\PrescricaoExame $fkCsePrescricaoExame
     * @return TipoExame
     */
    public function addFkCsePrescricaoExames(\Urbem\CoreBundle\Entity\Cse\PrescricaoExame $fkCsePrescricaoExame)
    {
        if (false === $this->fkCsePrescricaoExames->contains($fkCsePrescricaoExame)) {
            $fkCsePrescricaoExame->setFkCseTipoExame($this);
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
     * ManyToOne (inverse side)
     * Set fkCseTipoTratamento
     *
     * @param \Urbem\CoreBundle\Entity\Cse\TipoTratamento $fkCseTipoTratamento
     * @return TipoExame
     */
    public function setFkCseTipoTratamento(\Urbem\CoreBundle\Entity\Cse\TipoTratamento $fkCseTipoTratamento)
    {
        $this->codTratamento = $fkCseTipoTratamento->getCodTratamento();
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
