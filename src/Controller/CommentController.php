<?php

// ****************************** \\
// ***** COMMENT CONTROLLER ***** \\
// ****************************** \\

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Model\ModelFactory;
use Pam\Helper\Session;


/** *********************************\
* All control actions to the comments
*/
class CommentController extends Controller
{

  /** ********************\
   * Creates a new comment
   */
  public function CreateAction()
  {
    // Checks if the user is connected
    if (Session::islogged())
    {
      // Creates the $data array to store the new comment
      $data['article_id']   = $_GET['id'];
      $data['content']      = $_POST['content'];
      $data['created_date'] = $_POST['date'];
      $data['user_id']      = $_SESSION['user']['id'];

      // Creates the comment
      ModelFactory::get('Comment')->create($data);

      // Creates a valid message to confirm the creation of a new comment
      Session::createAlert('Nouveau commentaire créé avec succès !', 'valid');

      // Redirects to the view readArticle
      $this->redirect('article!read', ['id' => $_GET['id']]);
    }
    else {
      // Creates a fail message to ask to be connected
      Session::createAlert('Vous devez être connecté pour ajouter un commentaire...', 'cancel');
    }
    // Redirects to the view loginUser
    $this->redirect('user!login');
  }


  /** ****************\
   * Deletes a comment
   */
  public function DeleteAction()
  {
    // Gets the comment id, then stores it
    $id = $_GET['id'];

    // Deletes the selected comment
    ModelFactory::get('Comment')->delete($id);

    // Creates a delete message to confirm the removal of the selected comment
    Session::createAlert('Commentaire définitivement supprimé !', 'delete');

    // Redirects to the view admin
    $this->redirect('admin');
  }
}