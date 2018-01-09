<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * CausaAfastamentoMte
 */
class CausaAfastamentoMte
{
    /**
     * PK
     * @var string
     */
    private $codCausaAfastamento;

    /**
     * @var string
     */
    private $nomCausaAfastamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CausaRescisao
     */
    private $fkPessoalCausaRescisoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalCausaRescisoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCausaAfastamento
     *
     * @param string $codCausaAfastamento
     * @return CausaAfastamentoMte
     */
    public function setCodCausaAfastamento($codCausaAfastamento)
    {
        $this->codCausaAfastamento = $codCausaAfastamento;
        return $this;
    }

    /**
     * Get codCausaAfastamento
     *
     * @return string
     */
    public function getCodCausaAfastamento()
    {
        return $this->codCausaAfastamento;
    }

    /**
     * Set nomCausaAfastamento
     *
     * @param string $nomCausaAfastamento
     * @return CausaAfastamentoMte
     */
    public function setNomCausaAfastamento($nomCausaAfastamento)
    {
        $this->nomCausaAfastamento = $nomCausaAfastamento;
        return $this;
    }

    /**
     * Get nomCausaAfastamento
     *
     * @return string
     */
    public function getNomCausaAfastamento()
    {
        return $this->nomCausaAfastamento;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalCausaRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CausaRescisao $fkPessoalCausaRescisao
     * @return CausaAfastamentoMte
     */
    public function addFkPessoalCausaRescisoes(\Urbem\CoreBundle\Entity\Pessoal\CausaRescisao $fkPessoalCausaRescisao)
    {
        if (false === $this->fkPessoalCausaRescisoes->contains($fkPessoalCausaRescisao)) {
            $fkPessoalCausaRescisao->setFkPessoalCausaAfastamentoMte($this);
            $this->fkPessoalCausaRescisoes->add($fkPessoalCausaRescisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCausaRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CausaRescisao $fkPessoalCausaRescisao
     */
    public function removeFkPessoalCausaRescisoes(\Urbem\CoreBundle\Entity\Pessoal\CausaRescisao $fkPessoalCausaRescisao)
    {
        $this->fkPessoalCausaRescisoes->removeElement($fkPessoalCausaRescisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCausaRescisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CausaRescisao
     */
    public function getFkPessoalCausaRescisoes()
    {
        return $this->fkPessoalCausaRescisoes;
    }
}
