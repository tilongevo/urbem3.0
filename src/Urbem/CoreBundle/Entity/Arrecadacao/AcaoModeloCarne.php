<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * AcaoModeloCarne
 */
class AcaoModeloCarne
{
    /**
     * PK
     * @var integer
     */
    private $codModelo;

    /**
     * PK
     * @var integer
     */
    private $codAcao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne
     */
    private $fkArrecadacaoModeloCarne;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Acao
     */
    private $fkAdministracaoAcao;


    /**
     * Set codModelo
     *
     * @param integer $codModelo
     * @return AcaoModeloCarne
     */
    public function setCodModelo($codModelo)
    {
        $this->codModelo = $codModelo;
        return $this;
    }

    /**
     * Get codModelo
     *
     * @return integer
     */
    public function getCodModelo()
    {
        return $this->codModelo;
    }

    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return AcaoModeloCarne
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
        return $this;
    }

    /**
     * Get codAcao
     *
     * @return integer
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoModeloCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne $fkArrecadacaoModeloCarne
     * @return AcaoModeloCarne
     */
    public function setFkArrecadacaoModeloCarne(\Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne $fkArrecadacaoModeloCarne)
    {
        $this->codModelo = $fkArrecadacaoModeloCarne->getCodModelo();
        $this->fkArrecadacaoModeloCarne = $fkArrecadacaoModeloCarne;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoModeloCarne
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne
     */
    public function getFkArrecadacaoModeloCarne()
    {
        return $this->fkArrecadacaoModeloCarne;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAcao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Acao $fkAdministracaoAcao
     * @return AcaoModeloCarne
     */
    public function setFkAdministracaoAcao(\Urbem\CoreBundle\Entity\Administracao\Acao $fkAdministracaoAcao)
    {
        $this->codAcao = $fkAdministracaoAcao->getCodAcao();
        $this->fkAdministracaoAcao = $fkAdministracaoAcao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoAcao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Acao
     */
    public function getFkAdministracaoAcao()
    {
        return $this->fkAdministracaoAcao;
    }
}
