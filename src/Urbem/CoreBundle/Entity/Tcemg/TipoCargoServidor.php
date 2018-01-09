<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * TipoCargoServidor
 */
class TipoCargoServidor
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeCargoServidor
     */
    private $fkFolhapagamentoTcemgEntidadeCargoServidores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoTcemgEntidadeCargoServidores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoCargoServidor
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoCargoServidor
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
     * Add FolhapagamentoTcemgEntidadeCargoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeCargoServidor $fkFolhapagamentoTcemgEntidadeCargoServidor
     * @return TipoCargoServidor
     */
    public function addFkFolhapagamentoTcemgEntidadeCargoServidores(\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeCargoServidor $fkFolhapagamentoTcemgEntidadeCargoServidor)
    {
        if (false === $this->fkFolhapagamentoTcemgEntidadeCargoServidores->contains($fkFolhapagamentoTcemgEntidadeCargoServidor)) {
            $fkFolhapagamentoTcemgEntidadeCargoServidor->setFkTcemgTipoCargoServidor($this);
            $this->fkFolhapagamentoTcemgEntidadeCargoServidores->add($fkFolhapagamentoTcemgEntidadeCargoServidor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcemgEntidadeCargoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeCargoServidor $fkFolhapagamentoTcemgEntidadeCargoServidor
     */
    public function removeFkFolhapagamentoTcemgEntidadeCargoServidores(\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeCargoServidor $fkFolhapagamentoTcemgEntidadeCargoServidor)
    {
        $this->fkFolhapagamentoTcemgEntidadeCargoServidores->removeElement($fkFolhapagamentoTcemgEntidadeCargoServidor);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcemgEntidadeCargoServidores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeCargoServidor
     */
    public function getFkFolhapagamentoTcemgEntidadeCargoServidores()
    {
        return $this->fkFolhapagamentoTcemgEntidadeCargoServidores;
    }
}
