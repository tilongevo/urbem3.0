<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * Obra
 */
class Obra
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numObra;

    /**
     * @var string
     */
    private $obra;

    /**
     * @var string
     */
    private $objetivo;

    /**
     * @var string
     */
    private $localizacao;

    /**
     * @var integer
     */
    private $codCidade;

    /**
     * @var integer
     */
    private $codRecurso1;

    /**
     * @var integer
     */
    private $codRecurso2;

    /**
     * @var integer
     */
    private $codRecurso3;

    /**
     * @var integer
     */
    private $valorRecurso1;

    /**
     * @var integer
     */
    private $valorRecurso2;

    /**
     * @var integer
     */
    private $valorRecurso3;

    /**
     * @var integer
     */
    private $valorOrcamentoBase;

    /**
     * @var string
     */
    private $projetoExistente;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $latitude;

    /**
     * @var integer
     */
    private $longitude;

    /**
     * @var integer
     */
    private $rdc;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ObraContrato
     */
    private $fkTcernObraContratos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcernObraContratos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Obra
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Obra
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
     * Set numObra
     *
     * @param integer $numObra
     * @return Obra
     */
    public function setNumObra($numObra)
    {
        $this->numObra = $numObra;
        return $this;
    }

    /**
     * Get numObra
     *
     * @return integer
     */
    public function getNumObra()
    {
        return $this->numObra;
    }

    /**
     * Set obra
     *
     * @param string $obra
     * @return Obra
     */
    public function setObra($obra)
    {
        $this->obra = $obra;
        return $this;
    }

    /**
     * Get obra
     *
     * @return string
     */
    public function getObra()
    {
        return $this->obra;
    }

    /**
     * Set objetivo
     *
     * @param string $objetivo
     * @return Obra
     */
    public function setObjetivo($objetivo)
    {
        $this->objetivo = $objetivo;
        return $this;
    }

    /**
     * Get objetivo
     *
     * @return string
     */
    public function getObjetivo()
    {
        return $this->objetivo;
    }

    /**
     * Set localizacao
     *
     * @param string $localizacao
     * @return Obra
     */
    public function setLocalizacao($localizacao)
    {
        $this->localizacao = $localizacao;
        return $this;
    }

    /**
     * Get localizacao
     *
     * @return string
     */
    public function getLocalizacao()
    {
        return $this->localizacao;
    }

    /**
     * Set codCidade
     *
     * @param integer $codCidade
     * @return Obra
     */
    public function setCodCidade($codCidade)
    {
        $this->codCidade = $codCidade;
        return $this;
    }

    /**
     * Get codCidade
     *
     * @return integer
     */
    public function getCodCidade()
    {
        return $this->codCidade;
    }

    /**
     * Set codRecurso1
     *
     * @param integer $codRecurso1
     * @return Obra
     */
    public function setCodRecurso1($codRecurso1 = null)
    {
        $this->codRecurso1 = $codRecurso1;
        return $this;
    }

    /**
     * Get codRecurso1
     *
     * @return integer
     */
    public function getCodRecurso1()
    {
        return $this->codRecurso1;
    }

    /**
     * Set codRecurso2
     *
     * @param integer $codRecurso2
     * @return Obra
     */
    public function setCodRecurso2($codRecurso2 = null)
    {
        $this->codRecurso2 = $codRecurso2;
        return $this;
    }

    /**
     * Get codRecurso2
     *
     * @return integer
     */
    public function getCodRecurso2()
    {
        return $this->codRecurso2;
    }

    /**
     * Set codRecurso3
     *
     * @param integer $codRecurso3
     * @return Obra
     */
    public function setCodRecurso3($codRecurso3 = null)
    {
        $this->codRecurso3 = $codRecurso3;
        return $this;
    }

    /**
     * Get codRecurso3
     *
     * @return integer
     */
    public function getCodRecurso3()
    {
        return $this->codRecurso3;
    }

    /**
     * Set valorRecurso1
     *
     * @param integer $valorRecurso1
     * @return Obra
     */
    public function setValorRecurso1($valorRecurso1 = null)
    {
        $this->valorRecurso1 = $valorRecurso1;
        return $this;
    }

    /**
     * Get valorRecurso1
     *
     * @return integer
     */
    public function getValorRecurso1()
    {
        return $this->valorRecurso1;
    }

    /**
     * Set valorRecurso2
     *
     * @param integer $valorRecurso2
     * @return Obra
     */
    public function setValorRecurso2($valorRecurso2 = null)
    {
        $this->valorRecurso2 = $valorRecurso2;
        return $this;
    }

    /**
     * Get valorRecurso2
     *
     * @return integer
     */
    public function getValorRecurso2()
    {
        return $this->valorRecurso2;
    }

    /**
     * Set valorRecurso3
     *
     * @param integer $valorRecurso3
     * @return Obra
     */
    public function setValorRecurso3($valorRecurso3 = null)
    {
        $this->valorRecurso3 = $valorRecurso3;
        return $this;
    }

    /**
     * Get valorRecurso3
     *
     * @return integer
     */
    public function getValorRecurso3()
    {
        return $this->valorRecurso3;
    }

    /**
     * Set valorOrcamentoBase
     *
     * @param integer $valorOrcamentoBase
     * @return Obra
     */
    public function setValorOrcamentoBase($valorOrcamentoBase)
    {
        $this->valorOrcamentoBase = $valorOrcamentoBase;
        return $this;
    }

    /**
     * Get valorOrcamentoBase
     *
     * @return integer
     */
    public function getValorOrcamentoBase()
    {
        return $this->valorOrcamentoBase;
    }

    /**
     * Set projetoExistente
     *
     * @param string $projetoExistente
     * @return Obra
     */
    public function setProjetoExistente($projetoExistente)
    {
        $this->projetoExistente = $projetoExistente;
        return $this;
    }

    /**
     * Get projetoExistente
     *
     * @return string
     */
    public function getProjetoExistente()
    {
        return $this->projetoExistente;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return Obra
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set latitude
     *
     * @param integer $latitude
     * @return Obra
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * Get latitude
     *
     * @return integer
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param integer $longitude
     * @return Obra
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Get longitude
     *
     * @return integer
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set rdc
     *
     * @param integer $rdc
     * @return Obra
     */
    public function setRdc($rdc)
    {
        $this->rdc = $rdc;
        return $this;
    }

    /**
     * Get rdc
     *
     * @return integer
     */
    public function getRdc()
    {
        return $this->rdc;
    }

    /**
     * OneToMany (owning side)
     * Add TcernObraContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ObraContrato $fkTcernObraContrato
     * @return Obra
     */
    public function addFkTcernObraContratos(\Urbem\CoreBundle\Entity\Tcern\ObraContrato $fkTcernObraContrato)
    {
        if (false === $this->fkTcernObraContratos->contains($fkTcernObraContrato)) {
            $fkTcernObraContrato->setFkTcernObra($this);
            $this->fkTcernObraContratos->add($fkTcernObraContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernObraContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ObraContrato $fkTcernObraContrato
     */
    public function removeFkTcernObraContratos(\Urbem\CoreBundle\Entity\Tcern\ObraContrato $fkTcernObraContrato)
    {
        $this->fkTcernObraContratos->removeElement($fkTcernObraContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernObraContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ObraContrato
     */
    public function getFkTcernObraContratos()
    {
        return $this->fkTcernObraContratos;
    }
}
