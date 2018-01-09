<?php
 
namespace Urbem\CoreBundle\Entity\Tceto;

/**
 * ValoresIdentificadores
 */
class ValoresIdentificadores
{
    /**
     * PK
     * @var integer
     */
    private $codIdentificador;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\ReceitaIndentificadoresPeculiarReceita
     */
    private $fkTcetoReceitaIndentificadoresPeculiarReceitas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcetoReceitaIndentificadoresPeculiarReceitas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codIdentificador
     *
     * @param integer $codIdentificador
     * @return ValoresIdentificadores
     */
    public function setCodIdentificador($codIdentificador)
    {
        $this->codIdentificador = $codIdentificador;
        return $this;
    }

    /**
     * Get codIdentificador
     *
     * @return integer
     */
    public function getCodIdentificador()
    {
        return $this->codIdentificador;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ValoresIdentificadores
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
     * Add TcetoReceitaIndentificadoresPeculiarReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\ReceitaIndentificadoresPeculiarReceita $fkTcetoReceitaIndentificadoresPeculiarReceita
     * @return ValoresIdentificadores
     */
    public function addFkTcetoReceitaIndentificadoresPeculiarReceitas(\Urbem\CoreBundle\Entity\Tceto\ReceitaIndentificadoresPeculiarReceita $fkTcetoReceitaIndentificadoresPeculiarReceita)
    {
        if (false === $this->fkTcetoReceitaIndentificadoresPeculiarReceitas->contains($fkTcetoReceitaIndentificadoresPeculiarReceita)) {
            $fkTcetoReceitaIndentificadoresPeculiarReceita->setFkTcetoValoresIdentificadores($this);
            $this->fkTcetoReceitaIndentificadoresPeculiarReceitas->add($fkTcetoReceitaIndentificadoresPeculiarReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcetoReceitaIndentificadoresPeculiarReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\ReceitaIndentificadoresPeculiarReceita $fkTcetoReceitaIndentificadoresPeculiarReceita
     */
    public function removeFkTcetoReceitaIndentificadoresPeculiarReceitas(\Urbem\CoreBundle\Entity\Tceto\ReceitaIndentificadoresPeculiarReceita $fkTcetoReceitaIndentificadoresPeculiarReceita)
    {
        $this->fkTcetoReceitaIndentificadoresPeculiarReceitas->removeElement($fkTcetoReceitaIndentificadoresPeculiarReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcetoReceitaIndentificadoresPeculiarReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\ReceitaIndentificadoresPeculiarReceita
     */
    public function getFkTcetoReceitaIndentificadoresPeculiarReceitas()
    {
        return $this->fkTcetoReceitaIndentificadoresPeculiarReceitas;
    }
}
