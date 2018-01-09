<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * CodigoFonteTce
 */
class CodigoFonteTce
{
    /**
     * PK
     * @var integer
     */
    private $codFonte;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\CodigoFonteRecurso
     */
    private $fkTcepeCodigoFonteRecursos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepeCodigoFonteRecursos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFonte
     *
     * @param integer $codFonte
     * @return CodigoFonteTce
     */
    public function setCodFonte($codFonte)
    {
        $this->codFonte = $codFonte;
        return $this;
    }

    /**
     * Get codFonte
     *
     * @return integer
     */
    public function getCodFonte()
    {
        return $this->codFonte;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return CodigoFonteTce
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
     * Add TcepeCodigoFonteRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\CodigoFonteRecurso $fkTcepeCodigoFonteRecurso
     * @return CodigoFonteTce
     */
    public function addFkTcepeCodigoFonteRecursos(\Urbem\CoreBundle\Entity\Tcepe\CodigoFonteRecurso $fkTcepeCodigoFonteRecurso)
    {
        if (false === $this->fkTcepeCodigoFonteRecursos->contains($fkTcepeCodigoFonteRecurso)) {
            $fkTcepeCodigoFonteRecurso->setFkTcepeCodigoFonteTce($this);
            $this->fkTcepeCodigoFonteRecursos->add($fkTcepeCodigoFonteRecurso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeCodigoFonteRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\CodigoFonteRecurso $fkTcepeCodigoFonteRecurso
     */
    public function removeFkTcepeCodigoFonteRecursos(\Urbem\CoreBundle\Entity\Tcepe\CodigoFonteRecurso $fkTcepeCodigoFonteRecurso)
    {
        $this->fkTcepeCodigoFonteRecursos->removeElement($fkTcepeCodigoFonteRecurso);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeCodigoFonteRecursos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\CodigoFonteRecurso
     */
    public function getFkTcepeCodigoFonteRecursos()
    {
        return $this->fkTcepeCodigoFonteRecursos;
    }
}
