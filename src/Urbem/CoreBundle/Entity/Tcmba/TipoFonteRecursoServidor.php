<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoFonteRecursoServidor
 */
class TipoFonteRecursoServidor
{
    /**
     * PK
     * @var integer
     */
    private $codTipoFonte;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal
     */
    private $fkTcmbaFonteRecursoLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao
     */
    private $fkTcmbaFonteRecursoLotacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmbaFonteRecursoLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaFonteRecursoLotacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoFonte
     *
     * @param integer $codTipoFonte
     * @return TipoFonteRecursoServidor
     */
    public function setCodTipoFonte($codTipoFonte)
    {
        $this->codTipoFonte = $codTipoFonte;
        return $this;
    }

    /**
     * Get codTipoFonte
     *
     * @return integer
     */
    public function getCodTipoFonte()
    {
        return $this->codTipoFonte;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoFonteRecursoServidor
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
     * Add TcmbaFonteRecursoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal $fkTcmbaFonteRecursoLocal
     * @return TipoFonteRecursoServidor
     */
    public function addFkTcmbaFonteRecursoLocais(\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal $fkTcmbaFonteRecursoLocal)
    {
        if (false === $this->fkTcmbaFonteRecursoLocais->contains($fkTcmbaFonteRecursoLocal)) {
            $fkTcmbaFonteRecursoLocal->setFkTcmbaTipoFonteRecursoServidor($this);
            $this->fkTcmbaFonteRecursoLocais->add($fkTcmbaFonteRecursoLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaFonteRecursoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal $fkTcmbaFonteRecursoLocal
     */
    public function removeFkTcmbaFonteRecursoLocais(\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal $fkTcmbaFonteRecursoLocal)
    {
        $this->fkTcmbaFonteRecursoLocais->removeElement($fkTcmbaFonteRecursoLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaFonteRecursoLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal
     */
    public function getFkTcmbaFonteRecursoLocais()
    {
        return $this->fkTcmbaFonteRecursoLocais;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaFonteRecursoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao $fkTcmbaFonteRecursoLotacao
     * @return TipoFonteRecursoServidor
     */
    public function addFkTcmbaFonteRecursoLotacoes(\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao $fkTcmbaFonteRecursoLotacao)
    {
        if (false === $this->fkTcmbaFonteRecursoLotacoes->contains($fkTcmbaFonteRecursoLotacao)) {
            $fkTcmbaFonteRecursoLotacao->setFkTcmbaTipoFonteRecursoServidor($this);
            $this->fkTcmbaFonteRecursoLotacoes->add($fkTcmbaFonteRecursoLotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaFonteRecursoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao $fkTcmbaFonteRecursoLotacao
     */
    public function removeFkTcmbaFonteRecursoLotacoes(\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao $fkTcmbaFonteRecursoLotacao)
    {
        $this->fkTcmbaFonteRecursoLotacoes->removeElement($fkTcmbaFonteRecursoLotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaFonteRecursoLotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao
     */
    public function getFkTcmbaFonteRecursoLotacoes()
    {
        return $this->fkTcmbaFonteRecursoLotacoes;
    }
}
