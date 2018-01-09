<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoRegimeTce
 */
class TipoRegimeTce
{
    /**
     * PK
     * @var integer
     */
    private $codTipoRegimeTce;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargoTcmba
     */
    private $fkPessoalDeParaTipoCargoTcmbas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalDeParaTipoCargoTcmbas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoRegimeTce
     *
     * @param integer $codTipoRegimeTce
     * @return TipoRegimeTce
     */
    public function setCodTipoRegimeTce($codTipoRegimeTce)
    {
        $this->codTipoRegimeTce = $codTipoRegimeTce;
        return $this;
    }

    /**
     * Get codTipoRegimeTce
     *
     * @return integer
     */
    public function getCodTipoRegimeTce()
    {
        return $this->codTipoRegimeTce;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoRegimeTce
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
     * Add PessoalDeParaTipoCargoTcmba
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargoTcmba $fkPessoalDeParaTipoCargoTcmba
     * @return TipoRegimeTce
     */
    public function addFkPessoalDeParaTipoCargoTcmbas(\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargoTcmba $fkPessoalDeParaTipoCargoTcmba)
    {
        if (false === $this->fkPessoalDeParaTipoCargoTcmbas->contains($fkPessoalDeParaTipoCargoTcmba)) {
            $fkPessoalDeParaTipoCargoTcmba->setFkTcmbaTipoRegimeTce($this);
            $this->fkPessoalDeParaTipoCargoTcmbas->add($fkPessoalDeParaTipoCargoTcmba);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalDeParaTipoCargoTcmba
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargoTcmba $fkPessoalDeParaTipoCargoTcmba
     */
    public function removeFkPessoalDeParaTipoCargoTcmbas(\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargoTcmba $fkPessoalDeParaTipoCargoTcmba)
    {
        $this->fkPessoalDeParaTipoCargoTcmbas->removeElement($fkPessoalDeParaTipoCargoTcmba);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalDeParaTipoCargoTcmbas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargoTcmba
     */
    public function getFkPessoalDeParaTipoCargoTcmbas()
    {
        return $this->fkPessoalDeParaTipoCargoTcmbas;
    }
}
