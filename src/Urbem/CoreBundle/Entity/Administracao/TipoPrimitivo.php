<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * TipoPrimitivo
 */
class TipoPrimitivo
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    private $fkAdministracaoFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Variavel
     */
    private $fkAdministracaoVariaveis;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoVariaveis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoPrimitivo
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return TipoPrimitivo
     */
    public function setNomTipo($nomTipo = null)
    {
        $this->nomTipo = $nomTipo;
        return $this;
    }

    /**
     * Get nomTipo
     *
     * @return string
     */
    public function getNomTipo()
    {
        return $this->nomTipo;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return TipoPrimitivo
     */
    public function addFkAdministracaoFuncoes(\Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao)
    {
        if (false === $this->fkAdministracaoFuncoes->contains($fkAdministracaoFuncao)) {
            $fkAdministracaoFuncao->setFkAdministracaoTipoPrimitivo($this);
            $this->fkAdministracaoFuncoes->add($fkAdministracaoFuncao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     */
    public function removeFkAdministracaoFuncoes(\Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao)
    {
        $this->fkAdministracaoFuncoes->removeElement($fkAdministracaoFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    public function getFkAdministracaoFuncoes()
    {
        return $this->fkAdministracaoFuncoes;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoVariavel
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Variavel $fkAdministracaoVariavel
     * @return TipoPrimitivo
     */
    public function addFkAdministracaoVariaveis(\Urbem\CoreBundle\Entity\Administracao\Variavel $fkAdministracaoVariavel)
    {
        if (false === $this->fkAdministracaoVariaveis->contains($fkAdministracaoVariavel)) {
            $fkAdministracaoVariavel->setFkAdministracaoTipoPrimitivo($this);
            $this->fkAdministracaoVariaveis->add($fkAdministracaoVariavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoVariavel
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Variavel $fkAdministracaoVariavel
     */
    public function removeFkAdministracaoVariaveis(\Urbem\CoreBundle\Entity\Administracao\Variavel $fkAdministracaoVariavel)
    {
        $this->fkAdministracaoVariaveis->removeElement($fkAdministracaoVariavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoVariaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Variavel
     */
    public function getFkAdministracaoVariaveis()
    {
        return $this->fkAdministracaoVariaveis;
    }
}
