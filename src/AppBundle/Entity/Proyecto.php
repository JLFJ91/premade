<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proyecto
 *
 * @ORM\Table(name="proyecto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProyectoRepository")
 *
 * @ORM\HasLifecycleCallbacks
 */
class Proyecto
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=50, nullable=true)
     */
    private $img;

    /**
     * @var string
     *
     * @ORM\Column(name="iframe", type="text", nullable=true)
     */
    private $iframe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity="Equipo", mappedBy="proyectos")
     */
    private $equipos;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->equipos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Proyecto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set img
     *
     * @param string $img
     *
     * @return Proyecto
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set iframe
     *
     * @param string $iframe
     *
     * @return Proyecto
     */
    public function setIframe($iframe)
    {
        $this->iframe = $iframe;

        return $this;
    }

    /**
     * Get iframe
     *
     * @return string
     */
    public function getIframe()
    {
        return $this->iframe;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Proyecto
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add equipo
     *
     * @param \AppBundle\Entity\Equipo $equipo
     *
     * @return Proyecto
     */
    public function addEquipo(\AppBundle\Entity\Equipo $equipo)
    {
        $this->equipos[] = $equipo;

        return $this;
    }

    /**
     * Remove equipo
     *
     * @param \AppBundle\Entity\Equipo $equipo
     */
    public function removeEquipo(\AppBundle\Entity\Equipo $equipo)
    {
        $this->equipos->removeElement($equipo);
    }

    /**
     * Get equipos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipos()
    {
        return $this->equipos;
    }

    /**
     * Establece la fecha actual en el campo created_at
     *
     * @ORM\PrePersist
     */
    public function updatedTimestamps()
    {
        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

    public function __toString()
    {
       return $this->nombre;
    }


}
