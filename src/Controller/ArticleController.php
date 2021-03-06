<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ArticleController
 * @package App\Controller
 */
class ArticleController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $allArticles = ModelFactory::getModel('Article')->listData();

        return $this->render('blog/blog.twig', ['allArticles' => $allArticles]);
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
        if (!empty($this->post->getPostArray())) {

            $data['image'] = $this->files->uploadFile('img/blog');

            $data['title']        = $this->post->getPostVar('title');
            $data['link']         = $this->post->getPostVar('link');
            $data['content']      = $this->post->getPostVar('content');
            $data['created_date'] = $this->post->getPostVar('date');
            $data['updated_date'] = $this->post->getPostVar('date');

            ModelFactory::getModel('Article')->createData($data);
            $this->cookie->createAlert('Nouvel article créé avec succès !');

            $this->redirect('admin');
        }
        return $this->render('admin/blog/createArticle.twig');
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function readMethod()
    {
        $article    = ModelFactory::getModel('Article')->readData($this->get->getGetVar('id'));
        $comments   = ModelFactory::getModel('Comment')->list($this->get->getGetVar('id'), 'article_id');

        if(!empty($comments)) {

            for ($i = 0; $i < count($comments); $i++) {

                $userId = $comments[$i]['user_id'];
                $user   = ModelFactory::getModel('User')->readData($userId);

                $comments[$i]['user']   = $user['first_name'];
                $comments[$i]['image']  = $user['image'];
            }
        } else {
            $this->cookie->createAlert('Soyez le premier à commenter cet article !');
        }

        return $this->render('blog/readArticle.twig', [
            'article'   => $article,
            'comments'  => $comments
        ]);
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

            if (!empty($this->files->getFileVar('name'))) {
                $data['image'] = $this->files->uploadFile('img/blog');
            }

            $data['title']        = $this->post->getPostVar('title');
            $data['link']         = $this->post->getPostVar('link');
            $data['content']      = $this->post->getPostVar('content');
            $data['updated_date'] = $this->post->getPostVar('date');

            ModelFactory::getModel('Article')->updateData($this->get->getGetVar('id'), $data);
            $this->cookie->createAlert('Modification réussie de l\'article sélectionné !');

            $this->redirect('admin');
        }
        $article = ModelFactory::getModel('Article')->readData($this->get->getGetVar('id'));

        return $this->render('admin/blog/updateArticle.twig', ['article' => $article]);
    }

    public function deleteMethod()
    {
        ModelFactory::getModel('Article')->deleteData($this->get->getGetVar('id'));
        $this->cookie->createAlert('Article définitivement supprimé !');

        $this->redirect('admin');
    }
}
