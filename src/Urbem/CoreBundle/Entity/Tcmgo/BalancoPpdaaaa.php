<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * BalancoPpdaaaa
 */
class BalancoPpdaaaa
{
    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $tipoLancamento;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\GrupoPlanoAnaliticaLei
     */
    private $fkTcmgoGrupoPlanoAnaliticaLeis;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoGrupoPlanoAnaliticaLeis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return BalancoPpdaaaa
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return BalancoPpdaaaa
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set tipoLancamento
     *
     * @param integer $tipoLancamento
     * @return BalancoPpdaaaa
     */
    public function setTipoLancamento($tipoLancamento)
    {
        $this->tipoLancamento = $tipoLancamento;
        return $this;
    }

    /**
     * Get tipoLancamento
     *
     * @return integer
     */
    public function getTipoLancamento()
    {
        return $this->tipoLancamento;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoGrupoPlanoAnaliticaLei
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\GrupoPlanoAnaliticaLei $fkTcmgoGrupoPlanoAnaliticaLei
     * @return BalancoPpdaaaa
     */
    public function addFkTcmgoGrupoPlanoAnaliticaLeis(\Urbem\CoreBundle\Entity\Tcmgo\GrupoPlanoAnaliticaLei $fkTcmgoGrupoPlanoAnaliticaLei)
    {
        if (false === $this->fkTcmgoGrupoPlanoAnaliticaLeis->contains($fkTcmgoGrupoPlanoAnaliticaLei)) {
            $fkTcmgoGrupoPlanoAnaliticaLei->setFkTcmgoBalancoPpdaaaa($this);
            $this->fkTcmgoGrupoPlanoAnaliticaLeis->add($fkTcmgoGrupoPlanoAnaliticaLei);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoGrupoPlanoAnaliticaLei
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\GrupoPlanoAnaliticaLei $fkTcmgoGrupoPlanoAnaliticaLei
     */
    public function removeFkTcmgoGrupoPlanoAnaliticaLeis(\Urbem\CoreBundle\Entity\Tcmgo\GrupoPlanoAnaliticaLei $fkTcmgoGrupoPlanoAnaliticaLei)
    {
        $this->fkTcmgoGrupoPlanoAnaliticaLeis->removeElement($fkTcmgoGrupoPlanoAnaliticaLei);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoGrupoPlanoAnaliticaLeis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\GrupoPlanoAnaliticaLei
     */
    public function getFkTcmgoGrupoPlanoAnaliticaLeis()
    {
        return $this->fkTcmgoGrupoPlanoAnaliticaLeis;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return BalancoPpdaaaa
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlano = $fkContabilidadePlanoAnalitica->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica->getExercicio();
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }
}
