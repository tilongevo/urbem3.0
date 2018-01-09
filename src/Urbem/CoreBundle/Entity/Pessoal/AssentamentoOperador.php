<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoOperador
 */
class AssentamentoOperador
{
    /**
     * PK
     * @var integer
     */
    private $codOperador;

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
     * Set codOperador
     *
     * @param integer $codOperador
     * @return AssentamentoOperador
     */
    public function setCodOperador($codOperador)
    {
        $this->codOperador = $codOperador;
        return $this;
    }

    /**
     * Get codOperador
     *
     * @return integer
     */
    public function getCodOperador()
    {
        return $this->codOperador;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return AssentamentoOperador
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
     * @return AssentamentoOperador
     */
    public function addFkPessoalAssentamentoAssentamentos(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento)
    {
        if (false === $this->fkPessoalAssentamentoAssentamentos->contains($fkPessoalAssentamentoAssentamento)) {
            $fkPessoalAssentamentoAssentamento->setFkPessoalAssentamentoOperador($this);
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
