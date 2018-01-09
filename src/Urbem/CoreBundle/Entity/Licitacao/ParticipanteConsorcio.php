<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ParticipanteConsorcio
 */
class ParticipanteConsorcio
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
    private $codModalidade;

    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * PK
     * @var integer
     */
    private $codLicitacao;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Participante
     */
    private $fkLicitacaoParticipante;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ParticipanteConsorcio
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
     * @return ParticipanteConsorcio
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
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ParticipanteConsorcio
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return ParticipanteConsorcio
     */
    public function setCgmFornecedor($cgmFornecedor)
    {
        $this->cgmFornecedor = $cgmFornecedor;
        return $this;
    }

    /**
     * Get cgmFornecedor
     *
     * @return integer
     */
    public function getCgmFornecedor()
    {
        return $this->cgmFornecedor;
    }

    /**
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return ParticipanteConsorcio
     */
    public function setCodLicitacao($codLicitacao)
    {
        $this->codLicitacao = $codLicitacao;
        return $this;
    }

    /**
     * Get codLicitacao
     *
     * @return integer
     */
    public function getCodLicitacao()
    {
        return $this->codLicitacao;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ParticipanteConsorcio
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoParticipante
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Participante $fkLicitacaoParticipante
     * @return ParticipanteConsorcio
     */
    public function setFkLicitacaoParticipante(\Urbem\CoreBundle\Entity\Licitacao\Participante $fkLicitacaoParticipante)
    {
        $this->codLicitacao = $fkLicitacaoParticipante->getCodLicitacao();
        $this->cgmFornecedor = $fkLicitacaoParticipante->getCgmFornecedor();
        $this->codModalidade = $fkLicitacaoParticipante->getCodModalidade();
        $this->codEntidade = $fkLicitacaoParticipante->getCodEntidade();
        $this->exercicio = $fkLicitacaoParticipante->getExercicio();
        $this->fkLicitacaoParticipante = $fkLicitacaoParticipante;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoParticipante
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Participante
     */
    public function getFkLicitacaoParticipante()
    {
        return $this->fkLicitacaoParticipante;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ParticipanteConsorcio
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }
}
