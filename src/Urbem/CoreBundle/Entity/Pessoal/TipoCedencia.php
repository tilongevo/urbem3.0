<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * TipoCedencia
 */
class TipoCedencia
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCedencia
     */
    private $fkPessoalContratoServidorCedencias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalContratoServidorCedencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoCedencia
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoCedencia
     */
    public function setDescricao($descricao = null)
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
     * Add PessoalContratoServidorCedencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCedencia $fkPessoalContratoServidorCedencia
     * @return TipoCedencia
     */
    public function addFkPessoalContratoServidorCedencias(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCedencia $fkPessoalContratoServidorCedencia)
    {
        if (false === $this->fkPessoalContratoServidorCedencias->contains($fkPessoalContratoServidorCedencia)) {
            $fkPessoalContratoServidorCedencia->setFkPessoalTipoCedencia($this);
            $this->fkPessoalContratoServidorCedencias->add($fkPessoalContratoServidorCedencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorCedencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCedencia $fkPessoalContratoServidorCedencia
     */
    public function removeFkPessoalContratoServidorCedencias(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCedencia $fkPessoalContratoServidorCedencia)
    {
        $this->fkPessoalContratoServidorCedencias->removeElement($fkPessoalContratoServidorCedencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorCedencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCedencia
     */
    public function getFkPessoalContratoServidorCedencias()
    {
        return $this->fkPessoalContratoServidorCedencias;
    }
}
