<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * RespostaQuestao
 */
class RespostaQuestao
{
    /**
     * PK
     * @var integer
     */
    private $codQuestao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codCidadao;

    /**
     * PK
     * @var integer
     */
    private $codResposta;

    /**
     * @var string
     */
    private $resposta;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\QuestaoCenso
     */
    private $fkCseQuestaoCenso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    private $fkCseCidadao;


    /**
     * Set codQuestao
     *
     * @param integer $codQuestao
     * @return RespostaQuestao
     */
    public function setCodQuestao($codQuestao)
    {
        $this->codQuestao = $codQuestao;
        return $this;
    }

    /**
     * Get codQuestao
     *
     * @return integer
     */
    public function getCodQuestao()
    {
        return $this->codQuestao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return RespostaQuestao
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
     * Set codCidadao
     *
     * @param integer $codCidadao
     * @return RespostaQuestao
     */
    public function setCodCidadao($codCidadao)
    {
        $this->codCidadao = $codCidadao;
        return $this;
    }

    /**
     * Get codCidadao
     *
     * @return integer
     */
    public function getCodCidadao()
    {
        return $this->codCidadao;
    }

    /**
     * Set codResposta
     *
     * @param integer $codResposta
     * @return RespostaQuestao
     */
    public function setCodResposta($codResposta)
    {
        $this->codResposta = $codResposta;
        return $this;
    }

    /**
     * Get codResposta
     *
     * @return integer
     */
    public function getCodResposta()
    {
        return $this->codResposta;
    }

    /**
     * Set resposta
     *
     * @param string $resposta
     * @return RespostaQuestao
     */
    public function setResposta($resposta)
    {
        $this->resposta = $resposta;
        return $this;
    }

    /**
     * Get resposta
     *
     * @return string
     */
    public function getResposta()
    {
        return $this->resposta;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseQuestaoCenso
     *
     * @param \Urbem\CoreBundle\Entity\Cse\QuestaoCenso $fkCseQuestaoCenso
     * @return RespostaQuestao
     */
    public function setFkCseQuestaoCenso(\Urbem\CoreBundle\Entity\Cse\QuestaoCenso $fkCseQuestaoCenso)
    {
        $this->codQuestao = $fkCseQuestaoCenso->getCodQuestao();
        $this->exercicio = $fkCseQuestaoCenso->getExercicio();
        $this->fkCseQuestaoCenso = $fkCseQuestaoCenso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseQuestaoCenso
     *
     * @return \Urbem\CoreBundle\Entity\Cse\QuestaoCenso
     */
    public function getFkCseQuestaoCenso()
    {
        return $this->fkCseQuestaoCenso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     * @return RespostaQuestao
     */
    public function setFkCseCidadao(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        $this->codCidadao = $fkCseCidadao->getCodCidadao();
        $this->fkCseCidadao = $fkCseCidadao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseCidadao
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    public function getFkCseCidadao()
    {
        return $this->fkCseCidadao;
    }
}
