<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * TipoSuspensao
 */
class TipoSuspensao
{
    /**
     * PK
     * @var integer
     */
    private $codTipoSuspensao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var boolean
     */
    private $emitir;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Suspensao
     */
    private $fkArrecadacaoSuspensoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoSuspensoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoSuspensao
     *
     * @param integer $codTipoSuspensao
     * @return TipoSuspensao
     */
    public function setCodTipoSuspensao($codTipoSuspensao)
    {
        $this->codTipoSuspensao = $codTipoSuspensao;
        return $this;
    }

    /**
     * Get codTipoSuspensao
     *
     * @return integer
     */
    public function getCodTipoSuspensao()
    {
        return $this->codTipoSuspensao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoSuspensao
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
     * Set emitir
     *
     * @param boolean $emitir
     * @return TipoSuspensao
     */
    public function setEmitir($emitir)
    {
        $this->emitir = $emitir;
        return $this;
    }

    /**
     * Get emitir
     *
     * @return boolean
     */
    public function getEmitir()
    {
        return $this->emitir;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoSuspensao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Suspensao $fkArrecadacaoSuspensao
     * @return TipoSuspensao
     */
    public function addFkArrecadacaoSuspensoes(\Urbem\CoreBundle\Entity\Arrecadacao\Suspensao $fkArrecadacaoSuspensao)
    {
        if (false === $this->fkArrecadacaoSuspensoes->contains($fkArrecadacaoSuspensao)) {
            $fkArrecadacaoSuspensao->setFkArrecadacaoTipoSuspensao($this);
            $this->fkArrecadacaoSuspensoes->add($fkArrecadacaoSuspensao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoSuspensao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Suspensao $fkArrecadacaoSuspensao
     */
    public function removeFkArrecadacaoSuspensoes(\Urbem\CoreBundle\Entity\Arrecadacao\Suspensao $fkArrecadacaoSuspensao)
    {
        $this->fkArrecadacaoSuspensoes->removeElement($fkArrecadacaoSuspensao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoSuspensoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Suspensao
     */
    public function getFkArrecadacaoSuspensoes()
    {
        return $this->fkArrecadacaoSuspensoes;
    }
}
