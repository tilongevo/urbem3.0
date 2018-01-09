<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * TipoRegimeTrabalho
 */
class TipoRegimeTrabalho
{
    /**
     * PK
     * @var integer
     */
    private $codTipoRegime;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\VinculoRegimeSubdivisao
     */
    private $fkPessoalVinculoRegimeSubdivisoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalVinculoRegimeSubdivisoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoRegime
     *
     * @param integer $codTipoRegime
     * @return TipoRegimeTrabalho
     */
    public function setCodTipoRegime($codTipoRegime)
    {
        $this->codTipoRegime = $codTipoRegime;
        return $this;
    }

    /**
     * Get codTipoRegime
     *
     * @return integer
     */
    public function getCodTipoRegime()
    {
        return $this->codTipoRegime;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoRegimeTrabalho
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
     * Add PessoalVinculoRegimeSubdivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\VinculoRegimeSubdivisao $fkPessoalVinculoRegimeSubdivisao
     * @return TipoRegimeTrabalho
     */
    public function addFkPessoalVinculoRegimeSubdivisoes(\Urbem\CoreBundle\Entity\Pessoal\VinculoRegimeSubdivisao $fkPessoalVinculoRegimeSubdivisao)
    {
        if (false === $this->fkPessoalVinculoRegimeSubdivisoes->contains($fkPessoalVinculoRegimeSubdivisao)) {
            $fkPessoalVinculoRegimeSubdivisao->setFkTcepeTipoRegimeTrabalho($this);
            $this->fkPessoalVinculoRegimeSubdivisoes->add($fkPessoalVinculoRegimeSubdivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalVinculoRegimeSubdivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\VinculoRegimeSubdivisao $fkPessoalVinculoRegimeSubdivisao
     */
    public function removeFkPessoalVinculoRegimeSubdivisoes(\Urbem\CoreBundle\Entity\Pessoal\VinculoRegimeSubdivisao $fkPessoalVinculoRegimeSubdivisao)
    {
        $this->fkPessoalVinculoRegimeSubdivisoes->removeElement($fkPessoalVinculoRegimeSubdivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalVinculoRegimeSubdivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\VinculoRegimeSubdivisao
     */
    public function getFkPessoalVinculoRegimeSubdivisoes()
    {
        return $this->fkPessoalVinculoRegimeSubdivisoes;
    }
}
