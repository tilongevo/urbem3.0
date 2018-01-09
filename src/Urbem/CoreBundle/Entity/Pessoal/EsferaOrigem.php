<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * EsferaOrigem
 */
class EsferaOrigem
{
    /**
     * PK
     * @var integer
     */
    private $codEsfera;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Assentamento
     */
    private $fkPessoalAssentamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalAssentamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEsfera
     *
     * @param integer $codEsfera
     * @return EsferaOrigem
     */
    public function setCodEsfera($codEsfera)
    {
        $this->codEsfera = $codEsfera;
        return $this;
    }

    /**
     * Get codEsfera
     *
     * @return integer
     */
    public function getCodEsfera()
    {
        return $this->codEsfera;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return EsferaOrigem
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
     * Add PessoalAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento
     * @return EsferaOrigem
     */
    public function addFkPessoalAssentamentos(\Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento)
    {
        if (false === $this->fkPessoalAssentamentos->contains($fkPessoalAssentamento)) {
            $fkPessoalAssentamento->setFkPessoalEsferaOrigem($this);
            $this->fkPessoalAssentamentos->add($fkPessoalAssentamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento
     */
    public function removeFkPessoalAssentamentos(\Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento)
    {
        $this->fkPessoalAssentamentos->removeElement($fkPessoalAssentamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Assentamento
     */
    public function getFkPessoalAssentamentos()
    {
        return $this->fkPessoalAssentamentos;
    }
}
