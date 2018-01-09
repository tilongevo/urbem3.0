<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Caged
 */
class Caged
{
    /**
     * PK
     * @var integer
     */
    private $codCaged;

    /**
     * @var integer
     */
    private $numCaged;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $tipo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CausaRescisaoCaged
     */
    private $fkPessoalCausaRescisaoCageds;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\TipoAdmissaoCaged
     */
    private $fkPessoalTipoAdmissaoCageds;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalCausaRescisaoCageds = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalTipoAdmissaoCageds = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCaged
     *
     * @param integer $codCaged
     * @return Caged
     */
    public function setCodCaged($codCaged)
    {
        $this->codCaged = $codCaged;
        return $this;
    }

    /**
     * Get codCaged
     *
     * @return integer
     */
    public function getCodCaged()
    {
        return $this->codCaged;
    }

    /**
     * Set numCaged
     *
     * @param integer $numCaged
     * @return Caged
     */
    public function setNumCaged($numCaged)
    {
        $this->numCaged = $numCaged;
        return $this;
    }

    /**
     * Get numCaged
     *
     * @return integer
     */
    public function getNumCaged()
    {
        return $this->numCaged;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Caged
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
     * Set tipo
     *
     * @param string $tipo
     * @return Caged
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalCausaRescisaoCaged
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CausaRescisaoCaged $fkPessoalCausaRescisaoCaged
     * @return Caged
     */
    public function addFkPessoalCausaRescisaoCageds(\Urbem\CoreBundle\Entity\Pessoal\CausaRescisaoCaged $fkPessoalCausaRescisaoCaged)
    {
        if (false === $this->fkPessoalCausaRescisaoCageds->contains($fkPessoalCausaRescisaoCaged)) {
            $fkPessoalCausaRescisaoCaged->setFkPessoalCaged($this);
            $this->fkPessoalCausaRescisaoCageds->add($fkPessoalCausaRescisaoCaged);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCausaRescisaoCaged
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CausaRescisaoCaged $fkPessoalCausaRescisaoCaged
     */
    public function removeFkPessoalCausaRescisaoCageds(\Urbem\CoreBundle\Entity\Pessoal\CausaRescisaoCaged $fkPessoalCausaRescisaoCaged)
    {
        $this->fkPessoalCausaRescisaoCageds->removeElement($fkPessoalCausaRescisaoCaged);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCausaRescisaoCageds
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CausaRescisaoCaged
     */
    public function getFkPessoalCausaRescisaoCageds()
    {
        return $this->fkPessoalCausaRescisaoCageds;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalTipoAdmissaoCaged
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TipoAdmissaoCaged $fkPessoalTipoAdmissaoCaged
     * @return Caged
     */
    public function addFkPessoalTipoAdmissaoCageds(\Urbem\CoreBundle\Entity\Pessoal\TipoAdmissaoCaged $fkPessoalTipoAdmissaoCaged)
    {
        if (false === $this->fkPessoalTipoAdmissaoCageds->contains($fkPessoalTipoAdmissaoCaged)) {
            $fkPessoalTipoAdmissaoCaged->setFkPessoalCaged($this);
            $this->fkPessoalTipoAdmissaoCageds->add($fkPessoalTipoAdmissaoCaged);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalTipoAdmissaoCaged
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TipoAdmissaoCaged $fkPessoalTipoAdmissaoCaged
     */
    public function removeFkPessoalTipoAdmissaoCageds(\Urbem\CoreBundle\Entity\Pessoal\TipoAdmissaoCaged $fkPessoalTipoAdmissaoCaged)
    {
        $this->fkPessoalTipoAdmissaoCageds->removeElement($fkPessoalTipoAdmissaoCaged);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalTipoAdmissaoCageds
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\TipoAdmissaoCaged
     */
    public function getFkPessoalTipoAdmissaoCageds()
    {
        return $this->fkPessoalTipoAdmissaoCageds;
    }
}
