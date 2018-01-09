<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * TipoRequisitosCargo
 */
class TipoRequisitosCargo
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRequisitosCargo
     */
    private $fkFolhapagamentoTcemgEntidadeRequisitosCargos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoTcemgEntidadeRequisitosCargos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoRequisitosCargo
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
     * @return TipoRequisitosCargo
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
     * Add FolhapagamentoTcemgEntidadeRequisitosCargo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRequisitosCargo $fkFolhapagamentoTcemgEntidadeRequisitosCargo
     * @return TipoRequisitosCargo
     */
    public function addFkFolhapagamentoTcemgEntidadeRequisitosCargos(\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRequisitosCargo $fkFolhapagamentoTcemgEntidadeRequisitosCargo)
    {
        if (false === $this->fkFolhapagamentoTcemgEntidadeRequisitosCargos->contains($fkFolhapagamentoTcemgEntidadeRequisitosCargo)) {
            $fkFolhapagamentoTcemgEntidadeRequisitosCargo->setFkTcemgTipoRequisitosCargo($this);
            $this->fkFolhapagamentoTcemgEntidadeRequisitosCargos->add($fkFolhapagamentoTcemgEntidadeRequisitosCargo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcemgEntidadeRequisitosCargo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRequisitosCargo $fkFolhapagamentoTcemgEntidadeRequisitosCargo
     */
    public function removeFkFolhapagamentoTcemgEntidadeRequisitosCargos(\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRequisitosCargo $fkFolhapagamentoTcemgEntidadeRequisitosCargo)
    {
        $this->fkFolhapagamentoTcemgEntidadeRequisitosCargos->removeElement($fkFolhapagamentoTcemgEntidadeRequisitosCargo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcemgEntidadeRequisitosCargos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRequisitosCargo
     */
    public function getFkFolhapagamentoTcemgEntidadeRequisitosCargos()
    {
        return $this->fkFolhapagamentoTcemgEntidadeRequisitosCargos;
    }
}
