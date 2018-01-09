<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * GrupoPlanoAnaliticaLei
 */
class GrupoPlanoAnaliticaLei
{
    /**
     * PK
     * @var integer
     */
    private $nroLei;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dataLei;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\BalancoPpdaaaa
     */
    private $fkTcmgoBalancoPpdaaaa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dataLei = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set nroLei
     *
     * @param integer $nroLei
     * @return GrupoPlanoAnaliticaLei
     */
    public function setNroLei($nroLei)
    {
        $this->nroLei = $nroLei;
        return $this;
    }

    /**
     * Get nroLei
     *
     * @return integer
     */
    public function getNroLei()
    {
        return $this->nroLei;
    }

    /**
     * Set dataLei
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dataLei
     * @return GrupoPlanoAnaliticaLei
     */
    public function setDataLei(\Urbem\CoreBundle\Helper\DatePK $dataLei)
    {
        $this->dataLei = $dataLei;
        return $this;
    }

    /**
     * Get dataLei
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDataLei()
    {
        return $this->dataLei;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return GrupoPlanoAnaliticaLei
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
     * Set codPlano
     *
     * @param integer $codPlano
     * @return GrupoPlanoAnaliticaLei
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
     * ManyToOne (inverse side)
     * Set fkTcmgoBalancoPpdaaaa
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\BalancoPpdaaaa $fkTcmgoBalancoPpdaaaa
     * @return GrupoPlanoAnaliticaLei
     */
    public function setFkTcmgoBalancoPpdaaaa(\Urbem\CoreBundle\Entity\Tcmgo\BalancoPpdaaaa $fkTcmgoBalancoPpdaaaa)
    {
        $this->codPlano = $fkTcmgoBalancoPpdaaaa->getCodPlano();
        $this->exercicio = $fkTcmgoBalancoPpdaaaa->getExercicio();
        $this->fkTcmgoBalancoPpdaaaa = $fkTcmgoBalancoPpdaaaa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoBalancoPpdaaaa
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\BalancoPpdaaaa
     */
    public function getFkTcmgoBalancoPpdaaaa()
    {
        return $this->fkTcmgoBalancoPpdaaaa;
    }
}
