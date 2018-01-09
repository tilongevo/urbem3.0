<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * FonteRecurso
 */
class FonteRecurso
{
    /**
     * PK
     * @var integer
     */
    private $codFonte;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\EspecificacaoDestinacaoRecurso
     */
    private $fkOrcamentoEspecificacaoDestinacaoRecursos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\RecursoDireto
     */
    private $fkOrcamentoRecursoDiretos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkOrcamentoEspecificacaoDestinacaoRecursos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoRecursoDiretos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFonte
     *
     * @param integer $codFonte
     * @return FonteRecurso
     */
    public function setCodFonte($codFonte)
    {
        $this->codFonte = $codFonte;
        return $this;
    }

    /**
     * Get codFonte
     *
     * @return integer
     */
    public function getCodFonte()
    {
        return $this->codFonte;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return FonteRecurso
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
     * Add OrcamentoEspecificacaoDestinacaoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\EspecificacaoDestinacaoRecurso $fkOrcamentoEspecificacaoDestinacaoRecurso
     * @return FonteRecurso
     */
    public function addFkOrcamentoEspecificacaoDestinacaoRecursos(\Urbem\CoreBundle\Entity\Orcamento\EspecificacaoDestinacaoRecurso $fkOrcamentoEspecificacaoDestinacaoRecurso)
    {
        if (false === $this->fkOrcamentoEspecificacaoDestinacaoRecursos->contains($fkOrcamentoEspecificacaoDestinacaoRecurso)) {
            $fkOrcamentoEspecificacaoDestinacaoRecurso->setFkOrcamentoFonteRecurso($this);
            $this->fkOrcamentoEspecificacaoDestinacaoRecursos->add($fkOrcamentoEspecificacaoDestinacaoRecurso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoEspecificacaoDestinacaoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\EspecificacaoDestinacaoRecurso $fkOrcamentoEspecificacaoDestinacaoRecurso
     */
    public function removeFkOrcamentoEspecificacaoDestinacaoRecursos(\Urbem\CoreBundle\Entity\Orcamento\EspecificacaoDestinacaoRecurso $fkOrcamentoEspecificacaoDestinacaoRecurso)
    {
        $this->fkOrcamentoEspecificacaoDestinacaoRecursos->removeElement($fkOrcamentoEspecificacaoDestinacaoRecurso);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoEspecificacaoDestinacaoRecursos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\EspecificacaoDestinacaoRecurso
     */
    public function getFkOrcamentoEspecificacaoDestinacaoRecursos()
    {
        return $this->fkOrcamentoEspecificacaoDestinacaoRecursos;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoRecursoDireto
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\RecursoDireto $fkOrcamentoRecursoDireto
     * @return FonteRecurso
     */
    public function addFkOrcamentoRecursoDiretos(\Urbem\CoreBundle\Entity\Orcamento\RecursoDireto $fkOrcamentoRecursoDireto)
    {
        if (false === $this->fkOrcamentoRecursoDiretos->contains($fkOrcamentoRecursoDireto)) {
            $fkOrcamentoRecursoDireto->setFkOrcamentoFonteRecurso($this);
            $this->fkOrcamentoRecursoDiretos->add($fkOrcamentoRecursoDireto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoRecursoDireto
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\RecursoDireto $fkOrcamentoRecursoDireto
     */
    public function removeFkOrcamentoRecursoDiretos(\Urbem\CoreBundle\Entity\Orcamento\RecursoDireto $fkOrcamentoRecursoDireto)
    {
        $this->fkOrcamentoRecursoDiretos->removeElement($fkOrcamentoRecursoDireto);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoRecursoDiretos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\RecursoDireto
     */
    public function getFkOrcamentoRecursoDiretos()
    {
        return $this->fkOrcamentoRecursoDiretos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codFonte, $this->descricao);
    }
}
