<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Natureza
 */
class Natureza
{
    const SAIDA = 'S';
    const ENTRADA = 'E';

    const SAIDA_DIVERSA = "9~S";
    const AUTORIZACAO_ABASTECIMENTO = 12;

    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * PK
     * @var string
     */
    private $tipoNatureza;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento
     */
    private $fkAlmoxarifadoNaturezaLancamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoNaturezaLancamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return Natureza
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set tipoNatureza
     *
     * @param string $tipoNatureza
     * @return Natureza
     */
    public function setTipoNatureza($tipoNatureza)
    {
        $this->tipoNatureza = $tipoNatureza;
        return $this;
    }

    /**
     * Get tipoNatureza
     *
     * @return string
     */
    public function getTipoNatureza()
    {
        return $this->tipoNatureza;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Natureza
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
     * OneToMany (owning side)
     * Add AlmoxarifadoNaturezaLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento $fkAlmoxarifadoNaturezaLancamento
     * @return Natureza
     */
    public function addFkAlmoxarifadoNaturezaLancamentos(\Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento $fkAlmoxarifadoNaturezaLancamento)
    {
        if (false === $this->fkAlmoxarifadoNaturezaLancamentos->contains($fkAlmoxarifadoNaturezaLancamento)) {
            $fkAlmoxarifadoNaturezaLancamento->setFkAlmoxarifadoNatureza($this);
            $this->fkAlmoxarifadoNaturezaLancamentos->add($fkAlmoxarifadoNaturezaLancamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoNaturezaLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento $fkAlmoxarifadoNaturezaLancamento
     */
    public function removeFkAlmoxarifadoNaturezaLancamentos(\Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento $fkAlmoxarifadoNaturezaLancamento)
    {
        $this->fkAlmoxarifadoNaturezaLancamentos->removeElement($fkAlmoxarifadoNaturezaLancamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoNaturezaLancamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento
     */
    public function getFkAlmoxarifadoNaturezaLancamentos()
    {
        return $this->fkAlmoxarifadoNaturezaLancamentos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getDescricao();
    }
}
