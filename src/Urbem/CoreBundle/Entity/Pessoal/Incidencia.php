<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Incidencia
 */
class Incidencia
{
    /**
     * PK
     * @var integer
     */
    private $codIncidencia;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\PensaoIncidencia
     */
    private $fkPessoalPensaoIncidencias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalPensaoIncidencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codIncidencia
     *
     * @param integer $codIncidencia
     * @return Incidencia
     */
    public function setCodIncidencia($codIncidencia)
    {
        $this->codIncidencia = $codIncidencia;
        return $this;
    }

    /**
     * Get codIncidencia
     *
     * @return integer
     */
    public function getCodIncidencia()
    {
        return $this->codIncidencia;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Incidencia
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
     * Add PessoalPensaoIncidencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PensaoIncidencia $fkPessoalPensaoIncidencia
     * @return Incidencia
     */
    public function addFkPessoalPensaoIncidencias(\Urbem\CoreBundle\Entity\Pessoal\PensaoIncidencia $fkPessoalPensaoIncidencia)
    {
        if (false === $this->fkPessoalPensaoIncidencias->contains($fkPessoalPensaoIncidencia)) {
            $fkPessoalPensaoIncidencia->setFkPessoalIncidencia($this);
            $this->fkPessoalPensaoIncidencias->add($fkPessoalPensaoIncidencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalPensaoIncidencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PensaoIncidencia $fkPessoalPensaoIncidencia
     */
    public function removeFkPessoalPensaoIncidencias(\Urbem\CoreBundle\Entity\Pessoal\PensaoIncidencia $fkPessoalPensaoIncidencia)
    {
        $this->fkPessoalPensaoIncidencias->removeElement($fkPessoalPensaoIncidencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalPensaoIncidencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\PensaoIncidencia
     */
    public function getFkPessoalPensaoIncidencias()
    {
        return $this->fkPessoalPensaoIncidencias;
    }
}
