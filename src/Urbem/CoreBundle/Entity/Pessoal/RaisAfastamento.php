<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * RaisAfastamento
 */
class RaisAfastamento
{
    /**
     * PK
     * @var integer
     */
    private $codRais;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoRaisAfastamento
     */
    private $fkPessoalAssentamentoRaisAfastamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalAssentamentoRaisAfastamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codRais
     *
     * @param integer $codRais
     * @return RaisAfastamento
     */
    public function setCodRais($codRais)
    {
        $this->codRais = $codRais;
        return $this;
    }

    /**
     * Get codRais
     *
     * @return integer
     */
    public function getCodRais()
    {
        return $this->codRais;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return RaisAfastamento
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
     * Add PessoalAssentamentoRaisAfastamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoRaisAfastamento $fkPessoalAssentamentoRaisAfastamento
     * @return RaisAfastamento
     */
    public function addFkPessoalAssentamentoRaisAfastamentos(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoRaisAfastamento $fkPessoalAssentamentoRaisAfastamento)
    {
        if (false === $this->fkPessoalAssentamentoRaisAfastamentos->contains($fkPessoalAssentamentoRaisAfastamento)) {
            $fkPessoalAssentamentoRaisAfastamento->setFkPessoalRaisAfastamento($this);
            $this->fkPessoalAssentamentoRaisAfastamentos->add($fkPessoalAssentamentoRaisAfastamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoRaisAfastamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoRaisAfastamento $fkPessoalAssentamentoRaisAfastamento
     */
    public function removeFkPessoalAssentamentoRaisAfastamentos(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoRaisAfastamento $fkPessoalAssentamentoRaisAfastamento)
    {
        $this->fkPessoalAssentamentoRaisAfastamentos->removeElement($fkPessoalAssentamentoRaisAfastamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoRaisAfastamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoRaisAfastamento
     */
    public function getFkPessoalAssentamentoRaisAfastamentos()
    {
        return $this->fkPessoalAssentamentoRaisAfastamentos;
    }
}
