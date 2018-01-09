<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoVinculado
 */
class AssentamentoVinculado
{
    /**
     * PK
     * @var integer
     */
    private $codCondicao;

    /**
     * PK
     * @var integer
     */
    private $codAssentamento;

    /**
     * PK
     * @var integer
     */
    private $codAssentamentoAssentamento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var string
     */
    private $condicao;

    /**
     * PK
     * @var integer
     */
    private $diasIncidencia;

    /**
     * PK
     * @var integer
     */
    private $diasProtelarAverbar;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculadoFuncao
     */
    private $fkPessoalAssentamentoVinculadoFuncoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento
     */
    private $fkPessoalCondicaoAssentamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    private $fkPessoalAssentamentoAssentamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalAssentamentoVinculadoFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codCondicao
     *
     * @param integer $codCondicao
     * @return AssentamentoVinculado
     */
    public function setCodCondicao($codCondicao)
    {
        $this->codCondicao = $codCondicao;
        return $this;
    }

    /**
     * Get codCondicao
     *
     * @return integer
     */
    public function getCodCondicao()
    {
        return $this->codCondicao;
    }

    /**
     * Set codAssentamento
     *
     * @param integer $codAssentamento
     * @return AssentamentoVinculado
     */
    public function setCodAssentamento($codAssentamento)
    {
        $this->codAssentamento = $codAssentamento;
        return $this;
    }

    /**
     * Get codAssentamento
     *
     * @return integer
     */
    public function getCodAssentamento()
    {
        return $this->codAssentamento;
    }

    /**
     * Set codAssentamentoAssentamento
     *
     * @param integer $codAssentamentoAssentamento
     * @return AssentamentoVinculado
     */
    public function setCodAssentamentoAssentamento($codAssentamentoAssentamento)
    {
        $this->codAssentamentoAssentamento = $codAssentamentoAssentamento;
        return $this;
    }

    /**
     * Get codAssentamentoAssentamento
     *
     * @return integer
     */
    public function getCodAssentamentoAssentamento()
    {
        return $this->codAssentamentoAssentamento;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AssentamentoVinculado
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
     * Set condicao
     *
     * @param string $condicao
     * @return AssentamentoVinculado
     */
    public function setCondicao($condicao)
    {
        $this->condicao = $condicao;
        return $this;
    }

    /**
     * Get condicao
     *
     * @return string
     */
    public function getCondicao()
    {
        return $this->condicao;
    }

    /**
     * Set diasIncidencia
     *
     * @param integer $diasIncidencia
     * @return AssentamentoVinculado
     */
    public function setDiasIncidencia($diasIncidencia)
    {
        $this->diasIncidencia = $diasIncidencia;
        return $this;
    }

    /**
     * Get diasIncidencia
     *
     * @return integer
     */
    public function getDiasIncidencia()
    {
        return $this->diasIncidencia;
    }

    /**
     * Set diasProtelarAverbar
     *
     * @param integer $diasProtelarAverbar
     * @return AssentamentoVinculado
     */
    public function setDiasProtelarAverbar($diasProtelarAverbar)
    {
        $this->diasProtelarAverbar = $diasProtelarAverbar;
        return $this;
    }

    /**
     * Get diasProtelarAverbar
     *
     * @return integer
     */
    public function getDiasProtelarAverbar()
    {
        return $this->diasProtelarAverbar;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoVinculadoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculadoFuncao $fkPessoalAssentamentoVinculadoFuncao
     * @return AssentamentoVinculado
     */
    public function addFkPessoalAssentamentoVinculadoFuncoes(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculadoFuncao $fkPessoalAssentamentoVinculadoFuncao)
    {
        if (false === $this->fkPessoalAssentamentoVinculadoFuncoes->contains($fkPessoalAssentamentoVinculadoFuncao)) {
            $fkPessoalAssentamentoVinculadoFuncao->setFkPessoalAssentamentoVinculado($this);
            $this->fkPessoalAssentamentoVinculadoFuncoes->add($fkPessoalAssentamentoVinculadoFuncao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoVinculadoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculadoFuncao $fkPessoalAssentamentoVinculadoFuncao
     */
    public function removeFkPessoalAssentamentoVinculadoFuncoes(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculadoFuncao $fkPessoalAssentamentoVinculadoFuncao)
    {
        $this->fkPessoalAssentamentoVinculadoFuncoes->removeElement($fkPessoalAssentamentoVinculadoFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoVinculadoFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculadoFuncao
     */
    public function getFkPessoalAssentamentoVinculadoFuncoes()
    {
        return $this->fkPessoalAssentamentoVinculadoFuncoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCondicaoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento $fkPessoalCondicaoAssentamento
     * @return AssentamentoVinculado
     */
    public function setFkPessoalCondicaoAssentamento(\Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento $fkPessoalCondicaoAssentamento)
    {
        $this->codCondicao = $fkPessoalCondicaoAssentamento->getCodCondicao();
        $this->timestamp = $fkPessoalCondicaoAssentamento->getTimestamp();
        $this->codAssentamento = $fkPessoalCondicaoAssentamento->getCodAssentamento();
        $this->fkPessoalCondicaoAssentamento = $fkPessoalCondicaoAssentamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCondicaoAssentamento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento
     */
    public function getFkPessoalCondicaoAssentamento()
    {
        return $this->fkPessoalCondicaoAssentamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalAssentamentoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento
     * @return AssentamentoVinculado
     */
    public function setFkPessoalAssentamentoAssentamento(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento)
    {
        $this->codAssentamentoAssentamento = $fkPessoalAssentamentoAssentamento->getCodAssentamento();
        $this->fkPessoalAssentamentoAssentamento = $fkPessoalAssentamentoAssentamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalAssentamentoAssentamento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    public function getFkPessoalAssentamentoAssentamento()
    {
        return $this->fkPessoalAssentamentoAssentamento;
    }
}
