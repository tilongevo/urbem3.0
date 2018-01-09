<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TipoEventoPensao
 */
class TipoEventoPensao
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento
     */
    private $fkFolhapagamentoPensaoEventos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoPensaoEventos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoEventoPensao
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
     * @return TipoEventoPensao
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
     * Add FolhapagamentoPensaoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento $fkFolhapagamentoPensaoEvento
     * @return TipoEventoPensao
     */
    public function addFkFolhapagamentoPensaoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento $fkFolhapagamentoPensaoEvento)
    {
        if (false === $this->fkFolhapagamentoPensaoEventos->contains($fkFolhapagamentoPensaoEvento)) {
            $fkFolhapagamentoPensaoEvento->setFkFolhapagamentoTipoEventoPensao($this);
            $this->fkFolhapagamentoPensaoEventos->add($fkFolhapagamentoPensaoEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoPensaoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento $fkFolhapagamentoPensaoEvento
     */
    public function removeFkFolhapagamentoPensaoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento $fkFolhapagamentoPensaoEvento)
    {
        $this->fkFolhapagamentoPensaoEventos->removeElement($fkFolhapagamentoPensaoEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoPensaoEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento
     */
    public function getFkFolhapagamentoPensaoEventos()
    {
        return $this->fkFolhapagamentoPensaoEventos;
    }
}
