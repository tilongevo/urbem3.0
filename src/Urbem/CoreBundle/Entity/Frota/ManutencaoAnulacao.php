<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * ManutencaoAnulacao
 */
class ManutencaoAnulacao
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
    private $codManutencao;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $observacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Frota\Manutencao
     */
    private $fkFrotaManutencao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ManutencaoAnulacao
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
     * Set codManutencao
     *
     * @param integer $codManutencao
     * @return ManutencaoAnulacao
     */
    public function setCodManutencao($codManutencao)
    {
        $this->codManutencao = $codManutencao;
        return $this;
    }

    /**
     * Get codManutencao
     *
     * @return integer
     */
    public function getCodManutencao()
    {
        return $this->codManutencao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ManutencaoAnulacao
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
     * Set observacao
     *
     * @param string $observacao
     * @return ManutencaoAnulacao
     */
    public function setObservacao($observacao = null)
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
     * OneToOne (owning side)
     * Set FrotaManutencao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Manutencao $fkFrotaManutencao
     * @return ManutencaoAnulacao
     */
    public function setFkFrotaManutencao(\Urbem\CoreBundle\Entity\Frota\Manutencao $fkFrotaManutencao)
    {
        $this->codManutencao = $fkFrotaManutencao->getCodManutencao();
        $this->exercicio = $fkFrotaManutencao->getExercicio();
        $this->fkFrotaManutencao = $fkFrotaManutencao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFrotaManutencao
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Manutencao
     */
    public function getFkFrotaManutencao()
    {
        return $this->fkFrotaManutencao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Anulação '.$this->getFkFrotaManutencao();
    }
}
