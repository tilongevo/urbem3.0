<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * ClassificacaoTratamento
 */
class ClassificacaoTratamento
{
    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * @var string
     */
    private $nomClassificacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\TipoTratamento
     */
    private $fkCseTipoTratamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCseTipoTratamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return ClassificacaoTratamento
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
     * Set nomClassificacao
     *
     * @param string $nomClassificacao
     * @return ClassificacaoTratamento
     */
    public function setNomClassificacao($nomClassificacao)
    {
        $this->nomClassificacao = $nomClassificacao;
        return $this;
    }

    /**
     * Get nomClassificacao
     *
     * @return string
     */
    public function getNomClassificacao()
    {
        return $this->nomClassificacao;
    }

    /**
     * OneToMany (owning side)
     * Add CseTipoTratamento
     *
     * @param \Urbem\CoreBundle\Entity\Cse\TipoTratamento $fkCseTipoTratamento
     * @return ClassificacaoTratamento
     */
    public function addFkCseTipoTratamentos(\Urbem\CoreBundle\Entity\Cse\TipoTratamento $fkCseTipoTratamento)
    {
        if (false === $this->fkCseTipoTratamentos->contains($fkCseTipoTratamento)) {
            $fkCseTipoTratamento->setFkCseClassificacaoTratamento($this);
            $this->fkCseTipoTratamentos->add($fkCseTipoTratamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseTipoTratamento
     *
     * @param \Urbem\CoreBundle\Entity\Cse\TipoTratamento $fkCseTipoTratamento
     */
    public function removeFkCseTipoTratamentos(\Urbem\CoreBundle\Entity\Cse\TipoTratamento $fkCseTipoTratamento)
    {
        $this->fkCseTipoTratamentos->removeElement($fkCseTipoTratamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseTipoTratamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\TipoTratamento
     */
    public function getFkCseTipoTratamentos()
    {
        return $this->fkCseTipoTratamentos;
    }
}
