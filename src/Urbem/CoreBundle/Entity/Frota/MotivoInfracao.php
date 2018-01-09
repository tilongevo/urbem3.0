<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * MotivoInfracao
 */
class MotivoInfracao
{
    /**
     * PK
     * @var integer
     */
    private $codInfracao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $baseLegal;

    /**
     * @var string
     */
    private $gravidade;

    /**
     * @var string
     */
    private $responsabilidade;

    /**
     * @var string
     */
    private $competencia;

    /**
     * @var integer
     */
    private $pontos;

    /**
     * @var integer
     */
    private $valor;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Infracao
     */
    private $fkFrotaInfracoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFrotaInfracoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codInfracao
     *
     * @param integer $codInfracao
     * @return MotivoInfracao
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
     * Set descricao
     *
     * @param string $descricao
     * @return MotivoInfracao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set baseLegal
     *
     * @param string $baseLegal
     * @return MotivoInfracao
     */
    public function setBaseLegal($baseLegal)
    {
        $this->baseLegal = $baseLegal;
        return $this;
    }

    /**
     * Get baseLegal
     *
     * @return string
     */
    public function getBaseLegal()
    {
        return $this->baseLegal;
    }

    /**
     * Set gravidade
     *
     * @param string $gravidade
     * @return MotivoInfracao
     */
    public function setGravidade($gravidade)
    {
        $this->gravidade = $gravidade;
        return $this;
    }

    /**
     * Get gravidade
     *
     * @return string
     */
    public function getGravidade()
    {
        return $this->gravidade;
    }

    /**
     * Set responsabilidade
     *
     * @param string $responsabilidade
     * @return MotivoInfracao
     */
    public function setResponsabilidade($responsabilidade)
    {
        $this->responsabilidade = $responsabilidade;
        return $this;
    }

    /**
     * Get responsabilidade
     *
     * @return string
     */
    public function getResponsabilidade()
    {
        return $this->responsabilidade;
    }

    /**
     * Set competencia
     *
     * @param string $competencia
     * @return MotivoInfracao
     */
    public function setCompetencia($competencia)
    {
        $this->competencia = $competencia;
        return $this;
    }

    /**
     * Get competencia
     *
     * @return string
     */
    public function getCompetencia()
    {
        return $this->competencia;
    }

    /**
     * Set pontos
     *
     * @param integer $pontos
     * @return MotivoInfracao
     */
    public function setPontos($pontos)
    {
        $this->pontos = $pontos;
        return $this;
    }

    /**
     * Get pontos
     *
     * @return integer
     */
    public function getPontos()
    {
        return $this->pontos;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return MotivoInfracao
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Infracao $fkFrotaInfracao
     * @return MotivoInfracao
     */
    public function addFkFrotaInfracoes(\Urbem\CoreBundle\Entity\Frota\Infracao $fkFrotaInfracao)
    {
        if (false === $this->fkFrotaInfracoes->contains($fkFrotaInfracao)) {
            $fkFrotaInfracao->setFkFrotaMotivoInfracao($this);
            $this->fkFrotaInfracoes->add($fkFrotaInfracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Infracao $fkFrotaInfracao
     */
    public function removeFkFrotaInfracoes(\Urbem\CoreBundle\Entity\Frota\Infracao $fkFrotaInfracao)
    {
        $this->fkFrotaInfracoes->removeElement($fkFrotaInfracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaInfracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Infracao
     */
    public function getFkFrotaInfracoes()
    {
        return $this->fkFrotaInfracoes;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s - %s',
            $this->codInfracao,
            $this->descricao
        );
    }
}
