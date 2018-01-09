<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoMotivo
 */
class AssentamentoMotivo
{
    /**
     * PK
     * @var integer
     */
    private $codMotivo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    private $fkPessoalAssentamentoAssentamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalAssentamentoAssentamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codMotivo
     *
     * @param integer $codMotivo
     * @return AssentamentoMotivo
     */
    public function setCodMotivo($codMotivo)
    {
        $this->codMotivo = $codMotivo;
        return $this;
    }

    /**
     * Get codMotivo
     *
     * @return integer
     */
    public function getCodMotivo()
    {
        return $this->codMotivo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return AssentamentoMotivo
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
     * Add PessoalAssentamentoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento
     * @return AssentamentoMotivo
     */
    public function addFkPessoalAssentamentoAssentamentos(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento)
    {
        if (false === $this->fkPessoalAssentamentoAssentamentos->contains($fkPessoalAssentamentoAssentamento)) {
            $fkPessoalAssentamentoAssentamento->setFkPessoalAssentamentoMotivo($this);
            $this->fkPessoalAssentamentoAssentamentos->add($fkPessoalAssentamentoAssentamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento
     */
    public function removeFkPessoalAssentamentoAssentamentos(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento)
    {
        $this->fkPessoalAssentamentoAssentamentos->removeElement($fkPessoalAssentamentoAssentamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoAssentamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    public function getFkPessoalAssentamentoAssentamentos()
    {
        return $this->fkPessoalAssentamentoAssentamentos;
    }
}
