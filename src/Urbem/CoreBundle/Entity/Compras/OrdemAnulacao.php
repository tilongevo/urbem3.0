<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * OrdemAnulacao
 */
class OrdemAnulacao
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
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codOrdem;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var string
     */
    private $tipo = 'C';

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\OrdemItemAnulacao
     */
    private $fkComprasOrdemItemAnulacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Ordem
     */
    private $fkComprasOrdem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasOrdemItemAnulacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return OrdemAnulacao
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return OrdemAnulacao
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
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return OrdemAnulacao
     */
    public function setCodOrdem($codOrdem)
    {
        $this->codOrdem = $codOrdem;
        return $this;
    }

    /**
     * Get codOrdem
     *
     * @return integer
     */
    public function getCodOrdem()
    {
        return $this->codOrdem;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return OrdemAnulacao
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
     * Set tipo
     *
     * @param string $tipo
     * @return OrdemAnulacao
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return OrdemAnulacao
     */
    public function setMotivo($motivo = null)
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
     * Add ComprasOrdemItemAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\OrdemItemAnulacao $fkComprasOrdemItemAnulacao
     * @return OrdemAnulacao
     */
    public function addFkComprasOrdemItemAnulacoes(\Urbem\CoreBundle\Entity\Compras\OrdemItemAnulacao $fkComprasOrdemItemAnulacao)
    {
        if (false === $this->fkComprasOrdemItemAnulacoes->contains($fkComprasOrdemItemAnulacao)) {
            $fkComprasOrdemItemAnulacao->setFkComprasOrdemAnulacao($this);
            $this->fkComprasOrdemItemAnulacoes->add($fkComprasOrdemItemAnulacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasOrdemItemAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\OrdemItemAnulacao $fkComprasOrdemItemAnulacao
     */
    public function removeFkComprasOrdemItemAnulacoes(\Urbem\CoreBundle\Entity\Compras\OrdemItemAnulacao $fkComprasOrdemItemAnulacao)
    {
        $this->fkComprasOrdemItemAnulacoes->removeElement($fkComprasOrdemItemAnulacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasOrdemItemAnulacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\OrdemItemAnulacao
     */
    public function getFkComprasOrdemItemAnulacoes()
    {
        return $this->fkComprasOrdemItemAnulacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasOrdem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Ordem $fkComprasOrdem
     * @return OrdemAnulacao
     */
    public function setFkComprasOrdem(\Urbem\CoreBundle\Entity\Compras\Ordem $fkComprasOrdem)
    {
        $this->exercicio = $fkComprasOrdem->getExercicio();
        $this->codEntidade = $fkComprasOrdem->getCodEntidade();
        $this->codOrdem = $fkComprasOrdem->getCodOrdem();
        $this->tipo = $fkComprasOrdem->getTipo();
        $this->fkComprasOrdem = $fkComprasOrdem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasOrdem
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Ordem
     */
    public function getFkComprasOrdem()
    {
        return $this->fkComprasOrdem;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('Anulação Ordem %s', $this->fkComprasOrdem);
    }
}
