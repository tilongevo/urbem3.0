<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * InformacaoAdicional
 */
class InformacaoAdicional
{
    /**
     * PK
     * @var integer
     */
    private $codInformacao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $tamanho;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var integer
     */
    private $codBiblioteca;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\InformacaoAdicionalLayoutCarne
     */
    private $fkArrecadacaoInformacaoAdicionalLayoutCarnes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoInformacaoAdicionalLayoutCarnes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codInformacao
     *
     * @param integer $codInformacao
     * @return InformacaoAdicional
     */
    public function setCodInformacao($codInformacao)
    {
        $this->codInformacao = $codInformacao;
        return $this;
    }

    /**
     * Get codInformacao
     *
     * @return integer
     */
    public function getCodInformacao()
    {
        return $this->codInformacao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return InformacaoAdicional
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
     * Set tamanho
     *
     * @param integer $tamanho
     * @return InformacaoAdicional
     */
    public function setTamanho($tamanho)
    {
        $this->tamanho = $tamanho;
        return $this;
    }

    /**
     * Get tamanho
     *
     * @return integer
     */
    public function getTamanho()
    {
        return $this->tamanho;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return InformacaoAdicional
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set codBiblioteca
     *
     * @param integer $codBiblioteca
     * @return InformacaoAdicional
     */
    public function setCodBiblioteca($codBiblioteca)
    {
        $this->codBiblioteca = $codBiblioteca;
        return $this;
    }

    /**
     * Get codBiblioteca
     *
     * @return integer
     */
    public function getCodBiblioteca()
    {
        return $this->codBiblioteca;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return InformacaoAdicional
     */
    public function setCodFuncao($codFuncao)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoInformacaoAdicionalLayoutCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\InformacaoAdicionalLayoutCarne $fkArrecadacaoInformacaoAdicionalLayoutCarne
     * @return InformacaoAdicional
     */
    public function addFkArrecadacaoInformacaoAdicionalLayoutCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\InformacaoAdicionalLayoutCarne $fkArrecadacaoInformacaoAdicionalLayoutCarne)
    {
        if (false === $this->fkArrecadacaoInformacaoAdicionalLayoutCarnes->contains($fkArrecadacaoInformacaoAdicionalLayoutCarne)) {
            $fkArrecadacaoInformacaoAdicionalLayoutCarne->setFkArrecadacaoInformacaoAdicional($this);
            $this->fkArrecadacaoInformacaoAdicionalLayoutCarnes->add($fkArrecadacaoInformacaoAdicionalLayoutCarne);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoInformacaoAdicionalLayoutCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\InformacaoAdicionalLayoutCarne $fkArrecadacaoInformacaoAdicionalLayoutCarne
     */
    public function removeFkArrecadacaoInformacaoAdicionalLayoutCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\InformacaoAdicionalLayoutCarne $fkArrecadacaoInformacaoAdicionalLayoutCarne)
    {
        $this->fkArrecadacaoInformacaoAdicionalLayoutCarnes->removeElement($fkArrecadacaoInformacaoAdicionalLayoutCarne);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoInformacaoAdicionalLayoutCarnes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\InformacaoAdicionalLayoutCarne
     */
    public function getFkArrecadacaoInformacaoAdicionalLayoutCarnes()
    {
        return $this->fkArrecadacaoInformacaoAdicionalLayoutCarnes;
    }
}
