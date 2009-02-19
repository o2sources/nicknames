<?php

/**
 * GuestbookController - in this example, we will build a simple
 * guestbook style application.  It is capable only of being "signed" and
 * listing the previous entries.
 */
class GuestbookController extends Zend_Controller_Action 
{
    /** 
     * While overly simplistic, we will create a property for this controller 
     * to contain a reference to the model associated with this controller. In 
     * larger system, or in systems that might have referential models, we 
     * would need additional properties for each.
     */
    protected $_model;

    /**
     * The index, or landing, action will be concerned with listing the entries 
     * that already exist.
     *
     * Assuming the default route and default router, this action is dispatched 
     * via the following urls:
     *   /guestbook/
     *   /guestbook/index
     *
     * @return void
     */
    public function indexAction()
    {
        $model = $this->_getModel();
        $this->view->entries = $model->fetchEntries();
    }

    /**
     * The sign action is responsible for handling the "signing" of the 
     * guestbook. 
     *
     * Assuming the default route and default router, this action is dispatched 
     * via the following url:
     *   /guestbook/sign
     *
     * @return void
     */
    public function signAction()
    {
        $request = $this->getRequest();
        $form    = $this->_getGuestbookForm();

        // check to see if this action has been POST'ed to
        if ($this->getRequest()->isPost()) {
            
            // now check to see if the form submitted exists, and
            // if the values passed in are valid for this form
            if ($form->isValid($request->getPost())) {
                
                // since we now know the form validated, we can now
                // start integrating that data sumitted via the form
                // into our model
                $model = $this->_getModel();
                $model->save($form->getValues());
                
                // now that we have saved our model, lets url redirect
                // to a new location
                // this is also considered a "redirect after post"
                // @see http://en.wikipedia.org/wiki/Post/Redirect/Get
                return $this->_helper->redirector('index');
            }
        }
        
        // assign the form to the view
        $this->view->form = $form;
    }

    /**
     * _getModel() is a protected utility method for this controller. It is 
     * responsible for creating the model object and returning it to the 
     * calling action when needed. Depending on the depth and breadth of the 
     * application, this may or may not be the best way of handling the loading 
     * of models.  This concept will be visited in later tutorials, but for now 
     * - in this application - this is the best technique.
     *
     * Also note that since this is a protected method without the word 'Action',
     * it is impossible that the application can actually route a url to this 
     * method. 
     *
     * @return Model_GuestBook
     */
    protected function _getModel()
    {
        if (null === $this->_model) {
            // autoload only handles "library" compoennts.  Since this is an 
            // application model, we need to require it from its application 
            // path location.
            require_once APPLICATION_PATH . '/models/GuestBook.php';
            $this->_model = new Model_GuestBook();
        }
        return $this->_model;
    }

    /**
     * This method is essentially doing the same thing for the Form that we did 
     * above in the protected model accessor.  Same logic applies here.
     *
     * @return Form_GuestBook
     */
    protected function _getGuestbookForm()
    {
        require_once APPLICATION_PATH . '/forms/GuestBook.php';
        $form = new Form_GuestBook();
        $form->setAction($this->_helper->url('sign'));
        return $form;
    }
}
