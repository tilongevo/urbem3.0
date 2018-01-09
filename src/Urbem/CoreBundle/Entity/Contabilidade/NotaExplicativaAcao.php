<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * NotaExplicativaAcao
 */
class NotaExplicativaAcao
{
    /**
     * PK
     * @var integer
     */
    private $codAcao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Administracao\Acao
     */
    private $fkAdministracaoAcao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\NotaExplicativa
     */
    private $fkContabilidadeNotaExplicativas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadeNotaExplicativas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return NotaExplicativaAcao
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
     * OneToMany (owning side)
     * Add ContabilidadeNotaExplicativa
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\NotaExplicativa $fkContabilidadeNotaExplicativa
     * @return NotaExplicativaAcao
     */
    public function addFkContabilidadeNotaExplicativas(\Urbem\CoreBundle\Entity\Contabilidade\NotaExplicativa $fkContabilidadeNotaExplicativa)
    {
        if (false === $this->fkContabilidadeNotaExplicativas->contains($fkContabilidadeNotaExplicativa)) {
            $fkContabilidadeNotaExplicativa->setFkContabilidadeNotaExplicativaAcao($this);
            $this->fkContabilidadeNotaExplicativas->add($fkContabilidadeNotaExplicativa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeNotaExplicativa
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\NotaExplicativa $fkContabilidadeNotaExplicativa
     */
    public function removeFkContabilidadeNotaExplicativas(\Urbem\CoreBundle\Entity\Contabilidade\NotaExplicativa $fkContabilidadeNotaExplicativa)
    {
        $this->fkContabilidadeNotaExplicativas->removeElement($fkContabilidadeNotaExplicativa);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeNotaExplicativas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\NotaExplicativa
     */
    public function getFkContabilidadeNotaExplicativas()
    {
        return $this->fkContabilidadeNotaExplicativas;
    }

    /**
     * OneToOne (owning side)
     * Set AdministracaoAcao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Acao $fkAdministracaoAcao
     * @return NotaExplicativaAcao
     */
    public function setFkAdministracaoAcao(\Urbem\CoreBundle\Entity\Administracao\Acao $fkAdministracaoAcao)
    {
        $this->codAcao = $fkAdministracaoAcao->getCodAcao();
        $this->fkAdministracaoAcao = $fkAdministracaoAcao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkAdministracaoAcao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Acao
     */
    public function getFkAdministracaoAcao()
    {
        return $this->fkAdministracaoAcao;
    }
}
