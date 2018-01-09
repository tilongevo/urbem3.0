<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * RequisicaoAnulacao
 */
class RequisicaoAnulacao
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codRequisicao;

    /**
     * PK
     * @var integer
     */
    private $codAlmoxarifado;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItensAnulacao
     */
    private $fkAlmoxarifadoRequisicaoItensAnulacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Requisicao
     */
    private $fkAlmoxarifadoRequisicao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoRequisicaoItensAnulacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return RequisicaoAnulacao
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
     * Set codRequisicao
     *
     * @param integer $codRequisicao
     * @return RequisicaoAnulacao
     */
    public function setCodRequisicao($codRequisicao)
    {
        $this->codRequisicao = $codRequisicao;
        return $this;
    }

    /**
     * Get codRequisicao
     *
     * @return integer
     */
    public function getCodRequisicao()
    {
        return $this->codRequisicao;
    }

    /**
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return RequisicaoAnulacao
     */
    public function setCodAlmoxarifado($codAlmoxarifado)
    {
        $this->codAlmoxarifado = $codAlmoxarifado;
        return $this;
    }

    /**
     * Get codAlmoxarifado
     *
     * @return integer
     */
    public function getCodAlmoxarifado()
    {
        return $this->codAlmoxarifado;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return RequisicaoAnulacao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return RequisicaoAnulacao
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoRequisicaoItensAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItensAnulacao $fkAlmoxarifadoRequisicaoItensAnulacao
     * @return RequisicaoAnulacao
     */
    public function addFkAlmoxarifadoRequisicaoItensAnulacoes(\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItensAnulacao $fkAlmoxarifadoRequisicaoItensAnulacao)
    {
        if (false === $this->fkAlmoxarifadoRequisicaoItensAnulacoes->contains($fkAlmoxarifadoRequisicaoItensAnulacao)) {
            $fkAlmoxarifadoRequisicaoItensAnulacao->setFkAlmoxarifadoRequisicaoAnulacao($this);
            $this->fkAlmoxarifadoRequisicaoItensAnulacoes->add($fkAlmoxarifadoRequisicaoItensAnulacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoRequisicaoItensAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItensAnulacao $fkAlmoxarifadoRequisicaoItensAnulacao
     */
    public function removeFkAlmoxarifadoRequisicaoItensAnulacoes(\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItensAnulacao $fkAlmoxarifadoRequisicaoItensAnulacao)
    {
        $this->fkAlmoxarifadoRequisicaoItensAnulacoes->removeElement($fkAlmoxarifadoRequisicaoItensAnulacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoRequisicaoItensAnulacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItensAnulacao
     */
    public function getFkAlmoxarifadoRequisicaoItensAnulacoes()
    {
        return $this->fkAlmoxarifadoRequisicaoItensAnulacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoRequisicao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao
     * @return RequisicaoAnulacao
     */
    public function setFkAlmoxarifadoRequisicao(\Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao)
    {
        $this->exercicio = $fkAlmoxarifadoRequisicao->getExercicio();
        $this->codRequisicao = $fkAlmoxarifadoRequisicao->getCodRequisicao();
        $this->codAlmoxarifado = $fkAlmoxarifadoRequisicao->getCodAlmoxarifado();
        $this->fkAlmoxarifadoRequisicao = $fkAlmoxarifadoRequisicao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoRequisicao
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Requisicao
     */
    public function getFkAlmoxarifadoRequisicao()
    {
        return $this->fkAlmoxarifadoRequisicao;
    }
}
