<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * TipoDeficiencia
 */
class TipoDeficiencia
{
    /**
     * PK
     * @var integer
     */
    private $codTipoDeficiencia;

    /**
     * @var integer
     */
    private $numDeficiencia;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Cid
     */
    private $fkPessoalCids;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalCids = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoDeficiencia
     *
     * @param integer $codTipoDeficiencia
     * @return TipoDeficiencia
     */
    public function setCodTipoDeficiencia($codTipoDeficiencia)
    {
        $this->codTipoDeficiencia = $codTipoDeficiencia;
        return $this;
    }

    /**
     * Get codTipoDeficiencia
     *
     * @return integer
     */
    public function getCodTipoDeficiencia()
    {
        return $this->codTipoDeficiencia;
    }

    /**
     * Set numDeficiencia
     *
     * @param integer $numDeficiencia
     * @return TipoDeficiencia
     */
    public function setNumDeficiencia($numDeficiencia)
    {
        $this->numDeficiencia = $numDeficiencia;
        return $this;
    }

    /**
     * Get numDeficiencia
     *
     * @return integer
     */
    public function getNumDeficiencia()
    {
        return $this->numDeficiencia;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoDeficiencia
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
     * Add PessoalCid
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cid $fkPessoalCid
     * @return TipoDeficiencia
     */
    public function addFkPessoalCids(\Urbem\CoreBundle\Entity\Pessoal\Cid $fkPessoalCid)
    {
        if (false === $this->fkPessoalCids->contains($fkPessoalCid)) {
            $fkPessoalCid->setFkPessoalTipoDeficiencia($this);
            $this->fkPessoalCids->add($fkPessoalCid);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCid
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cid $fkPessoalCid
     */
    public function removeFkPessoalCids(\Urbem\CoreBundle\Entity\Pessoal\Cid $fkPessoalCid)
    {
        $this->fkPessoalCids->removeElement($fkPessoalCid);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCids
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Cid
     */
    public function getFkPessoalCids()
    {
        return $this->fkPessoalCids;
    }
}
