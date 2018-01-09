<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ReceitaIndentificadoresPeculiarReceita
     */
    private $fkTcemgReceitaIndentificadoresPeculiarReceitas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgReceitaIndentificadoresPeculiarReceitas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TcemgReceitaIndentificadoresPeculiarReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ReceitaIndentificadoresPeculiarReceita $fkTcemgReceitaIndentificadoresPeculiarReceita
     * @return ValoresIdentificadores
     */
    public function addFkTcemgReceitaIndentificadoresPeculiarReceitas(\Urbem\CoreBundle\Entity\Tcemg\ReceitaIndentificadoresPeculiarReceita $fkTcemgReceitaIndentificadoresPeculiarReceita)
    {
        if (false === $this->fkTcemgReceitaIndentificadoresPeculiarReceitas->contains($fkTcemgReceitaIndentificadoresPeculiarReceita)) {
            $fkTcemgReceitaIndentificadoresPeculiarReceita->setFkTcemgValoresIdentificadores($this);
            $this->fkTcemgReceitaIndentificadoresPeculiarReceitas->add($fkTcemgReceitaIndentificadoresPeculiarReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgReceitaIndentificadoresPeculiarReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ReceitaIndentificadoresPeculiarReceita $fkTcemgReceitaIndentificadoresPeculiarReceita
     */
    public function removeFkTcemgReceitaIndentificadoresPeculiarReceitas(\Urbem\CoreBundle\Entity\Tcemg\ReceitaIndentificadoresPeculiarReceita $fkTcemgReceitaIndentificadoresPeculiarReceita)
    {
        $this->fkTcemgReceitaIndentificadoresPeculiarReceitas->removeElement($fkTcemgReceitaIndentificadoresPeculiarReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgReceitaIndentificadoresPeculiarReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ReceitaIndentificadoresPeculiarReceita
     */
    public function getFkTcemgReceitaIndentificadoresPeculiarReceitas()
    {
        return $this->fkTcemgReceitaIndentificadoresPeculiarReceitas;
    }
}
