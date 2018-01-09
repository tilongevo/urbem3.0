<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * CondicaoAssentamento
 */
class CondicaoAssentamento
{
    /**
     * PK
     * @var integer
     */
    private $codCondicao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codAssentamento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamentoExcluido
     */
    private $fkPessoalCondicaoAssentamentoExcluido;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculado
     */
    private $fkPessoalAssentamentoVinculados;

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
        $this->fkPessoalAssentamentoVinculados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codCondicao
     *
     * @param integer $codCondicao
     * @return CondicaoAssentamento
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return CondicaoAssentamento
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
     * Set codAssentamento
     *
     * @param integer $codAssentamento
     * @return CondicaoAssentamento
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
     * OneToMany (owning side)
     * Add PessoalAssentamentoVinculado
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculado $fkPessoalAssentamentoVinculado
     * @return CondicaoAssentamento
     */
    public function addFkPessoalAssentamentoVinculados(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculado $fkPessoalAssentamentoVinculado)
    {
        if (false === $this->fkPessoalAssentamentoVinculados->contains($fkPessoalAssentamentoVinculado)) {
            $fkPessoalAssentamentoVinculado->setFkPessoalCondicaoAssentamento($this);
            $this->fkPessoalAssentamentoVinculados->add($fkPessoalAssentamentoVinculado);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoVinculado
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculado $fkPessoalAssentamentoVinculado
     */
    public function removeFkPessoalAssentamentoVinculados(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculado $fkPessoalAssentamentoVinculado)
    {
        $this->fkPessoalAssentamentoVinculados->removeElement($fkPessoalAssentamentoVinculado);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoVinculados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculado
     */
    public function getFkPessoalAssentamentoVinculados()
    {
        return $this->fkPessoalAssentamentoVinculados;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection|AssentamentoVinculado $fkPessoalAssentamentoVinculados
     */
    public function setFkPessoalAssentamentoVinculados($fkPessoalAssentamentoVinculados)
    {
        $this->fkPessoalAssentamentoVinculados = $fkPessoalAssentamentoVinculados;
    }


    /**
     * ManyToOne (inverse side)
     * Set fkPessoalAssentamentoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento
     * @return CondicaoAssentamento
     */
    public function setFkPessoalAssentamentoAssentamento(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento)
    {
        $this->codAssentamento = $fkPessoalAssentamentoAssentamento->getCodAssentamento();
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

    /**
     * OneToOne (inverse side)
     * Set PessoalCondicaoAssentamentoExcluido
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamentoExcluido $fkPessoalCondicaoAssentamentoExcluido
     * @return CondicaoAssentamento
     */
    public function setFkPessoalCondicaoAssentamentoExcluido(\Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamentoExcluido $fkPessoalCondicaoAssentamentoExcluido)
    {
        $fkPessoalCondicaoAssentamentoExcluido->setFkPessoalCondicaoAssentamento($this);
        $this->fkPessoalCondicaoAssentamentoExcluido = $fkPessoalCondicaoAssentamentoExcluido;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalCondicaoAssentamentoExcluido
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamentoExcluido
     */
    public function getFkPessoalCondicaoAssentamentoExcluido()
    {
        return $this->fkPessoalCondicaoAssentamentoExcluido;
    }

    public function __toString()
    {
        if ($this->codCondicao) {
            return sprintf(
                '%s - %s - %s',
                $this->codCondicao,
                $this->fkPessoalAssentamentoAssentamento->getDescricao(),
                $this->timestamp->format('d/m/Y')
            );
        } else {
            return "Condição de Assentamento";
        }
    }
}
