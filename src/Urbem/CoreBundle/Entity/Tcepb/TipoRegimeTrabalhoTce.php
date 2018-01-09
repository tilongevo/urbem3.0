<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

/**
 * TipoRegimeTrabalhoTce
 */
class TipoRegimeTrabalhoTce
{
    /**
     * PK
     * @var integer
     */
    private $codTipoRegimeTrabalhoTce;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoRegimeTrabalho
     */
    private $fkPessoalDeParaTipoRegimeTrabalhos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalDeParaTipoRegimeTrabalhos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoRegimeTrabalhoTce
     *
     * @param integer $codTipoRegimeTrabalhoTce
     * @return TipoRegimeTrabalhoTce
     */
    public function setCodTipoRegimeTrabalhoTce($codTipoRegimeTrabalhoTce)
    {
        $this->codTipoRegimeTrabalhoTce = $codTipoRegimeTrabalhoTce;
        return $this;
    }

    /**
     * Get codTipoRegimeTrabalhoTce
     *
     * @return integer
     */
    public function getCodTipoRegimeTrabalhoTce()
    {
        return $this->codTipoRegimeTrabalhoTce;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoRegimeTrabalhoTce
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
     * Add PessoalDeParaTipoRegimeTrabalho
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaTipoRegimeTrabalho $fkPessoalDeParaTipoRegimeTrabalho
     * @return TipoRegimeTrabalhoTce
     */
    public function addFkPessoalDeParaTipoRegimeTrabalhos(\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoRegimeTrabalho $fkPessoalDeParaTipoRegimeTrabalho)
    {
        if (false === $this->fkPessoalDeParaTipoRegimeTrabalhos->contains($fkPessoalDeParaTipoRegimeTrabalho)) {
            $fkPessoalDeParaTipoRegimeTrabalho->setFkTcepbTipoRegimeTrabalhoTce($this);
            $this->fkPessoalDeParaTipoRegimeTrabalhos->add($fkPessoalDeParaTipoRegimeTrabalho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalDeParaTipoRegimeTrabalho
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaTipoRegimeTrabalho $fkPessoalDeParaTipoRegimeTrabalho
     */
    public function removeFkPessoalDeParaTipoRegimeTrabalhos(\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoRegimeTrabalho $fkPessoalDeParaTipoRegimeTrabalho)
    {
        $this->fkPessoalDeParaTipoRegimeTrabalhos->removeElement($fkPessoalDeParaTipoRegimeTrabalho);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalDeParaTipoRegimeTrabalhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoRegimeTrabalho
     */
    public function getFkPessoalDeParaTipoRegimeTrabalhos()
    {
        return $this->fkPessoalDeParaTipoRegimeTrabalhos;
    }
}
