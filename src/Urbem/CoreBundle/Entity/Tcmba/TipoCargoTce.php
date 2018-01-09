<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoCargoTce
 */
class TipoCargoTce
{
    /**
     * PK
     * @var integer
     */
    private $codTipoCargoTce;

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
     * Set codTipoCargoTce
     *
     * @param integer $codTipoCargoTce
     * @return TipoCargoTce
     */
    public function setCodTipoCargoTce($codTipoCargoTce)
    {
        $this->codTipoCargoTce = $codTipoCargoTce;
        return $this;
    }

    /**
     * Get codTipoCargoTce
     *
     * @return integer
     */
    public function getCodTipoCargoTce()
    {
        return $this->codTipoCargoTce;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoCargoTce
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
     * @return TipoCargoTce
     */
    public function addFkPessoalDeParaTipoCargoTcmbas(\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargoTcmba $fkPessoalDeParaTipoCargoTcmba)
    {
        if (false === $this->fkPessoalDeParaTipoCargoTcmbas->contains($fkPessoalDeParaTipoCargoTcmba)) {
            $fkPessoalDeParaTipoCargoTcmba->setFkTcmbaTipoCargoTce($this);
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
