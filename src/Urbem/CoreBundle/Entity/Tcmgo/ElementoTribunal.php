<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * ElementoTribunal
 */
class ElementoTribunal
{
    /**
     * PK
     * @var string
     */
    private $estrutural;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ElementoDePara
     */
    private $fkTcmgoElementoDeParas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoElementoDeParas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set estrutural
     *
     * @param string $estrutural
     * @return ElementoTribunal
     */
    public function setEstrutural($estrutural)
    {
        $this->estrutural = $estrutural;
        return $this;
    }

    /**
     * Get estrutural
     *
     * @return string
     */
    public function getEstrutural()
    {
        return $this->estrutural;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ElementoTribunal
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
     * Add TcmgoElementoDePara
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ElementoDePara $fkTcmgoElementoDePara
     * @return ElementoTribunal
     */
    public function addFkTcmgoElementoDeParas(\Urbem\CoreBundle\Entity\Tcmgo\ElementoDePara $fkTcmgoElementoDePara)
    {
        if (false === $this->fkTcmgoElementoDeParas->contains($fkTcmgoElementoDePara)) {
            $fkTcmgoElementoDePara->setFkTcmgoElementoTribunal($this);
            $this->fkTcmgoElementoDeParas->add($fkTcmgoElementoDePara);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoElementoDePara
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ElementoDePara $fkTcmgoElementoDePara
     */
    public function removeFkTcmgoElementoDeParas(\Urbem\CoreBundle\Entity\Tcmgo\ElementoDePara $fkTcmgoElementoDePara)
    {
        $this->fkTcmgoElementoDeParas->removeElement($fkTcmgoElementoDePara);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoElementoDeParas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ElementoDePara
     */
    public function getFkTcmgoElementoDeParas()
    {
        return $this->fkTcmgoElementoDeParas;
    }
}
