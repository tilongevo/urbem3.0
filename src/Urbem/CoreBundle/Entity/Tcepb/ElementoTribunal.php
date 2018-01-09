<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

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
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\ElementoDePara
     */
    private $fkTcepbElementoDeParas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepbElementoDeParas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ElementoTribunal
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ElementoTribunal
     */
    public function setDescricao($descricao = null)
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
     * Add TcepbElementoDePara
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\ElementoDePara $fkTcepbElementoDePara
     * @return ElementoTribunal
     */
    public function addFkTcepbElementoDeParas(\Urbem\CoreBundle\Entity\Tcepb\ElementoDePara $fkTcepbElementoDePara)
    {
        if (false === $this->fkTcepbElementoDeParas->contains($fkTcepbElementoDePara)) {
            $fkTcepbElementoDePara->setFkTcepbElementoTribunal($this);
            $this->fkTcepbElementoDeParas->add($fkTcepbElementoDePara);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepbElementoDePara
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\ElementoDePara $fkTcepbElementoDePara
     */
    public function removeFkTcepbElementoDeParas(\Urbem\CoreBundle\Entity\Tcepb\ElementoDePara $fkTcepbElementoDePara)
    {
        $this->fkTcepbElementoDeParas->removeElement($fkTcepbElementoDePara);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepbElementoDeParas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\ElementoDePara
     */
    public function getFkTcepbElementoDeParas()
    {
        return $this->fkTcepbElementoDeParas;
    }
}
