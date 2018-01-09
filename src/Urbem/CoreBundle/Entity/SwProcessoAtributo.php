<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwProcessoAtributo
 */
class SwProcessoAtributo
{
    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * @var boolean
     */
    private $indexavel;

    /**
     * @var boolean
     */
    private $leitura;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwAtributoProtocolo
     */
    private $fkSwAtributoProtocolo;


    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return SwProcessoAtributo
     */
    public function setCodAtributo($codAtributo)
    {
        $this->codAtributo = $codAtributo;
        return $this;
    }

    /**
     * Get codAtributo
     *
     * @return integer
     */
    public function getCodAtributo()
    {
        return $this->codAtributo;
    }

    /**
     * Set indexavel
     *
     * @param boolean $indexavel
     * @return SwProcessoAtributo
     */
    public function setIndexavel($indexavel = null)
    {
        $this->indexavel = $indexavel;
        return $this;
    }

    /**
     * Get indexavel
     *
     * @return boolean
     */
    public function getIndexavel()
    {
        return $this->indexavel;
    }

    /**
     * Set leitura
     *
     * @param boolean $leitura
     * @return SwProcessoAtributo
     */
    public function setLeitura($leitura = null)
    {
        $this->leitura = $leitura;
        return $this;
    }

    /**
     * Get leitura
     *
     * @return boolean
     */
    public function getLeitura()
    {
        return $this->leitura;
    }

    /**
     * OneToOne (owning side)
     * Set SwAtributoProtocolo
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoProtocolo $fkSwAtributoProtocolo
     * @return SwProcessoAtributo
     */
    public function setFkSwAtributoProtocolo(\Urbem\CoreBundle\Entity\SwAtributoProtocolo $fkSwAtributoProtocolo)
    {
        $this->codAtributo = $fkSwAtributoProtocolo->getCodAtributo();
        $this->fkSwAtributoProtocolo = $fkSwAtributoProtocolo;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwAtributoProtocolo
     *
     * @return \Urbem\CoreBundle\Entity\SwAtributoProtocolo
     */
    public function getFkSwAtributoProtocolo()
    {
        return $this->fkSwAtributoProtocolo;
    }
}
