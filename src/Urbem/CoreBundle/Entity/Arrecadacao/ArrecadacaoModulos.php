<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * ArrecadacaoModulos
 */
class ArrecadacaoModulos
{
    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    private $fkAdministracaoModulo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito
     */
    private $fkArrecadacaoGrupoCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversao
     */
    private $fkArrecadacaoTabelaConversoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoGrupoCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoTabelaConversoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return ArrecadacaoModulos
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoGrupoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito $fkArrecadacaoGrupoCredito
     * @return ArrecadacaoModulos
     */
    public function addFkArrecadacaoGrupoCreditos(\Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito $fkArrecadacaoGrupoCredito)
    {
        if (false === $this->fkArrecadacaoGrupoCreditos->contains($fkArrecadacaoGrupoCredito)) {
            $fkArrecadacaoGrupoCredito->setFkArrecadacaoArrecadacaoModulos($this);
            $this->fkArrecadacaoGrupoCreditos->add($fkArrecadacaoGrupoCredito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoGrupoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito $fkArrecadacaoGrupoCredito
     */
    public function removeFkArrecadacaoGrupoCreditos(\Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito $fkArrecadacaoGrupoCredito)
    {
        $this->fkArrecadacaoGrupoCreditos->removeElement($fkArrecadacaoGrupoCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoGrupoCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito
     */
    public function getFkArrecadacaoGrupoCreditos()
    {
        return $this->fkArrecadacaoGrupoCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoTabelaConversao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversao $fkArrecadacaoTabelaConversao
     * @return ArrecadacaoModulos
     */
    public function addFkArrecadacaoTabelaConversoes(\Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversao $fkArrecadacaoTabelaConversao)
    {
        if (false === $this->fkArrecadacaoTabelaConversoes->contains($fkArrecadacaoTabelaConversao)) {
            $fkArrecadacaoTabelaConversao->setFkArrecadacaoArrecadacaoModulos($this);
            $this->fkArrecadacaoTabelaConversoes->add($fkArrecadacaoTabelaConversao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoTabelaConversao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversao $fkArrecadacaoTabelaConversao
     */
    public function removeFkArrecadacaoTabelaConversoes(\Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversao $fkArrecadacaoTabelaConversao)
    {
        $this->fkArrecadacaoTabelaConversoes->removeElement($fkArrecadacaoTabelaConversao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoTabelaConversoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversao
     */
    public function getFkArrecadacaoTabelaConversoes()
    {
        return $this->fkArrecadacaoTabelaConversoes;
    }

    /**
     * OneToOne (owning side)
     * Set AdministracaoModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo
     * @return ArrecadacaoModulos
     */
    public function setFkAdministracaoModulo(\Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo)
    {
        $this->codModulo = $fkAdministracaoModulo->getCodModulo();
        $this->fkAdministracaoModulo = $fkAdministracaoModulo;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkAdministracaoModulo
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    public function getFkAdministracaoModulo()
    {
        return $this->fkAdministracaoModulo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->fkAdministracaoModulo->getNomModulo();
    }
}
