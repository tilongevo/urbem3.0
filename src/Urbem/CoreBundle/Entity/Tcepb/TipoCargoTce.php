<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargo
     */
    private $fkPessoalDeParaTipoCargos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ArquivoCargos
     */
    private $fkPessoalArquivoCargos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalDeParaTipoCargos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalArquivoCargos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add PessoalDeParaTipoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargo $fkPessoalDeParaTipoCargo
     * @return TipoCargoTce
     */
    public function addFkPessoalDeParaTipoCargos(\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargo $fkPessoalDeParaTipoCargo)
    {
        if (false === $this->fkPessoalDeParaTipoCargos->contains($fkPessoalDeParaTipoCargo)) {
            $fkPessoalDeParaTipoCargo->setFkTcepbTipoCargoTce($this);
            $this->fkPessoalDeParaTipoCargos->add($fkPessoalDeParaTipoCargo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalDeParaTipoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargo $fkPessoalDeParaTipoCargo
     */
    public function removeFkPessoalDeParaTipoCargos(\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargo $fkPessoalDeParaTipoCargo)
    {
        $this->fkPessoalDeParaTipoCargos->removeElement($fkPessoalDeParaTipoCargo);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalDeParaTipoCargos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargo
     */
    public function getFkPessoalDeParaTipoCargos()
    {
        return $this->fkPessoalDeParaTipoCargos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalArquivoCargos
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ArquivoCargos $fkPessoalArquivoCargos
     * @return TipoCargoTce
     */
    public function addFkPessoalArquivoCargos(\Urbem\CoreBundle\Entity\Pessoal\ArquivoCargos $fkPessoalArquivoCargos)
    {
        if (false === $this->fkPessoalArquivoCargos->contains($fkPessoalArquivoCargos)) {
            $fkPessoalArquivoCargos->setFkTcepbTipoCargoTce($this);
            $this->fkPessoalArquivoCargos->add($fkPessoalArquivoCargos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalArquivoCargos
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ArquivoCargos $fkPessoalArquivoCargos
     */
    public function removeFkPessoalArquivoCargos(\Urbem\CoreBundle\Entity\Pessoal\ArquivoCargos $fkPessoalArquivoCargos)
    {
        $this->fkPessoalArquivoCargos->removeElement($fkPessoalArquivoCargos);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalArquivoCargos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ArquivoCargos
     */
    public function getFkPessoalArquivoCargos()
    {
        return $this->fkPessoalArquivoCargos;
    }
}
