<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * ContratoAditivo
 */
class ContratoAditivo
{
    /**
     * PK
     * @var integer
     */
    private $numConvenio;

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
    private $numContratoAditivo;

    /**
     * PK
     * @var string
     */
    private $exercicioAditivo;

    /**
     * @var integer
     */
    private $codProcesso;

    /**
     * @var string
     */
    private $exercicioProcesso;

    /**
     * @var integer
     */
    private $bimestre;

    /**
     * @var integer
     */
    private $codObjeto;

    /**
     * @var integer
     */
    private $valorAditivo;

    /**
     * @var \DateTime
     */
    private $dtInicioVigencia;

    /**
     * @var \DateTime
     */
    private $dtTerminoVigencia;

    /**
     * @var \DateTime
     */
    private $dtAssinatura;

    /**
     * @var \DateTime
     */
    private $dtPublicacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcern\Convenio
     */
    private $fkTcernConvenio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Objeto
     */
    private $fkComprasObjeto;


    /**
     * Set numConvenio
     *
     * @param integer $numConvenio
     * @return ContratoAditivo
     */
    public function setNumConvenio($numConvenio)
    {
        $this->numConvenio = $numConvenio;
        return $this;
    }

    /**
     * Get numConvenio
     *
     * @return integer
     */
    public function getNumConvenio()
    {
        return $this->numConvenio;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ContratoAditivo
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
     * @return ContratoAditivo
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
     * Set numContratoAditivo
     *
     * @param integer $numContratoAditivo
     * @return ContratoAditivo
     */
    public function setNumContratoAditivo($numContratoAditivo)
    {
        $this->numContratoAditivo = $numContratoAditivo;
        return $this;
    }

    /**
     * Get numContratoAditivo
     *
     * @return integer
     */
    public function getNumContratoAditivo()
    {
        return $this->numContratoAditivo;
    }

    /**
     * Set exercicioAditivo
     *
     * @param string $exercicioAditivo
     * @return ContratoAditivo
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
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return ContratoAditivo
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set exercicioProcesso
     *
     * @param string $exercicioProcesso
     * @return ContratoAditivo
     */
    public function setExercicioProcesso($exercicioProcesso)
    {
        $this->exercicioProcesso = $exercicioProcesso;
        return $this;
    }

    /**
     * Get exercicioProcesso
     *
     * @return string
     */
    public function getExercicioProcesso()
    {
        return $this->exercicioProcesso;
    }

    /**
     * Set bimestre
     *
     * @param integer $bimestre
     * @return ContratoAditivo
     */
    public function setBimestre($bimestre)
    {
        $this->bimestre = $bimestre;
        return $this;
    }

    /**
     * Get bimestre
     *
     * @return integer
     */
    public function getBimestre()
    {
        return $this->bimestre;
    }

    /**
     * Set codObjeto
     *
     * @param integer $codObjeto
     * @return ContratoAditivo
     */
    public function setCodObjeto($codObjeto)
    {
        $this->codObjeto = $codObjeto;
        return $this;
    }

    /**
     * Get codObjeto
     *
     * @return integer
     */
    public function getCodObjeto()
    {
        return $this->codObjeto;
    }

    /**
     * Set valorAditivo
     *
     * @param integer $valorAditivo
     * @return ContratoAditivo
     */
    public function setValorAditivo($valorAditivo)
    {
        $this->valorAditivo = $valorAditivo;
        return $this;
    }

    /**
     * Get valorAditivo
     *
     * @return integer
     */
    public function getValorAditivo()
    {
        return $this->valorAditivo;
    }

    /**
     * Set dtInicioVigencia
     *
     * @param \DateTime $dtInicioVigencia
     * @return ContratoAditivo
     */
    public function setDtInicioVigencia(\DateTime $dtInicioVigencia)
    {
        $this->dtInicioVigencia = $dtInicioVigencia;
        return $this;
    }

    /**
     * Get dtInicioVigencia
     *
     * @return \DateTime
     */
    public function getDtInicioVigencia()
    {
        return $this->dtInicioVigencia;
    }

    /**
     * Set dtTerminoVigencia
     *
     * @param \DateTime $dtTerminoVigencia
     * @return ContratoAditivo
     */
    public function setDtTerminoVigencia(\DateTime $dtTerminoVigencia)
    {
        $this->dtTerminoVigencia = $dtTerminoVigencia;
        return $this;
    }

    /**
     * Get dtTerminoVigencia
     *
     * @return \DateTime
     */
    public function getDtTerminoVigencia()
    {
        return $this->dtTerminoVigencia;
    }

    /**
     * Set dtAssinatura
     *
     * @param \DateTime $dtAssinatura
     * @return ContratoAditivo
     */
    public function setDtAssinatura(\DateTime $dtAssinatura)
    {
        $this->dtAssinatura = $dtAssinatura;
        return $this;
    }

    /**
     * Get dtAssinatura
     *
     * @return \DateTime
     */
    public function getDtAssinatura()
    {
        return $this->dtAssinatura;
    }

    /**
     * Set dtPublicacao
     *
     * @param \DateTime $dtPublicacao
     * @return ContratoAditivo
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
     * ManyToOne (inverse side)
     * Set fkTcernConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\Convenio $fkTcernConvenio
     * @return ContratoAditivo
     */
    public function setFkTcernConvenio(\Urbem\CoreBundle\Entity\Tcern\Convenio $fkTcernConvenio)
    {
        $this->codEntidade = $fkTcernConvenio->getCodEntidade();
        $this->exercicio = $fkTcernConvenio->getExercicio();
        $this->numConvenio = $fkTcernConvenio->getNumConvenio();
        $this->fkTcernConvenio = $fkTcernConvenio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcernConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\Convenio
     */
    public function getFkTcernConvenio()
    {
        return $this->fkTcernConvenio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return ContratoAditivo
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->exercicioProcesso = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasObjeto
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Objeto $fkComprasObjeto
     * @return ContratoAditivo
     */
    public function setFkComprasObjeto(\Urbem\CoreBundle\Entity\Compras\Objeto $fkComprasObjeto)
    {
        $this->codObjeto = $fkComprasObjeto->getCodObjeto();
        $this->fkComprasObjeto = $fkComprasObjeto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasObjeto
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Objeto
     */
    public function getFkComprasObjeto()
    {
        return $this->fkComprasObjeto;
    }
}
