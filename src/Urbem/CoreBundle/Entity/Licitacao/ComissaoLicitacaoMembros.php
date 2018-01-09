<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ComissaoLicitacaoMembros
 */
class ComissaoLicitacaoMembros
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
    private $codLicitacao;

    /**
     * PK
     * @var integer
     */
    private $codComissao;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao
     */
    private $fkLicitacaoComissaoLicitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros
     */
    private $fkLicitacaoComissaoMembros;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ComissaoLicitacaoMembros
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
     * @return ComissaoLicitacaoMembros
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
     * @return ComissaoLicitacaoMembros
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
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return ComissaoLicitacaoMembros
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
     * Set codComissao
     *
     * @param integer $codComissao
     * @return ComissaoLicitacaoMembros
     */
    public function setCodComissao($codComissao)
    {
        $this->codComissao = $codComissao;
        return $this;
    }

    /**
     * Get codComissao
     *
     * @return integer
     */
    public function getCodComissao()
    {
        return $this->codComissao;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ComissaoLicitacaoMembros
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
     * Set codNorma
     *
     * @param integer $codNorma
     * @return ComissaoLicitacaoMembros
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoComissaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao $fkLicitacaoComissaoLicitacao
     * @return ComissaoLicitacaoMembros
     */
    public function setFkLicitacaoComissaoLicitacao(\Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao $fkLicitacaoComissaoLicitacao)
    {
        $this->exercicio = $fkLicitacaoComissaoLicitacao->getExercicio();
        $this->codEntidade = $fkLicitacaoComissaoLicitacao->getCodEntidade();
        $this->codModalidade = $fkLicitacaoComissaoLicitacao->getCodModalidade();
        $this->codLicitacao = $fkLicitacaoComissaoLicitacao->getCodLicitacao();
        $this->codComissao = $fkLicitacaoComissaoLicitacao->getCodComissao();
        $this->fkLicitacaoComissaoLicitacao = $fkLicitacaoComissaoLicitacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoComissaoLicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao
     */
    public function getFkLicitacaoComissaoLicitacao()
    {
        return $this->fkLicitacaoComissaoLicitacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoComissaoMembros
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros
     * @return ComissaoLicitacaoMembros
     */
    public function setFkLicitacaoComissaoMembros(\Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros)
    {
        $this->codComissao = $fkLicitacaoComissaoMembros->getCodComissao();
        $this->numcgm = $fkLicitacaoComissaoMembros->getNumcgm();
        $this->codNorma = $fkLicitacaoComissaoMembros->getCodNorma();
        $this->fkLicitacaoComissaoMembros = $fkLicitacaoComissaoMembros;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoComissaoMembros
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros
     */
    public function getFkLicitacaoComissaoMembros()
    {
        return $this->fkLicitacaoComissaoMembros;
    }
}
