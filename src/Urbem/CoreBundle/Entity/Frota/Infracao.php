<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * Infracao
 */
class Infracao
{
    /**
     * PK
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $autoInfracao;

    /**
     * @var \DateTime
     */
    private $dataInfracao;

    /**
     * @var integer
     */
    private $codVeiculo;

    /**
     * @var integer
     */
    private $cgmMotorista;

    /**
     * @var integer
     */
    private $codInfracao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    private $fkFrotaVeiculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Motorista
     */
    private $fkFrotaMotorista;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\MotivoInfracao
     */
    private $fkFrotaMotivoInfracao;


    /**
     * Set id
     *
     * @param integer $id
     * @return Infracao
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set autoInfracao
     *
     * @param string $autoInfracao
     * @return Infracao
     */
    public function setAutoInfracao($autoInfracao)
    {
        $this->autoInfracao = $autoInfracao;
        return $this;
    }

    /**
     * Get autoInfracao
     *
     * @return string
     */
    public function getAutoInfracao()
    {
        return $this->autoInfracao;
    }

    /**
     * Set dataInfracao
     *
     * @param \DateTime $dataInfracao
     * @return Infracao
     */
    public function setDataInfracao(\DateTime $dataInfracao)
    {
        $this->dataInfracao = $dataInfracao;
        return $this;
    }

    /**
     * Get dataInfracao
     *
     * @return \DateTime
     */
    public function getDataInfracao()
    {
        return $this->dataInfracao;
    }

    /**
     * Set codVeiculo
     *
     * @param integer $codVeiculo
     * @return Infracao
     */
    public function setCodVeiculo($codVeiculo)
    {
        $this->codVeiculo = $codVeiculo;
        return $this;
    }

    /**
     * Get codVeiculo
     *
     * @return integer
     */
    public function getCodVeiculo()
    {
        return $this->codVeiculo;
    }

    /**
     * Set cgmMotorista
     *
     * @param integer $cgmMotorista
     * @return Infracao
     */
    public function setCgmMotorista($cgmMotorista)
    {
        $this->cgmMotorista = $cgmMotorista;
        return $this;
    }

    /**
     * Get cgmMotorista
     *
     * @return integer
     */
    public function getCgmMotorista()
    {
        return $this->cgmMotorista;
    }

    /**
     * Set codInfracao
     *
     * @param integer $codInfracao
     * @return Infracao
     */
    public function setCodInfracao($codInfracao)
    {
        $this->codInfracao = $codInfracao;
        return $this;
    }

    /**
     * Get codInfracao
     *
     * @return integer
     */
    public function getCodInfracao()
    {
        return $this->codInfracao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     * @return Infracao
     */
    public function setFkFrotaVeiculo(\Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo)
    {
        $this->codVeiculo = $fkFrotaVeiculo->getCodVeiculo();
        $this->fkFrotaVeiculo = $fkFrotaVeiculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaVeiculo
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    public function getFkFrotaVeiculo()
    {
        return $this->fkFrotaVeiculo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaMotorista
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Motorista $fkFrotaMotorista
     * @return Infracao
     */
    public function setFkFrotaMotorista(\Urbem\CoreBundle\Entity\Frota\Motorista $fkFrotaMotorista)
    {
        $this->cgmMotorista = $fkFrotaMotorista->getCgmMotorista();
        $this->fkFrotaMotorista = $fkFrotaMotorista;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaMotorista
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Motorista
     */
    public function getFkFrotaMotorista()
    {
        return $this->fkFrotaMotorista;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaMotivoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\MotivoInfracao $fkFrotaMotivoInfracao
     * @return Infracao
     */
    public function setFkFrotaMotivoInfracao(\Urbem\CoreBundle\Entity\Frota\MotivoInfracao $fkFrotaMotivoInfracao)
    {
        $this->codInfracao = $fkFrotaMotivoInfracao->getCodInfracao();
        $this->fkFrotaMotivoInfracao = $fkFrotaMotivoInfracao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaMotivoInfracao
     *
     * @return \Urbem\CoreBundle\Entity\Frota\MotivoInfracao
     */
    public function getFkFrotaMotivoInfracao()
    {
        return $this->fkFrotaMotivoInfracao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (is_object($this->getFkFrotaVeiculo())) {
            return sprintf(
                "%s - %s",
                $this->fkFrotaVeiculo,
                $this->dataInfracao->format('d/m/Y')
            );
        } else {
            return 'frota';
        }
    }
}
