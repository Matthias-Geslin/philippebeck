<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class CourseController
 * @package App\Controller
 */
class CourseController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
        if (!empty($this->post->getPostArray())) {

            ModelFactory::get('Course')->create($this->post->getPostArray());
            $this->cookie->createAlert('Nouveau cours créé avec succès !');

            $this->redirect('admin');
        }
        return $this->render('admin/portfolio/createCourse.twig');
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function updateMethod()
    {
        if (!empty($this->post->getPostArray())) {

            ModelFactory::get('Course')->update($this->get->getGetVar('id'), $this->post->getPostArray());
            $this->cookie->createAlert('Modification réussie du cours sélectionné !');

            $this->redirect('admin');
        }
        $course = ModelFactory::get('Course')->read($this->get->getGetVar('id'));

        return $this->render('admin/portfolio/updateCourse.twig', ['course' => $course]);
    }

    public function deleteMethod()
    {
        ModelFactory::get('Course')->delete($this->get->getGetVar('id'));
        $this->cookie->createAlert('Cours définitivement supprimé !');

        $this->redirect('admin');
    }
}
