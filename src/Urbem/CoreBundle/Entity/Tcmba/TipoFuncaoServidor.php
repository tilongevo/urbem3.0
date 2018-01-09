<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoFuncaoServidor
 */
class TipoFuncaoServidor
{
    /**
     * PK
     * @var integer
     */
    private $codTipoFuncao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor
     */
    private $fkFolhapagamentoTcmbaCargoServidores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoTcmbaCargoServidores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoFuncao
     *
     * @param integer $codTipoFuncao
     * @return TipoFuncaoServidor
     */
    public function setCodTipoFuncao($codTipoFuncao)
    {
        $this->codTipoFuncao = $codTipoFuncao;
        return $this;
    }

    /**
     * Get codTipoFuncao
     *
     * @return integer
     */
    public function getCodTipoFuncao()
    {
        return $this->codTipoFuncao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoFuncaoServidor
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
     * Add FolhapagamentoTcmbaCargoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor $fkFolhapagamentoTcmbaCargoServidor
     * @return TipoFuncaoServidor
     */
    public function addFkFolhapagamentoTcmbaCargoServidores(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor $fkFolhapagamentoTcmbaCargoServidor)
    {
        if (false === $this->fkFolhapagamentoTcmbaCargoServidores->contains($fkFolhapagamentoTcmbaCargoServidor)) {
            $fkFolhapagamentoTcmbaCargoServidor->setFkTcmbaTipoFuncaoServidor($this);
            $this->fkFolhapagamentoTcmbaCargoServidores->add($fkFolhapagamentoTcmbaCargoServidor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaCargoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor $fkFolhapagamentoTcmbaCargoServidor
     */
    public function removeFkFolhapagamentoTcmbaCargoServidores(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor $fkFolhapagamentoTcmbaCargoServidor)
    {
        $this->fkFolhapagamentoTcmbaCargoServidores->removeElement($fkFolhapagamentoTcmbaCargoServidor);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaCargoServidores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor
     */
    public function getFkFolhapagamentoTcmbaCargoServidores()
    {
        return $this->fkFolhapagamentoTcmbaCargoServidores;
    }
}
