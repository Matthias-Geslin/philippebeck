<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Model\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class PortfolioController
 * @package App\Controller
 */
class PortfolioController extends Controller
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function indexAction()
  {
    $allProjects = ModelFactory::get('Project')->list();
    $allPens     = ModelFactory::get('Pen')    ->list();
    $allRoutes   = ModelFactory::get('Route')  ->list();
    $allCourses  = ModelFactory::get('Course') ->list();

    return $this->render('portfolio/portfolio.twig', [
      'allProjects' => $allProjects,
      'allPens'     => $allPens,
      'allRoutes'   => $allRoutes,
      'allCourses'  => $allCourses
    ]);
  }
}
