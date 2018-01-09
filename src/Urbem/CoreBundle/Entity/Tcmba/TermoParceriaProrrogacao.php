<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TermoParceriaProrrogacao
 */
class TermoParceriaProrrogacao
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
     * @var string
     */
    private $nroProcesso;

    /**
     * PK
     * @var string
     */
    private $nroTermoAditivo;

    /**
     * PK
     * @var string
     */
    private $exercicioAditivo;

    /**
     * @var \DateTime
     */
    private $dtProrrogacao;

    /**
     * @var \DateTime
     */
    private $dtPublicacao;

    /**
     * @var string
     */
    private $imprensaOficial;

    /**
     * @var boolean
     */
    private $indicadorAdimplemento = false;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * @var integer
     */
    private $vlProrrogacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\TermoParceria
     */
    private $fkTcmbaTermoParceria;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TermoParceriaProrrogacao
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
     * @return TermoParceriaProrrogacao
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
     * Set nroProcesso
     *
     * @param string $nroProcesso
     * @return TermoParceriaProrrogacao
     */
    public function setNroProcesso($nroProcesso)
    {
        $this->nroProcesso = $nroProcesso;
        return $this;
    }

    /**
     * Get nroProcesso
     *
     * @return string
     */
    public function getNroProcesso()
    {
        return $this->nroProcesso;
    }

    /**
     * Set nroTermoAditivo
     *
     * @param string $nroTermoAditivo
     * @return TermoParceriaProrrogacao
     */
    public function setNroTermoAditivo($nroTermoAditivo)
    {
        $this->nroTermoAditivo = $nroTermoAditivo;
        return $this;
    }

    /**
     * Get nroTermoAditivo
     *
     * @return string
     */
    public function getNroTermoAditivo()
    {
        return $this->nroTermoAditivo;
    }

    /**
     * Set exercicioAditivo
     *
     * @param string $exercicioAditivo
     * @return TermoParceriaProrrogacao
     */
    public function setExercicioAditivo($exercicioAditivo)
    {
        $this->exercicioAditivo = $exercicioAditivo;
        return $this;
    }

    /**
     * Get exercicioAditivo
     *
     * @return string
     */
    public function getExercicioAditivo()
    {
        return $this->exercicioAditivo;
    }

    /**
     * Set dtProrrogacao
     *
     * @param \DateTime $dtProrrogacao
     * @return TermoParceriaProrrogacao
     */
    public function setDtProrrogacao(\DateTime $dtProrrogacao)
    {
        $this->dtProrrogacao = $dtProrrogacao;
        return $this;
    }

    /**
     * Get dtProrrogacao
     *
     * @return \DateTime
     */
    public function getDtProrrogacao()
    {
        return $this->dtProrrogacao;
    }

    /**
     * Set dtPublicacao
     *
     * @param \DateTime $dtPublicacao
     * @return TermoParceriaProrrogacao
     */
    public function setDtPublicacao(\DateTime $dtPublicacao)
    {
        $this->dtPublicacao = $dtPublicacao;
        return $this;
    }

    /**
     * Get dtPublicacao
     *
     * @return \DateTime
     */
    public function getDtPublicacao()
    {
        return $this->dtPublicacao;
    }

    /**
     * Set imprensaOficial
     *
     * @param string $imprensaOficial
     * @return TermoParceriaProrrogacao
     */
    public function setImprensaOficial($imprensaOficial)
    {
        $this->imprensaOficial = $imprensaOficial;
        return $this;
    }

    /**
     * Get imprensaOficial
     *
     * @return string
     */
    public function getImprensaOficial()
    {
        return $this->imprensaOficial;
    }

    /**
     * Set indicadorAdimplemento
     *
     * @param boolean $indicadorAdimplemento
     * @return TermoParceriaProrrogacao
     */
    public function setIndicadorAdimplemento($indicadorAdimplemento)
    {
        $this->indicadorAdimplemento = $indicadorAdimplemento;
        return $this;
    }

    /**
     * Get indicadorAdimplemento
     *
     * @return boolean
     */
    public function getIndicadorAdimplemento()
    {
        return $this->indicadorAdimplemento;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return TermoParceriaProrrogacao
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtTermino
     *
     * @param \DateTime $dtTermino
     * @return TermoParceriaProrrogacao
     */
    public function setDtTermino(\DateTime $dtTermino)
    {
        $this->dtTermino = $dtTermino;
        return $this;
    }

    /**
     * Get dtTermino
     *
     * @return \DateTime
     */
    public function getDtTermino()
    {
        return $this->dtTermino;
    }

    /**
     * Set vlProrrogacao
     *
     * @param integer $vlProrrogacao
     * @return TermoParceriaProrrogacao
     */
    public function setVlProrrogacao($vlProrrogacao)
    {
        $this->vlProrrogacao = $vlProrrogacao;
        return $this;
    }

    /**
     * Get vlProrrogacao
     *
     * @return integer
     */
    public function getVlProrrogacao()
    {
        return $this->vlProrrogacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmbaTermoParceria
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TermoParceria $fkTcmbaTermoParceria
     * @return TermoParceriaProrrogacao
     */
    public function setFkTcmbaTermoParceria(\Urbem\CoreBundle\Entity\Tcmba\TermoParceria $fkTcmbaTermoParceria)
    {
        $this->exercicio = $fkTcmbaTermoParceria->getExercicio();
        $this->codEntidade = $fkTcmbaTermoParceria->getCodEntidade();
        $this->nroProcesso = $fkTcmbaTermoParceria->getNroProcesso();
        $this->fkTcmbaTermoParceria = $fkTcmbaTermoParceria;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaTermoParceria
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TermoParceria
     */
    public function getFkTcmbaTermoParceria()
    {
        return $this->fkTcmbaTermoParceria;
    }
}
