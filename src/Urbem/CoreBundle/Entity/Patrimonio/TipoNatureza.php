<?php

namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * TipoNatureza
 */
class TipoNatureza
{
    /**
     * PK
     * @var integer
     */
    private $codigo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Natureza
     */
    private $fkPatrimonioNaturezas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPatrimonioNaturezas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codigo
     *
     * @param integer $codigo
     * @return TipoNatureza
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
     * @return TipoNatureza
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
     * Add PatrimonioNatureza
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Natureza $fkPatrimonioNatureza
     * @return TipoNatureza
     */
    public function addFkPatrimonioNaturezas(\Urbem\CoreBundle\Entity\Patrimonio\Natureza $fkPatrimonioNatureza)
    {
        if (false === $this->fkPatrimonioNaturezas->contains($fkPatrimonioNatureza)) {
            $fkPatrimonioNatureza->setFkPatrimonioTipoNatureza($this);
            $this->fkPatrimonioNaturezas->add($fkPatrimonioNatureza);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioNatureza
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Natureza $fkPatrimonioNatureza
     */
    public function removeFkPatrimonioNaturezas(\Urbem\CoreBundle\Entity\Patrimonio\Natureza $fkPatrimonioNatureza)
    {
        $this->fkPatrimonioNaturezas->removeElement($fkPatrimonioNatureza);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioNaturezas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Natureza
     */
    public function getFkPatrimonioNaturezas()
    {
        return $this->fkPatrimonioNaturezas;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s - %s',
            $this->codigo,
            $this->descricao
        );
    }
}
