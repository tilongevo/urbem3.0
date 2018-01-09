<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * TipoVinculo
 */
class TipoVinculo
{
    /**
     * PK
     * @var integer
     */
    private $codTipoVinculo;

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
     * Set codTipoVinculo
     *
     * @param integer $codTipoVinculo
     * @return TipoVinculo
     */
    public function setCodTipoVinculo($codTipoVinculo)
    {
        $this->codTipoVinculo = $codTipoVinculo;
        return $this;
    }

    /**
     * Get codTipoVinculo
     *
     * @return integer
     */
    public function getCodTipoVinculo()
    {
        return $this->codTipoVinculo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoVinculo
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
     * @return TipoVinculo
     */
    public function addFkPessoalVinculoRegimeSubdivisoes(\Urbem\CoreBundle\Entity\Pessoal\VinculoRegimeSubdivisao $fkPessoalVinculoRegimeSubdivisao)
    {
        if (false === $this->fkPessoalVinculoRegimeSubdivisoes->contains($fkPessoalVinculoRegimeSubdivisao)) {
            $fkPessoalVinculoRegimeSubdivisao->setFkTcepeTipoVinculo($this);
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
