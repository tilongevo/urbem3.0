<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Cbo
 */
class Cbo
{
    /**
     * PK
     * @var integer
     */
    private $codCbo;

    /**
     * @var integer
     */
    private $codigo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var \DateTime
     */
    private $dtInicial;

    /**
     * @var \DateTime
     */
    private $dtFinal;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CboCargo
     */
    private $fkPessoalCboCargos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CboEspecialidade
     */
    private $fkPessoalCboEspecialidades;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalCboCargos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalCboEspecialidades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCbo
     *
     * @param integer $codCbo
     * @return Cbo
     */
    public function setCodCbo($codCbo)
    {
        $this->codCbo = $codCbo;
        return $this;
    }

    /**
     * Get codCbo
     *
     * @return integer
     */
    public function getCodCbo()
    {
        return $this->codCbo;
    }

    /**
     * Set codigo
     *
     * @param integer $codigo
     * @return Cbo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Get codigo
     *
     * @return integer
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Cbo
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
     * Set dtInicial
     *
     * @param \DateTime $dtInicial
     * @return Cbo
     */
    public function setDtInicial(\DateTime $dtInicial)
    {
        $this->dtInicial = $dtInicial;
        return $this;
    }

    /**
     * Get dtInicial
     *
     * @return \DateTime
     */
    public function getDtInicial()
    {
        return $this->dtInicial;
    }

    /**
     * Set dtFinal
     *
     * @param \DateTime $dtFinal
     * @return Cbo
     */
    public function setDtFinal(\DateTime $dtFinal = null)
    {
        $this->dtFinal = $dtFinal;
        return $this;
    }

    /**
     * Get dtFinal
     *
     * @return \DateTime
     */
    public function getDtFinal()
    {
        return $this->dtFinal;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalCboCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CboCargo $fkPessoalCboCargo
     * @return Cbo
     */
    public function addFkPessoalCboCargos(\Urbem\CoreBundle\Entity\Pessoal\CboCargo $fkPessoalCboCargo)
    {
        if (false === $this->fkPessoalCboCargos->contains($fkPessoalCboCargo)) {
            $fkPessoalCboCargo->setFkPessoalCbo($this);
            $this->fkPessoalCboCargos->add($fkPessoalCboCargo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCboCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CboCargo $fkPessoalCboCargo
     */
    public function removeFkPessoalCboCargos(\Urbem\CoreBundle\Entity\Pessoal\CboCargo $fkPessoalCboCargo)
    {
        $this->fkPessoalCboCargos->removeElement($fkPessoalCboCargo);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCboCargos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CboCargo
     */
    public function getFkPessoalCboCargos()
    {
        return $this->fkPessoalCboCargos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalCboEspecialidade
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CboEspecialidade $fkPessoalCboEspecialidade
     * @return Cbo
     */
    public function addFkPessoalCboEspecialidades(\Urbem\CoreBundle\Entity\Pessoal\CboEspecialidade $fkPessoalCboEspecialidade)
    {
        if (false === $this->fkPessoalCboEspecialidades->contains($fkPessoalCboEspecialidade)) {
            $fkPessoalCboEspecialidade->setFkPessoalCbo($this);
            $this->fkPessoalCboEspecialidades->add($fkPessoalCboEspecialidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCboEspecialidade
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CboEspecialidade $fkPessoalCboEspecialidade
     */
    public function removeFkPessoalCboEspecialidades(\Urbem\CoreBundle\Entity\Pessoal\CboEspecialidade $fkPessoalCboEspecialidade)
    {
        $this->fkPessoalCboEspecialidades->removeElement($fkPessoalCboEspecialidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCboEspecialidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CboEspecialidade
     */
    public function getFkPessoalCboEspecialidades()
    {
        return $this->fkPessoalCboEspecialidades;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
