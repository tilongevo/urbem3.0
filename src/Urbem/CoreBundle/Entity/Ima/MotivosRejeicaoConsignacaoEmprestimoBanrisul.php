<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * MotivosRejeicaoConsignacaoEmprestimoBanrisul
 */
class MotivosRejeicaoConsignacaoEmprestimoBanrisul
{
    /**
     * PK
     * @var string
     */
    private $codMotivoRejeicao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisulErro
     */
    private $fkImaConsignacaoEmprestimoBanrisulErros;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaConsignacaoEmprestimoBanrisulErros = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codMotivoRejeicao
     *
     * @param string $codMotivoRejeicao
     * @return MotivosRejeicaoConsignacaoEmprestimoBanrisul
     */
    public function setCodMotivoRejeicao($codMotivoRejeicao)
    {
        $this->codMotivoRejeicao = $codMotivoRejeicao;
        return $this;
    }

    /**
     * Get codMotivoRejeicao
     *
     * @return string
     */
    public function getCodMotivoRejeicao()
    {
        return $this->codMotivoRejeicao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return MotivosRejeicaoConsignacaoEmprestimoBanrisul
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
     * Add ImaConsignacaoEmprestimoBanrisulErro
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisulErro $fkImaConsignacaoEmprestimoBanrisulErro
     * @return MotivosRejeicaoConsignacaoEmprestimoBanrisul
     */
    public function addFkImaConsignacaoEmprestimoBanrisulErros(\Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisulErro $fkImaConsignacaoEmprestimoBanrisulErro)
    {
        if (false === $this->fkImaConsignacaoEmprestimoBanrisulErros->contains($fkImaConsignacaoEmprestimoBanrisulErro)) {
            $fkImaConsignacaoEmprestimoBanrisulErro->setFkImaMotivosRejeicaoConsignacaoEmprestimoBanrisul($this);
            $this->fkImaConsignacaoEmprestimoBanrisulErros->add($fkImaConsignacaoEmprestimoBanrisulErro);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConsignacaoEmprestimoBanrisulErro
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisulErro $fkImaConsignacaoEmprestimoBanrisulErro
     */
    public function removeFkImaConsignacaoEmprestimoBanrisulErros(\Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisulErro $fkImaConsignacaoEmprestimoBanrisulErro)
    {
        $this->fkImaConsignacaoEmprestimoBanrisulErros->removeElement($fkImaConsignacaoEmprestimoBanrisulErro);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConsignacaoEmprestimoBanrisulErros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisulErro
     */
    public function getFkImaConsignacaoEmprestimoBanrisulErros()
    {
        return $this->fkImaConsignacaoEmprestimoBanrisulErros;
    }
}
