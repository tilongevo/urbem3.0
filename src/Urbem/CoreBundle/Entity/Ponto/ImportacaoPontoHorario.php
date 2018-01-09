<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * ImportacaoPontoHorario
 */
class ImportacaoPontoHorario
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var integer
     */
    private $codPonto;

    /**
     * PK
     * @var integer
     */
    private $codImportacao;

    /**
     * PK
     * @var integer
     */
    private $codHora;

    /**
     * @var \DateTime
     */
    private $horario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\ImportacaoPonto
     */
    private $fkPontoImportacaoPonto;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ImportacaoPontoHorario
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set codPonto
     *
     * @param integer $codPonto
     * @return ImportacaoPontoHorario
     */
    public function setCodPonto($codPonto)
    {
        $this->codPonto = $codPonto;
        return $this;
    }

    /**
     * Get codPonto
     *
     * @return integer
     */
    public function getCodPonto()
    {
        return $this->codPonto;
    }

    /**
     * Set codImportacao
     *
     * @param integer $codImportacao
     * @return ImportacaoPontoHorario
     */
    public function setCodImportacao($codImportacao)
    {
        $this->codImportacao = $codImportacao;
        return $this;
    }

    /**
     * Get codImportacao
     *
     * @return integer
     */
    public function getCodImportacao()
    {
        return $this->codImportacao;
    }

    /**
     * Set codHora
     *
     * @param integer $codHora
     * @return ImportacaoPontoHorario
     */
    public function setCodHora($codHora)
    {
        $this->codHora = $codHora;
        return $this;
    }

    /**
     * Get codHora
     *
     * @return integer
     */
    public function getCodHora()
    {
        return $this->codHora;
    }

    /**
     * Set horario
     *
     * @param \DateTime $horario
     * @return ImportacaoPontoHorario
     */
    public function setHorario(\DateTime $horario)
    {
        $this->horario = $horario;
        return $this;
    }

    /**
     * Get horario
     *
     * @return \DateTime
     */
    public function getHorario()
    {
        return $this->horario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoImportacaoPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ImportacaoPonto $fkPontoImportacaoPonto
     * @return ImportacaoPontoHorario
     */
    public function setFkPontoImportacaoPonto(\Urbem\CoreBundle\Entity\Ponto\ImportacaoPonto $fkPontoImportacaoPonto)
    {
        $this->codPonto = $fkPontoImportacaoPonto->getCodPonto();
        $this->codContrato = $fkPontoImportacaoPonto->getCodContrato();
        $this->codImportacao = $fkPontoImportacaoPonto->getCodImportacao();
        $this->fkPontoImportacaoPonto = $fkPontoImportacaoPonto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoImportacaoPonto
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\ImportacaoPonto
     */
    public function getFkPontoImportacaoPonto()
    {
        return $this->fkPontoImportacaoPonto;
    }
}
