<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * FonteRecurso
 */
class FonteRecurso
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal
     */
    private $fkTcepeFonteRecursoLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao
     */
    private $fkTcepeFonteRecursoLotacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepeFonteRecursoLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeFonteRecursoLotacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFonte
     *
     * @param integer $codFonte
     * @return FonteRecurso
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
     * @return FonteRecurso
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
     * Add TcepeFonteRecursoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal $fkTcepeFonteRecursoLocal
     * @return FonteRecurso
     */
    public function addFkTcepeFonteRecursoLocais(\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal $fkTcepeFonteRecursoLocal)
    {
        if (false === $this->fkTcepeFonteRecursoLocais->contains($fkTcepeFonteRecursoLocal)) {
            $fkTcepeFonteRecursoLocal->setFkTcepeFonteRecurso($this);
            $this->fkTcepeFonteRecursoLocais->add($fkTcepeFonteRecursoLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeFonteRecursoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal $fkTcepeFonteRecursoLocal
     */
    public function removeFkTcepeFonteRecursoLocais(\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal $fkTcepeFonteRecursoLocal)
    {
        $this->fkTcepeFonteRecursoLocais->removeElement($fkTcepeFonteRecursoLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeFonteRecursoLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal
     */
    public function getFkTcepeFonteRecursoLocais()
    {
        return $this->fkTcepeFonteRecursoLocais;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeFonteRecursoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao $fkTcepeFonteRecursoLotacao
     * @return FonteRecurso
     */
    public function addFkTcepeFonteRecursoLotacoes(\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao $fkTcepeFonteRecursoLotacao)
    {
        if (false === $this->fkTcepeFonteRecursoLotacoes->contains($fkTcepeFonteRecursoLotacao)) {
            $fkTcepeFonteRecursoLotacao->setFkTcepeFonteRecurso($this);
            $this->fkTcepeFonteRecursoLotacoes->add($fkTcepeFonteRecursoLotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeFonteRecursoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao $fkTcepeFonteRecursoLotacao
     */
    public function removeFkTcepeFonteRecursoLotacoes(\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao $fkTcepeFonteRecursoLotacao)
    {
        $this->fkTcepeFonteRecursoLotacoes->removeElement($fkTcepeFonteRecursoLotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeFonteRecursoLotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao
     */
    public function getFkTcepeFonteRecursoLotacoes()
    {
        return $this->fkTcepeFonteRecursoLotacoes;
    }
}
